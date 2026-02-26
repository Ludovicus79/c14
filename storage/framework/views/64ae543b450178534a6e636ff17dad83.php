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


                <?php if($errors->has('emptyError')): ?>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4 class="help-block">
                                <strong style="color: red;"><?php echo trans('applicationResource.errors.requeridos'); ?></strong>
                            </h4>
                        </div>
                    </div>
                <?php endif; ?>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('search/byName')); ?>"
                      onsubmit="showLoading()">
                    <?php echo csrf_field(); ?>

                    <!--FAMILIA, TIPO, GRUPO-->
                   
                        <?php echo $__env->make('search.familiesPartial', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    

                    <!-- FORMULA MOLECULAR -->
                    
                    <div class="form-group row">
                            <label class="col-xs-12 col-sm-1 control-label"><?php echo trans('applicationResource.form.formulamol'); ?></label>

                            <!-- CARBONO -->
                            <label class="col-xs-2 col-sm-1 control-label label2cifras" style="margin-left: 40px">C</label>
                            <div class="col-xs-4 col-sm-1<?php echo e($errors->has('ca') ? ' has-error' : ''); ?> columna">
                                <input type="text" class=" form-control" id="ca" name="ca"
                                       value="<?php echo e(old('ca')); ?>" placeholder="0">
                                <?php if($errors->has('ca')): ?>
                                    <span class="col-sm-12 help-block">
                            <strong><?php echo e($errors->first('ca')); ?></strong>
                        </span>
                                <?php endif; ?>
                            </div>
                            <!-- HIDROGENO -->
                            <label class="col-xs-2 col-sm-1 control-label label2cifras">H</label>
                            <div class="col-xs-4 col-sm-1 <?php echo e($errors->has('hi') ? ' has-error' : ''); ?> columna">
                                <input type="text" class=" form-control" id="hi" name="hi"
                                       value="<?php echo e(old('hi')); ?>" placeholder="0">
                                <?php if($errors->has('hi')): ?>
                                    <span class="help-block">
                            <strong><?php echo e($errors->first('hi')); ?></strong>
                        </span>
                                <?php endif; ?>
                            </div>
                            <!-- NITROGENO -->
                            <label class="col-xs-2 col-sm-1 control-label label2cifras">N</label>
                            <div class="col-xs-4 col-sm-1 <?php echo e($errors->has('ni') ? ' has-error' : ''); ?> columna">
                                <input type="text" class=" form-control" id="ni" name="ni"
                                       value="<?php echo e(old('ni')); ?>" placeholder="0">
                                <?php if($errors->has('ni')): ?>
                                    <span class="help-block">
                            <strong><?php echo e($errors->first('ni')); ?></strong>
                        </span>
                                <?php endif; ?>
                            </div>

                            <!-- OXIGENO -->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">O</label>
                            <div class="col-xs-4 col-sm-1<?php echo e($errors->has('ox') ? ' has-error' : ''); ?> columna">
                                <input type="text" class=" form-control" id="ox" name="ox"
                                       value="<?php echo e(old('ox')); ?>" placeholder="0">
                                <?php if($errors->has('ox')): ?>
                                    <span class="help-block">
                            <strong><?php echo e($errors->first('ox')); ?></strong>
                        </span>
                                <?php endif; ?>
                            </div>
                        <!--Prueba Azufre-->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">S</label>
                            <div class="col-xs-4 col-sm-1<?php echo e($errors->has('s') ? ' has-error' : ''); ?> columna">
                                <input type="text" class=" form-control" id="s" name="s"
                                       value="<?php echo e(old('s')); ?>" placeholder="0">
                                <?php if($errors->has('s')): ?>
                                    <span class="help-block">
                            <strong><?php echo e($errors->first('s')); ?></strong>
                        </span>
                                <?php endif; ?>
                            </div>
                    <!--Prueba Fluor-->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">F</label>
                            <div class="col-xs-4 col-sm-1<?php echo e($errors->has('fl') ? ' has-error' : ''); ?> columna">
                                <input type="text" class=" form-control" id="fl" name="fl"
                                       value="<?php echo e(old('fl')); ?>" placeholder="0">
                                <?php if($errors->has('fl')): ?>
                                    <span class="help-block">
                            <strong><?php echo e($errors->first('fl')); ?></strong>
                        </span>
                                <?php endif; ?>
                            </div>

                        <!--Prueba Cloros-->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">Cl</label>
                            <div class="col-xs-4 col-sm-1<?php echo e($errors->has('cl') ? ' has-error' : ''); ?> columna">
                                <input type="text" class=" form-control" id="cl" name="cl"
                                       value="<?php echo e(old('cl')); ?>" placeholder="0">
                                <?php if($errors->has('cl')): ?>
                                    <span class="help-block">
                            <strong><?php echo e($errors->first('cl')); ?></strong>
                        </span>
                                <?php endif; ?>
                            </div>

                        <!--Prueba Bromo-->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">Br</label>
                            <div class="col-xs-4 col-sm-1<?php echo e($errors->has('br') ? ' has-error' : ''); ?> columna">
                                <input type="text" class=" form-control" id="br" name="br"
                                       value="<?php echo e(old('br')); ?>" placeholder="0">
                                <?php if($errors->has('br')): ?>
                                    <span class="help-block">
                            <strong><?php echo e($errors->first('br')); ?></strong>
                        </span>
                                <?php endif; ?>
                            </div>

                        <!--Prueba Iodo-->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">I</label>
                            <div class="col-xs-4 col-sm-1<?php echo e($errors->has('io') ? ' has-error' : ''); ?> columna">
                                <input type="text" class=" form-control" id="io" name="io"
                                       value="<?php echo e(old('io')); ?>" placeholder="0">
                                <?php if($errors->has('io')): ?>
                                    <span class="help-block">
                            <strong><?php echo e($errors->first('io')); ?></strong>
                        </span>
                                <?php endif; ?>
                            </div>

                    </div>
                    <br>
                    <!-- FIN DE FORMULA MOLECULAR -->



                    <!-- PESO MOLECULAR -->
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-3 control-label"><?php echo trans('applicationResource.form.pesomol'); ?></label>
                        <div class="col-xs-5 col-sm-2 <?php echo e($errors->has('minWeight') ? ' has-error' : ''); ?>">
                            <input type="text" class=" form-control" id="minWeight" name="minWeight"
                                   value="<?php echo e(old('minWeight')); ?>" placeholder="0.000">
                            <?php if($errors->has('minWeight')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('minWeight')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-1 col-sm-2 text-center"><></div>
                        <div class="col-xs-5 col-sm-2 <?php echo e($errors->has('maxWeight') ? ' has-error' : ''); ?>">
                            <input type="text" class=" form-control" id="maxWeight" name="maxWeight"
                                   value="<?php echo e(old('maxWeight')); ?>" placeholder="0.000">
                            <?php if($errors->has('maxWeight')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('maxWeight')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- FIN DE PESO MOLECULAR -->

                    <!-- NOMBRES -->
                    <!-- TRIVIAL -->
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-3 control-label"><?php echo trans('applicationResource.form.nombretri'); ?></label>
                        <div class="col-xs-12 col-sm-6 <?php echo e($errors->has('triName') ? ' has-error' : ''); ?>">
                            <input type="text" class=" form-control" id="triName" name="triName"
                                   value="<?php echo e(old('triName')); ?>">
                            <?php if($errors->has('triName')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('triName')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- SEMISISTEMATICO -->
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-3 control-label"><?php echo trans('applicationResource.form.nombresemi'); ?></label>
                        <div class="col-xs-12 col-sm-6 <?php echo e($errors->has('semiName') ? ' has-error' : ''); ?>">
                            <input type="text" class=" form-control" id="semiName" name="semiName"
                                   value="<?php echo e(old('semiName')); ?>">
                            <?php if($errors->has('semiName')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('semiName')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- FIN DE NOMBRES -->

                    <!-- BIBLIOGRAFIA -->
                    <h4 class="col-xs-12 text-center"><?php echo trans('applicationResource.form.biblio'); ?></h4>
           
                    <!-- AUTORES -->
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-3 control-label"><?php echo trans('applicationResource.form.autores'); ?></label>
                        <div class="col-xs-12 col-sm-6<?php echo e($errors->has('authors') ? ' has-error' : ''); ?>">
                            <input type="text" class="form-control " id="authors" name="authors"
                                   value="<?php echo e(old('authors')); ?>">
                            <?php if($errors->has('authors')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('authors')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- REVISTA -->
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-3 control-label"><?php echo trans('applicationResource.form.revista'); ?></label>
                        <div class="col-xs-12 col-sm-6 <?php echo e($errors->has('magazine') ? ' has-error' : ''); ?>">
                            <input type="text" class="form-control " id="magazine" name="magazine"
                                   value="<?php echo e(old('magazine')); ?>">
                            <?php if($errors->has('magazine')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('magazine')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        
                        
                        <!-- PAGINA -->
                        <label class="col-xs-12 col-sm-3 control-label"><?php echo trans('applicationResource.form.pag'); ?></label>
                        <div class="col-xs-12 col-sm-2 <?php echo e($errors->has('page') ? ' has-error' : ''); ?>">
                            <input type="text" class="form-control " id="page" name="page"
                                   value="<?php echo e(old('page')); ?>">
                            <?php if($errors->has('page')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('page')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>

                        <!-- VOLUMEN -->
                        <label class="col-xs-12 col-sm-1 control-label"><?php echo trans('applicationResource.form.vol'); ?></label>
                        <div class="col-xs-12 col-sm-1 <?php echo e($errors->has('volume') ? ' has-error' : ''); ?>">
                            <input type="text" class="form-control " id="volume" name="volume"
                                   value="<?php echo e(old('volume')); ?>">
                            <?php if($errors->has('volume')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('volume')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>

                        <!-- AÑO -->
                        <label class="col-xs-12 col-sm-1 control-label label2cifras"><?php echo trans('applicationResource.form.anio'); ?></label>
                        <div class="col-xs-12 col-sm-2 columna2 <?php echo e($errors->has('year') ? ' has-error' : ''); ?>">
                            <input type="text" class="form-control " id="year" name="year"
                                   value="<?php echo e(old('year')); ?>">
                            <?php if($errors->has('year')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('year')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                    <!-- FIN DE BIBLIOGRAFIA -->


                    <!-- ENVIAR -->
                        <div class="form-group row">
                            <div class="col-xs-12 text-center">
                            <button type="submit" name="submitBtn" value="submitBtn" class="btn btn-md btn-danger">
                                <?php echo trans('applicationResource.form.buscar'); ?>

                            </button>
                            </div>
                        </div>
                </form>


            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/search/byName.blade.php ENDPATH**/ ?>