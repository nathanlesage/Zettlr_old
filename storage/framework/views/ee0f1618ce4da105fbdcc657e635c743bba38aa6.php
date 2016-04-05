<?php /* Creation template */ ?>



<?php $__env->startSection('content'); ?>
<div class="container" style="background-color:white">
    <h1>Create new note</h1>
    <?php /* Check if this URL works */ ?>
    
    <form method="POST" action="<?php echo e(url('/notes/create')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="form-group<?php echo e($errors->has('title') ? ' has-error has-feedback' : ''); ?>">
                <input type="text" class="form-control" name="title" autofocus="autofocus" placeholder="Titel" value="<?php echo e(old('title')); ?>">               
            </div>
            
            <div class="form-group<?php echo e($errors->has('content') ? ' has-error has-feedback' : ''); ?>">
                <textarea class="form-control" id="gfm-code" name="content" placeholder="Content"><?php echo e(old('content')); ?></textarea>           
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-default">Create</button>
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