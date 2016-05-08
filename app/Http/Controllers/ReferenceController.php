<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

use App\Http\Requests;

use App\Reference;
use App\Note;

use Validator;
use Storage;

use Illuminate\View\View;

use OpenJournalSoftware\BibtexBundle\Helper\Bibtex;

class ReferenceController extends Controller
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

    /**
    * Displays an index of all references
    *
    * @return View List template for references
    */
    public function index()
    {
        $references = Reference::orderBy('author_last', 'asc')->get();

        return view('references.list', compact('references'));
    }

    /**
    * Displays a form to create a new reference
    *
    * @return View Form for adding a new reference
    */
    public function getCreate()
    {
        return view('references.create');
    }

    /**
    * Inserts a new reference
    *
    * @param  Request $request The posted data
    * @return RedirectResponse           Redirects to reference index
    */
    public function postCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'author_first' => 'required|min:3|max:255',
            'author_last' => 'required|min:3|max:255',
            'year' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect('/references/create')
            ->withErrors($validator)
            ->withInput();
        }

        // Begin insertion
        $reference = new Reference();
        $reference->title = $request->title;
        $reference->author_first = $request->author_first;
        $reference->author_last = $request->author_last;
        $reference->year = $request->year;
        $reference->reference_type = $request->reference_type;

        $reference->save();

        return redirect('/references/index');
    }

    /**
    * Displays a form with the reference data prefilled
    *
    * @param  integer $id  Corresponds to the database column id
    * @return View     Returns a view with reference data
    */
    public function getEdit($id)
    {
        if(!$id || $id <= 0)
        return redirect(url('/references/index'));

        $reference = Reference::find($id);

        return view('references.edit', compact('reference'));
    }

    /**
    * Updates a reference in the database
    *
    * @param  Request $request  Data to be updated
    * @param  integer  $id          Corresponds to the database column id
    * @return RedirectResponse  Redirects depending on validation
    */
    public function postEdit(Request $request, $id)
    {
        if(!$id || $id <= 0)
        return redirect(url('/references/index'));

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'author_first' => 'required|min:3|max:255',
            'author_last' => 'required|min:3|max:255',
            'year' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect('/references/edit/'.$id)
            ->withErrors($validator)
            ->withInput();
        }

        $reference = Reference::find($id);
        $reference->title = $request->title;
        $reference->author_first = $request->author_first;
        $reference->author_last = $request->author_last;
        $reference->year = $request->year;
        $reference->reference_type = $request->reference_type;

        $reference->save();

        return redirect('/references/index');
    }

    /**
    * Removes a record from the database table
    *
    * @param  integer $id           Corresponds to the id-column
    * @return RedirectResponse  Redirects
    */
    public function delete($id)
    {
        if(!$id || $id <= 0)
        return redirect(url('/references/index'));

        $ref = Reference::find($id);

        $ref->notes()->detach();
        $ref->outlines()->detach();

        $ref->delete();

        return redirect('/references/index');
    }

    /**
    * Displays a form to import references from a *.bib-file
    *
    * @return View Returns an empty form
    */
    public function getImport()
    {
        // Display a view and let the Ajax-controller again handle the file collection
        $dummyRef = new Reference();
        return view('references.form', ["types" => $dummyRef->getTypes()]);
    }

    /**
    * Displays a results page to check the import status
    *
    * @return mixed Depending on validation redirects or view
    */
    public function getConfirm()
    {
        // Check if files have been uploaded
        $store = Storage::disk('local');
        $files = $store->files('bibtex');
        if(count($files) <= 0)
        return redirect('/references/import')->withErrors(['content' => 'Please upload something to import!']);

        // Now loop through all found files and extract the notes
        $references = new Collection();
        $bibtex = new Bibtex();
        $omitted = [];
        foreach($files as $file)
        {
            $filecontents = $store->get($file);
            $ret    = $bibtex->loadString($store->get($file));
            $bibtex->parse();

            // Okay, the bibtex-data looks nice. So for now let's only fill the
            // already migrated fields: title, year, author_last, author_first, reference_type

            foreach($bibtex->data as $index => $entry)
            {
                $ref = new Reference();
                // Convert entryTypes if necessary
                switch($entry['entryType'])
                {
                    case "article": $entry['entryType'] = "journal article"; break;
                    case "conference": $entry['entryType'] = "conference paper"; break;
                    case "inbook": $entry['entryType'] = "book section"; break;
                    case "masterthesis": $entry['entryType'] = "thesis"; break;
                    case "phdthesis": $entry['entryType'] = "thesis"; break;
                    case "techreport": $entry['entryType'] = "report"; break;
                }

                // Can we store this datatype?
                if(!$ref->typeAllowed($entry['entryType']))
                {
                    $omitted[$index]['reason'] = 'Entry type incompatible with database';
                    continue;
                }

                // Is anything empty? Then also omit
                if(strlen($entry['title']) <= 0)
                {
                    $omitted[$index]['reason'] = 'Title missing';
                    continue;
                }
                if(strlen($entry['year']) <= 0)
                {
                    $omitted[$index]['reason'] = 'Year missing';
                    continue;
                }
                if(strlen($entry['author'][0]['last']) <= 0)
                {
                    $omitted[$index]['reason'] = 'Author last name missing';
                    continue;
                }
                if(strlen($entry['author'][0]['first']) <= 0)
                {
                    $omitted[$index]['reason'] = 'Author first name missing';
                    continue;
                }

                $entry['title'] = str_replace(["{", "}"], "", $entry['title']);
                $bibtex->data[$index]['title'] = $entry['title'];

                $ref->title = $entry['title'];
                $ref->year = $entry['year'];
                $ref->author_last = $entry['author'][0]['last'];
                $ref->author_first = $entry['author'][0]['first'];
                $ref->reference_type = $ref->getTypeKey($entry['entryType']);

                // Create or, if it exists, omit
                Reference::firstOrCreate($ref->toArray());

                /*
                * Accordding to the BibTex people these entries are allowed:
                * Everything with NULL hasn't been implemented yet
                * 'article', -> "journal article"
                * 'book', -> book
                * 'booklet', -> NULL
                * 'confernce', -> conference paper
                * 'inbook', -> book section
                * 'incollection', -> NULL
                * 'inproceedings', -> NULL
                * 'manual', -> NULL
                * 'mastersthesis', -> thesis
                * 'misc', -> NULL
                * 'phdthesis', -> thesis
                * 'proceedings', -> NULL
                * 'techreport', -> report
                * 'unpublished' -> NULL
                */
            }
        }
        // Clear the uploaded files before exiting
        $store->delete($files);

        return view('references.confirm', ['bibtex' => $bibtex->data, 'omitted' => $omitted]);
    }
}
