<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Validator;

use App\Http\Requests;

// Helper classes
use Auth;
use Form;
use Hash;

use Illuminate\Support\Facades\Redirect;
// Models
use App\Note;
use App\Outline;
use App\Reference;
use App\Tag;

class AppController extends Controller
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
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function home() {
        // Some general statistics
        $notes = Note::all();
        $noteCount = count($notes);
        $references = Reference::all();
        $referenceCount = count($references);
        $tags = Tag::all();
        $tagCount = count($tags);
        $outlines = Outline::all();
        $outlineCount = count($outlines);

        return view('app.main', compact('noteCount', 'referenceCount', 'tagCount', 'outlineCount'));
    }

    /**
     *  Shows the settings pane
     *
     *  @return  \Illuminate\Http\Response
     */
    public function getSettings()
    {
        return view('app.settings');
    }

    /**
     *  Updates settings in database
     *
     *  @param   Request  $request
     *
     *  @return  \Redirect
     */
    public function postSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'new_pass' => 'min:6|confirmed'
        ]);

        if($validator->fails())
        return redirect('/settings')->withErrors($validator)->withInput();

        $user = Auth::user();

        if(!Hash::check($request->password, $user->password))
        return redirect('/settings')->withErrors(['password' => 'Your old password was wrong'])->withInput();

        // Update user
        $newpass = (strlen($request->new_pass) > 0) ? true : false;

        if($newpass)
        {
            $user->password = Hash::make($request->new_pass);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
        return redirect('/settings');
    }
}
