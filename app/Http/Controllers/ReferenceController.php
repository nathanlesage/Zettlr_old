<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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

  public function index()
  {

  }

  public function getCreate()
  {

  }

  public function postCreate()
  {

  }

  public function getEdit()
  {

  }

  public function postEdit()
  {
    
  }
}
