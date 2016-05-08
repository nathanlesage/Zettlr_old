@extends('app')

@section('content')
    <!-- For now just display a simple page -->
    <div class="container" style="background-color:white;">
        <div class="page-header">
            <h1>Import files <small>Step #2: Confirm imports</small></h1>
        </div>
        <div class="alert alert-info">
            On this page, we've collected for you all the notes we could find in your uploaded files. Please check them carefully before you click on the import button. If you see a mistake, just click on the respective title or on the content, to be able to edit the contents.
        </div>
        <hr>
        @foreach($bibtex as $index => $entry)
            <div class="panel
            @if(array_key_exists($index, $omitted))
                panel-danger
            @else
                panel-success
            @endif">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $entry['title'] or "NULL" }}</h3>
                </div>
                <div class="panel-body">
                    {{ $entry['author'][0]['last'] or "NULL" }}, {{ $entry['author'][0]['first'] or "NULL" }}<br />
                    {{ $entry['year'] or "NULL" }}<br />
                    {{ $entry['entryType'] or "NULL" }}
                    @if(array_key_exists($index, $omitted))
                        <br /> <strong>Entry omitted: {{ $omitted[$index]['reason'] }}</strong>
                    @endif
                </div>
            </div>
        @endforeach
        <hr>
        <div class="form-group">
            <a href="{{ url('/references/index') }}"><button class="form-control btn btn-primary">Everything looks good? Go to references</button></a>
        </div>
    </div>
@endsection
