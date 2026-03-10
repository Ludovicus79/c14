<?php $__env->startSection('estilos'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/footable.core.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/footable.metro.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/footable.js')); ?>"></script>
    <script src="<?php echo e(asset('js/footable.sort.js')); ?>"></script>
    <script type="text/javascript">
        $(function () {
            $('.footable').footable();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContainer'); ?>
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">


                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h2><?php echo trans('applicationResource.admin.users'); ?></h2>
                    </div>
                </div>

                <?php echo $__env->make('admin.adminMenuPartial', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <?php if(session('eliminado')): ?>
                    <div class="row">
                        <div class="col-xs-12 text-center" style="color: #CB0223">
                            <h2><?php echo trans('applicationResource.admin.deleteUser'); ?></h2>
                        </div>
                    </div>
                <?php endif; ?>
                    
                    
                <hr class="invisible">

                

                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <table class="footable table" data-sort="false">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('applicationResource.userData.name'); ?></th>
                                        <th class="col-md-1"><?php echo trans('applicationResource.userData.allowed'); ?></th>
                                        <th style="width: 50px; border-bottom: solid 1px #000;"> </th>
                                        <th style="width: 50px; border-bottom: solid 1px #000;"> </th>
                                    </tr>

                                    </thead>

                                    <tbody>
                                    <?php for($i = 0; $i < sizeof($users); $i++): ?>
                                        <tr>
                                            <td><?php echo $users[$i]->id; ?></td>
                                            <td><?php echo $users[$i]->name; ?></td>
                                            <td>
                                                <div class="square <?php echo $users[$i]->allowed?'greenSquare':'redSquare'; ?> "></div>
                                            </td>
  <td style="text-align: center;">
    <a href="<?php echo e(url('admin/users/show/'.$users[$i]->id)); ?>">Ver</a>
</td>
<td style="text-align: center;">
    <form action="<?php echo e(url('admin/users/'.$users[$i]->id)); ?>" method="POST" style="display: inline;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
    </form>
</td>                           </tr>
                                    <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <?php echo e($users->render()); ?>

                    </div>
                </div>


            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/admin/users.blade.php ENDPATH**/ ?>