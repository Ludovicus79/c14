<?php $__env->startSection('mainContainer'); ?>
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
                <h2><b><?php echo trans('applicationResource.sesion.tituloc'); ?></b></h2>
                <p><?php echo trans('applicationResource.sesion.subtituloc'); ?></p></div>
        </div>

        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-md-12 col-md-offset-0">
                <img style="max-height: 400px;" class="img-responsive center-block" src="<?php echo asset('images/plumeria.jpg'); ?>" title="Naproc 13"
                     alt="Naproc 13">
            </div>
        </div>
        <hr class="invisible">
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/home.blade.php ENDPATH**/ ?>