@extends('layouts.master')

@section('headers')
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
@endsection

@section('estilos')
    <link rel="stylesheet" href="{{ asset('css/footable.core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footable.metro.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/spin.js') }}"></script>
    <script src="{{ asset('js/loadingScreen.js') }}"></script>
    <script src="{{ asset('jsme/jsme.nocache.js') }}"></script>
    <script src="{{ asset('js/footable.js') }}"></script>
    <script src="{{ asset('js/footable.sort.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.footable').footable();
        });
    </script>

    <script>
        var jsmeApplets = new Array();
        var jmeDivs = new Array();
        var jmeCodes = new Array();

        $(document).ready(function () {
            $("#checkAll").change(function () {
                if ($(this).is(':checked')) {
                    $("input[type=checkbox]").prop('checked', true); //todos los check
                } else {
                    $("input[type=checkbox]").prop('checked', false);//todos los check
                }
            });
        });

        function replaceDivs() {
            jmeDivs = $('.jmeDiv');
            for (var i = 0; i < jmeDivs.length; i++) {
                $(jmeDivs[i]).attr('id', 'jsme_container' + i);
                jmeCodes[i] = $(jmeDivs[i]).attr('jme');
            }
        }
        /**
         * Inicializa el jsme
         */
        function jsmeOnLoad() {
            replaceDivs();
            for (var i = 0; i < jmeDivs.length; i++) {
                jsmeApplets.push(new JSApplet.JSME("jsme_container" + i, "150px", "150px", {
                    "options": "depict",
                    "jme": jmeCodes[i],
                }));
            }
        }
    </script>
@endsection

@section('mainContainer')
    <section class="container main-container">
        <!-- Wrapper -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-offset-1 col-md-10">
                <form id="formhist" method="post" action="" onsubmit="showLoading()">
                    @csrf
                    <!-- Título -->
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4><b>{!! trans('applicationResource.historial.historial') !!}</b></h4>
                        </div>
                    </div>

                    <!-- Error en la vista -->
                    @if ($errors->has('check'))
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4 class="help-block">
                                    <strong style="color: red;">{!! $errors->first('check') !!}</strong>
                                </h4>
                            </div>
                        </div>
                        @endif
                                <!-- Tabla con el historial de las búsquedas -->
                        <div class="row">
                            <div class="col-xs-12">
                                <table class="footable table" data-sort="false" data-page-size="10">
                                    <thead>
                                    <tr>
                                        <th data-sort-ignore="true"><input type="checkbox" property="check" name="checkAll"
                                                                           id="checkAll"/></th>
                                        <th data-sort-ignore="true">{!! trans('applicationResource.historial.numbusqueda') !!}</th>
                                        <th data-sort-ignore="true">{!! trans('applicationResource.historial.numcompuestos') !!}</th>


                                        <th data-sort-ignore="true" data-hide="phone">{!! trans('applicationResource.historial.critbusqueda') !!}</th>
                                        <th data-sort-ignore="true" data-hide="phone">{!! trans('applicationResource.historial.ver') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if ($history)
                                        @for($i = 0; $i < sizeof($history); $i++)
                                            <tr>
                                                <td><input type="checkbox" property="check" name="check[]" value="{!! $i !!}"/>
                                                </td>
                                                <td>{!! $i+1 !!}</td>
                                                <td>{!! $history[$i]['count']!!}</td>
                                                <td style="text-align: justify">
                                                    {!! \App\Http\Controllers\HistoryController::combineCriteria($history[$i]['criteria']) !!}
                                                </td>
                                                <td><a onclick="showLoading()"
                                                       href="{!! route('mol.results', $i+1) !!}">{!! trans('applicationResource.historial.ver') !!}</a>
                                                       <br>
                                                       @if (!empty($history[$i]['selected']))
                                                       <a onclick="showLoading()" href="{!! route('mol.Compare', $i+1) !!}">{!! trans('applicationResource.historial.busquedaRefinada') !!}</a>
                                                       @endif
                                                </td>
                                               
                                            </tr>
                                            
                                        @endfor
                                    @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div class="pagination center-block"></div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- Controles de las búsquedas cruzadas -->
                        <div class="row combinations">
                            <div class="col-xs-12 text-center">
                                <label>
                                    <input type="radio" name="comb" value="and">
                                    And
                                </label>
                                <label>
                                    <input type="radio" name="comb" value="or">
                                    Or
                                </label>
                                <label>
                                    <input type="radio" name="comb" value="1not2">
                                    1 not 2
                                </label>
                                <label>
                                    <input type="radio" name="comb" value="2not1">
                                    2 not 1
                                </label>
                            </div>
                        </div>
                        <!-- Botones -->
                        <hr class="invisible">
                        <div class="row text-center">
                            <div class="col-xs-12">
                                <button type="submit" name="comBtn" value="comBtn"
                                        class="btn btn-md btn-danger">{!! trans('applicationResource.historial.combinar') !!}
                                </button>
                                <button type="submit" name="removeBtn" value="removeBtn" class="btn btn-md btn-danger ">
                                    {!! trans('applicationResource.historial.eliminar') !!}
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </section>

@endsection