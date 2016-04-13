{{--<script>--}}
{{-- Generic code to be executed in app.blade.php --}}
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
             "Shift-Enter": function(cm){ $("#editNoteForm").submit(); }
             }
    });

    // Submit form on Shift+Enter
    // We're binding it to the document, which leads to
    // submitting the form REGARDLESSLY of when we press it.
    // TODO: Think about removing this (but think twice)
    $("div.codeMirror-focused").bind('keyup', 'Shift+Return', function(){
      $("#editNoteForm").submit();
    });

    // Do we have any errors concerning content? Add them to the editor afterwards.
    if({{ $errors->has('content') ? 'true' : 'false' }})
      $("div.CodeMirror").addClass("has-error has-feedback");
  }

  // Create the autocomplete box
  if($('#tagSearchBox').length)
  {
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
          data.unshift(new Object({name: $("#tagSearchBox").val(), isFieldValue: true}));
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
    autoFocus: true,
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
    if(item.isFieldValue)
      return $("<li>").append('Just use <strong>' + item.name + '</strong>').appendTo(ul);
    return $("<li>").append(item.name).appendTo(ul);
  };
  }

  // Create the reference search box
  if($('#referenceSearchBox').length)
  {
    $( "#referenceSearchBox" ).autocomplete({
    // The source option tells autocomplete to
    // send the request (with the term the user typed)
    // to a remote server and the response can be handled
    source: function( request, response ) {
        $.getJSON( "{{ url('/ajax/reference/search') }}/" + request.term, {}, function(data) {
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
      $( "#referenceSearchBox" ).val( ui.item.author_last + " (" + ui.item.year + "): " + ui.item.title );
      return false;
    },
    autoFocus: true,
    select: function( event, ui ) {
      // select function would assume to insert ui.item.label
      // so we've overwritten it.
      $( "#referenceSearchBox" ).val( ui.item.author_last + " (" + ui.item.year + "): " + ui.item.title);
      addReference(ui.item.id);
      return false;
    }
  }).autocomplete("instance")._renderItem = function(ul, item) {
    // Overwriting render function, as our JSON has key name,
    // and not label (which renderItem would assume).
    return $("<li>").append(item.author_last + " (" + item.year + "): " + item.title).appendTo(ul);
  };
  }
{{--</script>--}}
