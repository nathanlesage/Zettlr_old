{{-- single show page for notes --}}
@extends('app')

@section('scripts')
@endsection

@section('scripts_on_document_ready')
@endsection

@section('content')
<div class="container" style="background-color:white">
	<div class="page-header">
		<h1>{{ $note->title }} <small>#{{ $note->id }} (<a href="{{ url('notes/edit/'.$note->id) }}">Edit</a>)</small></h1>
	</div>
	<div>
		{!! Markdown::convertToHtml($note->content) !!}
	</div>
	<div class="panel panel-default panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Tags:</h3>
		</div>
		<div class="panel-body">
			@if(count($note->tags) > 0)
				@foreach($note->tags as $tag)
					<button class="btn btn-primary">{{ $tag->name }}</button>
				@endforeach
			@else
				<div class="alert alert-info">No tags found</div>
			@endif
		</div>
	</div>
</div>
@endsection
