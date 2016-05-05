@extends('app')

@section('content')
    <!-- For now just display a simple form -->
    <div class="container" style="background-color:white;">
        <div class="page-header">
            <h1>Import files</h1>
        </div>

        {!! Form::open(array('url'=>'/import','method'=>'POST', 'files'=>true)) !!}

        <div class="form-group">
            <textarea name="content" class="form-control" placeholder="Insert the text for conversion &hellip;" rows="20"></textarea>
        </div>
        <div class="form-group">
            <input type="file" name="notes" class="form-control">
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="suggestTags"> Suggest tags?
                </label>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" value="Submit" class="form-control btn btn-primary">
        </div>
    </form>
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
