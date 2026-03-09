<?php $__env->startSection('estilos'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/footable.core.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/footable.metro.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/footable.js')); ?>"></script>
    <script src="<?php echo e(asset('js/footable.sort.js')); ?>"></script>
    <script src="<?php echo e(asset('js/footable.paginate.js')); ?>"></script>
    <script type="text/javascript">
        $(function () {
            $('.footable').footable();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContainer'); ?>
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-12 col-md-offset-0">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b><?php echo trans('applicationResource.colab.colaboradores'); ?></b></h4>
                    </div>
                </div>
  
                <div class="row">
                    <div class="col-xs-12">
                        <table class="footable table" data-page-size="15">
                            <thead>
                            <tr>
                                <th><?php echo trans('applicationResource.colab.autor'); ?></th>
                                <th data-hide="phone"><?php echo trans('applicationResource.colab.email'); ?></th>
                                <th data-hide="phone"><?php echo trans('applicationResource.colab.organismo'); ?></th>
                                <th data-hide="phone"><?php echo trans('applicationResource.colab.pais'); ?></th>
                                <th data-type="numeric"><?php echo trans('applicationResource.colab.numcompuestos'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $contributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo $contributor->author; ?></td>
                                    <td><?php echo $contributor->email; ?></td>
                                    <td><?php echo $contributor->organization; ?></td>
                                    <td><?php echo $contributor->country; ?></td>
                                    <td><?php echo $contributor->molecules()->count(); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="pagination"></div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/contributors.blade.php ENDPATH**/ ?>