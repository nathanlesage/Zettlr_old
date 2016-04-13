<?php /* Changed layout.app to "our" app file */ ?>


<?php $__env->startSection('content'); ?>
    <div class="container">
        <!-- Little hack for vertical alignment -->
        <div class="jumbotron" style="margin-top:25%;">
            <h1>Zettlr</h1>
            <form class="form-inline" role="login" method="POST" action="<?php echo e(url('/login')); ?>">
                <?php echo csrf_field(); ?>


                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                    <input type="email" class="form-control" name="email" autofocus="autofocus" placeholder="Email" value="<?php echo e(old('email')); ?>">
                </div>

                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>

            </form>
            <p><a class="btn btn-link" href="<?php echo e(url('/password/reset')); ?>">Forgot Your Password?</a></p>

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
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>