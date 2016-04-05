{{-- Creation template --}}
@extends('app')


@section('content')
<div class="container" style="background-color:white">
    <h1>Create new note</h1>
    {{-- Check if this URL works --}}
    
    <form method="POST" action="{{ url('/notes/create') }}">
            {!! csrf_field() !!}
            
            <div class="form-group{{ $errors->has('title') ? ' has-error has-feedback' : '' }}">
                <input type="text" class="form-control" name="title" autofocus="autofocus" placeholder="Titel" value="{{ old('title') }}">               
            </div>
            
            <div class="form-group{{ $errors->has('content') ? ' has-error has-feedback' : '' }}">
                <textarea class="form-control" id="gfm-code" name="content" placeholder="Content">{{ old('content') }}</textarea>           
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-default">Create</button>
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
