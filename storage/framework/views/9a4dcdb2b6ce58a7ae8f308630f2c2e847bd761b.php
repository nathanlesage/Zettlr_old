<?php /* Creation template */ ?>



<?php $__env->startSection('content'); ?>
<div class="container" style="background-color:white">
    <h1>Create new note</h1>
    <?php /* Check if this URL works */ ?>
    <?php echo e(Form::open(array('url' => action('NoteController@create')))); ?>

    <div class="form-group">
    <?php echo e(Form::label('title', 'Title')); ?>

    <?php echo e(Form::text('title')); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('content', 'Content')); ?>

        <?php echo e(Form::textarea('content')); ?>

    </div>
    
    <button type="submit" class="btn btn-default">Create</button>
    
    <?php echo e(Form::close()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>