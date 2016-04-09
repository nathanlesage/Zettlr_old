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
	<div class="panel panel-default panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Note contents</h3>
		</div>
		<div class="panel-body">
			{!! Markdown::convertToHtml($note->content) !!}
			<hr>
			@if(count($note->tags) > 0)
				@foreach($note->tags as $tag)
					<button class="btn btn-primary">{{ $tag->name }}</button>
				@endforeach
			@else
				<div class="alert alert-info">No tags found</div>
			@endif
		</div>
	</div>
	<!-- Space for trails -->
	<div class="panel panel-default panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Related Notes</h3>
		</div>
		<div class="panel-body">
			@if(count($relatedNotes) > 0)
				@foreach($relatedNotes as $note)
					<div class="progress">
  						<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{ round($note->count/$maxCount, 2) * 100 }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ round($note->count/$maxCount, 2) * 100 }}%">
  							{{ $note->title }}
    						<span class="sr-only">{{ round($note->count/$maxCount) }}% Relevancy</span>
  						</div>
					</div>
				@endforeach
			@else
				<div class="alert alert-info">No related notes found</div>
			@endif
		</div>
	</div>
	<div>
	</div>
</div>
@endsection
