@extends('app');

@section('content')
    <div class="container" style="background-color:white;">
        <div class="page-header" id="{{ $tag->id }}">
            <h1>{{ $tag->name }}
                <small>Tag (<a href="{{ url('/tags/edit') }}/{{ $tag->id }}">Edit</a>)</small>
            </h1>
        </div>
        @if(count($notes) > 0)
            <div class="list-group">
                @foreach($notes as $note)
                    <a href="{{ url('/notes/show') }}/{{ $note->id }}" class="list-group-item">
                        {{ $note->title }}
                    </a>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning">There are no notes attached to this tag.</div>
        @endif
    </div>
@endsection
