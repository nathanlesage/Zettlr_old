<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Zettlr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Include jQuery -->
    {{ Html::script('js/jquery.min.js') }}

    <!-- Include noty jQuery plugin -->
    {{ Html::script('js/jquery.noty.packaged.min.js') }}
    <!-- Include Hotkey jQuery plugin -->
    {{ Html::script('js/jquery.hotkeys.js') }}
    <!-- Include tablesorter jQuery plugin -->
    {{ Html::script('js/jquery.tablesorter.min.js') }}

    <!-- Include jQuery UI -->
    {{ Html::style('css/jquery-ui.min.css') }}
    {{ Html::style('css/jquery-ui.structure.css') }}
    {{ Html::script('js/jquery-ui.min.js') }}

    <!-- Include Bootstrap CSS and JS -->
    {{ Html::style('css/app.min.css') }}
    {{ Html::script('js/bootstrap.min.js') }}

    <!-- Include helper functions -->
    {{ Html::script('js/helper_functions.js') }}

    <!-- Include codemirror main javascript -->
    {{ Html::script('js/codemirror.js') }}
    <!-- Bugfix that helps the textarea to be rendered successfully -->
    {{ Html::script('js/codemirror_addons/overlay.js') }}

    <!-- Include codemirror.css -->
    {{ Html::style('css/codemirror.css') }}

    <!-- Include Markdown and its addon GithubFlavoredMarkdown -->
    {{ Html::script('js/codemirror_modes/markdown.js') }}
    {{ Html::script('js/codemirror_modes/gfm.js') }}

    <!-- Include Show hint-addon for Codemirror -->
    {{ Html::script('js/codemirror_addons/show-hint.js') }}
    {{ Html::style('css/codemirror_addons/show-hint.css') }}

    {{-- yield possible additional scripts --}}
    @yield('scripts')

    {{-- yield anything that has to be executed on page load --}}
    <script>
    $(document).ready(function() {

        @yield('scripts_on_document_ready')

        @include('layouts.generic_document_ready')
    });
    </script>
</head>

<body>

    {{-- Navigation will only be showed to logged in users --}}
    {{-- All others will always be redirected to "/login". --}}

    <!-- Navigation -->
    @if (Auth::check())
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/home') }}">Zettlr</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/notes/index') }}">Notes</a></li>
                        <li><a href="{{ url('/notes/create') }}">Insert notes</a></li>
                        <li><a href="{{ url('/outlines') }}">Outlines</a></li>
                        <li><a href="{{ url('/outlines/create') }}">Create new outline</a></li>
                        <li><a href="{{ url('/trails') }}">Trails</a></li>
                        <li><a href="{{ url('tags/index') }}">Tags</a></li>
                        <li><a href="{{ url('/references/index') }}">References</a></li>
                    </ul>
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group" style="display:table;">
                            <label class="sr-only" for="navSearchBar">Search in notes</label>
                            <input type="text" class="form-control" id="navSearchBar" placeholder="Search in notes &hellip;">
                        </div>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ url('/settings') }}">Hello, <em>{{ Auth::user()->name }}</em>!</a></li>
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
