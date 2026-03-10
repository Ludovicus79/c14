<?php $__env->startSection('mainContainer'); ?>
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-0 col-md-12">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b><?php echo trans('applicationResource.menu.sesion'); ?></b></h4>
                    </div>
                </div>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group<?php echo e($errors->has('login') ? ' has-error' : ''); ?> row">
                        <label class="col-xs-12 col-sm-4 control-label"><?php echo trans('applicationResource.menu.login'); ?></label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" id="login" name="login"
                                   value="<?php echo e(old('login')); ?>"
                                   placeholder="<?php echo trans('applicationResource.menu.login'); ?>">
                            <?php if($errors->has('login')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('login')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?> row">
                        <label class="col-xs-12 col-sm-4 control-label"><?php echo trans('applicationResource.menu.password'); ?></label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="<?php echo trans('applicationResource.menu.password'); ?>">
                            <?php if($errors->has('password')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-12 text-center">
                            <label>
                                <input type="checkbox"
                                       name="remember"> <?php echo trans('applicationResource.menu.rememberMe'); ?>

                            </label>
                        </div>
                        <div class="col-xs-12 text-center">
                            <a class="btn btn-link"
                               href="<?php echo e(url('/password/reset')); ?>"><?php echo trans('applicationResource.menu.forgotPassword'); ?></a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-danger">
                                <?php echo trans('applicationResource.menu.signIn'); ?>

                            </button>
                            <a  href="<?php echo e(url('/register')); ?>" class="btn btn-danger">
                                <?php echo trans('applicationResource.menu.signUp'); ?>

                            </a>
                        </div>
                    </div>

                </form>


            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\c14-main\resources\views/auth/login.blade.php ENDPATH**/ ?>