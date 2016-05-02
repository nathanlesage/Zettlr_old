<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Zettlr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Generic Icons -->
    <link rel="shortcut icon" type="image/x-icon" href="/img/favicon/favicon.ico">
    <link rel="icon" type="image/x-icon" href="/img/favicon/favicon.ico">
    <link rel="icon" type="image/gif" href="/img/favicon/favicon.gif">
    <link rel="icon" type="image/png" href="/img/favicon/favicon.png">

    <!-- Apple specific icons -->
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-57x57.png" sizes="57x57">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-60x60.png" sizes="60x60">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-72x72.png" sizes="72x72">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-76x76.png" sizes="76x76">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-114x114.png" sizes="114x114">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-120x120.png" sizes="120x120">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-128x128.png" sizes="128x128">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-144x144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-152x152.png" sizes="152x152">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-180x180.png" sizes="180x180">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-precomposed.png">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-160x160.png" sizes="160x160">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-196x196.png" sizes="196x196">

    <!-- Microsoft specific icons -->
    <meta name="msapplication-TileImage" content="/img/favicon/win8-tile-144x144.png">
    <meta name="msapplication-TileColor" content="#15c707">
    <meta name="msapplication-navbutton-color" content="#ffffff">
    <meta name="application-name" content="Zettlr"/>
    <meta name="msapplication-tooltip" content="Zettlr"/>
    <meta name="apple-mobile-web-app-title" content="Zettlr"/>
    <meta name="msapplication-square70x70logo" content="/img/favicon/win8-tile-70x70.png">
    <meta name="msapplication-square144x144logo" content="/img/favicon/win8-tile-144x144.png">
    <meta name="msapplication-square150x150logo" content="/img/favicon/win8-tile-150x150.png">
    <meta name="msapplication-wide310x150logo" content="/img/favicon/win8-tile-310x150.png">
    <meta name="msapplication-square310x310logo" content="/img/favicon/win8-tile-310x310.png">

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

    <!-- Include Bootstrap CSS and JS -->
    {{ Html::style('css/app.min.css') }}
    {{ Html::script('js/bootstrap.min.js') }}

    <!-- Include helper functions -->
    {{ Html::script('js/helper_functions.js') }}

    {{-- yield possible additional scripts --}}
    @yield('scripts')

    {{-- yield anything that has to be executed on page load --}}
    <script>
    $(document).ready(function() {

        // Mobile detection (to deactivate outline sorting on mobile devices as it will break the scrolling function)
        var isMobile = false;
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

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
                    <div class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </div>
                    <a class="navbar-brand" href="{{ url('/home') }}">Zettlr</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="nav navbar-nav">


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">App <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/settings') }}"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">Logged in as <em>{{ Auth::user()->name }}</em></li>
                                <li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Notes <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/notes/index') }}">View notes</a></li>
                                <li><a href="{{ url('/notes/create') }}">Insert notes</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ url('/trails') }}">Find trails</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expaned="false">Outlines <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/outlines') }}">Outlines</a></li>
                                <li><a href="{{ url('/outlines/create') }}">Create new outline</a></li>
                            </ul>
                        </li>

                        <li><a href="{{ url('tags/index') }}">Tags</a></li>
                        <li><a href="{{ url('/references/index') }}">References</a></li>
                    </ul>

                    <form class="navbar-form" role="search">
                        <div class="form-group" style="display:inline;">
                            <div class="input-group" style="display:table;">
                                <!-- We need this stupid addon for displaying max width, so let's at least give it a function -->
                                <span class="input-group-addon" style="width:1%;" onClick="$('#navSearchBar').focus()"><span class="glyphicon glyphicon-search"></span></span>
                                <label class="sr-only" for="navSearchBar">Search in notes</label>
                                <input type="text" class="form-control" id="navSearchBar" placeholder="Search in notes &hellip;">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    @endif

    @yield('content')

</body>

</html>
