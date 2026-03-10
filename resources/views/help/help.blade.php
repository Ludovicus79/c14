@extends('layouts.master')

@section('scripts')
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

@endsection

@section('mainContainer')
    <hr class="invisible">
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <div class="row">
                    <div class="col-sm-3 ">
                        <div class="list-group">
                            <div class="list-group-item list-group-item-danger">{!! trans('applicationResource.ayuda.menu.ayuda') !!}</div>
                            <div class="list-group-item">{!! trans('applicationResource.ayuda.menu.busqueda') !!}</div>
                            <a href="" data-label="nombre" style="padding-left: 2em"
                               class="list-group-item">{!! trans('applicationResource.ayuda.menu.nombre') !!}</a>
                            <a href="" data-label="subestructura" style="padding-left: 2em"
                               class="list-group-item">{!! trans('applicationResource.ayuda.menu.subestructura') !!}</a>
                            <a href="" data-label="iterativa" style="padding-left: 2em"
                               class="list-group-item">{!! trans('applicationResource.ayuda.menu.iterativa') !!}</a>
                            <a href="" data-label="tipos" style="padding-left: 2em"
                               class="list-group-item">{!! trans('applicationResource.ayuda.menu.tipos') !!}</a>
                            <a href="" data-label="historial"
                               class="list-group-item">{!! trans('applicationResource.ayuda.menu.historial') !!}</a>
                            <a href="" data-label="resultados"
                               class="list-group-item">{!! trans('applicationResource.ayuda.menu.resultados') !!}</a>
                            <a href="" data-label="editor"
                               class="list-group-item">{!! trans('applicationResource.ayuda.menu.editor') !!}</a>
                        </div>
                    </div>


                    <div class="col-sm-9">
                        <div class="panel panel-danger" data-label="nombre">
                            <div class="panel-heading">
                                <strong>{!! trans('applicationResource.ayuda.busnombre.p0') !!}</strong>
                            </div>
                            <div class="panel-body">
                                <p>{!! trans('applicationResource.ayuda.busnombre.p1') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busnombre.p2') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busnombre.p3') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busnombre.p4') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busnombre.p5') !!}</p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="subestructura">
                            <div class="panel-heading">
                                <strong>{!! trans('applicationResource.ayuda.bussubestructura.p0') !!}</strong></div>
                            <div class="panel-body">
                                <p>{!! trans('applicationResource.ayuda.bussubestructura.p1') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.bussubestructura.p2') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.bussubestructura.p3') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.bussubestructura.p4') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.bussubestructura.p5') !!}</p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="iterativa">
                            <div class="panel-heading">
                                <strong>{!! trans('applicationResource.ayuda.busiterativa.p0') !!}</strong></div>
                            <div class="panel-body">
                                <p>{!! trans('applicationResource.ayuda.busiterativa.p1') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busiterativa.p2') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busiterativa.p3') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busiterativa.p4') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busiterativa.p5') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busiterativa.p6') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busiterativa.p7') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.busiterativa.p8') !!}</p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="tipos">
                            <div class="panel-heading">
                                <strong>{!! trans('applicationResource.ayuda.bustipcarb.p0') !!}</strong>
                            </div>
                            <div class="panel-body">
                                <p>{!! trans('applicationResource.ayuda.bustipcarb.p1') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.bustipcarb.p2') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.bustipcarb.p3') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.bustipcarb.p4') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.bustipcarb.p5') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.bustipcarb.p6') !!}</p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="historial">
                            <div class="panel-heading">
                                <strong>{!! trans('applicationResource.ayuda.historial.p0') !!}</strong>
                            </div>
                            <div class="panel-body">
                                <p>{!! trans('applicationResource.ayuda.historial.p1') !!}</p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="resultados">
                            <div class="panel-heading">
                                <strong>{!! trans('applicationResource.ayuda.resultados.p0') !!}</strong>
                            </div>
                            <div class="panel-body">
                                <p>{!! trans('applicationResource.ayuda.resultados.p1') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.resultados.p2') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.resultados.p3') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.resultados.p4') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.resultados.p5') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.resultados.p6') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.resultados.p7') !!}</p>
                            </div>
                        </div>
                        <div class="panel panel-danger" data-label="editor">
                            <div class="panel-heading">
                                <strong>{!! trans('applicationResource.ayuda.editor.p0') !!}</strong>
                            </div>
                            <div class="panel-body">
                                <p><strong>{!! trans('applicationResource.ayuda.editor.p1') !!}</strong></p>
                                <img class="img-responsive" src="{!! asset('images/helpImages/editorMenu.gif') !!}">
                                <p>
                                    <img class="img-responsive" src="{!! asset('/images/helpImages/smileControl.gif') !!}">{!! trans('applicationResource.ayuda.editor.p2') !!}
                                </p>
                                <p>{!! trans('applicationResource.ayuda.editor.p3') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p4') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p5') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p6') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p7') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p8') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p9') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p10') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p11') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p12') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p13') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p14') !!}</p>
                                <p><strong>{!! trans('applicationResource.ayuda.editor.p15') !!}</strong></p>
                                <img class="img-responsive" src="{!! asset('images/helpImages/editorShapes.gif') !!}">
                                <p>{!! trans('applicationResource.ayuda.editor.p16') !!}</p>
                                <p><strong>{!! trans('applicationResource.ayuda.editor.p17') !!}</strong></p>
                                <img class="img-responsive" src="{!! asset('images/helpImages/editorLinks.gif') !!}">
                                <p>{!! trans('applicationResource.ayuda.editor.p18') !!}</p>
                                <p><strong>{!! trans('applicationResource.ayuda.editor.p19') !!}</strong></p>
                                <img class="img-responsive" src="{!! asset('images/helpImages/editorAtoms.gif') !!}">
                                <p>{!! trans('applicationResource.ayuda.editor.p20') !!}</p>
                                <p>{!! trans('applicationResource.ayuda.editor.p21') !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
@endsection
