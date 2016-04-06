<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>noteworks | Index</title>
    
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
    <!-- Include noty jQuery plugin -->
    <?php echo e(Html::script('js/jquery.noty.packaged.min.js')); ?>

    
    <!-- Include Hotkey jQuery plugin -->
    <?php echo e(Html::script('js/jquery.hotkeys.js')); ?>

    
    <!-- Include jQuery UI -->
    <?php echo e(Html::style('css/jquery-ui.min.css')); ?>

    <?php echo e(Html::style('css/jquery-ui.structure.css')); ?>

    <?php echo e(Html::script('js/jquery-ui.min.js')); ?>


    <!-- Include Bootstrap CSS and JS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
    
    <!-- Include additional css -->
    <?php echo e(Html::style('css/main.css')); ?>

    
    <!-- Include helper functions -->
    <?php echo e(Html::script('js/helper_functions.js')); ?>

    
    <?php /* yield possible additional scripts */ ?>
    <?php echo $__env->yieldContent('scripts'); ?>
</head>

<body>

    <?php /* Navigation will only be showed to logged in users */ ?>
    <?php /* All others will always be redirected to "/login". */ ?>
    <?php /* TODO: Remove the possibility for guest registering! */ ?>

    <!-- Navigation -->
    <?php if(Auth::check()): ?>
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
                    <li><a href="<?php echo e(action('NoteController@home')); ?>">Home</a></li>
                    <li><a href="<?php echo e(action('NoteController@index')); ?>">View all notes</a></li>
                    <li><a href="<?php echo e(action('NoteController@getCreate')); ?>">Insert</a></li>
                    <li><a href="#">Import</a></li>
                </ul>
                <form class="navbar-form navbar-right" role="search">
        			<div class="form-group">
          				<input type="text" class="form-control" placeholder="Search in notes &hellip;">
        			</div>
      			</form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo e(url('/logout')); ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>

</body>

</html>
