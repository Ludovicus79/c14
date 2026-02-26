@extends('layouts.master')

@section('scripts')
    <script src="{!! asset('jsme/jsme.nocache.js') !!}" type="text/javascript"></script>

    <script>
        var jme = "{!! $molecule->jme !!}";
        var jmeNumeration = "{!! $molecule->jmeNumeration !!}";
        var jmeDisplacement = "{!! $molecule->jmeDisplacement !!}";
        var jsmeApplet;
        var selectedJme = jme;

        $(document).ready(init);

        /**
         * Funcion encargada de cargar la molecula
         */
        function loadJmeFile() {
            jsmeApplet.readMolecule(selectedJme);
            /**si la busqueda se hizo por desplazamiento*/
            @if(isset($atomos))
                jsmeApplet.setAtomBackgroundColors(1, "{{ $atomos }}");
                paintTable();
            @endif
        }

        /**
         * Funcion encargada de cargar el JSME
         */
        function jsmeOnLoad() {

            jsmeApplet = new JSApplet.JSME("jsme_container", "500px", "350px", {
                "options": "depict, number"
            });
            loadJmeFile();
        }

        /**
         * Funcion que inicia todo lo necesario
         */
        function init() {
            $("#numeration").click(loadNumeration);
            $("#shift").click(loadDisplacement);
            $("#noNumeration").click(loadNoNumeration);
        }

        /**
         * Cambia al formato numerado
         */
        function loadNumeration() {
            selectedJme = jmeNumeration;
            loadJmeFile();
            return false;
        }

        /**
         * Cambia al formato con desplazamiento
         */
        function loadDisplacement() {
            selectedJme = jmeDisplacement;
            loadJmeFile();
            return false;
        }

        /**
         * Cambia al formato sin numerar
         */
        function loadNoNumeration() {
            selectedJme = jme;
            loadJmeFile();
            return false;
        }

        /**
         * pinta las filas de la tabla que sean necesarias
         */
        function paintTable() {
            @if(isset($numeracion))
                @for($i=0; $i< sizeof($numeracion) ;$i++)

                    fila=document.getElementById("atomo{{ $numeracion[$i] }}");
                    fila.setAttribute("class","row diferencia{{ $diferencia[$i]-1 }}");

                @endfor
            @endif
        }

    </script>

@endsection

@section('mainContainer')
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.properties.properties') !!}</b></h4>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-11 col-md-offset-1 double-spaced">
                        <strong>{!! trans('applicationResource.molData.name') !!}</strong>: {!! $molecule->name !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-11 col-md-offset-1 double-spaced">
                        <strong>{!! trans('applicationResource.criteria.semiName') !!}</strong>: {!! $molecule->semiSystematicName !!}
                    </div>
                </div>
                @if(Auth::user() && Auth::user()->allowed)
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1 double-spaced">
                            <strong>Ref:</strong> {!! $molecule->reference !!}
                        </div>
                    </div>

                @endif

                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-2 col-md-offset-1 double-spaced">
                        <strong>{!! trans('applicationResource.molData.family') !!}
                            :</strong> {!! $molecule->family !!}</div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-2 double-spaced">
                        <strong>{!! trans('applicationResource.molData.group') !!}
                            :</strong> {!! $molecule->subFamily !!}</div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1 double-spaced">
                        <strong>{!! trans('applicationResource.molData.type') !!}
                            :</strong> {!! $molecule->subSubFamily !!}</div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-md-offset-1 double-spaced">
                        <strong>{!! trans('applicationResource.molData.solvent') !!}
                            :</strong> {!! $solvent !!}</div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1 double-spaced">
                        <strong>{!! trans('applicationResource.molData.formula') !!}
                            :</strong> {!! $molecularFormula !!}</div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1 double-spaced">
                        <strong>{!! trans('applicationResource.molData.weight') !!}
                            :</strong> {!! $molecule->molecularWeight !!}</div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-11 col-md-offset-1 double-spaced">
                        <strong>{!! trans('applicationResource.molData.bibliography') !!}
                            :</strong> {!! $bibliography->authors !!}
                        <i>{!! $bibliography->magazine !!}</i>
                        ({!! $bibliography->year !!})
                        <i>{!! $bibliography->volume !!}</i>,
                        {!! $bibliography->page !!}
                    </div>

                </div>
                <hr>

                <!--si la busqueda se hizo por desplazamiento pone la tabla de tolerancias-->
                @if(isset($atomos))
                    @include('layouts.toleranceTable')
                @endif

                <div class="row">
                    <div class="col-xs-12 col-md-4 col-md-offset-1 ">
                        <strong>{!! trans('applicationResource.molData.rmn') !!}</strong>
                    </div>
                    <div class="col-xs-12 col-md-4 col-md-offset-3">
                        <strong>{!! trans('applicationResource.submenu.estructura')!!}</strong>
                    </div>

                </div>
                <br>

                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1 col-md-3 col-md-offset-1 double-spaced">
                        <div class="row">
                            <div class="col-xs-4 col-md-3 text-left"><strong>Num</strong></div>
                            <div class="col-xs-4 col-md-3 text-left"><strong>Num2</strong></div>
                            <div class="col-xs-4 col-md-3 text-left">
                                <strong>{!! trans('applicationResource.properties.types') !!}</strong></div>
                            <div class="col-xs-4 col-md-3 text-right"><strong>&delta;(ppm)</strong></div>

                        </div>

                        @php
                        
                        if( !function_exists('array_key_first') ) {

     						function array_key_first(array $array) {

         						if( $array === [] ) { return NULL; }

         						foreach($array as $key => $_) { return $key; }
     						}
 						}
                        
                        
                            $config = config('numeracionespecial.families');

                            $method = 'general';
                            if (isset($config[$molecule->family]) && !empty($config[$molecule->family])) {
                                if (isset($config[$molecule->family]['groups'][$molecule->subFamily]) && !empty($config[$molecule->family]['groups'][$molecule->subFamily])) {
                                    if (isset($config[$molecule->family]['groups'][$molecule->subFamily]['types'][$molecule->subSubFamily]) && !empty($config[$molecule->family]['groups'][$molecule->subFamily]['types'][$molecule->subSubFamily])) {
                                        $method = $config[$molecule->family]['groups'][$molecule->subFamily]['types'][$molecule->subSubFamily];
                                    } else {
                                        if (isset($config[$molecule->family]['groups'][$molecule->subFamily]['global']) && !empty($config[$molecule->family]['groups'][$molecule->subFamily]['global'])) {
                                            $method = $config[$molecule->family]['groups'][$molecule->subFamily]['global'];
                                        } else {
                                            if (isset($config[$molecule->family]['global']) && !empty($config[$molecule->family]['global'])) {
                                                $method = $config[$molecule->family]['global'];
                                            }
                                        }
                                    }
                                } else {
                                    if (isset($config[$molecule->family]['global']) && !empty($config[$molecule->family]['global'])) {
                                        $method = $config[$molecule->family]['global'];
                                    }
                                }
                            }

                            $carbonsArray = $carbons->toArray();
                            $carbonsOrdered = [];
                            if ($method != "general") {
                                // "1,3,4,4a,4b,5,6,7,8,8a,10,10a"
                                // Por cada carbono del metodo seleccionado
                                // Miro si ese indice existe en carbonos
                                // Si existe lo introduzco en posicion secuencial en nuevo array
                                // Sino existe uno cualquiera, no vale, nos volvemos al general
                                // Si al acabar quedan carbonos sueltos, los pegamos a continuacion
                                foreach (explode(",", $method) as $index) {
                                    $filtered = array_filter($carbonsArray, function($elem) use($index) {
                                        return $elem['numeration'] == $index;
                                    });

                                    if (count($filtered) == 1) {
                                        $selectedKey = array_key_first($filtered);
                                        $carbonsOrdered[$selectedKey] = $carbonsArray[$selectedKey];
                                        unset($carbonsArray[$selectedKey]);
                                    }
                                }

                                if (count($carbonsArray)) {
                                    $carbonsOrdered = array_merge($carbonsOrdered, $carbonsArray);
                                }
                            } else {
                                $carbonsOrdered = $carbonsArray;
                            }
                        @endphp

                        @foreach($carbonsOrdered as $carbon)
                            <div class="row" id="atomo{{ $carbon['num2'] }}">
                                <div class="col-xs-4 col-md-3 text-left">{!! $carbon['numeration'] !!}</div>
                                <div class="col-xs-4 col-md-3 text-left">{!! $carbon['num2'] !!}</div>
                                <div class="col-xs-4 col-md-3 text-left">{!! $carbon['carbonType'] !!}</div>
                                <div class="col-xs-4 col-md-3 text-right">
                                    @if($carbon['shift'] == -9999)
                                        -
                                    @else
                                        {!! number_format($carbon['shift'], 1) !!}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-xs-12 col-sm-offset-1 col-sm-11 col-md-6 col-md-offset-2">
                        <div class="text-center" id="opcionesnumdesp">
                            <span><a style="outline: none;" href="#"
                               id="numeration">{!! trans('applicationResource.result.numeration') !!}</a></span>
                            <span><a style="outline: none;" href="#" id="shift">&delta;(ppm)</a></span>
                            <span><a style="outline: none;" href="#"
                                     id="noNumeration">{!! trans('applicationResource.result.noNumeration') !!}</a></span>
                        </div>
                        <div class="jmeProp" id="jsme_container">
                        </div>
                    </div>
                </div>

                <hr class="invisible">

                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-11 col-md-offset-1 double-spaced">
                        <strong>{!! trans('applicationResource.molData.comments') !!}: </strong> {!! $molecule->publicCom !!}
                    </div>
                </div>


                <hr class="invisible">
                <div class="row text-center">
                    <button id="backBtn" class="btn btn-md btn-danger" onclick="window.history.back()">
                        {!! trans('applicationResource.button.back') !!}
                    </button>
                    <hr class="invisible">
                    @if(Auth::user() && Auth::user()->allowed)
                        <div class="col-xs-12 text-center">
                            <a href="{!! url('admin/molEdit/'.$molecule->id)!!}"
                                class="btn btn-danger">{!! trans('applicationResource.button.edit') !!}
                            </a>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </section>
@endsection
