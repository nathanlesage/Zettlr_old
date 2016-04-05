<?php /*views/notes/list.blade.php*/ ?>
<?php /* This view just outputs a list of all notes */ ?>



<?php $__env->startSection('content'); ?>
<div class="container" style="background-color:white">
       <?php if(count($notes) > 0): ?>
        <?php foreach($notes as $note): ?>
        <table class="table table-striped">
        <tr>
            <th style="width:5%;"><?php echo e($note->id); ?></th>
            <th><?php echo e($note->title); ?> <a href="<?php echo e(url('/notes/delete/'.$note->id)); ?>" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></th>
        </tr>
        <tr>
        	<td></td><td><?php echo Markdown::convertToHtml($note->content); ?></td>
        </tr>
        </table>
        <?php endforeach; ?>
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