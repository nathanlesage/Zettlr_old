<?php /*views/notes/list.blade.php*/ ?>
<?php /* This view just outputs a list of all notes */ ?>


<?php $__env->startSection('scripts'); ?>
<script>
	// Helper variables
	var ajaxNoteBaseUrl = "<?php echo e(url('ajax/note')); ?>";
</script>
<?php $__env->stopSection(); ?>

<?php /* for syntax highlighting: <script>*/ ?>
<?php $__env->startSection('scripts_on_document_ready'); ?>

    	// Bind mouse clicks to the onClickLoadNote h3 elements
    	$("div.onClickLoadNote").click(function() {
    		myPanelHeader = $(this);
    		myPanel = myPanelHeader.parent();
    		myPanelBody = myPanel.children(".panel-body");

    		// Determine if panel is opened or closed
    		if(myPanelBody.length)
    			closeNote(myPanel);
    		else
    			openNote(myPanel);
    	});

    	$("div.onClickLoadNote").mouseover(function() {
    		if(!$(this).parent().hasClass("panel-primary"))
    			$(this).parent().addClass("panel-info");
    	});
    	$("div.onClickLoadNote").mouseout(function() {
    		if(!$(this).parent().hasClass("panel-primary") || $(this).parent().hasClass("panel-info"))
    			$(this).parent().removeClass("panel-info");
    	});

    	// Close panel on focus lose to pertain consistency with keyboard nav
    	$("div.panel-default").blur(function() {
    		console.log("blur");
    		myPanel = $(this);
    		myPanelBody = myPanel.children(".panel-body");

    		if(myPanelBody.length)
    			closeNote(myPanel);
    	});

    	// Bind mouse clicks to the onClickRemoveNote anchor elements
    	$("a.onClickRemoveNote").click(function(event) {
    		// First stop event propagation to prevent triggering
    		// a console 404-error as jQuery would try to load
    		// the content of the note, because the a-Anchor propagates
    		// ("bubbles") up the click event to its parent - which
    		// happens to be the onClickLoadNote-div element.
    		event.stopPropagation();
    		myAnchor = $(this);
    		id = myAnchor.parent().parent().parent().parent().parent().attr("id");

    		$.getJSON("<?php echo e(url('/ajax/note/delete')); ?>/" + id, function(data) {
    		myAnchor.parent().parent().parent().slideUp("fast", function() {
    			displaySuccess("Note deleted successfully");
    				myAnchor.parent().parent().parent().parent().parent().remove();
    			});
    		})
    		.fail(function() {
    			displayError("Could not remove note");
    		});
    	});
<?php $__env->stopSection(); ?>
<?php /*</script> end syntax highlighting */ ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="background-color:white">
	<div class="page-header">
		<h1>notework <small>showing all notes</small></h1>
	</div>
       <?php if(count($notes) > 0): ?>
       <div class="panel-group" id="panel-container">
       <?php /* The content of the notes will be dynamically loaded */ ?>
        <?php foreach($notes as $note): ?>
        <div class="panel panel-default" id="<?php echo e($note->id); ?>">
	  			<div class="panel-heading onClickLoadNote" style="cursor:pointer;">
						<div class="row">
							<div class="col-md-10">
								<h3 class="panel-title"><?php echo e($note->id); ?> &mdash; <?php echo e($note->title); ?></h3>
							</div>
							<div class="col-md-2">
								<span class="pull-right">
								<a title="Inspect this note in Trail Mode" data-toggle="tooltip" href="<?php echo e(url('/notes/show')); ?>/<?php echo e($note->id); ?>">
									<span class="glyphicon glyphicon-search"></span>
								</a>&nbsp;&nbsp;
								<a title="Edit this note" data-toggle="tooltip" href="<?php echo e(url('/notes/edit/')); ?>/<?php echo e($note->id); ?>">
									<span class="glyphicon glyphicon-edit"></span>
								</a>&nbsp;&nbsp;
								<a title="Permanently delete note" href="#" class="onClickRemoveNote" data-toggle="tooltip">
									<span class="glyphicon glyphicon-remove"></span>
								</a>
							</span>
							</div>
						</div>

	  			</div>
				</div>
        <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="alert alert-warning">There are no notes to show. <strong><a href="<?php echo e(url('/notes/create')); ?>">Create a note now!</a></strong> <span class="glyphicon glyphicon-warning-sign pull-right" aria-hidden="true"></span></div>
        <?php endif; ?>

    <?php if(count($errors) > 0): ?>
	<div class="alert alert-danger">
		<ul>
            <?php foreach($errors->all() as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
	<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>