<?php $__env->startSection('content'); ?>

    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">

            <div class="user_card" style="margin-top: 80px; background-color: white;">
                


                <div class="d-flex justify-content-center" >
                    <div class="brand_logo_container">
                        <img src="<?php echo e(asset('public/assets/images/ncard_logo.png')); ?>" class="brand_logo" alt="Logo">


                    </div>

                </div>

                <div class="justify-content-center form_container" >

                    <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(Session::has('alert-' . $msg)): ?>

                            <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?>

                                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <form method="post" action="<?php echo e(url('login')); ?>">
                        <?php echo e(csrf_field()); ?>




                        <div class="form-group <?php echo e($errors->has('email') ? 'errors' : ''); ?>">

                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                

                                <input type="text" value="<?php echo e(old('email')); ?>" required name="email" id="login-email2" class="form-control input_userw"  placeholder="email">

                            </div>
                            <small class="text-danger"><?php echo e($errors->first('email')); ?></small>


                        </div>

                        <div class="form-group <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">

                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                

                                <input type="password"  name="password" id="login-password2w" required class="form-control input_userw" value="" placeholder="password">

                            </div>
                            <small class="text-danger"><?php echo e($errors->first('password')); ?></small>


                        </div>


                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" name="button"  id="login-btn2" class="btn login_btn">Login</button>
                    </div>
                    <div class="mt-4">

                        <div class="d-flex justify-content-center links">
                            <a href="#">Forgot your password?</a>
                        </div>
                    </div>

                    </form>

                </div>


                

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

    <style>

    </style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master_login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/auth/login.blade.php ENDPATH**/ ?>