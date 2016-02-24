{{-- Creation template --}}
@extends('app')


@section('content')
<div class="container" style="background-color:white">
    <h1>Create new note</h1>
    {{-- Check if this URL works --}}
    {{ Form::open(array('url' => action('NoteController@create'))) }}
    <div class="form-group">
    {{ Form::label('title', 'Title') }}
    {{ Form::text('title') }}
    </div>
    <div class="form-group">
        {{ Form::label('content', 'Content') }}
        {{ Form::textarea('content') }}
    </div>
    
    <button type="submit" class="btn btn-default">Create</button>
    
    {{ Form::close() }}
</div>
@endsection