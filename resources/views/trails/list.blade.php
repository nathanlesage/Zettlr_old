@extends('app')

@section('content')
    <div class="container" style="background-color:white;">
        <div class="page-header">
    		<h1>Trails</h1>
    	</div>
        @if(count($trailContainer) > 0)
            @for($i=0; $i < count($trailContainer); $i++)
                {{-- Here we are on note-level.--}}
                <h3>{{ $noteTitles[$trailContainer[$i][0][0]] }}</h3>
                @for($i2=0; $i2 < count($trailContainer[$i]); $i2++)
                    {{-- Here we are on trail-level. --}}
                    <ol class="breadcrumb">
                        <li>Trail #{{ $i2+1 }}</li>
                    @for($i3=0; $i3 < count($trailContainer[$i][$i2]); $i3++)
                        {{-- Aaand here we are on the notes-in-the-trail-level. --}}
                            <li><a href="{{ url('/notes/show') }}/{{ $trailContainer[$i][$i2][$i3] }}">{{ $noteTitles[$trailContainer[$i][$i2][$i3]] }}</a></li>
                    @endfor
                </ol>
                @endfor
            @endfor
        @else
            <div class="alert alert-info">We could not find any trails! Create some by linking related notes.</div>
        @endif
    </div>
@endsection
