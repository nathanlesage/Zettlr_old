@extends('app');

@section('content')
<div class="container" style="background-color:white;">
    <div class="page-header">
        <h3 class="page-title">Create new reference</h3>
    </div>

    <form class="form-horizontal" method="POST" action="{{ url('/references/create') }}" id="createNewReferenceForm">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="col-sm-2">
                <label for="authorPreName">Author's first name(s):</label>
            </div>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="authorPreName" autofocus name="author_first" value="{{ old('author_first') }}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2">
                <label for="authorSurName">Author's surname:</label>
            </div>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="authorSurName" name="author_last" value="{{ old('author_last') }}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2">
                <label for="referenceYear">Year:</label>
            </div>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="referenceYear" name="year" value="{{ old('year') }}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2">
                <label for="referenceTitle">Title:</label>
            </div>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="referenceTitle" name="title" value="{{ old('title') }}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2">
                <label for="referenceType">Reference type: </label>
            </div>
            <div class="col-sm-10">
                <select class="form-control" name="reference_type" id="referenceType">
                    <option value="1">Audio Recording</option>
                    <option value="2">Blogpost</option>
                    <option value="3" selected>Book</option>
                    <option value="4">Book Section</option>
                    <option value="5">Case</option>
                    <option value="6">Conference Paper</option>
                    <option value="7">Dictionary Entry</option>
                    <option value="8">Document</option>
                    <option value="9">Email</option>
                    <option value="10">Encyclopedia Article</option>
                    <option value="11">Film</option>
                    <option value="12">Forum post</option>
                    <option value="13">Interview</option>
                    <option value="14">Journal Article</option>
                    <option value="15">Letter</option>
                    <option value="16">Magazine Article</option>
                    <option value="17">Manuscript</option>
                    <option value="18">Newspaper Article</option>
                    <option value="19">Note</option>
                    <option value="20">Patent</option>
                    <option value="21">Podcast</option>
                    <option value="22">Presentation</option>
                    <option value="23">Radio Broadcast</option>
                    <option value="24">Report</option>
                    <option value="25">Statute</option>
                    <option value="26">Thesis</option>
                    <option value="27">TV Broadcast</option>
                    <option value="28">Video Recording</option>
                    <option value="29">Webpage</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-default">Create</button>
            </div>
        </div>
    </form>
</div>
@endsection
