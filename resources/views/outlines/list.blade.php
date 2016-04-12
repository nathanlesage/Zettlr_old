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
              <a href="{{ url('outlines/show/'.$outline->id) }}"><h3 class="panel-title">{{ $outline->name }}</h3></a>
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
