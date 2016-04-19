<?php /* Creation template */ ?>


<?php /* Yield additional scripts */ ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php /* Yield our document ready code */ ?>
<?php $__env->startSection('scripts_on_document_ready'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container" style="background-color:white">
        <div class="page-header">
            <h1>Create new note
                <?php if($outline): ?>
                    <small>for <strong><?php echo e($outline->name); ?></strong></small>
                <?php endif; ?>
            </h1>
        </div>

        <form method="POST" action="<?php echo e(url('/notes/create')); ?>" id="noteForm">
            <?php echo csrf_field(); ?>


            <div class="form-group row<?php echo e($errors->has('title') ? ' has-error has-feedback' : ''); ?>">
                <div class="col-md-8">
                    <label for="titleInput" class="sr-only">Title</label>
                    <input type="text" class="form-control" name="title" autofocus="autofocus" placeholder="Title" value="<?php echo e(old('title')); ?>" tabindex="1">
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
                                <div class="btn btn-primary" onClick="$(this).fadeOut(function() { $(this).remove(); })">
                                    <input type="hidden" value="<?php echo e($tag->name); ?>" name="tags[]">
                                    <?php echo e($tag->name); ?>

                                    <button type="button" class="close" title="Remove" onClick="$(this).parent().fadeOut(function() { $(this).remove(); })">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php /* Old tags from $request */ ?>
                    <?php if(count(old('tags')) > 0): ?>
                        <?php foreach(old('tags') as $tag): ?>
                            <?php /* The old object only contains the array */ ?>
                            <div class="btn btn-primary" onClick="$(this).fadeOut(function() { $(this).remove(); })">
                                <input type="hidden" value="<?php echo e($tag); ?>" name="tags[]">
                                <?php echo e($tag); ?>

                                <button type="button" class="close" title="Remove" onClick="$(this).parent().fadeOut(function() { $(this).remove(); })">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-8">
                    <?php if($outline): ?>
                        <input type="hidden" name="outlineId" value="<?php echo e($outline->id); ?>">
                    <?php endif; ?>
                    <button type="submit" class="form-control" tabindex="5">Create</button>
                </div>
                <div class="col-md-4">
                    <input class="form-control" style="" type="text" id="referenceSearchBox" placeholder="Search for references &hellip;" tabindex="4">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <div id="referenceList">
                        <!-- Here the references are appended -->
                        <?php if($outline): ?>
                            <?php if(count($outline->references) > 0): ?>
                                <?php foreach($outline->references as $reference): ?>
                                    <div class="alert alert-success alert-dismissable">
                                        <input type="hidden" value="<?php echo e($reference->id); ?>" name="references[]">
                                        <?php echo e($reference->author_last); ?> <?php echo e($reference->year); ?>

                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if(count(old('references')) > 0): ?>
                            <?php foreach(old('references') as $referenceID): ?>
                                <?php $reference = App\Reference::find($referenceID) ?>
                                <?php /* The old object only contains the array */ ?>
                                <div class="alert alert-success alert-dismissable">
                                    <input type="hidden" value="<?php echo e($reference->id); ?>" name="references[]">
                                    <?php echo e($reference->author_last); ?> <?php echo e($reference->year); ?>

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
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