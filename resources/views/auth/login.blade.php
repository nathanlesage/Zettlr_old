{{-- Changed layout.app to "our" app file --}}
@extends('app')

@section('content')
    <div class="container">
        <!-- Little hack for vertical alignment -->
        <div class="jumbotron" style="margin-top:25%;">
            <h1 class="clearfix" style="vertical-align:middle;"><img src="/img/favicon/apple-touch-icon-76x76.png" alt="Zettlr" title="Zettlr logo" class="img-responsive pull-left"><span style="vertical-align:text-top; margin-left:15px;">Zettlr</span></h1>
            <form class="form-inline" role="login" method="POST" action="{{ url('/login') }}" id="loginForm">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control loginInputField" name="email" autofocus="autofocus" placeholder="Email" value="{{ old('email') }}">
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control loginInputField" name="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" class="form-control loginInputField"> Remember Me
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success loginInputField">Login</button>
                </div>

            </form>
            <p><a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a></p>

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
    </div>
@endsection
