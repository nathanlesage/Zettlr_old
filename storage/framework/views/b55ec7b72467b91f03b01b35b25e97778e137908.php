<?php /*views/notes/list.blade.php*/ ?>
<?php /* This view just outputs a list of all notes */ ?>


<?php $__env->startSection('scripts'); ?>
<script>
	// Helper variables
	var currentElement = 0;

	$(document).ready(function() {
	// TODO: When manually clicking on element traverse ALL childs to
	// close them all. Also, set currentElement to the clicked one.
	// TODO: When deleting an element, make sure if it was the currentElement
	// to set the next up/down element to current
	
    	// Bind mouse clicks to the onClickLoadNote h3 elements
    	$("h3.onClickLoadNote").click(function() {
    		myH3 = $(this);
    		myPanelHeader = myH3.parent();
    		myPanel = myPanelHeader.parent();
    		myPanelBody = myPanel.children(".panel-body"); // will be null if element is closed!
    		id = myH3.attr("id");
    		
    		// If the content already exists, just slide it up and delete
    		if(myPanelBody.length)
    		{
    			console.log("Closing element #" + myPanel.index());
    			myPanelBody.slideUp("fast", function() {
    				// Remove highlight class
    				myPanel.removeClass("panel-primary");
    				
    				// This is the #note-id-content - element
    				myPanelBody.remove();
    				
    			});
    		}
    		else
    		{
    			console.log("Opening element #" + myPanel.index());
    			// set this element as current
    			currentElement = myPanel.index();
    			// Ask the server via Ajax
    			$.getJSON("<?php echo e(url('ajax/note')); ?>/" + id, function(data) {
    				myPanel.append('<div class="panel-body" style="display:none;" id="note-'+ id +'-content">'+ data.content +'</div>');
    			})
    			.fail(function() {
    				displayError("Couldn't find note.");
    			})
    			.complete(function() {
    				// Add highlight class to parent element.
    				myPanel.addClass("panel-primary");
    				myPanel.children(".panel-body").slideDown("fast");
    			});
    		}
    	});
    	
    	// Bind mouse clicks to the onClickRemoveNote anchor elements
    	$("a.onClickRemoveNote").click(function(event) {
    		// First stop event propagation to prevent triggering
    		// a console 404-error as jQuery would try to load
    		// the content of the note, because the a-Anchor propagates
    		// ("bubbles") up the click event to its parent - which
    		// happens to be the onClickLoadNote-h3 element.
    		event.stopPropagation();
    		myElem = $(this);
    		id = $(this).attr("id");
    		
    		$.getJSON("<?php echo e(url('/ajax/note/delete')); ?>/" + id, function(data) {
    		myElem.parent().parent().parent().slideUp("fast", function() {
    			displaySuccess("Note deleted successfully");
    				myElem.parent().parent().parent().remove();
    			});
    			
    			// myElem.parent().parent().remove();
    		})
    		.fail(function() {
    			displayError("Could not remove note");
    		});
    	
    	});
    	
    	// Bind up and down arrows to showing/hiding content
    	// IMPORTANT: nth-child is 1-based, while the index()-function returns
    	// zero-based numbers!
    	// TODO: Get this shit to work.
    	$(document).keydown(function(e) {
    	
    	// helper variable to convert zero-based current-element to 1-based nth
    	nth = currentElement + 1;
    	
    	if(e.which == 38) // up
    	{
    		// TODO set panel-primary as class to the element
    		e.preventDefault();
    		// Is any element selected?
    		if(currentElement >= 0)
    		{
    			// Yes, the current Element is not the first or none, so we can do something
    			// First close the current element by triggering the click event
    			$("#panel-container > div:nth-child(" + nth + ") .panel-heading h3").trigger("click");
    			
    			// Trigger the "click" event on the element above
    			$("#panel-container > div:nth-child(" + (nth-1) + ") .panel-heading h3").trigger("click");
    		}
    	}
    	else if(e.which == 40) // down
    	{
    		e.preventDefault();
    		// Is any element selected?
    		if(currentElement <= $("#panel-container h3").length)
    		{
    			// Yes, the current Element is not the first or none, so we can do something
    			// First close the current element by triggering the click event
    			$("#panel-container > div:nth-child(" + nth + ") .panel-heading h3").trigger("click");
    			
    			// Trigger the "click" event on the element below
    			$("#panel-container > div:nth-child(" + (nth+1) + ") .panel-heading h3").trigger("click");
    		}
    	}
    	
    	});
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="background-color:white">
	<div class="page-header">
		<h1>notework <small>showing all notes</small></h1>
	</div>
       <?php if(count($notes) > 0): ?>
       <div class="panel-group" id="panel-container">
       <?php /* The content of the notes will be dynamically loaded */ ?>
        <?php foreach($notes as $note): ?>
        <div class="panel panel-default">
  			<div class="panel-heading">
    			<h3 class="panel-title onClickLoadNote" id="<?php echo e($note->id); ?>" style="cursor:pointer;"><?php echo e($note->id); ?> &mdash; <?php echo e($note->title); ?> <a href="#" class="pull-right onClickRemoveNote" id="<?php echo e($note->id); ?>"><span class="glyphicon glyphicon-remove"></span></a></h3>
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