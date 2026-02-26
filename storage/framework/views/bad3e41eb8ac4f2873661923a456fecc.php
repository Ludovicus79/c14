<?php $__env->startSection('headers'); ?>
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/spin.js')); ?>"></script>
    <script src="<?php echo e(asset('js/loadingScreen.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap-tabcollapse.js')); ?>"></script>
    <script src="<?php echo e(asset('js/nouislider.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/searchByCarbonType.js')); ?>"></script>
    <script>
        $(document).ready(function () {

            // DEPENDENCY: https://github.com/flatlogic/bootstrap-tabcollapse
            $('.content-tabs').tabCollapse();

            // initialize tab function
            $('.nav-tabs a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('estilos'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/nouislider.min.css')); ?>">

    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContainer'); ?>

    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b><?php echo trans('applicationResource.form.busquedas.tiposCarbono'); ?></b></h4>
                    </div>
                </div>
                <hr class="invisible"></hr>

                <?php if($errors->has('range')): ?>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4 class="help-block">
                                <strong style="color: red;"><?php echo trans('applicationResource.errors.requeridos'); ?></strong>
                            </h4>
                        </div>
                    </div>
                <?php endif; ?>
                        <!--MENÚ CONFIGURACIÓN-->
                    <?php
                    $skelOptions = array('Cs' => 'C*', 'CHs' => 'CH*', 'CH2s' => 'CH<sub>2</sub>*', 'CH3s' => 'CH<sub>3</sub>*', 'COs' => 'C-O*', 'CHOs' => 'CH-O*', 'CH2Os' => 'CH<sub>2</sub>-O*', 'CH3Os' => 'CH<sub>3</sub>-O*', 'CNs' => 'C-N*', 'CHNs' => 'CH-N*', 'CH2Ns' => 'CH<sub>2</sub>-N*', 'CH3Ns' => 'CH<sub>3</sub>-N*');
                    $options = array('C' => 'C', 'CH' => 'CH', 'CH2' => 'CH<sub>2</sub>', 'CH3' => 'CH<sub>3</sub>', 'CO' => 'C-O', 'CHO' => 'CH-O', 'CH2O' => 'CH<sub>2</sub>-O', 'CH3O' => 'CH<sub>3</sub>-O', 'CN' => 'C-N', 'CHN' => 'CH-N', 'CH2N' => 'CH<sub>2</sub>-N', 'CH3N' => 'CH<sub>3</sub>-N');
                    $sufixes = array('', '-O', '-N');
                    $heteroathoms = array('O' => 'O', 'N' => 'N', 'H' => 'H', 'F' => 'F', 'Cl' => 'Cl', 'Br' => 'Br', 'I' => 'I', 'P' => 'P', 'S' => 'S');
                    $types = array('CTali' => 'CT ali', 'CTaro' => 'CT aro', 'CTole' => 'CT ole', 'Csp2' => 'Csp<sup>2</sup>');
                    $ali = array('Cali' => 'C ali', 'CHali' => 'CH ali', 'CH2ali' => 'CH<sub>2</sub> ali', 'COali' => 'C-O ali', 'CHOali' => 'CH-O ali', 'CNali' => 'C-N ali', 'CHNali' => 'CH-N ali');
                    $aro = array('Caro' => 'C aro', 'CHaro' => 'CH aro', 'COaro' => 'C-O aro', 'CHOaro' => 'CH-O aro', 'CNaro' => 'C-N aro', 'CHNaro' => 'CH-N aro');
                    $ole = array('Cole' => 'C ole', 'CHole' => 'CH ole', 'CH2ole' => 'CH<sub>2</sub> ole');
                    $others = array('CCarbonil' => 'C=O');
                    $menus = array('esqueleto' => $skelOptions, 'carbono' => $options, 'heteroatomos' => $heteroathoms, 'tipos' => $types, 'alifaticos' => $ali, 'aromaticos' => $aro, 'olefinicos' => $ole, 'otros' => $others);
                    $index = 1;
                    ?>
                    <div id="tab-container" data-easytabs="true" class="row">
                        <ul class="nav nav-tabs content-tabs" role="tablist">
                            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title=>$options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a class="text-capitalize" data-toggle="tab" href="#tabs1-<?php echo $title; ?>"><strong><?php echo trans('applicationResource.type.'.$title); ?></strong></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <div id="sliderMenu" class="tab-content">
                            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title=>$options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $index++ ?>
                                <div id="tabs1-<?php echo $title; ?>" class="tab-pane fade">
                                    <div class="row panel-body" id="menu<?php echo $index; ?>">
                                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-xs-2">
                                                <input type="checkbox" value="<?php echo $option; ?>"><label>&nbsp;&nbsp;<?php echo $label; ?></label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div>
                        <form id="queryForm" action="<?php echo url('search/byCarbonType'); ?>" method="POST" onsubmit="showLoading()">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                <div class="row" class="col-xs-10 col-xs-offset-1">
                        <div id="containerTarget"></div>
                </div>
                <form id="sliderForm" class="form-group row" method="POST" action="<?php echo url("search/byCarbonType"); ?>">
                    <?php echo csrf_field(); ?>
                </form>

                <hr class="invisible">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button id="btnSearch" class="btn btn-danger"><?php echo trans('applicationResource.form.buscar'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/search/byCarbonType.blade.php ENDPATH**/ ?>