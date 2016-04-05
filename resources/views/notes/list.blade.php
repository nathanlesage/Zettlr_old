{{--views/notes/list.blade.php--}}
{{-- This view just outputs a list of all notes --}}
@extends('app')


@section('content')
<div class="container" style="background-color:white">
       @if (count($notes) > 0)
        @foreach ($notes as $note)
        <table class="table table-striped">
        <tr>
            <th style="width:5%;">{{ $note->id }}</th>
            <th>{{ $note->title }} <a href="{{ url('/notes/delete/'.$note->id) }}" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></th>
        </tr>
        <tr>
        	<td></td><td>{!! Markdown::convertToHtml($note->content) !!}</td>
        </tr>
        </table>
        @endforeach
        @else
        <div class="alert alert-warning">There are no notes to show. <strong><a href="{{ url('/notes/create') }}">Create a note now!</a></strong> <span class="glyphicon glyphicon-warning-sign pull-right" aria-hidden="true"></span></div>
        @endif

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
