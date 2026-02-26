<?php $__env->startSection('mainContainer'); ?>
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-0 col-md-12">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b><?php echo trans('applicationResource.menu.signUp'); ?></b></h4>
                    </div>
                </div>


                <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/register')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-group<?php echo e($errors->has('login') ? ' has-error' : ''); ?> row">
                        <label for="login" class="col-xs-12 col-sm-4 control-label"><?php echo trans('applicationResource.menu.login'); ?></label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="login" value="<?php echo e(old('login')); ?>"
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
                            <input type="password" class="form-control" name="password"
                                   placeholder="<?php echo trans('applicationResource.menu.password'); ?>">
                            <?php if($errors->has('password')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?> row">
                        <label class="col-xs-12 col-sm-4 control-label"><?php echo trans('applicationResource.menu.passwordConfirm'); ?></label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="password" class="form-control" name="password_confirmation"
                                   placeholder="<?php echo trans('applicationResource.menu.password'); ?>">
                            <?php if($errors->has('password_confirmation')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?> row">
                        <label class="col-xs-12 col-sm-4 control-label"><?php echo trans('applicationResource.menu.name'); ?></label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>"
                                   placeholder="<?php echo trans('applicationResource.menu.name'); ?>">

                            <?php if($errors->has('name')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('name')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?> row">
                        <label class="col-xs-12 col-sm-4 control-label"><?php echo trans('applicationResource.menu.email'); ?></label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>"
                                   placeholder="<?php echo trans('applicationResource.menu.email'); ?>">

                            <?php if($errors->has('email')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('university') ? ' has-error' : ''); ?> row">
                        <label class="col-xs-12 col-sm-4 control-label"><?php echo trans('applicationResource.menu.organization'); ?></label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="university" value="<?php echo e(old('university')); ?>"
                                   placeholder="<?php echo trans('applicationResource.menu.organization'); ?>">

                            <?php if($errors->has('university')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('university')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('city') ? ' has-error' : ''); ?> row">
                        <label class="col-xs-12 col-sm-4 control-label"><?php echo trans('applicationResource.userData.city'); ?></label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="city" value="<?php echo e(old('city')); ?>"
                                   placeholder="<?php echo trans('applicationResource.userData.city'); ?>">

                            <?php if($errors->has('city')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('city')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('country') ? ' has-error' : ''); ?> row">
                        <label class="col-xs-12 col-sm-4 control-label"><?php echo trans('applicationResource.userData.country'); ?></label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="country" value="<?php echo e(old('country')); ?>"
                                   placeholder="<?php echo trans('applicationResource.userData.country'); ?>">

                            <?php if($errors->has('country')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('country')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-offset-4 col-sm-4">
                            <div class="g-recaptcha" data-sitekey="<?php echo e(config('services.recaptcha.site_key')); ?>"></div>
                            <?php if($errors->has('g-recaptcha-response')): ?>
                                <span class="help-block text-danger">
                                    <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-btn fa-user"></i><?php echo trans('applicationResource.menu.signUp'); ?>

                            </button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/auth/register.blade.php ENDPATH**/ ?>