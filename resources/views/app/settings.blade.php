@extends('app');

@section('content')
<div class="container" style="background-color:white;">
  <div class="page-header">
    <h1 class="page-title">Settings</h1>
  </div>
  <form method="POST" class="form-horizontal" action="{{ url('/settings') }}">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
      <div class="col-sm-2">
        <label for="userName">Your username:</label>
      </div>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="userName" name="name" value="{{ Auth::user()->name }}">
        <p class="help-block">{{ $errors->first("name") }}</p>
      </div>
    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error has-feedback' : '' }}">
      <div class="col-sm-2">
        <label for="userMail">Your Email:</label>
      </div>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="userMail" name="email" value="{{ Auth::user()->email }}">
        <p class="help-block">{{$errors->first("email")}}</p>
      </div>
    </div>

    <div class="form-group{{ $errors->has('new_pass') ? ' has-error has-feedback' : '' }}">
      <div class="col-sm-2">
        <label for="newPass">New password:</label>
      </div>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="newPass" name="new_pass" value="">
        <p class="help-block">{{$errors->first("new_pass")}}</p>
      </div>
    </div>

    <div class="form-group{{ $errors->has('new_pass') ? ' has-error has-feedback' : '' }}">
      <div class="col-sm-2">
        <label for="repeatPass">Repeat new password:</label>
      </div>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="repeatPass" name="new_pass_confirmation" value="">
        <p class="help-block">{{$errors->first("new_pass")}}</p>
      </div>
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error has-feedback' : '' }}">
      <div class="col-sm-2">
        <label for="userPass">Old password (always required):</label>
      </div>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="userPass" name="password" value="">
        <p class="help-block">{{$errors->first("password")}}</p>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-10">
        <input type="submit" class="form-control" name="submit" value="Submit changes">
      </div>
    </div>
  </form>

  @if (count($errors) > 0)
  <div class="alert alert-danger">
  <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
      </div>
  @endif
</div>
@endsection
