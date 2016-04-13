@extends('app')

@section('scripts')
@endsection

@section('scripts_on_document_load')
@endsection

@section('content')
    <div class="container" style="background-color:white;">
        <div class="page-header">
            <h1>Outlines index</h1>
        </div>
        @if(count($outlines) > 0)
            <div class="panel-group">
                @foreach($outlines as $outline)
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h3 class="panel-title"><a href="{{ url('outlines/show/'.$outline->id) }}">{{ $outline->name }}</a>
                                <span class="pull-right">
                                    <a href="{{ url('/outlines/delete')}}/{{$outline->id}}" title="Remove outline" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </span>
                            </h3>
                        </div>
                        @if($outline->description)
                            <div class="panel-body">
                                {{ $outline->description }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning">No outlines to show</div>
        @endif
    </div>
@endsection
