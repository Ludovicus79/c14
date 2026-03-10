<?php $__env->startSection('headers'); ?>
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/spin.js')); ?>"></script>
    <script src="<?php echo e(asset('js/loadingScreen.js')); ?>"></script>
    <script src="<?php echo e(asset('js/loadFamilies.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContainer'); ?>
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b><?php echo trans('applicationResource.form.busquedas.nombre'); ?></b></h4>
                    </div>
                </div>

                <hr class="invisible">

                <form class="form-horizontal" role="form" method="POST" action="" onsubmit="showLoading()">
                    <?php echo csrf_field(); ?>

                    
                    <div class="row">
                        <div class="col-xs-12">
                            <?php echo $__env->make('search.familiesPartial', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>

                    <hr class="invisible">

                    
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            <?php echo trans('applicationResource.form.formulamol'); ?>

                        </label>
                        <div class="col-xs-12 col-sm-10 col-md-10">
                            <div class="row">
                                <?php $__currentLoopData = ['C','H','N','O','S','F','Cl','Br','I']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-xs-2 col-sm-1" style="padding-right:2px; padding-left:2px;">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon" style="padding:2px 4px;"><?php echo e($atom); ?></span>
                                        <input type="text"
                                               class="form-control input-sm"
                                               name="molFormula[<?php echo e($atom); ?>]"
                                               value="<?php echo e(old('molFormula.'.$atom, 0)); ?>"
                                               style="width:40px; padding:2px;">
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            <?php echo trans('applicationResource.form.pesomol'); ?>

                        </label>
                        <div class="col-xs-5 col-sm-3 col-md-2">
                            <input type="text"
                                   class="form-control"
                                   name="molWeightMin"
                                   placeholder="0.000"
                                   value="<?php echo e(old('molWeightMin')); ?>">
                        </div>
                        <div class="col-xs-2 col-sm-1 text-center" style="padding-top:7px;">
                            &#8920;
                        </div>
                        <div class="col-xs-5 col-sm-3 col-md-2">
                            <input type="text"
                                   class="form-control"
                                   name="molWeightMax"
                                   placeholder="0.000"
                                   value="<?php echo e(old('molWeightMax')); ?>">
                        </div>
                    </div>

                    
                    <div class="form-group row<?php echo e($errors->has('trivialName') ? ' has-error' : ''); ?>">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            <?php echo trans('applicationResource.form.nombretri'); ?>

                        </label>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <input type="text" class="form-control" name="trivialName" value="<?php echo e(old('trivialName')); ?>">
                        </div>
                    </div>

                    
                    <div class="form-group row<?php echo e($errors->has('semiName') ? ' has-error' : ''); ?>">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            <?php echo trans('applicationResource.form.nombresemi'); ?>

                        </label>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <input type="text" class="form-control" name="semiName" value="<?php echo e(old('semiName')); ?>">
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4><b><?php echo trans('applicationResource.form.biblio'); ?></b></h4>
                        </div>
                    </div>
                    <hr>

                    
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            <?php echo trans('applicationResource.form.autores'); ?>

                        </label>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <input type="text" class="form-control" name="biblio[autores]" value="<?php echo e(old('biblio.autores')); ?>">
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            <?php echo trans('applicationResource.form.revista'); ?>

                        </label>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <input type="text" class="form-control" name="biblio[revista]" value="<?php echo e(old('biblio.revista')); ?>">
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            <?php echo trans('applicationResource.form.pag'); ?>

                        </label>
                        <div class="col-xs-4 col-sm-3 col-md-2">
                            <input type="text" class="form-control" name="biblio[pag]" value="<?php echo e(old('biblio.pag')); ?>">
                        </div>

                        <label class="col-xs-4 col-sm-2 col-md-1 control-label">
                            <?php echo trans('applicationResource.form.vol'); ?>

                        </label>
                        <div class="col-xs-4 col-sm-1 col-md-1">
                            <input type="text" class="form-control" name="biblio[vol]" value="<?php echo e(old('biblio.vol')); ?>">
                        </div>

                        <label class="col-xs-4 col-sm-1 col-md-1 control-label">
                            <?php echo trans('applicationResource.form.anio'); ?>

                        </label>
                        <div class="col-xs-4 col-sm-2 col-md-2">
                            <input type="text" class="form-control" name="biblio[anio]" value="<?php echo e(old('biblio.anio')); ?>">
                        </div>
                    </div>

                    
                    <div class="form-group row text-center">
                        <button class="btn btn-danger" type="submit" onsubmit="showLoading()">
                            <?php echo trans('applicationResource.form.buscar'); ?>

                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\c14-main\resources\views/search/byName.blade.php ENDPATH**/ ?>