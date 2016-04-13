@extends('app');

@section('content')
    <div class="container" style="background-color:white;">
        <div class="page-header">
            <h1>Tags</h1>
        </div>
        @if(count($tags) > 0)
            <ul class="panel-group">
                @foreach($tags as $tag)
                    <li class="list-group-item">
                        {{ $tag->name }}
                        <span class="pull-right">
                            <a href="{{ url('/tags/delete')}}/{{$tag->id}}" title="Remove tag" data-toggle="tooltip">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-warning">No tags found</div>
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
