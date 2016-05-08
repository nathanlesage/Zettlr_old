@extends('app')

@section('scripts')
    <script>
    function titleTurnEditable(myElem)
    {
        // Fist check if there are other headings currently as an input
        if($("#editField").length)
        titleFinishEdit($("#editField"));

        // Retrieve the note's index - format: title[index]
        index = $(myElem).find("input[type='hidden']").attr("name").match(/([0-9]{1,})/)[0];

        $(myElem).replaceWith('<input type="text" name="' + index + '" class="form-control" id="editField" value=\'' + $(myElem).text() + '\'>');

        $("#editField").focus();

        // Display an info that one can close this via Return
        displayInfo("Finish editing by pressing the return key");

        // Bind an event listener to it
        $("#editField").keypress(function(e) {
            if(e.which == 13) { // Enter

                $(this).replaceWith('<h2 class="bg-primary" onClick="titleTurnEditable($(this))"><input type="hidden" name="title[' + $(this).attr("name") + ']" value=\'' + $(this).val() + '\'>' + $(this).val() + '</h2>');
            }
        });
    }

    function toggleRestForm()
    {
        console.log("toggle");
        if($("#outlineForm").length)
        {
            $("#outlineForm").remove();
        }
        else
        {
            $('<div id="outlineForm"><div class="form-group">'
                + '<input type="text" value="" name="outlineName" class="form-control" placeholder="Outline name"></div><div class="form-group">'
                + '<input type="text" value="" name="outlineDescription" class="form-control" placeholder="Outline description (optional)">'
                + '</div></div>').insertAfter("#outlineBox");
        }
    }
    </script>
@endsection

@section('content')
    <!-- For now just display a simple page -->
    <div class="container" style="background-color:white;">
        <div class="page-header">
            <h1>Import files <small>Step #2: Confirm imports</small></h1>
        </div>
        <div class="alert alert-info">
            On this page, we've collected for you all the notes we could find in your uploaded files. Please check them carefully before you click on the import button. If you see a mistake, just click on the respective title or on the content, to be able to edit the contents.
        </div>
        <hr>
        <form action="{{ url('import/finish') }}" method="POST">
            {{ csrf_field() }}
        @foreach($notes as $index => $note)
            <h2 class="bg-primary" onClick="titleTurnEditable($(this))"><input type="hidden" name="title[{{ $index }}]" value="{{ $note->title }}">{{ $note->title }}</h2>
                <pre onClick="codify($(this), {{ $index }})"><textarea class="hidden" name="content[{{ $index }}]">{{ $note->content }}</textarea>{{ $note->content }}
                </pre>
                @if(count($note->suggestedTags) > 0)
                    <div class="well">Suggested tags:
                        @foreach($note->suggestedTags as $tag)
                            <div class="btn btn-primary tag" onClick="$(this).fadeOut(function() { $(this).remove(); })">
                                <input type="hidden" value="{{ $tag }}" name="tags[{{ $index }}][]">
                                {{ $tag }}
                                <button type="button" class="close" title="Remove" onClick="$(this).parent().fadeOut(function() { $(this).remove(); })">
                                    &nbsp;<span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
            <hr>
            <div class="form-group" id="outlineBox">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="createOutline" onChange="toggleRestForm()"> Also create an outline for these notes?
                    </label>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Everything looks good? Import!" class="form-control btn btn-primary">
            </div>
        </form>
        </div>
    @endsection
