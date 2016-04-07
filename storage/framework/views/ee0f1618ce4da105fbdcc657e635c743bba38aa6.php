<?php /* Creation template */ ?>


<?php /* Yield additional scripts */ ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php /* Yield our document ready code */ ?>

<?php /*For syntax highlighting purposes (yes, gedit needs this crap): <script>*/ ?>
<?php $__env->startSection('scripts_on_document_ready'); ?>

    	// Is any gfm-code text in the area?
    	// (You just found a stupid pun. Congratulations!)
    	if($("#gfm-code").length)
    	{
    		var editor = CodeMirror.fromTextArea(document.getElementById("gfm-code"), {
        		mode: 'gfm',
        		lineNumbers: true,
        		theme: "default",
        		lineWrapping: true,
        		// Set Tab to false to focus next input
        		// And let Shift-Enter submit the form.
        		extraKeys: { "Tab": false, 
        					 "Shift-Enter": function(cm){ $("#editNoteForm").submit(); }
        				   }
      		});
      		
      		// Submit form on Shift+Enter
      		// We're binding it to the document, which leads to
      		// submitting the form REGARDLESSLY of when we press it.
      		// TODO: Think about removing this (but think twice)
      		$("div.codeMirror-focused").bind('keyup', 'Shift+Return', function(){
      			$("#editNoteForm").submit();
      		});
      		
      		// Do we have any errors concerning content? Add them to the editor afterwards.
      		if(<?php echo e($errors->has('content') ? 'true' : 'false'); ?>)
      			$("div.CodeMirror").addClass("has-error has-feedback");
      	}
      	
      	// Create the autocomplete box
      	// Create the autocomplete box
      	$( "#tagSearchBox" ).autocomplete({
      		// The source option tells autocomplete to
      		// send the request (with the term the user typed)
      		// to a remote server and the response can be handled
        	source: function( request, response ) {
            	$.getJSON( "<?php echo e(url('/ajax/tag/search')); ?>/" + request.term, {}, function(data) {
          			// Call the response function of autocompleteUI
          			// We don't need to alter our json object as we
          			// will be filling in everything manually via
          			// focus, select and the _renderItem function.
          			response(data);
          		});
        	},
        	// Focus is what happens, when the user selects a menu item.
        	// In our case autocomplete can't guess it, so we have to
        	// manually tell it which key it should use
        	focus: function( event, ui ) {
        		$( "#tagSearchBox" ).val( ui.item.name );
        		return false;
      		},
      		select: function( event, ui ) {
      			// select function would assume to insert ui.item.label
      			// so we've overwritten it.
        		$( "#tagSearchBox" ).val( ui.item.name );
        		addTag();
        		return false;
      		}
      	}).autocomplete("instance")._renderItem = function(ul, item) {
      		// Overwriting render function, as our JSON has key name, 
      		// and not label (which renderItem would assume).
      		return $("<li>").append(item.name).appendTo(ul);
      	};
      	
      	// Prevent form submission by pressing Enter key in inputs
      	$(window).keydown(function(e){
    		if(e.keyCode == 13) {
      			e.preventDefault();
      			return false;
    		}
 		});
      	
      	// Bind return key to adding the tag
      	$("#tagSearchBox").bind('keyup', 'Return', function(e){
      		e.preventDefault();
      		addTag();
      	});

<?php $__env->stopSection(); ?>
<?php /*</script> for syntax highlighting purposes*/ ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="background-color:white">
    <h1>Create new note</h1>
    <?php /* Check if this URL works */ ?>
    
    <form method="POST" action="<?php echo e(url('/notes/create')); ?>" id="createNewNoteForm">
            <?php echo csrf_field(); ?>

            
            <div class="form-group row<?php echo e($errors->has('title') ? ' has-error has-feedback' : ''); ?>">
            	<div class="col-md-8">
            		<label for="titleInput" class="sr-only">Title</label>
                	<input type="text" class="form-control" name="title" autofocus="autofocus" placeholder="Titel" value="<?php echo e(old('title')); ?>">  
                </div>
                <div class="col-md-4">
                	<input class="form-control" style="" type="text" id="tagSearchBox" placeholder="Search for tags &hellip;">
                </div>
            </div>
            
            <div class="form-group row<?php echo e($errors->has('content') ? ' has-error has-feedback' : ''); ?>">
            	<div class="col-md-8">
            		<label for="gfm-code" class="sr-only">Content</label>
                	<textarea class="form-control" id="gfm-code" name="content" placeholder="Content"><?php echo e(old('content')); ?></textarea>
                </div>
                <div class="col-md-4" id="tagList">
                	<!-- Here the tags are appended -->
                </div>
            </div>
            
            <div class="form-group row">
            	<div class="col-md-4 col-md-offset-4">
            		<button type="submit" class="btn btn-default">Create</button>
            	</div>
            </div>
		</form>
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