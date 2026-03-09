<div class="row">
    <div class="col-xs-12">
        <div class="btn-group btn-group-justified hidden-xs">
            <a href="<?php echo url('/admin/logs'); ?>"
               class="btn btn-danger"><?php echo trans('applicationResource.admin.logs'); ?></a>
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                    <?php echo trans('applicationResource.admin.mol'); ?>

                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo url('/admin/molEdit'); ?>"><?php echo trans('applicationResource.admin.new'); ?></a>
                    </li>
                    <li><a href="<?php echo url('/admin/search'); ?>"><?php echo trans('applicationResource.admin.edit'); ?></a>
                    </li>
                    <li><a href="<?php echo url('/admin/upload'); ?>"><?php echo trans('applicationResource.admin.excel'); ?></a>
                    </li>
                    <li><a href="<?php echo url('/admin/confirm'); ?>"><?php echo trans('applicationResource.admin.confirm'); ?></a>
                    </li>
                    <li><a href="<?php echo url('/admin/lastMolecules'); ?>"><?php echo trans('applicationResource.admin.lastMol'); ?></a>
                    </li>
                </ul>
            </div>
            <a href="<?php echo url('/admin/users'); ?>"
               class="btn btn-danger"><?php echo trans('applicationResource.admin.users'); ?></a>
            <a href="<?php echo url('/admin/config'); ?>"
               class="btn btn-danger"><?php echo trans('applicationResource.admin.config'); ?></a>
        </div>
    </div>
</div>
<div class="row text-center">
    <div class="col-xs-12">
        <div class="btn-group btn-group-vertical hidden-sm hidden-md hidden-lg">
            <a href="<?php echo url('/admin/logs'); ?>"
               class="btn btn-danger"><?php echo trans('applicationResource.admin.logs'); ?></a>
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                    <?php echo trans('applicationResource.admin.mol'); ?>

                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo url('/admin/molEdit'); ?>"><?php echo trans('applicationResource.admin.new'); ?></a>
                    </li>
                    <li><a href="<?php echo url('/admin/search'); ?>"><?php echo trans('applicationResource.admin.edit'); ?></a>
                    </li>
                    <li><a href="<?php echo url('/admin/upload'); ?>"><?php echo trans('applicationResource.admin.excel'); ?></a>
                    </li>
                </ul>
            </div>
            <a href="<?php echo url('/admin/users'); ?>"
               class="btn btn-danger"><?php echo trans('applicationResource.admin.users'); ?></a>
            <a href="<?php echo url('/admin/config'); ?>"
               class="btn btn-danger"><?php echo trans('applicationResource.admin.config'); ?></a>
        </div>
    </div>
</div><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/admin/adminMenuPartial.blade.php ENDPATH**/ ?>