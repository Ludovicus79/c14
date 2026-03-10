<?php $__env->startSection('headers'); ?>
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('estilos'); ?>
    <style>
        #ketcher-container {
            width: 100%;
            height: 500px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
        }
        #ketcher-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        .substructure-controls {
            padding-top: 60px;
        }
        .substructure-controls .form-group {
            margin-bottom: 20px;
        }
        @media (max-width: 767px) {
            #ketcher-container { height: 350px; }
            .substructure-controls { padding-top: 20px; }
        }

        #ketcher-container {
        width: 80%;
        height: 500px;
        border: 1px solid #ccc;
        border-radius: 4px;
        overflow: hidden;
        }

    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/spin.js')); ?>"></script>
    <script src="<?php echo e(asset('js/loadingScreen.js')); ?>"></script>
    <script src="<?php echo e(asset('js/loadFamilies.js')); ?>"></script>
    <script>
        function getSmile() {
            try {
                var iframe = document.getElementById('ketcherFrame');
                if (iframe && iframe.contentWindow && iframe.contentWindow.ketcher) {
                    var ketcher = iframe.contentWindow.ketcher;
                    ketcher.getSmiles().then(function(smiles) {
                        document.getElementById("smileCode").value = smiles;
                        document.getElementById("jmeCode").value = smiles;
                    });
                }
            } catch(e) {
                console.log('Ketcher not ready:', e);
            }
        }

        function submitWithSmiles() {
            var iframe = document.getElementById('ketcherFrame');
            if (iframe && iframe.contentWindow && iframe.contentWindow.ketcher) {
                var ketcher = iframe.contentWindow.ketcher;
                ketcher.getSmiles().then(function(smiles) {
                    document.getElementById("smileCode").value = smiles;
                    document.getElementById("jmeCode").value = smiles;
                    showLoading();
                    document.getElementById('substructureForm').submit();
                });
            } else {
                showLoading();
                document.getElementById('substructureForm').submit();
            }
        }

        $(document).ready(function() {
            $('#stereoButton').on('click', function() {
                var btn = $(this);
                setTimeout(function() {
                    btn.text(btn.hasClass('active') ? 'ON' : 'OFF');
                }, 10);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContainer'); ?>
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b><?php echo trans('applicationResource.form.busquedas.subestructura'); ?></b></h4>
                    </div>
                </div>

                <hr class="invisible">

                <form id="substructureForm" class="form-horizontal" role="form" method="POST" action="">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        
                        <div class="col-xs-10 col-md-8">
                            <div id="ketcher-container">
                              <iframe id="ketcherFrame"
                                        src="/standalone/index.html"
                                         title="Ketcher Molecule Editor">
                                </iframe> 
                            </div>
                        </div>

                        
                        <div class="col-xs-10 col-md-5 substructure-controls">

                            
                            <div class="form-group row text-center">
                                <label class="col-xs-6 control-label">
                                    <?php echo trans('applicationResource.form.stereo'); ?>

                                </label>
                                <div class="col-xs-6">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-danger <?php echo e(old('stereo') ? 'active' : ''); ?>" id="stereoButton">
                                            <input type="checkbox" name="stereo" value="1"
                                                <?php echo e(old('stereo') ? 'checked' : ''); ?>>
                                            <?php echo e(old('stereo') ? 'ON' : 'OFF'); ?>

                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr class="invisible">

                            
                            <div class="form-group row">
                                <?php echo $__env->make('search.familiesPartial', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>

                            <?php if($errors->has('emptyError')): ?>
                                <div class="row text-center">
                                    <span style="color:red" class="col-xs-12 help-block">
                                        <strong><?php echo e(trans('applicationResource.errors.substructure')); ?></strong>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <hr class="invisible">

                            
                            <div class="form-group row text-center">
                                <button class="btn btn-danger" type="button"
                                        onclick="submitWithSmiles()">
                                    <?php echo trans('applicationResource.form.buscar'); ?>

                                </button>
                            </div>
                        </div>
                    </div>

                    
                    <input type="hidden" name="smileCode" id="smileCode" value="<?php echo e(old('smileCode')); ?>">
                    <input type="hidden" name="jmeCode" id="jmeCode" value="<?php echo e(old('jmeCode')); ?>">
                    <input type="hidden" name="emptyError" value="">
                    <input type="hidden" name="submitBtn" value="submitBtn">

                </form>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\c14-main\resources\views/search/bySubstructure.blade.php ENDPATH**/ ?>