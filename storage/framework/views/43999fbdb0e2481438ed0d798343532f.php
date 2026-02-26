<div class="form-group row">
           
  
<!-- FAMILIA -->
<div class="<?php echo e($errors->has('family') ? ' has-error' : ''); ?> " id="searchSubstructure1">
    <label class="col-xs-12 col-sm-1 control-label"><?php echo trans('applicationResource.form.familia'); ?></label>
    <div class="col-xs-12 col-sm-3" id="desplegableFam">
        <select class="form-control " name="family" id="family">
            <option selected="true" value="">- - -</option>
        </select>
        <?php if($errors->has('family')): ?>
            <span class="col-xs-12 col-sm-5 col-md-5 help-block">
                            <strong><?php echo e($errors->first('family')); ?></strong>
                        </span>
        <?php endif; ?>
    </div>
</div>
<!-- FIN DE FAMILIA -->

<!-- SUBFAMILIA -->
<div class="f<?php echo e($errors->has('subFamily') ? ' has-error' : ''); ?> " id="searchSubstructure2">
    <label class="col-xs-12 col-sm-1 control-label"><?php echo trans('applicationResource.form.tipo'); ?></label>
    <div class="col-xs-12 col-sm-3" id="desplegableType">
        <select class="form-control" name="subFamily" id="subFamily">
            <option selected="true" value="">- - -</option>
        </select>
        <?php if($errors->has('subFamily')): ?>
            <span class="help-block">
                            <strong><?php echo e($errors->first('subFamily')); ?></strong>
                        </span>
        <?php endif; ?>
    </div>
</div>
<!-- FIN DE SUBFAMILIA -->

<!-- GRUPO -->
<div class="<?php echo e($errors->has('subSubFamily') ? ' has-error' : ''); ?> " id="searchSubstructure3">
    <label class="col-xs-12 col-sm-1 control-label"><?php echo trans('applicationResource.form.grupo'); ?></label>
    <div class="col-xs-12 col-sm-3" id="desplegableGroup">
        <select class="form-control" name="subSubFamily" id="subSubFamily">
            <option selected="true" value="">- - -</option>
        </select>
        <?php if($errors->has('subSubFamily')): ?>
            <span class="help-block">
                            <strong><?php echo e($errors->first('subSubFamily')); ?></strong>
                        </span>
        <?php endif; ?>
    </div>
</div>

<!-- FIN DE GRUPO -->

</div>
<?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/search/familiesPartial.blade.php ENDPATH**/ ?>