{{-- Generic code to be executed in app.blade.php --}}

// Select all elements with data-toggle="tooltip" in the document
$('[data-toggle="tooltip"]').tooltip();

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

/*
* Functions for search bar
*/
$("#navSearchBar").autocomplete({
    // The source option tells autocomplete to
    // send the request (with the term the user typed)
    // to a remote server and the response can be handled
    source: function( request, response ) {
        $.getJSON( "{{ url('/ajax/note/search') }}/" + request.term, {}, function(data) {
            // Call the response function of autocompleteUI
            // We don't need to alter our json object as we
            // will be filling in everything manually via
            // focus, select and the _renderItem function.
            response(data);
        }).fail(function() { displayError("Could not get search results"); });
    },
    // Do nothing on focus (i.e. don't do anything with content
    focus: function( event, ui ) {
        return false;
    },
    select: function( event, ui ) {
        window.location.href = "{{ url('/notes/show') }}/" + ui.item.id;
        return false;
    }
}).autocomplete("instance")._renderMenu = function(ul, items) {

    $(ul).addClass("list-group");
    // Bootstrap's fixed navbar has a z-index of 1030
    $(ul).css('z-index', '1031');
    var autocompleteObject = this;
    $.each(items, function(index, item) {
        // call _renderItemData which calls _renderItem
        autocompleteObject._renderItemData(ul, item);
    });

};

// Also overwrite the renderItem function
$("#navSearchBar").autocomplete("instance")._renderItem = function(ul, item) {
    // Overwriting render function, as our JSON has key name,
    // and not label (which renderItem would assume).
    return $("<li>").addClass("list-group-item").append('<h4 class="list-group-item-heading">'+item.title+'</h4><p class="list-group-item-text">'+item.content+'</p>').appendTo(ul);
};
