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
    <script src="{{ asset('js/bootstrap-tabcollapse.js') }}"></script>
    <script src="{{ asset('js/nouislider.min.js') }}"></script>
    <script src="{{ asset('js/searchByCarbonType.js') }}"></script>
    <script>
        $(document).ready(function () {

            // DEPENDENCY: https://github.com/flatlogic/bootstrap-tabcollapse
            $('.content-tabs').tabCollapse();

            // initialize tab function
            $('.nav-tabs a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

        });
    </script>
@endsection

@section('estilos')
    <link rel="stylesheet" href="{{ asset('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}">

    
@endsection
@section('mainContainer')

    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.form.busquedas.tiposCarbono') !!}</b></h4>
                    </div>
                </div>
                <hr class="invisible"></hr>

                @if ($errors->has('range'))
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4 class="help-block">
                                <strong style="color: red;">{!! trans('applicationResource.errors.requeridos') !!}</strong>
                            </h4>
                        </div>
                    </div>
                @endif
                        <!--MENÚ CONFIGURACIÓN-->
                    <?php
                    $skelOptions = array('Cs' => 'C*', 'CHs' => 'CH*', 'CH2s' => 'CH<sub>2</sub>*', 'CH3s' => 'CH<sub>3</sub>*', 'COs' => 'C-O*', 'CHOs' => 'CH-O*', 'CH2Os' => 'CH<sub>2</sub>-O*', 'CH3Os' => 'CH<sub>3</sub>-O*', 'CNs' => 'C-N*', 'CHNs' => 'CH-N*', 'CH2Ns' => 'CH<sub>2</sub>-N*', 'CH3Ns' => 'CH<sub>3</sub>-N*');
                    $options = array('C' => 'C', 'CH' => 'CH', 'CH2' => 'CH<sub>2</sub>', 'CH3' => 'CH<sub>3</sub>', 'CO' => 'C-O', 'CHO' => 'CH-O', 'CH2O' => 'CH<sub>2</sub>-O', 'CH3O' => 'CH<sub>3</sub>-O', 'CN' => 'C-N', 'CHN' => 'CH-N', 'CH2N' => 'CH<sub>2</sub>-N', 'CH3N' => 'CH<sub>3</sub>-N');
                    $sufixes = array('', '-O', '-N');
                    $heteroathoms = array('O' => 'O', 'N' => 'N', 'H' => 'H', 'F' => 'F', 'Cl' => 'Cl', 'Br' => 'Br', 'I' => 'I', 'P' => 'P', 'S' => 'S');
                    $types = array('CTali' => 'CT ali', 'CTaro' => 'CT aro', 'CTole' => 'CT ole', 'Csp2' => 'Csp<sup>2</sup>');
                    $ali = array('Cali' => 'C ali', 'CHali' => 'CH ali', 'CH2ali' => 'CH<sub>2</sub> ali', 'COali' => 'C-O ali', 'CHOali' => 'CH-O ali', 'CNali' => 'C-N ali', 'CHNali' => 'CH-N ali');
                    $aro = array('Caro' => 'C aro', 'CHaro' => 'CH aro', 'COaro' => 'C-O aro', 'CHOaro' => 'CH-O aro', 'CNaro' => 'C-N aro', 'CHNaro' => 'CH-N aro');
                    $ole = array('Cole' => 'C ole', 'CHole' => 'CH ole', 'CH2ole' => 'CH<sub>2</sub> ole');
                    $others = array('CCarbonil' => 'C=O');
                    $menus = array('esqueleto' => $skelOptions, 'carbono' => $options, 'heteroatomos' => $heteroathoms, 'tipos' => $types, 'alifaticos' => $ali, 'aromaticos' => $aro, 'olefinicos' => $ole, 'otros' => $others);
                    $index = 1;
                    ?>
                    <div id="tab-container" data-easytabs="true" class="row">
                        <ul class="nav nav-tabs content-tabs" role="tablist">
                            @foreach($menus as $title=>$options)
                                <li><a class="text-capitalize" data-toggle="tab" href="#tabs1-{!! $title !!}"><strong>{!! trans('applicationResource.type.'.$title) !!}</strong></a></li>
                            @endforeach
                        </ul>
                        <div id="sliderMenu" class="tab-content">
                            @foreach($menus as $title=>$options)
                                <?php $index++ ?>
                                <div id="tabs1-{!! $title !!}" class="tab-pane fade">
                                    <div class="row panel-body" id="menu{!! $index !!}">
                                        @foreach($options as $option=>$label)
                                            <div class="col-xs-2">
                                                <input type="checkbox" value="{!! $option !!}"><label>&nbsp;&nbsp;{!! $label !!}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <form id="queryForm" action="{!! url('search/byCarbonType') !!}" method="POST" onsubmit="showLoading()">
                            @csrf
                        </form>
                    </div>
                <div class="row" class="col-xs-10 col-xs-offset-1">
                        <div id="containerTarget"></div>
                </div>
                <form id="sliderForm" class="form-group row" method="POST" action="{!! url("search/byCarbonType") !!}">
                    @csrf
                </form>

                <hr class="invisible">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button id="btnSearch" class="btn btn-danger">{!! trans('applicationResource.form.buscar') !!}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection