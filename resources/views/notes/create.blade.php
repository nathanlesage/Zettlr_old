{{-- Creation template --}}
@extends('app')

{{-- Yield additional scripts --}}
@section('scripts')
@endsection

{{-- Yield our document ready code --}}
@section('scripts_on_document_ready')
@endsection

@section('content')
    <div class="container" style="background-color:white">
        <div class="page-header">
            <h1>Create new note
                @if($outline)
                    <small>for <strong>{{$outline->name}}</strong></small>
                @endif
            </h1>
        </div>

        <form method="POST" action="{{ url('/notes/create') }}" id="noteForm">
            {!! csrf_field() !!}

            <div class="row{{ $errors->has('title') ? ' has-error has-feedback' : '' }}">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="titleInput" class="sr-only">Title</label>
                        <input type="text" class="form-control" name="title" autofocus="autofocus" placeholder="Title" value="{{ old('title') }}" tabindex="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input class="form-control" style="" type="text" id="tagSearchBox" placeholder="Search for tags &hellip;" tabindex="3">
                    </div>
                </div>
            </div>

            <div class="row{{ $errors->has('content') ? ' has-error has-feedback' : '' }}">
                <div class="col-md-8">
                    <div class="form-group">
                    <label for="gfm-code" class="sr-only">Content</label>
                    <textarea class="form-control" id="gfm-code" name="content" placeholder="Content" tabindex="2">{{ old('content') }}</textarea>
                </div>
                </div>
                <div class="col-md-4" id="tagList">
                    <!-- Here the tags are appended -->
                    @if($outline)
                        @if(count($outline->tags) > 0)
                            @foreach($outline->tags as $tag)
                                <div class="btn btn-primary tag" onClick="$(this).fadeOut(function() { $(this).remove(); })">
                                    <input type="hidden" value="{{ $tag->name }}" name="tags[]">
                                    {{ $tag->name }}
                                    <button type="button" class="close" title="Remove" onClick="$(this).parent().fadeOut(function() { $(this).remove(); })">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    @endif
                    {{-- Old tags from $request --}}
                    @if(count(old('tags')) > 0)
                        @foreach(old('tags') as $tag)
                            {{-- The old object only contains the array --}}
                            <div class="btn btn-primary tag" onClick="$(this).fadeOut(function() { $(this).remove(); })">
                                <input type="hidden" value="{{ $tag }}" name="tags[]">
                                {{ $tag }}
                                <button type="button" class="close" title="Remove" onClick="$(this).parent().fadeOut(function() { $(this).remove(); })">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        @if($outline)
                            <input type="hidden" name="outlineId" value="{{ $outline->id }}">
                        @endif
                        <button type="submit" class="form-control" tabindex="5">Create</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input class="form-control" style="" type="text" id="referenceSearchBox" placeholder="Search for references &hellip;" tabindex="4">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <div id="referenceList">
                        <!-- Here the references are appended -->
                        @if($outline)
                            @if(count($outline->references) > 0)
                                @foreach($outline->references as $reference)
                                    <div class="alert alert-success alert-dismissable">
                                        <input type="hidden" value="{{ $reference->id }}" name="references[]">
                                        {{ $reference->author_last }} {{ $reference->year }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                        @if(count(old('references')) > 0)
                            @foreach(old('references') as $referenceID)
                                <?php $reference = App\Reference::find($referenceID) ?>
                                {{-- The old object only contains the array --}}
                                <div class="alert alert-success alert-dismissable">
                                    <input type="hidden" value="{{ $reference->id }}" name="references[]">
                                    {{ $reference->author_last }} {{ $reference->year }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
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
