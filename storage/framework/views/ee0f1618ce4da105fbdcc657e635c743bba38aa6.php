<?php /* Creation template */ ?>


<?php /* Yield additional scripts */ ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php /* Yield our document ready code */ ?>

<?php /*For syntax highlighting purposes (yes, gedit needs this crap): <script>*/ ?>
<?php $__env->startSection('scripts_on_document_ready'); ?>

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

            <div class="form-group">
              <input class="form-control" style="" type="text" id="referenceSearchBox" placeholder="Search for references &hellip;">
            </div>
            <div class="form-group">
              <div id="referenceList">
                <!-- Here the references are appended -->
                <?php if($outline): ?>
                  <?php if(count($outline->references) > 0): ?>
                    <?php foreach($outline->references as $reference): ?>
                      <div class="alert alert-info alert-dismissable">
                        <input type="hidden" value="$tag->name" name="references[]">
                        <?php echo e($reference->author_last); ?> <?php echo e($reference->year); ?>

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