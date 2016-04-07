<?php /* Main template for the Home section */ ?>


<?php /* ToDo: Make this the general settings pane */ ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <!-- Little hack for vertical alignment -->
        <div class="jumbotron" style="margin-top:25%;">
            <h1>noteworks</h1>
            <p>Noteworks is a free and open-source Zettelkasten adaption. <button class="btn btn-primary">Learn more &hellip;</button></p>
            <p>You are logged in as <strong><?php echo e(Auth::user()->name); ?></strong>.</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>