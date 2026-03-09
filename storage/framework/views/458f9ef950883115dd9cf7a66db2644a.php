<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function () {

            $('.panel').hide();

            $('a.list-group-item').click(function (event) {
                event.preventDefault();
                $('.panel').hide();
                label = $(this).data('label');
                $(".panel[data-label='" + label + "']").show();
            })
        })
    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContainer'); ?>
    <hr class="invisible">
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <div class="row">
                    <div class="col-sm-3 ">
                        <div class="list-group">
                            <div class="list-group-item list-group-item-danger"><?php echo trans('applicationResource.ayuda.menu.ayuda'); ?></div>
                            <div class="list-group-item"><?php echo trans('applicationResource.ayuda.menu.busqueda'); ?></div>
                            <a href="" data-label="nombre" style="padding-left: 2em"
                               class="list-group-item"><?php echo trans('applicationResource.ayuda.menu.nombre'); ?></a>
                            <a href="" data-label="subestructura" style="padding-left: 2em"
                               class="list-group-item"><?php echo trans('applicationResource.ayuda.menu.subestructura'); ?></a>
                            <a href="" data-label="iterativa" style="padding-left: 2em"
                               class="list-group-item"><?php echo trans('applicationResource.ayuda.menu.iterativa'); ?></a>
                            <a href="" data-label="tipos" style="padding-left: 2em"
                               class="list-group-item"><?php echo trans('applicationResource.ayuda.menu.tipos'); ?></a>
                            <a href="" data-label="historial"
                               class="list-group-item"><?php echo trans('applicationResource.ayuda.menu.historial'); ?></a>
                            <a href="" data-label="resultados"
                               class="list-group-item"><?php echo trans('applicationResource.ayuda.menu.resultados'); ?></a>
                            <a href="" data-label="editor"
                               class="list-group-item"><?php echo trans('applicationResource.ayuda.menu.editor'); ?></a>
                        </div>
                    </div>


                    <div class="col-sm-9">
                        <div class="panel panel-danger" data-label="nombre">
                            <div class="panel-heading">
                                <strong><?php echo trans('applicationResource.ayuda.busnombre.p0'); ?></strong>
                            </div>
                            <div class="panel-body">
                                <p><?php echo trans('applicationResource.ayuda.busnombre.p1'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busnombre.p2'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busnombre.p3'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busnombre.p4'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busnombre.p5'); ?></p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="subestructura">
                            <div class="panel-heading">
                                <strong><?php echo trans('applicationResource.ayuda.bussubestructura.p0'); ?></strong></div>
                            <div class="panel-body">
                                <p><?php echo trans('applicationResource.ayuda.bussubestructura.p1'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.bussubestructura.p2'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.bussubestructura.p3'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.bussubestructura.p4'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.bussubestructura.p5'); ?></p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="iterativa">
                            <div class="panel-heading">
                                <strong><?php echo trans('applicationResource.ayuda.busiterativa.p0'); ?></strong></div>
                            <div class="panel-body">
                                <p><?php echo trans('applicationResource.ayuda.busiterativa.p1'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busiterativa.p2'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busiterativa.p3'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busiterativa.p4'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busiterativa.p5'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busiterativa.p6'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busiterativa.p7'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.busiterativa.p8'); ?></p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="tipos">
                            <div class="panel-heading">
                                <strong><?php echo trans('applicationResource.ayuda.bustipcarb.p0'); ?></strong>
                            </div>
                            <div class="panel-body">
                                <p><?php echo trans('applicationResource.ayuda.bustipcarb.p1'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.bustipcarb.p2'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.bustipcarb.p3'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.bustipcarb.p4'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.bustipcarb.p5'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.bustipcarb.p6'); ?></p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="historial">
                            <div class="panel-heading">
                                <strong><?php echo trans('applicationResource.ayuda.historial.p0'); ?></strong>
                            </div>
                            <div class="panel-body">
                                <p><?php echo trans('applicationResource.ayuda.historial.p1'); ?></p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="resultados">
                            <div class="panel-heading">
                                <strong><?php echo trans('applicationResource.ayuda.resultados.p0'); ?></strong>
                            </div>
                            <div class="panel-body">
                                <p><?php echo trans('applicationResource.ayuda.resultados.p1'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.resultados.p2'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.resultados.p3'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.resultados.p4'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.resultados.p5'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.resultados.p6'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.resultados.p7'); ?></p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="editor">
                            <div class="panel-heading">
                                <strong><?php echo trans('applicationResource.ayuda.editor.p0'); ?></strong>
                            </div>
                            <div class="panel-body">
                                <p><strong><?php echo trans('applicationResource.ayuda.editor.p1'); ?></strong></p>
                                <img class="img-responsive" src="<?php echo asset('images/helpImages/editorMenu.gif'); ?>">
                                <p>
                                    <img class="img-responsive" src="<?php echo asset('/images/helpImages/smileControl.gif'); ?>"><?php echo trans('applicationResource.ayuda.editor.p2'); ?>

                                </p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p3'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p4'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p5'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p6'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p7'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p8'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p9'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p10'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p11'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p12'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p13'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p14'); ?></p>
                                <p><strong><?php echo trans('applicationResource.ayuda.editor.p15'); ?></strong></p>
                                <img class="img-responsive" src="<?php echo asset('images/helpImages/editorShapes.gif'); ?>">
                                <p><?php echo trans('applicationResource.ayuda.editor.p16'); ?></p>
                                <p><strong><?php echo trans('applicationResource.ayuda.editor.p17'); ?></strong></p>
                                <img class="img-responsive" src="<?php echo asset('images/helpImages/editorLinks.gif'); ?>">
                                <p><?php echo trans('applicationResource.ayuda.editor.p18'); ?></p>
                                <p><strong><?php echo trans('applicationResource.ayuda.editor.p19'); ?></strong></p>
                                <img class="img-responsive" src="<?php echo asset('images/helpImages/editorAtoms.gif'); ?>">
                                <p><?php echo trans('applicationResource.ayuda.editor.p20'); ?></p>
                                <p><?php echo trans('applicationResource.ayuda.editor.p21'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/help/help.blade.php ENDPATH**/ ?>