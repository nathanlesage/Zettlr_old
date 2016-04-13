{{-- Main template for the Home section --}}
@extends('app')

{{-- ToDo: Make this the general settings pane --}}

@section('content')
    <div class="container">
        <!-- Little hack for vertical alignment -->
        <div class="jumbotron" style="margin-top:25%;">
            <h1>Zettlr</h1>
            <p>You are logged in as <strong>{{ Auth::user()->name }}</strong>.</p>
            <p>There are currently <strong>{{ $noteCount }}</strong> Notes,
              <strong>{{ $tagCount }}</strong> Tags,
              <strong>{{ $referenceCount }}</strong> References and
              <strong>{{ $outlineCount }}</strong> Outlines saved in this app.</p>
              <p><a class="btn btn-primary" href="{{ url('/settings') }}">Settings</a></p>
        </div>
    </div>
@endsection
