<?php /* Main template for the Home section */ ?>


<?php /* ToDo: Make this the general settings pane */ ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <!-- Little hack for vertical alignment -->
        <div class="jumbotron" style="margin-top:25%;">
            <h1>Zettlr</h1>
            <p>You are logged in as <strong><?php echo e(Auth::user()->name); ?></strong>.</p>
            <p>There are currently <strong><?php echo e($noteCount); ?> Notes</strong>,
              <strong><?php echo e($tagCount); ?> Tags</strong>,
              <strong><?php echo e($referenceCount); ?> References</strong> and
              <strong><?php echo e($outlineCount); ?> Outlines</strong> saved in this app.</p>
              <p><a class="btn btn-primary" href="<?php echo e(url('/settings')); ?>">Settings</a></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>