<?php $__env->startSection('headers'); ?>
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        var alltranslation = "<?php echo trans('applicationResource.form.minimo.all'); ?>";
        var allminustranslation = "<?php echo trans('applicationResource.form.minimo.allminus'); ?>";
    </script>
    <script src="<?php echo e(asset('js/spin.js')); ?>"></script>
    <script src="<?php echo e(asset('js/loadingScreen.js')); ?>"></script>
    <script src="<?php echo e(asset('js/loadFamilies.js')); ?>"></script>
    <script src="<?php echo e(asset('js/shiftManager.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('.shift').last().find('.toleranceInput').val(2);
        })
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContainer'); ?>
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-12 col-md-offset-0">


                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b><?php echo trans('applicationResource.form.busquedas.desplazamiento'); ?></b></h4>
                    </div>
                </div>
                <hr class="invisible">

                <div class="row text-center">
                    <!-- BOTONES DE AÑADIR Y BORRAR DESPLAZAMIENTO SIN/CON TOLERANCIA-->
                    <div class="col-xs-4 col-sm-offset-3 col-sm-2 col-md-offset-3 col-md-2">
                        <button class="btn btn-md btn-danger"
                                type="button"
                                onclick="deleteShift()">
                            <?php echo trans('applicationResource.button.delete'); ?>

                        </button>
                    </div>

                    <div class="col-xs-4 col-sm-2  col-md-2">
                        <button class="btn btn-md btn-danger" type="button"
                                onclick="createShift()">
                            <?php echo trans('applicationResource.button.add'); ?>

                        </button>
                    </div>

                    <div class="col-xs-4 col-sm-2 col-md-2">
                        <button class="btn btn-md btn-danger" type="button"
                                onclick="switchTolerance()">
                            <?php echo trans('applicationResource.form.tolerance'); ?>

                        </button>
                    </div>

                </div>
                <hr class="invisible">


                <form class="form-horizontal" role="form" method="POST" action="" onsubmit="showLoading()">
                    <?php echo csrf_field(); ?>
                            <!-- CONTENEDOR CON LOS DESPLAZAMIENTOS -->
                    <div class="row">
                        <div id="shiftsContainer" class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-3 col-md-6">

                            <!-- ETIQUETAS -->
                            <div class="form-group  row">
                                <h4><span class="col-md-3 col-xs-4 label label-danger" style="margin-left: 25px;" id="searchChemShift1">δ
                                </span></h4>
                                <h4 hidden><span class="col-md-4 col-xs-4 label label-danger" id="searchChemShift2">δ min</span>
                                </h4>
                                <h4 hidden><span class="col-md-4 col-xs-4 label label-danger" id="searchChemShift3">δ max</span>
                                </h4>
                                <h4 id="typeLabel"><span
                                            class="col-md-3 col-md-offset-1 col-xs-4 label label-danger" id="searchChemShift4"><?php echo trans('applicationResource.form.selectCarbonType'); ?></span>
                                </h4>
                                <h4>
                                    <span class="col-md-3 col-md-offset-1 col-xs-4 label label-danger" id="searchChemShift5"><?php echo trans('applicationResource.form.tolerance'); ?></span>
                                </h4>
                            </div>

                            <!-- DESPLAZAMIENTOs -->
                            <?php if(old('shiftsArray')!==null): ?>
                                <?php for($i=0;$i<sizeof(old('shiftsArray'));$i++): ?>
                                    <?php
                                        $oldMax = old('shiftsArray')[$i]['shiftMax'] ?? null;
                                        $oldMin = old('shiftsArray')[$i]['shiftMin'] ?? null;
                                        $maxF = is_numeric($oldMax) ? (float)$oldMax : 0.0;
                                        $minF = is_numeric($oldMin) ? (float)$oldMin : 0.0;
                                        $midValue = $maxF - ($maxF - $minF) / 2;
                                        $tolValue = ($maxF - $minF) / 2;
                                    ?>
                                    <div class="form-group  row">
                                        <div class="col-xs-4"><input
                                                    onkeyup="updateByShift(this)"
                                                    value="<?php echo e($midValue); ?>"
                                                    class="form-control shiftInput "
                                                    type="text"></div>
                                        <div hidden class="col-xs-4"><input
                                                    onkeyup="updateByMinMax(this)"
                                                    value="<?php echo old('shiftsArray')[$i]['shiftMin']; ?>"
                                                    name="shiftsArray[<?php echo $i; ?>][shiftMin]"
                                                    class="form-control minInput "
                                                    type="text"></div>

                                        <div hidden class="col-xs-4"><input
                                                    onkeyup="updateByMinMax(this)"
                                                    value="<?php echo old('shiftsArray')[$i]['shiftMax']; ?>"
                                                    name="shiftsArray[<?php echo $i; ?>][shiftMax]"
                                                    class="form-control maxInput "
                                                    type="text"></div>
                                        <div class="col-xs-4"><select
                                                    name="shiftsArray[<?php echo $i; ?>][carbonType]"
                                                    class="form-control typeInput ">
                                                <option>C</option>
                                                <option <?php echo old('shiftsArray')[$i]['carbonType']=="CH"?"selected":""; ?>>
                                                    CH
                                                </option>
                                                <option <?php echo old('shiftsArray')[$i]['carbonType']=="CH2"?"selected":""; ?>>
                                                    CH2
                                                </option>
                                                <option <?php echo old('shiftsArray')[$i]['carbonType']=="CH3"?"selected":""; ?>>
                                                    CH3
                                                </option>
                                            </select></div>
                                        <div class="col-xs-4"><input onkeyup="updateByShift(this)"
                                                                     value="<?php echo e($tolValue); ?>"
                                                                     name="shiftsArray[<?php echo $i; ?>][tolerance]"
                                                                     class="form-control toleranceInput "
                                                                     type="text">
                                        </div>
                                    </div>

                                    <?php if($errors->has('shiftsArray.'.$i.'.shiftMin') || $errors->has('shiftsArray.'.$i.'.shiftMax')): ?>
                                        <div class="form-group row">
                                            <span style="color:red" class=" col-xs-12 help-block"><strong><?php echo e(trans('applicationResource.errors.shift')); ?></strong></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($errors->has('shiftsArray.'.$i.'.tolerance')): ?>
                                        <div class="form-group row">
                                            <span style="color:red" class=" col-xs-6 help-block">
                                                <strong><?php echo e(trans('applicationResource.errors.tolerance')); ?></strong>
                                            </span>
                                        </div>
                                        <?php endif; ?>
                                        <?php endfor; ?>
                                        </span>

                                        <!-- Desplazamientos nuevos -->
                                    <?php else: ?>
                                        <div class="form-group shift row">
                                            <div class="col-xs-4"><input
                                                        onkeyup="updateByShift(this)"
                                                        value=""
                                                        class="form-control shiftInput "
                                                        type="text">
                                            </div>
                                            <div hidden class="col-xs-4"><input
                                                        onkeyup="updateByMinMax(this)"
                                                        value=""
                                                        name="shiftsArray[0][shiftMin]"
                                                        class="form-control minInput "
                                                        type="text"></div>
                                            <div hidden class="col-xs-4"><input
                                                        onkeyup="updateByMinMax(this)"
                                                        value=""
                                                        name="shiftsArray[0][shiftMax]"
                                                        class="form-control maxInput "
                                                        type="text"></div>
                                            <div class="col-xs-4"><select
                                                        name="shiftsArray[0][carbonType]"
                                                        class="form-control typeInput ">
                                                    <option value="unknown">Unknown</option>
                                                    <option value="C">s = C</option>
                                                    <option value="CH">d = CH</option>
                                                    <option value="CH2">t = CH2</option>
                                                    <option value="CH3">q = CH3</option>
                                                    <option value="e">e = CH,CH3</option>
                                                </select></div>
                                            <div class="col-xs-4"><input
                                                        onkeyup="updateByShift(this)"
                                                        value=""
                                                        name="shiftsArray[0][tolerance]"
                                                        class="form-control toleranceInput "
                                                        type="text"></div>
                                        </div>
                                    <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                            <?php echo $__env->make('search.familiesPartial', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>

                            <!--ITERATIVA-->
                    <div class="form-group row">
                        <label class="col-xs-4 col-sm-offset-2 col-sm-3 control-label"><?php echo trans('applicationResource.form.minimo'); ?></label>
                        <div class="col-xs-6 col-sm-5<?php echo e($errors->has('minCarbons') ? ' has-error' : ''); ?>">
                            <select class="form-control" name="minCarbons" id="minCarbons">
                                <option value="1"><?php echo trans('applicationResource.form.minimo.all'); ?></option>
                            </select>
                            
                            <?php if($errors->has('minCarbons')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('minCarbons')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div id="info">?<div id="infotext"><?php echo trans('applicationResource.form.minimo.help'); ?></div></div>
                    </div>

                    <!-- ENVIAR -->
                    <div class="form-group row text-center">
                        <button class="btn btn-danger" onclick="submitForm()" type="submit" name="submitBtn"
                                value="submitBtn">
                            <i class="fa fa-btn fa-user"></i><?php echo trans('applicationResource.form.buscar'); ?>

                        </button>
                    </div>

                </form>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/search/byShiftNoPosition.blade.php ENDPATH**/ ?>