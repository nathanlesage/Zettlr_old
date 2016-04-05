<?php /* Changed layout.app to "our" app file */ ?>


<?php $__env->startSection('content'); ?>
<div class="container">
	<!-- Little hack for vertical alignment -->
    <div class="jumbotron" style="margin-top:25%;">
        <h1>noteworks</h1>
        <form class="form-inline" role="login" method="POST" action="<?php echo e(url('/login')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                <input type="email" class="form-control" name="email" autofocus="autofocus" placeholder="Email" value="<?php echo e(old('email')); ?>">
                <?php if($errors->has('email')): ?>
    	            <span class="help-block">
    	                <strong><?php echo e($errors->first('email')); ?></strong>
                    </span>
                <?php endif; ?>                
            </div>
            
            <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <?php if($errors->has('password')): ?>
            	    <span class="help-block">
            	        <strong><?php echo e($errors->first('password')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
    	        <div class="checkbox">
    	            <label>
    		            <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
                <a class="btn btn-link" href="<?php echo e(url('/password/reset')); ?>">Forgot Your Password?</a>
            </div>
    
            <div class="form-group">
    	        <button type="submit" class="btn btn-success">Login</button>
            </div>
                
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>