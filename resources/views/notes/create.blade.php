{{-- Creation template --}}
@extends('app')

{{-- There are no additional script tags, so remember to provide them --}}
@section('scripts')

{{--Include CodeMirror stuff--}}
<!-- Include codemirror main javascript -->
{{ Html::script('js/codemirror.js') }}
<!-- Bugfix that helps the textarea to be rendered successfully -->
{{ Html::script('js/codemirror_addons/overlay.js') }}
   
<!-- Include codemirror.css -->
{{ Html::style('css/codemirror.css') }}
    
<!-- Include Markdown and its addon GithubFlavoredMarkdown -->
{{ Html::script('js/codemirror_modes/markdown.js') }}
{{ Html::script('js/codemirror_modes/gfm.js') }}



<script>
$(document).ready(function() {
    	// Is any gfm-code text in the area?
    	// (You just found a stupid pun. Congratulations!)
    	if($("#gfm-code").length)
    	{
    		var editor = CodeMirror.fromTextArea(document.getElementById("gfm-code"), {
        		mode: 'gfm',
        		lineNumbers: true,
        		theme: "default",
        		lineWrapping: true,
        		// Set Tab to false to focus next input
        		// And let Shift-Enter submit the form.
        		extraKeys: { "Tab": false, 
        					 "Shift-Enter": function(cm){ $("#createNewNoteForm").submit(); }
        				   }
      		});
      		
      		// Submit form on Shift+Enter
      		// We're binding it to the document, which leads to
      		// submitting the form REGARDLESSLY of when we press it.
      		// TODO: Think about removing this (but think twice)
      		$("div.codeMirror-focused").bind('keyup', 'Shift+Return', function(){
      			$("#createNewNoteForm").submit();
      		});
      		
      		// Do we have any errors concerning content? Add them to the editor afterwards.
      		if({{ $errors->has('content') ? 'true' : 'false' }})
      			$("div.CodeMirror").addClass("has-error has-feedback");
      	}
      	
      	// Create the autocomplete box
      	$( "#tagSearchBox" ).autocomplete({
      		// The source option tells autocomplete to
      		// send the request (with the term the user typed)
      		// to a remote server and the response can be handled
        	source: function( request, response ) {
            	$.getJSON( "{{ url('/ajax/tag/search') }}/" + request.term, {}, function(data) {
          			// Remove the keys from the JSON data
          			tagArray = [];
          			for(i = 0; i < data.length; i++)
          				tagArray.push(data[i].name);
          	
          			// Call the response function of autocompleteUI
          			response(tagArray);
          		});
        	}
      	});
      	
      	// Prevent form submission by pressing Enter key in inputs
      	$(window).keydown(function(e){
    		if(e.keyCode == 13) {
      			e.preventDefault();
      			return false;
    		}
 		});
      	
      	// Bind return key to adding the tag
      	$("#tagSearchBox").bind('keyup', 'Return', function(e){
      		e.preventDefault();
      		console.log("Return on SearchBox pressed");
      		$("#tagList").append('<div class="alert alert-info alert-dismissable"><input type="hidden" value="'+$("#tagSearchBox").val()+'" name="tags[]">'+$("#tagSearchBox").val()+' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      		$("#tagSearchBox").val("");
      	});
    });
</script>
@endsection

@section('content')
<div class="container" style="background-color:white">
    <h1>Create new note</h1>
    {{-- Check if this URL works --}}
    
    <form method="POST" action="{{ url('/notes/create') }}" id="createNewNoteForm">
            {!! csrf_field() !!}
            
            <div class="form-group row{{ $errors->has('title') ? ' has-error has-feedback' : '' }}">
            	<div class="col-md-8">
            		<label for="titleInput" class="sr-only">Title</label>
                	<input type="text" class="form-control" name="title" autofocus="autofocus" placeholder="Titel" value="{{ old('title') }}">  
                </div>
                <div class="col-md-4">
                	<input class="form-control" style="" type="text" id="tagSearchBox" placeholder="Search for tags &hellip;">
                </div>
            </div>
            
            <div class="form-group row{{ $errors->has('content') ? ' has-error has-feedback' : '' }}">
            	<div class="col-md-8">
            		<label for="gfm-code" class="sr-only">Content</label>
                	<textarea class="form-control" id="gfm-code" name="content" placeholder="Content">{{ old('content') }}</textarea>
                </div>
                <div class="col-md-4" id="tagList">
                	<!-- Here the tags are appended -->
                </div>
            </div>
            
            <div class="form-group row">
            	<div class="col-md-4 col-md-offset-4">
            		<button type="submit" class="btn btn-default">Create</button>
            	</div>
            </div>
		</form>
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
