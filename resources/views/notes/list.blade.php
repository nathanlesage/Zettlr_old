{{--views/notes/list.blade.php--}}
{{-- This view just outputs a list of all notes --}}
@extends('app')

@section('scripts')
<script>
	// Helper variables
	var ajaxNoteBaseUrl = "{{ url('ajax/note') }}";
</script>
@endsection

{{-- for syntax highlighting: <script>--}}
@section('scripts_on_document_ready')

    	// Bind mouse clicks to the onClickLoadNote h3 elements
    	$("div.onClickLoadNote").click(function() {
    		myPanelHeader = $(this);
    		myPanel = myPanelHeader.parent();
    		myPanelBody = myPanel.children(".panel-body");

    		// Determine if panel is opened or closed
    		if(myPanelBody.length)
    			closeNote(myPanel);
    		else
    			openNote(myPanel);
    	});

    	$("div.onClickLoadNote").mouseover(function() {
    		if(!$(this).parent().hasClass("panel-primary"))
    			$(this).parent().addClass("panel-info");
    	});
    	$("div.onClickLoadNote").mouseout(function() {
    		if(!$(this).parent().hasClass("panel-primary") || $(this).parent().hasClass("panel-info"))
    			$(this).parent().removeClass("panel-info");
    	});

    	// Close panel on focus lose to pertain consistency with keyboard nav
    	$("div.panel-default").blur(function() {
    		console.log("blur");
    		myPanel = $(this);
    		myPanelBody = myPanel.children(".panel-body");

    		if(myPanelBody.length)
    			closeNote(myPanel);
    	});

    	// Bind mouse clicks to the onClickRemoveNote anchor elements
    	$("a.onClickRemoveNote").click(function(event) {
    		// First stop event propagation to prevent triggering
    		// a console 404-error as jQuery would try to load
    		// the content of the note, because the a-Anchor propagates
    		// ("bubbles") up the click event to its parent - which
    		// happens to be the onClickLoadNote-div element.
    		event.stopPropagation();
    		myAnchor = $(this);
    		id = myAnchor.parent().parent().parent().parent().parent().attr("id");

    		$.getJSON("{{ url('/ajax/note/delete') }}/" + id, function(data) {
    		myAnchor.parent().parent().parent().slideUp("fast", function() {
    			displaySuccess("Note deleted successfully");
    				myAnchor.parent().parent().parent().parent().parent().remove();
    			});
    		})
    		.fail(function() {
    			displayError("Could not remove note");
    		});
    	});
@endsection
{{--</script> end syntax highlighting --}}

@section('content')
<div class="container" style="background-color:white">
	<div class="page-header">
		<h1>Notes</h1>
	</div>
       @if (count($notes) > 0)
       <div class="panel-group" id="panel-container">
       {{-- The content of the notes will be dynamically loaded --}}
        @foreach ($notes as $note)
        <div class="panel panel-default" id="{{ $note->id }}">
	  			<div class="panel-heading onClickLoadNote" style="cursor:pointer;">
						<div class="row">
							<div class="col-md-10">
								<h3 class="panel-title">{{ $note->id }} &mdash; {{ $note->title }}</h3>
							</div>
							<div class="col-md-2">
								<span class="pull-right">
								<a title="Inspect this note in Trail Mode" data-toggle="tooltip" href="{{ url('/notes/show') }}/{{ $note->id }}">
									<span class="glyphicon glyphicon-search"></span>
								</a>&nbsp;&nbsp;
								<a title="Edit this note" data-toggle="tooltip" href="{{ url('/notes/edit/') }}/{{ $note->id }}">
									<span class="glyphicon glyphicon-edit"></span>
								</a>&nbsp;&nbsp;
								<a title="Permanently delete note" href="#" class="onClickRemoveNote" data-toggle="tooltip">
									<span class="glyphicon glyphicon-remove"></span>
								</a>
							</span>
							</div>
						</div>

	  			</div>
				</div>
        @endforeach
        </div>
        @else
        <div class="alert alert-warning">There are no notes to show. <strong><a href="{{ url('/notes/create') }}">Create a note now!</a></strong> <span class="glyphicon glyphicon-warning-sign pull-right" aria-hidden="true"></span></div>
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
