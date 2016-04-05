{{-- Changed layout.app to "our" app file --}}
@extends('app')

@section('content')
<div class="container">
	<!-- Little hack for vertical alignment -->
    <div class="jumbotron" style="margin-top:25%;">
        <h1>noteworks</h1>
        <form class="form-inline" role="login" method="POST" action="{{ url('/login') }}">
            {!! csrf_field() !!}
            
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" name="email" autofocus="autofocus" placeholder="Email" value="{{ old('email') }}">
                @if ($errors->has('email'))
    	            <span class="help-block">
    	                <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif                
            </div>
            
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" name="password" placeholder="Password">
                @if ($errors->has('password'))
            	    <span class="help-block">
            	        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            
            <div class="form-group">
    	        <div class="checkbox">
    	            <label>
    		            <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
            </div>
    
            <div class="form-group">
    	        <button type="submit" class="btn btn-success">Login</button>
            </div>
                
        </form>
    </div>
</div>
@endsection
