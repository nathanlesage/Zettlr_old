@extends('app')

@section('scripts')
@endsection

{{--<script> for highlighing--}}
@section('scripts_on_document_ready')

// Create the autocomplete box
$( "#tagSearchBox" ).autocomplete({
  // The source option tells autocomplete to
  // send the request (with the term the user typed)
  // to a remote server and the response can be handled
  source: function( request, response ) {
      $.getJSON( "{{ url('/ajax/tag/search') }}/" + request.term, {}, function(data) {
        // Call the response function of autocompleteUI
        // We don't need to alter our json object as we
        // will be filling in everything manually via
        // focus, select and the _renderItem function.
        response(data);
      });
  },
  // Focus is what happens, when the user selects a menu item.
  // In our case autocomplete can't guess it, so we have to
  // manually tell it which key it should use
  focus: function( event, ui ) {
    $( "#tagSearchBox" ).val( ui.item.name );
    return false;
  },
  select: function( event, ui ) {
    // select function would assume to insert ui.item.label
    // so we've overwritten it.
    $( "#tagSearchBox" ).val( ui.item.name );
    addTag();
    return false;
  }
}).autocomplete("instance")._renderItem = function(ul, item) {
  // Overwriting render function, as our JSON has key name,
  // and not label (which renderItem would assume).
  return $("<li>").append(item.name).appendTo(ul);
};

    // Prevent form submission by pressing Enter key in inputs
    $(window).keydown(function(e){
    if(e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
      });

@endsection
{{--</script>--}}

@section('content')
<div class="container" style="background-color:white;">
  <div class="page-header">
    <h1>Create new outline</h1>
  </div>

    <form method="POST" action="{{ url('/outlines/create') }}" id="createNewOutlineForm">
            {!! csrf_field() !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
            		<label for="titleInput" class="sr-only">Title</label>
                	<input type="text" class="form-control" name="name" autofocus="autofocus" placeholder="Title" value="{{ old('name') }}">
            </div>

            <div class="form-group">
              <input class="form-control" style="" type="text" id="tagSearchBox" placeholder="Search for tags &hellip;">
            </div>
            <div class="form-group">
              <div id="tagList">
                <!-- Here the tags are appended -->
              </div>
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error has-feedback' : '' }}">
            		<label for="desc" class="sr-only">Description</label>
                	<textarea class="form-control" id="desc" name="description" placeholder="Short description (optional)">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
            	<button type="submit" class="btn btn-default">Create Outline</button>
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
