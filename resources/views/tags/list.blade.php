@extends('app')

@section('content')
    <div class="container" style="background-color:white;">
        <div class="page-header">
            <h1>Tags</h1>
        </div>
        @if(count($tags) > 0)
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th style="text-align:right;">Occurrence</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
                @foreach($tags as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td><a href="{{ url('/tags/show/') }}/{{ $tag->id }}" title="Show all related notes" data-toggle="tooltip">{{ $tag->name }}</a></td>
                        <td style="text-align:right;">{{ count($tag->notes) }}</td>
                        <td style="text-align:right;">
                            <a href="{{ url('/tags/delete')}}/{{$tag->id}}" title="Remove tag" data-toggle="tooltip">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
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
