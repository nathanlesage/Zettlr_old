{{--views/notes/list.blade.php--}}
{{-- This view just outputs a list of all notes --}}
@extends('app')


@section('content')
<div class="container" style="background-color:white">
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Title</th>
        </tr>

       @if ($notes)
        @foreach ($notes as $note)
        <tr>
            <td>$note->id</td>
            <td>$note->title</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2"><p class="alert alert-warning">There are no notes to show <span class="glyphicon glyphicon-warning-sign pull-right" aria-hidden="true"></span></p></td>
        </tr>
        @endif
    </table>
</div>
@endsection