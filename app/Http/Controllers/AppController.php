<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\Http\Requests;

// Helper classes
use Auth;
use Form;
use Hash;

class AppController extends Controller
{
    public function index()
    {
      return view('app.settings');
    }

    public function postChanges(Request $request)
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
