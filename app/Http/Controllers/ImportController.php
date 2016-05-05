<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Note;
use App\Outline;
use App\Tag;
use App\CustomElement;

use GrahamCampbell\Markdown\Facades\Markdown;

class ImportController extends Controller
{
    /**
    * Create a new controller instance.
    * Use "auth" middleware.
    *
    * @return void
    */
    public function __construct()
    {
        // Require the user to be logged in
        // for every action this controller does
        $this->middleware('auth');
    }

    // Just a testing function
    public function getImport()
    {
        return view('imports.form');
    }

    public function postImport(Request $request)
    {
        //  Do we have a file?
        if($request->hasFile('notes'))
        {
            // Now get the file, read its contents and delete
            if(!$request->file('notes')->isValid())
                return redirect('/import')->withErrors(['notes' => 'The uploaded file was not valid!']);

            $fcontents = File::get($request->file('notes')->getRealPath());
            $lines = preg_split("/\\r\\n|\\r|\\n/", $fcontents);
        }
        elseif(strlen($request->content) > 0) // Or just input in the textarea?
        {
            // First split the retrieved contents linewise
            $lines = preg_split("/\\r\\n|\\r|\\n/", $request->content);
        }
        else
        {
            return redirect('/import')->withErrors(['content' => 'Please input something to import!']);
        }

        $notes = new Collection();

        // Now go through them
        $tmp = [];
        $noteFound = false;
        for($i = 0; $i < count($lines); $i++)
        {
            // h4 is always four ####
            if(substr($lines[$i], 0, 4) == '####')
            {
                if(count($tmp) > 1)
                {
                    $notes->push(new Note(['title' => substr(array_shift($tmp), 5), 'content' => implode("\n", $tmp)]));
                    // Flush tmp without unsetting (which would render it local
                    // only to this specific for-round)
                    $tmp = array();
                }
                $tmp[] = $lines[$i];
                $noteFound = true;
            }
            else
            {
                // This is necessary to strip potential additional lines before
                // the first note and to not include the next h4 also
                if(substr($lines[$i], 0, 4) != '####' && $noteFound)
                $tmp[] = $lines[$i];
            }
        }
        // Now, in the tmp-Array is a last note
        if(count($tmp) > 1)
            $notes->push(new Note(['title' => substr(array_shift($tmp), 5), 'content' => implode("\n", $tmp)]));

        // Now that we have all notes -> should we suggest tags?
        if($request->suggestTags)
        {
            foreach($notes as $note)
            {
                $note->suggestedTags = $this->suggestTags($note);
            }
        }

        // TODO: Check for custom elements (h2, h3, ps, etc.)
        // Now in $notes all h4s with trailing stuff should reside
        return view('imports.confirm', compact('notes'));
    }

    public function suggestTags($note)
    {
        // explode note contents and title by words
        $title = explode(" ", $note->title);
        $tmp = strip_tags(preg_replace('/[^a-zA-Z0-9[:space:]\p{L}]/u', '', $note->content));
        $tmp = str_replace(["\n", "\r"], " ", $tmp);
        $content = explode(" ", $tmp);
        // Remove duplicates and reset array keys to Zero-based
        $content = array_values(array_unique($content));
        $suggestedTags = [];
        // Now suggest tags for all words with > 3 letters
        for($i = 0; $i < count($content); $i++)
        {
            if(strlen($content[$i]) > 3)
            {
                $tags = Tag::where('name', 'LIKE', '%'.$content[$i].'%')->get();
                if(count($tags) > 0)
                {
                    foreach($tags as $t)
                    {
                        $suggestedTags[] = $t->name;
                    }
                }
            }
        }

        // Remove potential duplicate tags
        $suggestedTags = array_values(array_unique($suggestedTags));

        return $suggestedTags;
    }
}
