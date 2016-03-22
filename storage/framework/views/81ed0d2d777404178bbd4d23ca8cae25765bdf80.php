<?php /* Main template for the Home section */ ?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        
        <!-- Little hack for vertical alignment -->
        <div class="jumbotron" style="margin-top:25%;">
            <h1>noteworks</h1>
            <!-- Login form -->
            <form class="form-inline" role="login">
                <div class="form-group">
                    <input type="text" class="form-control" autofocus="autofocus" placeholder="Username">
                    <input type="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-success">Login</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>