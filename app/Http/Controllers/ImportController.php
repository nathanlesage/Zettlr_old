<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Note;
use App\Outline;
use App\Tag;
use App\CustomElement;

use Storage;

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

    public function getImport()
    {
        return view('imports.form');
    }

    public function postImport(Request $request)
    {
        // Check if files have been uploaded
        $store = Storage::disk('local');
        $files = $store->files('import');
        if(count($files) <= 0)
            return redirect('/import')->withErrors(['content' => 'Please input something to import!']);

        // Now loop through all found files and extract the notes
        $notes = new Collection();
        foreach($files as $file)
        {
            $notes = $notes->merge($this->retrieveNotes($store->get($file), $request->suggestTags, $request->headingType));
        }

        // Now clear the directory
        $store->delete($files);

        // TODO: Check for custom elements (h2, h3, ps, etc.)
        // Now in $notes all h4s with trailing stuff should reside
        return view('imports.confirm', compact('notes'));
    }

    public function insertImport(Request $request)
    {
        if($request->createOutline)
        {
            $outline = new Outline();
            $outline->name = $request->outlineName;
            $outline->description = $request->outlineDescription;
            $outline->save();
            $index = 1;
        }

        // Just copy the code from NoteController@postCreate
        foreach($request->title as $index => $title)
        {
            $note = new Note;
            $note->title = $title;
            $note->content = $request->content[$index];

            $note->save();

            if($request->createOutline)
                $outline->notes()->attach($note, ["index" => $index]);

            // Now fill the join table
            if(array_key_exists($index, $request->tags) && (count($request->tags[$index]) > 0))
            {
                foreach($request->tags[$index] as $tagname)
                {
                    $tag = Tag::firstOrCreate(["name" => $tagname]);
                    $note->tags()->attach($tag->id);
                }
            }
            $index++;
        }

        if($request->createOutline)
            return redirect('/outlines/show/'.$outline->id);

        // Redirect to the main page for now
        return redirect('/');
    }

    public function retrieveNotes($filecontents, $suggestTags = false, $headingType = "#")
    {
        // Extract file contents linewise
        $lines = preg_split("/\\r\\n|\\r|\\n/", $filecontents);

        $notes = new Collection();
        // Now go through the lines
        $tmp = [];
        $noteFound = false;
        for($i = 0; $i < count($lines); $i++)
        {
            // h4 is always four ####
            $thisHeading = explode(" ", $lines[$i])[0];
            if($thisHeading == $headingType)
            //if(substr($lines[$i], 0, 4) == "####")
            {
                if(count($tmp) > 1)
                {
                    $notes->push(new Note(['title' => substr(array_shift($tmp), strlen($headingType)+1), 'content' => implode("\n", $tmp)]));
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
                if(!(substr($lines[$i], 0, strlen($headingType)) == $headingType) && $noteFound)
                //if(substr($lines[$i], 0, 4) == "####" && $noteFound)
                    $tmp[] = $lines[$i];
            }
        }
        // Now, in the tmp-Array is a last note
        if(count($tmp) > 1)
            $notes->push(new Note(['title' => substr(array_shift($tmp), strlen($headingType)+1), 'content' => implode("\n", $tmp)]));

        // Now that we have all notes -> should we suggest tags?
        if($suggestTags)
        {
            foreach($notes as $note)
            {
                $note->suggestedTags = $this->suggestTags($note);
            }
        }
        return $notes;
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
