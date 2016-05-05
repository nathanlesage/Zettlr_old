@extends('app')

@section('scripts')
    <script>
    function turnEditable(myElem)
    {
        $(myElem).replaceWith('<input type="text" class="form-control" value="' + $(myElem).text() + '" onKeyPress="finishEdit($(this))">')
    }

    function finishEdit(myElem)
    {
        $(myElem).replaceWith('<h2 class="bg-primary" onClick="turnEditable($(this))">' + $(myElem).val() + '</h2>');
    }
    </script>
@endsection

@section('content')
    <!-- For now just display a simple page -->
    <div class="container" style="background-color:white;">
        <div class="page-header">
            <h1>Import files <small>Confirm status</small></h1>
        </div>
        @foreach($notes as $note)
            <h2 class="bg-primary" onClick="turnEditable($(this))">{{ $note->title }}</h2>
            <pre>{{ $note->content }}</pre>
            @if(count($note->suggestedTags) > 0)
                <div class="well">Suggested tags:
                    @foreach($note->suggestedTags as $tag)
                        <div class="btn btn-primary tag" onClick="$(this).fadeOut(function() { $(this).remove(); })">
                            <input type="hidden" value="{{ $tag }}" name="tags[]">
                            {{ $tag }}
                            <button type="button" class="close" title="Remove" onClick="$(this).parent().fadeOut(function() { $(this).remove(); })">
                                &nbsp;<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
@endsection
