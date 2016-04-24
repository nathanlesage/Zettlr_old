@extends('app')

@section('scripts_on_document_ready')
    $('#tagsTable').tablesorter();
@endsection

@section('content')
    <div class="container" style="background-color:white;">
        <div class="page-header">
            <h1>Tags</h1>
        </div>
        @if(count($tags) > 0)
            <table class="table table-striped" id="tagsTable">
                <thead>
                    <tr>
                        <th><a href="#" title="Sort by ID" data-toggle="tooltip">ID</a></th>
                        <th><a href="#" title="Sort by name" data-toggle="tooltip">Name</a></th>
                        <th style="text-align:right;"><a href="#" title="Sort by occurrence" data-toggle="tooltip">Occurrence</a></th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
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
