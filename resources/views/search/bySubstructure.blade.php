@extends('layouts.master')

@section('headers')
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
@endsection

@section('scripts')
    <script src="{{ asset('js/spin.js') }}"></script>
    <script src="{{ asset('js/loadingScreen.js') }}"></script>
    <script src="{{ asset('js/loadFamilies.js') }}"></script>
    <script src="{{ asset('jsme/jsme.nocache.js') }}"></script>
    <script type="text/javascript">
        var jsme;
        var stereo = true;
        function switchStereo() {
            stereo ? jsme.options('nostereo') : jsme.options('stereo');
            stereo ? text = 'OFF' : text = 'ON';
            $('#stereoButton').html(text);
            stereo = !stereo;
        }

        function submitForm() {
            $('#smileCode').val(jsme.smiles());
            $('#jmeCode').val(jsme.jmeFile());
        }

    </script>
    <script type="text/javascript">
        // Al entrar en la búsqueda por subestructura, apagamos el modo "solo seleccionadas"
        document.addEventListener('DOMContentLoaded', function() {
            try {
                localStorage.setItem('FilterOnlySelected', 'false');
            } catch (e) {}
        });
    </script>
    <script type="text/javascript">
        function jsmeOnLoad() {
            // Forzar tamaño explícito para evitar cálculos negativos de ancho/alto en SVG
            // cuando el contenedor aún no tiene dimensiones visibles.
            try {
                var cont = document.getElementById('jmeVentana');
                if (cont && (cont.clientWidth <= 0 || cont.clientHeight <= 0)) {
                    cont.style.width = '500px';
                    cont.style.height = '350px';
                }
            } catch (e) {}

            jsme = new JSApplet.JSME("jmeVentana", "500px", "350px", {
                 "options" : "newlook,canonize,number,marker"
            });
        }
        ;
    </script>
@endsection
@section('mainContainer')
    <section class="container main-container">
        <div class="row">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.form.busquedas.subestructura') !!}</b></h4><br>
                    </div>
                </div>

                @if ($errors->has('emptyError'))
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="help-block">
                                <strong style="color: red;">{!! trans('applicationResource.errors.requeridos') !!}</strong>
                            </h4>
                        </div>
                    </div>
                @endif

                            <!-- Ventana del script para "pintar" las estructuras, se puede modificar el tamaño -->
                    <div class="col-xs-12 col-sm-6 col-md-5 text-center">
                        <div class="jmeEditor" name="JME" id="jmeVentana">
                        </div>
                    </div>

                <div class="col-xs-12 col-sm-6 col-md-6 text-center">
                    <form class="form-horizontal" role="form" method="POST"
                          action="{{ url('search/bySubstructure') }}"
                          onsubmit="showLoading()">
                        @csrf
                                <!-- Campo hidden para guardar el código SMILE generado por la estructura-->
                        <input type="hidden" name="smileCode" id="smileCode">
                        <!--Campo hidden para guardar el código JME generado por la estructura -->
                        <input type="hidden" name="jmeCode" id="jmeCode">

                        <div class="form-group row text-center">
                            <label>{!! trans('applicationResource.form.estereoquimica') !!}
                            </label>
                            <button class="btn btn-md btn-danger" onclick="switchStereo()" id="stereoButton"
                                    type="button">
                                ON
                            </button>
                        </div>

                        <hr class="invisible">

                        <div class="row">
                        	<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-12 ">

                                <div class="form-group row">
                                    <!--FAMILIA, TIPO, GRUPO-->

                                    @include('search.familiesPartial')

                                </div>

                        	</div>
                        </div>

                        <hr class="invisible">
                                <!-- ENVIAR -->
                        <div class="form-group">
                            <div class="col-xs-12 col-md-offset-1">
                                <button class="btn btn-md btn-danger" onclick="submitForm()" type="submit" name="submitBtn"
                                        value="submitBtn">{!! trans('applicationResource.form.buscar') !!}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </section>
@endsection
