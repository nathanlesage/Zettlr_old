@extends('app')

@section('scripts')
@endsection

{{--<script> for highlighing--}}
@section('scripts_on_document_ready')

@endsection
{{--</script>--}}

@section('content')
    <div class="container" style="background-color:white;">
        <div class="page-header">
            <h1>Edit {{ $outline->name }}</h1>
        </div>

        <form method="POST" action="{{ url('/outlines/edit') }}/{{ $outline->id }}" id="editOutlineForm" class="form-horizontal">
            {!! csrf_field() !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                <div class="col-md-2">
                    <label for="nameInput">Title</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="nameInput" name="name" autofocus="autofocus" placeholder="Name" value="{{ $outline->name }}">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2">
                    <label for="tagSearchBox">Associate tags:</label>
                </div>
                <div class="col-md-10">
                    <input class="form-control" type="text" id="tagSearchBox" placeholder="Search for tags &hellip;">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-10">
                    <div id="tagList">
                        <!-- Here the tags are appended -->
                        @if(count($outline->tags) > 0)
                            @foreach($outline->tags as $tag)
                                <div class="btn btn-primary" onClick="$(this).fadeOut(function() { $(this).remove(); })">
                                    <input type="hidden" value="{{ $tag->name }}" name="tags[]">
                                    {{ $tag->name }}
                                    <button type="button" class="close" title="Remove" onClick="$(this).parent().fadeOut(function() { $(this).remove(); })">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2">
                    <label for="referenceSearchBox">Associate references:</label>
                </div>
                <div class="col-md-10">
                    <input class="form-control" style="" type="text" id="referenceSearchBox" placeholder="Search for references &hellip;">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-10">
                    <div id="referenceList">
                        <!-- Here the references are appended -->
                        @if(count($outline->references) > 0)
                            @foreach($outline->references as $reference)
                                <div class="alert alert-success alert-dismissable"><input type="hidden" value="{{ $reference->id }}" name="references[]">{{ $reference->author_last }} {{ $reference->year }} <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error has-feedback' : '' }}">
                <div class="col-md-2">
                    <label for="desc">Description:</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control" id="desc" name="description" placeholder="Short description (optional)">{{ $outline->description }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-10">
                    <input type="submit" class="form-control" value="Save changes">
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
