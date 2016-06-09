@extends('app')

@section('scripts')
@endsection
<script>
@section('scripts_on_document_ready')
$('#onClickAddHeading').click(function(e) {
    e.preventDefault();

    outlineID = $('div.page-header').attr("id");
    // The index results from the position of this element inside the outlinecontents
    outlineChildren = $('#outlineContents').children();

    // Do a 1-based index retrieval
    myIndex = outlineChildren.length+1;

    // Display a text input for the heading
    $('#outlineContents')
    .after('<div class="form-horizontal" id="formStyler">'
    + '<div class="input-group">'
    + '<input class="form-control" type="text" name="heading"'
    + 'id="onEnterAddHeading" placeholder="Heading" value="">'
    + '<div class="input-group-addon" style="cursor:pointer;" title="Cancel" data-toggle="tooltip" onClick="$(\'#formStyler\').remove()"><span class="glyphicon glyphicon-remove"></span></div></div>'
    + '<hr></div>');
    // Now focus
    $('#onEnterAddHeading').focus();
    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
    // bind the return key to this text area
    $('#onEnterAddHeading').on("keypress", function(e) {
        if(e.which == 13)
        {
            // For now just display it
            val = $('#onEnterAddHeading').val();
            // TODO: Ajax insert into database
            // Link: /ajax/outline/attach/{outlineID}/custom/{requestContent}/{index}/{type}
            $.getJSON("{{ url('/ajax/outline/attach') }}/" + outlineID + "/custom/" + encodeURIComponent(val) + "/" + myIndex + "/h2", {}, function(data) {
                // remove the form
                $('#formStyler').remove();
                $('#outlineContents').append('<h2 class="draggable" id="' + data.id + '">'+ val +'<span class="pull-right">'
                + '<a title="Remove custom field from outliner" href="#" class="onClickRemoveCustom" data-toggle="tooltip">'
                + '<span class="glyphicon glyphicon-remove"></span>'
                + '</a>'
                + '</span></h2>');
                displaySuccess("Custom field added successfully");
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                // Refresh the remove events
                $('.onClickRemoveCustom').click(removeCustom);
            }).fail(function() {
                displayError("Could not save custom field.")
            });
        }
        elseif(e.which == 27) // Escape
        {
            // Just remove the element and do nothing
            $('#formStyler').remove();
        }
    });
});
// End Heading input

$('#onClickAddParagraph').click(function(e) {
    // Now the same with paragraphs
    e.preventDefault();

    outlineID = $('div.page-header').attr("id");
    // The index results from the position of this element inside the outlinecontents
    outlineChildren = $('#outlineContents').children();

    // Do a 1-based index retrieval
    myIndex = outlineChildren.length+1;

    // Display a text input for the heading
    $('#outlineContents')
    .after('<div class="form-horizontal" id="formStyler">'
    + '<div class="input-group">'
    + '<textarea rows="10" class="form-control" name="paragraph"'
    + 'id="onEnterAddParagraph" placeholder="Press Shift+Return for a new line"'
    + 'value=""></textarea>'
    + '<div class="input-group-addon" style="cursor:pointer;" title="Cancel" data-toggle="tooltip" onClick="$(\'#formStyler\').remove()"><span class="glyphicon glyphicon-remove"></span></div>'
    + '</div><hr></div>');
    // Now focus and scroll down to have the field in view
    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
    $('#onEnterAddParagraph').focus();
    // bind the return key to this text area
    $('#onEnterAddParagraph').on("keypress", function(e) {
        // Add new lines with Shift+Enter
        if((e.which == 13) && !e.shiftKey)
        {
            val = $('#onEnterAddParagraph').val();
            $.getJSON("{{ url('/ajax/outline/attach') }}/" + outlineID + "/custom/" + encodeURIComponent(val) + "/" + myIndex + "/p", {}, function(data) {
                // remove the form
                $('#formStyler').remove();
                // Replace newline with <br>-tags just for instant displaying. When reloading the page, this is done
                // via the nl2br-function in PHP.
                val = (val + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br> '+ '$2');

                $('#outlineContents').append('<p class="draggable" id="' + data.id + '">'+ val +'<span class="pull-right">'
                + '<a title="Remove custom field from outliner" href="#" class="onClickRemoveCustom" data-toggle="tooltip">'
                + '<span class="glyphicon glyphicon-remove"></span>'
                + '</a>'
                + '</span></p>');

                displaySuccess("Custom field saved successfully");
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                // Refresh the deletion event
                $('.onClickRemoveCustom').click(removeCustom);
            }).fail(function() {
                displayError("Could not save custom field.")
            });
        }
        elseif(e.which == 27) // Escape
        {
            // Just remove the element and do nothing
            $('#formStyler').remove();
        }
    });
}); // End Paragraph Input

// Display a note search box
// Helper function
function addNoteToOutliner(data)
{
    outlineID = $('div.page-header').attr("id");
    // The index results from the position of this element inside the outlinecontents
    outlineChildren = $('#outlineContents').children();

    // That returns all children INCLUDING the formStyler
    // Do a 1-based index retrieval
    myIndex = outlineChildren.length + 1;

    $('#formStyler').remove();
    $('#outlineContents').append('<article id="'+data.id+'" class="draggable"><h3 class="bg-primary">'+data.title+'<span class="pull-right">'
    + '<a title="Remove note from outliner" href="#" class="onClickRemoveNote" style="color:#bce8f1;" data-toggle="tooltip">'
    + '<span class="glyphicon glyphicon-remove"></span>'
    + '</a>'
    + '</span></h3><div>'+data.content+'</div><hr></article>');

    // Now create the JSON
    // Link: /ajax/outline/attach/{outlineID}/{attachmentType}/{requestContent}/{index}/{type}
    // Type can be omitted
    $.getJSON("{{ url('/ajax/outline/attach') }}/"+ outlineID + "/note/" + data.id + "/" + myIndex, {}, function(data) {
        displaySuccess("Note attached successfully");
        // Refresh the deletion event
        $('.onClickRemoveNote').click(removeNote);
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
    }).fail(function(data) {
        displayError("Could not attach note.");
    });
}

$('#onClickAddNote').click(function(e) {
    e.preventDefault();

    // Display a search box
    $('#outlineContents')
    .after('<div class="form-horizontal" id="formStyler">'
    + '<div class="input-group">'
    + '<input class="form-control" type="text" name="note" id="noteSearchBox"'
    + 'placeholder="Search for notes" value="">'
    + '<div class="input-group-addon" style="cursor:pointer;" title="Cancel" data-toggle="tooltip" onClick="$(\'#formStyler\').remove()"><span class="glyphicon glyphicon-remove"></span></div>'
    + '</div><hr></div>');
    // Now focus
    $('#noteSearchBox').focus();

    $( "#noteSearchBox" ).autocomplete({
        // The source option tells autocomplete to
        // send the request (with the term the user typed)
        // to a remote server and the response can be handled
        source: function( request, response ) {
            request.term = encodeURIComponent(request.term);
            $.getJSON( "{{ url('/ajax/note/search') }}/" + request.term, {}, function(data) {
                // Call the response function of autocompleteUI
                // We don't need to alter our json object as we
                // will be filling in everything manually via
                // focus, select and the _renderItem function.
                response(data);
            }).fail(function() { displayError("Could not get search results"); });
        },
        // Do nothing on focus (i.e. don't do anything with content)
        focus: function( event, ui ) {
            return false;
        },
        select: function( event, ui ) {
            // TODO: Get Notes via json
            $.getJSON("{{ url('/ajax/note')}}/" + ui.item.id, {}, function(data) {
                addNoteToOutliner(data);
            }).fail(function() { displayError("Could not add note")});
            return false;
        }
    }).autocomplete("instance")._renderMenu = function(ul, items) {

        $(ul).addClass("list-group");
        var autocompleteObject = this;
        $.each(items, function(index, item) {
            // call _renderItemData which calls _renderItem
            autocompleteObject._renderItemData(ul, item);
        });
        // Scroll down
        $('html, body').animate({
            // add the body padding (fixed navbar hack)
            scrollTop: $("#noteSearchBox").offset().top - parseInt($("body").css("paddingTop"))
        }, 100);
    };

    // Also overwrite the renderItem function
    $("#noteSearchBox").autocomplete("instance")._renderItem = function(ul, item) {
        // Overwriting render function, as our JSON has key name,
        // and not label (which renderItem would assume).
        return $("<li>").addClass("list-group-item").append('<h4 class="list-group-item-heading">'+item.title+'</h4><p class="list-group-item-text">'+item.content+'</p>').appendTo(ul);
    };
}); // End note input

function updateIndices()
{
    // call URL: /ajax/changeindex/{type}/{elementId}/{outlineId}/{newIndex}
    // type can be either note or custom
    // First get all children and get through them
    error = false;
    $('#outlineContents').children().each(function(elemIndex) {
        // First get the type
        if($(this).is("article"))
        {
            // We have a note
            type = 'note';
            elementId = $(this).attr("id");
            outlineId = $('div.page-header').attr("id");
            // Index is 1-based
            newIndex = elemIndex + 1;
        }
        else {
            // We have a custom field
            type = 'custom';
            elementId = $(this).attr("id");
            outlineId = $('div.page-header').attr("id");
            // Index is 1-based
            newIndex = elemIndex + 1;
        }
        $.getJSON("{{ url('/ajax/changeindex')}}/" + type + "/" + elementId + "/" + outlineId + "/" + newIndex, {}, function(data) {
        })
        .fail(function() { error = true; });
    });
    if(!error)
    displaySuccess("All changes saved");
    else
    displayError("Could not save some changes");
}

$('.onClickRemoveNote').click(removeNote);

function removeNote(e) {
    e.preventDefault();
    e.stopPropagation();
    outlineId = $('div.page-header').attr("id");
    noteId = $(this).parent().parent().parent().attr("id");
    $.getJSON("{{ url('/ajax/outline/detach')}}/" + outlineId + "/" + noteId, {}, function(data) {
        displaySuccess("Removed note from outliner");
        updateIndices();
        location.reload();
    })
    .fail(function() {
        displayError("Could not remove note from outliner");
    });
}

$('.onClickRemoveCustom').click(removeCustom);

function removeCustom(e)
{
    e.preventDefault();
    e.stopPropagation();
    outlineId = $('div.page-header').attr("id");
    customId = $(this).parent().parent().attr("id");
    $.getJSON("{{ url('/ajax/outline/remove')}}/" + outlineId + "/" + customId, {}, function(data) {
        displaySuccess("Removed custom note from outliner");
        updateIndices();
        location.reload();
    })
    .fail(function() {
        displayError("Could not remove custom field from outliner");
    });
}

$('#sortMode').click(function() {
    $(this).find('input').prop('checked', true);
    toggleMode($(this).find('input').val());
});

$('#editMode').click(function() {
    $(this).find('input').prop('checked', true);
    toggleMode($(this).find('input').val());
});

function toggleMode(mode)
{
    if(mode == 'editMode') {
        // Enter edit mode
        editMode = true;
        sortMode = false;
        if($('#outlineContents').hasClass('ui-sortable'))
        $('#outlineContents').sortable("destroy");

        // Remove the draggable classes
        $('h2.draggable').addClass("notDraggable").removeClass('draggable');
        $('p.draggable').addClass("notDraggable").removeClass('draggable');
        $('article.draggable').addClass("notDraggable").removeClass('draggable');
    }
    else {
        if(isMobile)
        {
            // Disable on mobile browser as sortable crashes the touch scroll functionality
            displayError("Cannot enter sortMode on mobile.");
            return;
        }

        editMode = false;
        sortMode = true;
        // Enter sort mode
        $('#outlineContents').sortable({
            axis: "y",
            // TODO: Implement cross browser cursor (no, not move)
            cursor:"-webkit-grabbing",
            items: ".draggable",
            opacity: 0.5,
            // Don't drag and confuse the server on link clicking
            cancel: "a",
            update: function(event, ui) {
                updateIndices();
            }
        }); // End sortable

        // Add the draggable classes
        $('h2.notDraggable').addClass("draggable").removeClass('notDraggable');
        $('p.notDraggable').addClass("draggable").removeClass('notDraggable');
        $('article.notDraggable').addClass("draggable").removeClass('notDraggable');
    }
}

@endsection
</script>
@section('content')
    <div class="container" style="background-color:white;">
        <div class="page-header" id="{{ $outline->id }}">
            <!-- Menu -->
            <div class="dropdown pull-right">
                <button href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="glyphicon glyphicon-option-horizontal"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/outlines/edit') }}/{{ $outline->id }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
                    <li><a href="{{ url('/outlines/show/' . $outline->id . '/export') }}"><span class="glyphicon glyphicon-download"></span> Export</a></li>
                    <li><a href="{{ url('/notes/create') }}/{{ $outline->id }}"><span class="glyphicon glyphicon-plus"></span> Create new notes</a></li>
                    <li><a href="{{ url('/outlines/delete') }}/{{ $outline->id }}"><span class="glyphicon glyphicon-trash"></span> Delete</a></li>
                    <li role="separator" class="divider"></li>
                    <li id="sortMode"><a href="#">
                        <div class="radio">
                            <label>
                                <input type="radio" name="mode" value="sortMode"> Sort mode
                            </label>
                        </div>
                    </a></li>
                    <li id="editMode"><a href="#">
                        <div class="radio">
                            <label>
                                <input type="radio" name="mode" value="editMode" checked="checked"> Edit mode
                            </label>
                        </div>
                    </li>
                    <li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>

            <h1>{{ $outline->name }} <small>Outline</small></h1>
            <!-- For the ajax functions -->
            <input type="hidden" name="_token" id="csrf" value="{{ csrf_token() }}">
        </div>
        @if($outline->description)
            <div class="well well-lg">{{ $outline->description }}</div>
        @else
            <div class="well well-lg"><em>No description</em></div>
        @endif
        <div class="row">
            <div class="col-md-6">
                @if(count($outline->tags) > 0)
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-info">Associated tags</li>
                        @foreach($outline->tags as $tag)
                            <li class="list-group-item">{{ $tag->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-md-6">
                @if(count($outline->references) > 0)
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success">Associated references</li>
                        @foreach($outline->references as $reference)
                            <li class="list-group-item">{{ $reference->author_last }} ({{ $reference->year }}): {{ $reference->title }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div id="outlineContents">
            <!-- Here the contents of this outliner will be displayed -->
            @if(count($attachedElements) > 0)
                @foreach($attachedElements as $element)
                    {{-- Each element can either be a note or a customField --}}
                    {{-- Determine with $element->objType (can be 'custom' or 'note')--}}
                    @if($element->objType == 'note')
                        <article id="{{ $element->id }}" class="notDraggable">
                            <h3 class="bg-primary">{{ $element->title }}
                                <span class="pull-right">
                                    <a title="Remove note from outliner" href="#" class="onClickRemoveNote" style="color:#bce8f1;" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </span>
                            </h3>
                            <div onClick="codifyOnEdit($(this), {{ $element->id }})">{!! Markdown::convertToHtml($element->content) !!}</div>
                            <hr>
                        </article>
                    @else
                        {{-- Element is a custom field --}}
                        <{{ $element->type }} class="notDraggable" id="{{ $element->id }}">{!! $element->content !!}
                        <span class="pull-right">
                            <a title="Remove custom field from outliner" href="#" class="onClickRemoveCustom" data-toggle="tooltip">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </span></{{ $element->type }}>
                    @endif
                @endforeach
            @endif
        </div>
        {{-- Now add functionality to let the users add additional stuff --}}
        <!-- First: What do you want to add? -->
        <button type="button" class="btn btn-primary" id="onClickAddHeading">Add a new heading</button>
        <button type="button" class="btn btn-primary" id="onClickAddParagraph">Add a new custom note</button>
        <button type="button" class="btn btn-primary" id="onClickAddNote">Add a new note to this outliner</button>
        <hr>
    </div>
@endsection
