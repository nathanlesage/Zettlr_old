{{--views/references/list.blade.php--}}
{{-- This view just outputs a list of all references --}}
@extends('app')

@section('scripts')
	<script>
	// Helper variables
	var ajaxNoteBaseUrl = "{{ url('ajax/note') }}";
	</script>
@endsection

{{-- for syntax highlighting: <script>--}}
@section('scripts_on_document_ready')
@endsection
{{--</script> end syntax highlighting --}}

@section('content')
	<div class="container" style="background-color:white">
		<div class="page-header">
			<h1>References <small>(<a href="{{ url('/references/create') }}">Create new reference</a>)</small></h1>
		</div>
		@if (count($references) > 0)
			<ul class="list-group">
				@foreach ($references as $reference)
					<li class="list-group-item">
						{{ $reference->author_last }}, {{ $reference->author_first }} ({{ $reference->year }}): {{ $reference->title }}
						<span class="pull-right">
							<a title="Edit this reference" data-toggle="tooltip" href="{{ url('/references/edit/') }}/{{ $reference->id }}">
								<span class="glyphicon glyphicon-edit"></span>
							</a>&nbsp;&nbsp;
							<a title="Permanently delete reference" href="{{ url('/references/delete/') }}/{{ $reference->id }}" data-toggle="tooltip">
								<span class="glyphicon glyphicon-remove"></span>
							</a>
						</span>
					</li>
				@endforeach
			</ul>
		@else
			<div class="alert alert-warning">There are no references to show.<span class="glyphicon glyphicon-warning-sign pull-right" aria-hidden="true"></span></div>
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
