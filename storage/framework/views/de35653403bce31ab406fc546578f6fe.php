<?php $__env->startSection('headers'); ?>
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        var index;
        $(document).ready(
                function () {
                    $('#newCButton').click(newCarbon);
                    index = $('#tabladesplazamientos tbody tr.carbonRow').size();
                    $('.delCButton').click(deleteCarbon);
                    $('#jmeArea').change(reloadJme);
                }
        )

        var deleteCarbon = function () {
            if ($('#tabladesplazamientos tbody tr.carbonRow').size() > 1) {
                $(this).closest('tr').next('.errorRow').remove();
                $(this).closest('tr').remove();
            }
        }

        var newCarbon = function () {
            row = $('<tr>').addClass('carbonRow').appendTo('#tabladesplazamientos tbody');
            $('<input>', {'type': 'hidden'}).attr('name', 'carbon[' + index + '][id]').appendTo(row);
            $('<td>').append($('<input>').addClass('form-control input-sm inp-small').attr('name', 'carbon[' + index + '][num2]')).appendTo(row);
            $('<td>').append($('<input>').addClass('form-control input-sm inp-small').attr('name', 'carbon[' + index + '][numeration]')).appendTo(row);
            selectType = $('<select>').addClass('form-control input-sm inp-small').attr('name', 'carbon[' + index + '][carbonType]');
            selectType.append($('<option value="C">C</option>'));
            selectType.append($('<option value="CH">CH</option>'));
            selectType.append($('<option value="CH2">CH<sub>2</sub></option>'));
            selectType.append($('<option value="CH3">CH<sub>3</sub></option>'));

            $('<td>').append(selectType).appendTo(row);
            $('<td>').append($('<input>').addClass('form-control input-sm inp-small').attr('name', 'carbon[' + index + '][shift]')).appendTo(row);
            $('<td>').append($('<button>').attr('type', 'button').addClass('btn btn-danger delCButton').text('X').click(deleteCarbon)).appendTo(row);
            index++;
        }

    </script>

    <script src="<?php echo asset('jsme/jsme.nocache.js'); ?>" type="text/javascript"></script>

    <script>
        var jsmeDis;
        var jsmeNum;

        $(document).ready(
                function () {
                    $('#jmeArea').change(reloadJme);
                }
        )

        function reloadJme() {
            jsmeNum.readMolecule($(this).val());
        }

        function jsmeOnLoad() {
            jsmeNum = new JSApplet.JSME("jsme_container_num", "500px", "350px", {
                "options": "depict, number"
            });
            jsmeNum.readMolecule("<?php echo $molecule->jmeNumeration; ?>");
            jsmeDis = new JSApplet.JSME("jsme_container_dis", "500px", "350px", {
                "options": "depict, number"
            });
            jsmeDis.readMolecule("<?php echo $molecule->jmeDisplacement; ?>");
        }
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContainer'); ?>
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-sm-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h4><b><?php echo trans('applicationResource.admin.edit'); ?></b></h4>
                    </div>
                </div>

                <?php echo $__env->make('admin.adminMenuPartial', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <br>

                <form class="form-horizontal" action="<?php echo e(url('admin/molEdit/')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="molecule[id]" value="<?php echo $molecule->id; ?>">

                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Ref: </label>
                        <div class="col-sm-2 <?php echo $errors->has('molecule.reference')?'has-error':''; ?>">
                            <input
                                    class="form-control input-sm"
                                    name="molecule[reference]"
                                    value="<?php echo empty(old('molecule.reference'))?$molecule->reference:old('molecule.reference'); ?>">
                            <?php if($errors->has('molecule.reference')): ?>
                                <span class="help-block"><?php echo e($errors->first('molecule.reference')); ?></span>
                            <?php endif; ?>
                        </div>
                        <label class="col-sm-2 control-label"><?php echo trans('applicationResource.molData.state'); ?></label>
                        <div class="col-sm-2 <?php echo $errors->has('molecule.state')?'has-error':''; ?>">

                            <select class="form-control input-sm" name="molecule[state]" id="molecule[state]">
                                <option value="6">Sin confirmar</option>
                                <option value="1" <?php echo $molecule->state=="1"?"selected":""; ?>>Confirmada</option>
                            </select>
                            <?php if($errors->has('molecule.state')): ?>
                                <span class="help-block"><?php echo e($errors->first('molecule.state')); ?></span>
                            <?php endif; ?>
                        </div>
                        <label class="col-sm-2 control-label"><?php echo trans('applicationResource.molData.solvent'); ?></label>
                        <div class="col-sm-1 <?php echo $errors->has('molecule.solvent')?'has-error':''; ?>">
                            <input
                                    class="form-control input-sm"
                                    name="molecule[solvent]"
                                    value="<?php echo empty(old('molecule.solvent'))?$molecule->solvent:old('molecule.solvent'); ?>">
                            <?php if($errors->has('molecule.solvent')): ?>
                                <span class="help-block "><?php echo e($errors->first('molecule.solvent')); ?></span>
                            <?php endif; ?>
                        </div>

                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 control-label"><?php echo trans('applicationResource.molData.family'); ?></label>
                        <div class="col-sm-2 <?php echo $errors->has('molecule.family')?'has-error':''; ?>">
                            <input
                                    class="form-control input-sm"
                                    name="molecule[family]"
                                    value="<?php echo empty(old('molecule.family'))?$molecule->family:old('molecule.family'); ?>">
                            <?php if($errors->has('molecule.family')): ?>
                                <span class="help-block "><?php echo e($errors->first('molecule.family')); ?></span>
                            <?php endif; ?>
                        </div>
                         <label class="col-sm-2 control-label"><?php echo trans('applicationResource.molData.group'); ?></label>
                        <div class="col-sm-2 <?php echo $errors->has('molecule.subFamily')?'has-error':''; ?>">
                            <input
                                    name="molecule[subFamily]"
                                    class="form-control input-sm"
                                    value="<?php echo empty(old('molecule.subFamily'))?$molecule->subFamily:old('molecule.subFamily'); ?>">
                            <?php if($errors->has('molecule.subFamily')): ?>
                                <span class="help-block "><?php echo e($errors->first('molecule.subFamily')); ?></span>
                            <?php endif; ?>
                        </div>
                        <label class="col-sm-2 control-label"><?php echo trans('applicationResource.molData.type'); ?></label>
                        <div class="col-sm-2 <?php echo $errors->has('molecule.subSubFamily')?'has-error':''; ?>">
                            <input
                                    name="molecule[subSubFamily]"
                                    class="form-control input-sm"
                                    value="<?php echo empty(old('molecule.subSubFamily'))?$molecule->subSubFamily:old('molecule.subSubFamily'); ?>">
                            <?php if($errors->has('molecule.subSubFamily')): ?>
                                <span class="help-block "><?php echo e($errors->first('molecule.subSubFamily')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label"><?php echo trans('applicationResource.molData.weight'); ?></label>
                        <div class="col-sm-2">
                            <?php echo e($molecule->molecularWeight); ?>

                        </div>
                        <label class="col-sm-2 control-label"><?php echo trans('applicationResource.molData.formula'); ?></label>
                        <div class="col-sm-2">
                            <?php echo $molecularFormula; ?>

                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-6 text-center"><u><?php echo trans('applicationResource.submenu.desplazamiento'); ?></u></label>
                    <label class="col-md-6 text-center"><u><?php echo trans('applicationResource.submenu.estructura'); ?></u></label>
                    </div>


                    <div class="row">
                        <div class="col-xs-12 col-sm-5" id="desplazamientos">
                            <table id="tabladesplazamientos">
                                <thead>
                                <tr>
                                    <td colspan="4">
                                        <button id="newCButton" class="btn btn-danger"
                                                type="button"><?php echo trans('applicationResource.button.add'); ?></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <span><?php echo trans('applicationResource.carbonData.numeration2'); ?></span>
                                    </td>
                                    <td align="left">
                                        <span><?php echo trans('applicationResource.carbonData.numeration'); ?></span>
                                    </td>
                                    <td align="left">
                                        <span><?php echo trans('applicationResource.carbonData.type'); ?></span>
                                    </td>
                                    <td align="right"><span>&delta;(ppm)</span></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(old('carbon')!==null): ?>
                                    <?php $__currentLoopData = (old('carbon')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$carbon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="carbonRow">
                                            <input type="hidden" name="carbon[<?php echo $i; ?>][id]"
                                                   value="<?php echo $carbon['id']; ?>">
                                            <td>
                                                <input class="form-control input-sm inp-small <?php echo $errors->has('carbon.'.$i.'.num2')?'inp-error':''; ?>"
                                                       name="carbon[<?php echo $i; ?>][num2]"
                                                       value="<?php echo $carbon['num2']; ?>">
                                            </td>
                                            <td>
                                                <input class="form-control input-sm inp-small <?php echo $errors->has('carbon.'.$i.'.numeration')?'inp-error':''; ?>"
                                                       name="carbon[<?php echo $i; ?>][numeration]"
                                                       value="<?php echo $carbon['numeration']; ?>"></td>
                                            <td><select class="form-control input-sm inp-small"
                                                        name="carbon[<?php echo $i; ?>][carbonType]">
                                                    <option <?php echo e($carbon['carbonType']=="C"?"selected":""); ?> value="C">
                                                        C
                                                    </option>
                                                    <option <?php echo e($carbon['carbonType']=="CH"?"selected":""); ?> value="CH">
                                                        CH
                                                    </option>
                                                    <option <?php echo e($carbon['carbonType']=="CH2"?"selected":""); ?> value="CH2">
                                                        CH<sub>2</sub></option>
                                                    <option <?php echo e($carbon['carbonType']=="CH3"?"selected":""); ?> value="CH3">
                                                        CH<sub>3</sub></option>
                                                </select></td>
                                            <td>
                                                <input class="form-control input-sm inp-small <?php echo $errors->has('carbon.'.$i.'.shift')?'inp-error':''; ?>"
                                                       name="carbon[<?php echo $i; ?>][shift]"
                                                       value="<?php echo $carbon['shift']; ?>"></td>
                                            <td>
                                                <button class="btn btn-danger delCButton" type="button">X</button>
                                            </td>
                                        </tr>
                                        <tr class="errorRow">
                                            <td colspan="5">
                                                <?php if($errors->has('carbon.'.$i.'.num2')): ?>
                                                    <span class="help-block "><?php echo e($errors->first('carbon.'.$i.'.num2')); ?></span>
                                                <?php endif; ?>
                                                <?php if($errors->has('carbon.'.$i.'.numeration')): ?>
                                                    <span class="help-block "><?php echo e($errors->first('carbon.'.$i.'.numeration')); ?></span>
                                                <?php endif; ?>
                                                <?php if($errors->has('carbon.'.$i.'.num2')): ?>
                                                    <span class="help-block "><?php echo e($errors->first('carbon.'.$i.'.shift')); ?></span>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php else: ?>
                                    <?php for($i=0;$i<sizeof($carbons);$i++): ?>
                                        <tr class="carbonRow">
                                            <input type="hidden" name="carbon[<?php echo $i; ?>][id]"
                                                   value="<?php echo $carbons[$i]->id; ?>">
                                            <td><input class="form-control input-sm inp-small"
                                                       name="carbon[<?php echo $i; ?>][num2]"
                                                       value="<?php echo $carbons[$i]->num2; ?>">
                                            </td>
                                            <td><input class="form-control input-sm inp-small"
                                                       name="carbon[<?php echo $i; ?>][numeration]"
                                                       value="<?php echo $carbons[$i]->numeration; ?>"></td>
                                            <td><select class="form-control input-sm inp-small"
                                                        name="carbon[<?php echo $i; ?>][carbonType]">
                                                    <option <?php echo e($carbons[$i]->carbonType=="C"?"selected":""); ?> value="C">
                                                        C
                                                    </option>
                                                    <option <?php echo e($carbons[$i]->carbonType=="CH"?"selected":""); ?> value="CH">
                                                        CH
                                                    </option>
                                                    <option <?php echo e($carbons[$i]->carbonType=="CH2"?"selected":""); ?> value="CH2">
                                                        CH<sub>2</sub></option>
                                                    <option <?php echo e($carbons[$i]->carbonType=="CH3"?"selected":""); ?> value="CH3">
                                                        CH<sub>3</sub></option>
                                                </select></td>
                                            <td><input class="form-control input-sm inp-small"
                                                       name="carbon[<?php echo $i; ?>][shift]"
                                                       value="<?php echo $carbons[$i]->shift; ?>"></td>
                                            <td>
                                                <button class="btn btn-danger delCButton" type="button">X</button>
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endif; ?>
                                </tbody>

                            </table>
                        </div>



                        <div class="col-xs-12 col-sm-6">
                            <div class="jmeProp" id="jsme_container_num"></div>
                            <div class="jmeProp" id="jsme_container_dis"></div>
                        </div>

                    </div>

                    <hr class="invisible"></hr>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label"><?php echo trans('applicationResource.molData.name'); ?></label>
                        <div class="col-sm-5 <?php echo $errors->has('molecule.name')?'has-error':''; ?>">
                            <input
                                    class="form-control input-sm"
                                    name="molecule[name]"
                                    value="<?php echo empty(old('molecule.name'))?$molecule->name:old('molecule.name'); ?>">
                            <?php if($errors->has('molecule.name')): ?>
                                <span class="help-block "><?php echo e($errors->first('molecule.name')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label"><?php echo trans('applicationResource.molData.ssname'); ?></label>
                        <div class="col-sm-5 <?php echo $errors->has('molecule.semiSystematicName')?'has-error':''; ?>">
                            <input
                                    class="form-control input-sm "
                                    name="molecule[semiSystematicName]"
                                    value="<?php echo empty(old('molecule.semiSystematicName'))?$molecule->semiSystematicName:old('molecule.semiSystematicName'); ?>">
                            <?php if($errors->has('molecule.semiSystematicName')): ?>
                                <span class="help-block "><?php echo e($errors->first('molecule.semiSystematicName')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row text-center">
                        <div class="col-sm-12 text-center">
                            <label class="control-label"><?php echo trans('applicationResource.molData.jmeNum'); ?></label>
                        </div>
                        <div class="col-sm-12 <?php echo $errors->has('molecule.jmeNumeration')?'has-error':''; ?>">
                                <textarea
                                        class="form-control"
                                        id="jmeArea"
                                        name="molecule[jmeNumeration]"><?php echo empty(old('molecule.jmeNumeration'))?$molecule->jmeNumeration:old('molecule.jmeNumeration'); ?></textarea>
                            <?php if($errors->has('molecule.jmeNumeration')): ?>
                                <span class="help-block "><?php echo e($errors->first('molecule.jmeNumeration')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row text-center">
                        <div class="col-sm-12 text-center">
                            <label class="control-label"><?php echo trans('applicationResource.molData.smilesNum'); ?></label>
                        </div>
                        <div class="col-sm-12 <?php echo $errors->has('molecule.smilesNumeration')?'has-error':''; ?>">
                            <textarea
                                    class="form-control"
                                    name="molecule[smilesNumeration]"><?php echo empty(old('molecule.smilesNumeration'))?$molecule->smilesNumeration:old('molecule.smilesNumeration'); ?></textarea>
                            <?php if($errors->has('molecule.smilesNumeration')): ?>
                                <span class="help-block"><?php echo e($errors->first('molecule.smilesNumeration')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">

                            <h3><?php echo trans('applicationResource.molData.bibliography'); ?></h3>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <label class="control-label"><?php echo trans('applicationResource.biblioData.authors'); ?></label>
                        </div>
                        <div class="col-sm-12 <?php echo $errors->has('bibliography.authors')?'has-error':''; ?>">
                                <textarea
                                        class="form-control input-sm"
                                        name="bibliography[authors]"><?php echo empty(old('bibliography.authors'))?$bibliography->authors:old('bibliography.authors'); ?></textarea>
                            <?php if($errors->has('bibliography.authors')): ?>
                                <span class="help-block "><?php echo e($errors->first('bibliography.authors')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">


                        <label class="control-label col-sm-1"><?php echo trans('applicationResource.biblioData.magazine'); ?></label>
                        <div class="col-sm-4  <?php echo $errors->has('bibliography.magazine')?'has-error':''; ?>">
                            <input
                                    class="form-control input-sm"
                                    name="bibliography[magazine]"
                                    value="<?php echo empty(old('bibliography.magazine'))?$bibliography->magazine:old('bibliography.magazine'); ?>">
                            <?php if($errors->has('bibliography.magazine')): ?>
                                <span class="help-block "><?php echo e($errors->first('bibliography.magazine')); ?></span>
                            <?php endif; ?>
                        </div>
                        <label class="control-label col-sm-1"><?php echo trans('applicationResource.biblioData.year'); ?></label>
                        <div class="col-sm-1 <?php echo $errors->has('bibliography.year')?'has-error':''; ?>"><input
                                    class="form-control input-sm"
                                    name="bibliography[year]"
                                    value="<?php echo empty(old('bibliography.year'))?$bibliography->year:old('bibliography.year'); ?>">
                            <?php if($errors->has('bibliography.year')): ?>
                                <span class="help-block"><?php echo e($errors->first('bibliography.year')); ?></span>
                            <?php endif; ?>
                        </div>
                        <label class="control-label col-sm-1"><?php echo trans('applicationResource.biblioData.volume'); ?></label>
                        <div class="col-sm-1 <?php echo $errors->has('bibliography.volume')?'has-error':''; ?>"><input
                                    class="form-control input-sm"
                                    name="bibliography[volume]"
                                    value="<?php echo empty(old('bibliography.volume'))?$bibliography->volume:old('bibliography.volume'); ?>">
                            <?php if($errors->has('bibliography.volume')): ?>
                                <span class="help-block "><?php echo e($errors->first('bibliography.volume')); ?></span>
                            <?php endif; ?>
                        </div>
                        <label class="control-label col-sm-1"><?php echo trans('applicationResource.biblioData.page'); ?></label>
                        <div class="col-sm-2 <?php echo $errors->has('bibliography.page')?'has-error':''; ?>"><input
                                    class="form-control input-sm"
                                    name="bibliography[page]"
                                    value="<?php echo empty(old('bibliography.page'))?$bibliography->page:old('bibliography.page'); ?>">
                            <?php if($errors->has('bibliography.page')): ?>
                                <span class="help-block "><?php echo e($errors->first('bibliography.page')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-1"><?php echo trans('applicationResource.biblioData.doi'); ?></label>
                        <div class="col-sm-4  <?php echo $errors->has('bibliography.doi')?'has-error':''; ?>">
                            <input
                                    class="form-control input-sm"
                                    name="bibliography[doi]"
                                    value="<?php echo empty(old('bibliography.doi'))?$bibliography->doi:old('bibliography.doi'); ?>">
                            <?php if($errors->has('bibliography.doi')): ?>
                                <span class="help-block "><?php echo e($errors->first('bibliography.doi')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <h3><?php echo trans('applicationResource.molData.author'); ?></h3>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-2"><?php echo trans('applicationResource.authorData.author'); ?></label>
                        <div class="col-sm-4 <?php echo $errors->has('author.author')?'has-error':''; ?>">
                            <input
                                    class="form-control input-sm"
                                    name="author[author]"
                                    value="<?php echo empty(old('author.author'))?$author->author:old('author.author'); ?>">
                            <?php if($errors->has('author.author')): ?>
                                <span class="help-block  "><?php echo e($errors->first('author.author')); ?></span>
                            <?php endif; ?>
                        </div>
                        <label class="control-label col-sm-2"><?php echo trans('applicationResource.authorData.email'); ?></label>
                        <div class="col-sm-4 <?php echo $errors->has('author.email')?'has-error':''; ?>">
                            <input
                                    class="form-control input-sm"
                                    name="author[email]"
                                    value="<?php echo empty(old('author.email'))?$author->email:old('author.email'); ?>">
                            <?php if($errors->has('author.email')): ?>
                                <span class="help-block "><?php echo e($errors->first('author.email')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-2"><?php echo trans('applicationResource.authorData.country'); ?></label>
                        <div class="col-sm-4 <?php echo $errors->has('author.country')?'has-error':''; ?>">
                            <input
                                    class="form-control input-sm"
                                    name="author[country]"
                                    value="<?php echo empty(old('author.country'))?$author->country:old('author.country'); ?>">
                            <?php if($errors->has('author.country')): ?>
                                <span class="help-block "><?php echo e($errors->first('author.country')); ?></span>
                            <?php endif; ?>
                        </div>
                        <label class="control-label col-sm-2"><?php echo trans('applicationResource.authorData.organization'); ?></label>
                        <div class="col-sm-4 <?php echo $errors->has('author.organization')?'has-error':''; ?>"><input
                                    class="form-control input-sm"
                                    name="author[organization]"
                                    value="<?php echo empty(old('author.organization'))?$author->organization:old('author.organization'); ?>">
                            <?php if($errors->has('author.organization')): ?>
                                <span class="help-block "><?php echo e($errors->first('author.organization')); ?></span>
                            <?php endif; ?>
                        </div>

                    </div>



                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <label class="control-label"><?php echo trans('applicationResource.molData.comments'); ?></label>
                        </div>
                        <div class="col-sm-12 <?php echo $errors->has('molecule.publicCom')?'has-error':''; ?>">
                                <textarea
                                        class="form-control"
                                        name="molecule[publicCom]"><?php echo empty(old('molecule.publicCom'))?$molecule->publicCom:old('molecule.publicCom'); ?></textarea>
                            <?php if($errors->has('molecule.publicCom')): ?>
                                <span class="has-error "><?php echo e($errors->first('molecule.publicCom')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <label class="control-label"><?php echo trans('applicationResource.molData.priComments'); ?></label>
                        </div>
                        <div class="col-sm-12 <?php echo $errors->has('molecule.privateCom')?'has-error':''; ?>">
                                <textarea
                                        class="form-control"
                                        name="molecule[privateCom]"><?php echo empty(old('molecule.privateCom'))?$molecule->privateCom:old('molecule.privateCom'); ?></textarea>
                            <?php if($errors->has('molecule.privateCom')): ?>
                                <span class="has-error "><?php echo e($errors->first('molecule.privateCom')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-12 text-center">
                        <button id="submitBtn" type="button" data-toggle="modal" data-target="#alertSave"
                                class="btn btn-md btn-danger"><?php echo trans('applicationResource.button.save'); ?></button>
                        <button type="button" id="deleteButton" data-toggle="modal" data-target="#alertDelete"
                                class="btn btn-md btn-danger <?php echo empty($molecule->id)?'disabled':''; ?>"><?php echo trans('applicationResource.button.delete'); ?></button>
                    </div>
                    <!-- Diálogo Guardar -->
                    <div id="alertSave" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><?php echo trans('applicationResource.dialog.sure'); ?></h4>
                                </div>
                                <div class="modal-body">
                                    <p><?php echo trans('applicationResource.dialog.save'); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name
                                            class="btn btn-danger"><?php echo trans('applicationResource.button.confirm'); ?></
                                    >
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal"><?php echo trans('applicationResource.button.cancel'); ?></button>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- Diálogo borrar -->
                    <div id="alertDelete" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><?php echo trans('applicationResource.dialog.sure'); ?></h4>
                                </div>
                                <div class="modal-body">
                                    <p><?php echo trans('applicationResource.dialog.deleteMol'); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="delete"
                                            class="btn btn-danger"><?php echo trans('applicationResource.button.confirm'); ?></button>
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal"><?php echo trans('applicationResource.button.cancel'); ?></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>


            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/admin/adminMolDetail.blade.php ENDPATH**/ ?>