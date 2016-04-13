@extends('app');

@section('content')
<div class="container" style="background-color:white;">
  <div class="page-header">
		<h1>Tags</h1>
	</div>
  @if(count($tags) > 0)
  <div class="panel-group">
    @foreach($tags as $tag)
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">{{ $tag->name }}
          <span class="pull-right">
            <a href="{{ url('/tags/delete')}}/{{$tag->id}}" title="Remove tag" data-toggle="tooltip">
              <span class="glyphicon glyphicon-remove"></span>
            </a>
          </span>
        </h3>
      </div>
    </div>
    @endforeach
  </div>
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
