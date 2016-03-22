<?php /*views/notes/list.blade.php*/ ?>
<?php /* This view just outputs a list of all notes */ ?>



<?php $__env->startSection('content'); ?>
<div class="container" style="background-color:white">
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Title</th>
        </tr>

       <?php if($notes): ?>
        <?php foreach($notes as $note): ?>
        <tr>
            <td>$note->id</td>
            <td>$note->title</td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="2"><p class="alert alert-warning">There are no notes to show <span class="glyphicon glyphicon-warning-sign pull-right" aria-hidden="true"></span></p></td>
        </tr>
        <?php endif; ?>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>