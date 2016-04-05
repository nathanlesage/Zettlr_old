<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>noteworks | Index</title>
    
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Include Bootstrap CSS and JS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
    
    <!-- Include additional css -->
    {{ Html::style('css/main.css') }}
    
    <!-- Include codemirror main javascript -->
    {{ Html::script('js/codemirror.js') }}
    <!-- Bugfix that prevents the textarea to be rendered successfully -->
    {{ Html::script('js/codemirror_addons/overlay.js') }}
    
    <!-- Include codemirror.css -->
    {{ Html::style('css/codemirror.css') }}
    
    <!-- Include Markdown and its addon GithubFlavoredMarkdown -->
    {{ Html::script('js/codemirror_modes/markdown.js') }}
    {{ Html::script('js/codemirror_modes/gfm.js') }}
    
    <script>
    $(document).ready(function() {
    	// Is any gfm-code text in the area?
    	// (You just found a stupid pun. Congratulations!)
    	if($("#gfm-code").length)
    	{
    		var editor = CodeMirror.fromTextArea(document.getElementById("gfm-code"), {
        		mode: 'gfm',
        		lineNumbers: true,
        		theme: "default"
      		});
      	}
    });
    </script>
</head>

<body>

    {{-- Navigation will only be showed to logged in users --}}
    {{-- All others will always be redirected to "/login". --}}
    {{-- TODO: Remove the possibility for guest registering! --}}

    <!-- Navigation -->
    @if (Auth::check())
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="nav navbar-nav">
                    <li><a href="{{ action('NoteController@home') }}">Home</a></li>
                    <li><a href="{{ action('NoteController@index') }}">View all notes</a></li>
                    <li><a href="{{ action('NoteController@getCreate') }}">Insert</a></li>
                    <li><a href="#">Import</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    @endif

    @yield('content')

</body>

</html>
