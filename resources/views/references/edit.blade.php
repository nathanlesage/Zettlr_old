@extends('app');

@section('content')
<div class="container" style="background-color:white;">
  <div class="page-header">
    <h3 class="page-title">Edit reference</h3>
  </div>

  <form class="form-horizontal" method="POST" action="{{ url('/references/edit') }}/{{ $reference->id }}" id="editReferenceForm">
    {{ csrf_field() }}
    <div class="form-group">
      <div class="col-sm-2">
        <label for="authorPreName">Author's first name(s):</label>
      </div>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="authorPreName" name="author_first" value="{{ $reference->author_first }}">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-2">
        <label for="authorSurName">Author's surname:</label>
      </div>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="authorSurName" name="author_last" value="{{ $reference->author_last }}">
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-2">
        <label for="referenceYear">Year:</label>
      </div>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="referenceYear" name="year" value="{{ $reference->year }}">
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-2">
        <label for="referenceTitle">Title:</label>
      </div>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="referenceTitle" name="title" value="{{ $reference->title }}">
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-2">
        <label for="referenceType">Reference type: </label>
      </div>
      <div class="col-sm-10">
        <select class="form-control" name="reference_type" id="referenceType">
          <option value="1" @if($reference->reference_type == 1) selected @endif>Audio Recording</option>
          <option value="2" @if($reference->reference_type == 2) selected @endif>Blogpost</option>
          <option value="3" @if($reference->reference_type == 3) selected @endif>Book</option>
          <option value="4" @if($reference->reference_type == 4) selected @endif>Book Section</option>
          <option value="5" @if($reference->reference_type == 5) selected @endif>Case</option>
          <option value="6" @if($reference->reference_type == 6) selected @endif>Conference Paper</option>
          <option value="7" @if($reference->reference_type == 7) selected @endif>Dictionary Entry</option>
          <option value="8" @if($reference->reference_type == 8) selected @endif>Document</option>
          <option value="9" @if($reference->reference_type == 9) selected @endif>Email</option>
          <option value="10" @if($reference->reference_type == 10) selected @endif>Encyclopedia Article</option>
          <option value="11" @if($reference->reference_type == 11) selected @endif>Film</option>
          <option value="12" @if($reference->reference_type == 12) selected @endif>Forum post</option>
          <option value="13" @if($reference->reference_type == 13) selected @endif>Interview</option>
          <option value="14" @if($reference->reference_type == 14) selected @endif>Journal Article</option>
          <option value="15" @if($reference->reference_type == 15) selected @endif>Letter</option>
          <option value="16" @if($reference->reference_type == 16) selected @endif>Magazine Article</option>
          <option value="17" @if($reference->reference_type == 17) selected @endif>Manuscript</option>
          <option value="18" @if($reference->reference_type == 18) selected @endif>Newspaper Article</option>
          <option value="19" @if($reference->reference_type == 19) selected @endif>Note</option>
          <option value="20" @if($reference->reference_type == 20) selected @endif>Patent</option>
          <option value="21" @if($reference->reference_type == 21) selected @endif>Podcast</option>
          <option value="22" @if($reference->reference_type == 22) selected @endif>Presentation</option>
          <option value="23" @if($reference->reference_type == 23) selected @endif>Radio Broadcast</option>
          <option value="24" @if($reference->reference_type == 24) selected @endif>Report</option>
          <option value="25" @if($reference->reference_type == 25) selected @endif>Statute</option>
          <option value="26" @if($reference->reference_type == 26) selected @endif>Thesis</option>
          <option value="27" @if($reference->reference_type == 27) selected @endif>TV Broadcast</option>
          <option value="28" @if($reference->reference_type == 28) selected @endif>Video Recording</option>
          <option value="29" @if($reference->reference_type == 29) selected @endif>Webpage</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-10">
        <button type="submit" class="btn btn-default">Edit</button>
      </div>
    </div>
  </form>
</div>
@endsection
