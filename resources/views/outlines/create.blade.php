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
            <h1>Create new outline</h1>
        </div>

        <form method="POST" action="{{ url('/outlines/create') }}" id="createNewOutlineForm" class="form-horizontal">
            {!! csrf_field() !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                <div class="col-md-2">
                    <label for="titleInput">Title</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="name" autofocus="autofocus" placeholder="Title" value="{{ old('name') }}" tabindex="1">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2">
                    <label for="tagSearchBox">Associate tags:</label>
                </div>
                <div class="col-md-10">
                    <input class="form-control" style="" type="text" id="tagSearchBox" placeholder="Search for tags &hellip;" tabindex="2">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">
                </div>
                <div class="col-md-10" id="tagList">
                    <!-- Here the tags are appended -->
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2">
                    <label for="referenceSearchBox">Associate references:</label>
                </div>
                <div class="col-md-10">
                    <input class="form-control" style="" type="text" id="referenceSearchBox" placeholder="Search for references &hellip;" tabindex="3">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">
                </div>
                <div class="col-md-10" id="referenceList">
                    <!-- Here the references are appended -->
                </div>
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error has-feedback' : '' }}">
                <div class="col-md-2">
                    <label for="desc">Description</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control" id="desc" name="description" placeholder="Short description (optional)" tabindex="4">
                        {{ old('description') }}
                    </textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-10">
                    <button type="submit" class="form-control" tabindex="5">Create Outline</button>
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
