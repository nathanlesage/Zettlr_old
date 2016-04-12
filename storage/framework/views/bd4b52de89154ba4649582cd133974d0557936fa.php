<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>noteworks</title>

    <!-- Include jQuery -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
    <?php echo e(Html::script('js/jquery.min.js')); ?>


    <!-- Include noty jQuery plugin -->
    <?php echo e(Html::script('js/jquery.noty.packaged.min.js')); ?>

    <!-- Include Hotkey jQuery plugin -->
    <?php echo e(Html::script('js/jquery.hotkeys.js')); ?>


    <!-- Include jQuery UI -->
    <?php echo e(Html::style('css/jquery-ui.min.css')); ?>

    <?php echo e(Html::style('css/jquery-ui.structure.css')); ?>

    <?php echo e(Html::script('js/jquery-ui.min.js')); ?>


    <!-- Include Bootstrap CSS and JS -->
    <?php echo e(Html::style('css/bootstrap.min.css')); ?>

    <?php echo e(Html::script('js/bootstrap.min.js')); ?>

    <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>-->



    <!-- Include additional css -->
    <?php echo e(Html::style('css/main.css')); ?>


    <!-- Include helper functions -->
    <?php echo e(Html::script('js/helper_functions.js')); ?>


    <!-- Include codemirror main javascript -->
	<?php echo e(Html::script('js/codemirror.js')); ?>

	<!-- Bugfix that helps the textarea to be rendered successfully -->
	<?php echo e(Html::script('js/codemirror_addons/overlay.js')); ?>


	<!-- Include codemirror.css -->
	<?php echo e(Html::style('css/codemirror.css')); ?>


	<!-- Include Markdown and its addon GithubFlavoredMarkdown -->
	<?php echo e(Html::script('js/codemirror_modes/markdown.js')); ?>

	<?php echo e(Html::script('js/codemirror_modes/gfm.js')); ?>


  <!-- Include Show hint-addon for Codemirror -->
  <?php echo e(Html::script('js/codemirror_addons/show-hint.js')); ?>

  <?php echo e(Html::style('css/codemirror_addons/show-hint.css')); ?>


    <?php /* yield possible additional scripts */ ?>
    <?php echo $__env->yieldContent('scripts'); ?>

    <?php /* yield anything that has to be executed on page load */ ?>
    <script>
    $(document).ready(function() {

    // Select all elements with data-toggle="tooltip" in the document
	$('[data-toggle="tooltip"]').tooltip();

    <?php echo $__env->yieldContent('scripts_on_document_ready'); ?>

    /*
     * Functions for search bar follow here
     */
     $("#navSearchBar").autocomplete({
      		// The source option tells autocomplete to
      		// send the request (with the term the user typed)
      		// to a remote server and the response can be handled
        	source: function( request, response ) {
            	$.getJSON( "<?php echo e(url('/ajax/note/search')); ?>/" + request.term, {}, function(data) {
          			// Call the response function of autocompleteUI
          			// We don't need to alter our json object as we
          			// will be filling in everything manually via
          			// focus, select and the _renderItem function.
          			response(data);
          		}).fail(function() { displayError("Could not get search results"); });
        	},
        	// Do nothing on focus (i.e. don't do anything with content
        	focus: function( event, ui ) {
        		return false;
      		},
      		select: function( event, ui ) {
      			window.location.href = "<?php echo e(url('/notes/show')); ?>/" + ui.item.id;
        		return false;
      		}
      	}).autocomplete("instance")._renderMenu = function(ul, items) {

      	$(ul).addClass("list-group");
      		var autocompleteObject = this;
      		$.each(items, function(index, item) {
      			// call _renderItemData which calls _renderItem
      			autocompleteObject._renderItemData(ul, item);
      		});

      	};

      	// Also overwrite the renderItem function
      	$("#navSearchBar").autocomplete("instance")._renderItem = function(ul, item) {
      		// Overwriting render function, as our JSON has key name,
      		// and not label (which renderItem would assume).
      		return $("<li>").addClass("list-group-item").append('<h4 class="list-group-item-heading">'+item.title+'</h4><p class="list-group-item-text">'+item.content+'</p>').appendTo(ul);
    	};
    });
    </script>
</head>

<body>

    <?php /* Navigation will only be showed to logged in users */ ?>
    <?php /* All others will always be redirected to "/login". */ ?>
    <?php /* TODO: Remove the possibility for guest registering! */ ?>

    <!-- Navigation -->
    <?php if(Auth::check()): ?>
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
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo e(url('/home')); ?>">Home</a></li>
                    <li><a href="<?php echo e(url('/notes/index')); ?>">Notes</a></li>
                    <li><a href="<?php echo e(url('/notes/create')); ?>">Insert notes</a></li>
                    <li><a href="<?php echo e(url('/outlines')); ?>">Outlines</a></li>
                    <li><a href="<?php echo e(url('/outlines/create')); ?>">Create new outline</a></li>
                    <li><a href="#">Import</a></li>
                </ul>
                <form class="navbar-form navbar-left" role="search">
        			<div class="form-group">
        				<label class="sr-only" for="navSearchBar">Search in notes</label>
          				<input type="text" class="form-control" id="navSearchBar" placeholder="Search in notes &hellip;">
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
