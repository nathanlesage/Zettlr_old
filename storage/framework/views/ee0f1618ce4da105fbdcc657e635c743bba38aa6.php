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

<?php $__env->stopSection(); ?>
<?php /*</script> for syntax highlighting purposes*/ ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="background-color:white">
  <div class="page-header">
    <h1>Create new note
      <?php if($outline): ?>
        <small><?php echo e($outline->name); ?></small>
      <?php endif; ?>
    </h1>
  </div>

    <form method="POST" action="<?php echo e(url('/notes/create')); ?>" id="createNewNoteForm">
            <?php echo csrf_field(); ?>


            <div class="form-group row<?php echo e($errors->has('title') ? ' has-error has-feedback' : ''); ?>">
            	<div class="col-md-8">
            		<label for="titleInput" class="sr-only">Title</label>
                	<input type="text" class="form-control" name="title" autofocus="autofocus" placeholder="Titel" value="<?php echo e(old('title')); ?>" tabindex="1">
                </div>
                <div class="col-md-4">
                	<input class="form-control" style="" type="text" id="tagSearchBox" placeholder="Search for tags &hellip;" tabindex="3">
                </div>
            </div>

            <div class="form-group row<?php echo e($errors->has('content') ? ' has-error has-feedback' : ''); ?>">
            	<div class="col-md-8">
            		<label for="gfm-code" class="sr-only">Content</label>
                	<textarea class="form-control" id="gfm-code" name="content" placeholder="Content" tabindex="2"><?php echo e(old('content')); ?></textarea>
                </div>
                <div class="col-md-4" id="tagList">
                	<!-- Here the tags are appended -->
                  <?php if($outline): ?>
                    <?php if(count($outline->tags) > 0): ?>
                      <?php foreach($outline->tags as $tag): ?>
                        <div class="alert alert-info alert-dismissable">
                          <input type="hidden" value="$tag->name" name="tags[]">
                          <?php echo e($tag->name); ?>

                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
            </div>

            <div class="form-group row">
            	<div class="col-md-4 col-md-offset-4">
                <?php if($outline): ?>
                <input type="hidden" name="outlineId" value="<?php echo e($outline->id); ?>">
                <?php endif; ?>
            		<button type="submit" class="btn btn-default" tabindex="4">Create</button>
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