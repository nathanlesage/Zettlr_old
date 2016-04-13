{{-- single show page for notes --}}
@extends('app')

@section('scripts')
@endsection

{{--<script> Highlighting--}}
@section('scripts_on_document_ready')

	$("a.onClickPreviewNote").click(function(e) {
		e.preventDefault();
		id = $(this).attr("id");

		$.getJSON("{{ url('ajax/note') }}/" + id, function(data) {
			$("#tabs-2").html(data.content);
		})
		.fail(function() {
			displayError("Could not find note.");
		});
	});

	$("a.onClickLink").click(function(e) {
		e.preventDefault();
		id = $(this).attr("id");
		$.getJSON("{{ url('ajax/link') }}/" + $("div.page-header").attr("id").substr(8) + "/with/" + id, function(data) {
			displaySuccess("Notes linked successfully");
			// Reload to show the newly added link in the breadcrumb
			location.reload();
		})
		.fail(function(data) {
			displayError(data.message);
		});
	});

	$("#tabs").tabs();
@endsection
{{--</script> end highlighting--}}

@section('content')
	<div class="container" style="background-color:white">
		<div class="page-header" id="note-id-{{ $note->id }}">
			<h1>{{ $note->title }} <small>#{{ $note->id }} (<a href="{{ url('notes/edit/'.$note->id) }}">Edit</a>)</small></h1>
		</div>
		<div class="row">
			<div class="col-lg-8" id="tabs">
				<!-- Tab navigation -->
				<ul>
					<li><a href="#tabs-1">Current note</a></li>
					<li><a href="#tabs-2">Preview note</a></li>
				</ul>
				<div class="panel panel-default panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Note contents</h3>
					</div>
					<div class="panel-body" id="tabs-1">
						<!-- Display linked notes -->
						@if(count($linkedNotes) > 0)
							<ol class="breadcrumb">
								@foreach($linkedNotes as $linkedNote)
									<li><a href="{{ url('notes/show/'.$linkedNote->id) }}" title="{{ $linkedNote->title }}" data-toggle="tooltip">{{ $linkedNote->id }}</a></li>
								@endforeach
							</ol>
						@endif
						{!! Markdown::convertToHtml($note->content) !!}
						<hr>
						@if(count($note->tags) > 0)
							@foreach($note->tags as $tag)
								<button class="btn btn-primary">{{ $tag->name }}</button>
							@endforeach
						@else
							<div class="alert alert-primary">No tags found</div>
						@endif
						<hr>
						@if(count($note->references) > 0)
							@foreach($note->references as $reference)
								<button class="btn btn-success">{{ $reference->author_last }} ({{ $reference->year }}): {{ $reference->title }}</button>
							@endforeach
						@else
							<div class="alert alert-success">No references found</div>
						@endif
					</div>
					<div class="panel-body" id="tabs-2">
						<!-- Space for related notes -->
						<p>Please select a related note to preview it here</p>
					</div>
				</div>
			</div> <!-- ./ col-lg-8 -->
			<!-- Space for trails -->
			<div class="col-lg-4">
				<div class="panel panel-default panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Related Notes</h3>
					</div>
					<div class="panel-body" style="max-height:20%">
						@if(count($relatedNotes) > 0)
							@foreach($relatedNotes as $note)
								<div class="row">
									<div class="col-md-9">
										<p><a href="#" id="{{ $note->id }}" title="Preview this note" class="onClickPreviewNote">{{ $note->title }}</a></p>
									</div>
									<div class="col-md-3">
										<p>
											<a href="#" title="Link these two notes" data-toggle="tooltip" class="onClickLink" id="{{ $note->id }}"><span class="glyphicon glyphicon-plus"></span></a>
										</p>
										<div class="progress">
											<div class="progress-bar
											@if(round($note->count/$maxCount, 2) < 0.33)
												progress-bar-danger
											@elseif(round($note->count/$maxCount, 2) < 0.66)
												progress-bar-warning
											@else
												progress-bar-success
											@endif" role="progressbar"
											aria-valuenow="{{ round($note->count/$maxCount, 2) * 100 }}"
											aria-valuemin="0"
											aria-valuemax="100"
											style="width: {{ round($note->count/$maxCount, 2) * 100 }}%"
											title="{{ round($note->count/$maxCount, 2) * 100 }}% Relevancy"
											data-toggle="tooltip">
											<span class="sr-only">{{ round($note->count/$maxCount, 2) * 100 }}% Relevancy</span>
										</div>
									</div> <!-- ./ progress -->
								</div> <!-- ./ col-md-3 -->
							</div> <!-- ./ row -->
							<hr>
						@endforeach
					@else
						<div class="alert alert-info">No related notes found</div>
					@endif
				</div> <!-- ./ panel-body -->
			</div> <!-- ./ panel-default -->
		</div> <!-- ./ col-lg-4 -->
	</div> <!-- ./ row -->
</div> <!-- ./ container -->
@endsection