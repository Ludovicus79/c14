@extends('layouts.master')

@section('scripts')
    <script src="{{ asset('js/spin.js') }}"></script>
    <script src="{{ asset('js/loadingScreen.js') }}"></script>
    <script src="{{ asset('jsme/jsme.nocache.js') }}"></script>
    <script src="{{ asset('jsme/hideResult.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('a').not($('#resultadosnumdesp a, .dropdown-toggle')).click(showLoading);
        });
    </script>

    <script>

        //Numero de moleculas
        var jsmeApplets = new Array();
        var type = 1; //1.jme, 2.jmeNum, 3.Desp
        $(document).ready(init);

        /**
         * Funcion que carga las moleculas
         */
        function loadJmeFile() {
            switch (type) {
                case 1: //jme
                    @for ($i = 0; $i < sizeof($molecules); $i++)
                        jsmeApplets["{!! $i !!}"].readMolecule("{!! $molecules[$i]->jme !!}");
                    @endfor
                    break;
                case 2: //jmeNum
                    @for ($i = 0; $i < sizeof($molecules); $i++)
                        jsmeApplets["{!! $i !!}"].readMolecule("{!! $molecules[$i]->jmeNumeration !!}");
                    @endfor
                    break;
                case 3: //Desp
                    @for ($i = 0; $i < sizeof($molecules); $i++)
                        jsmeApplets["{!! $i !!}"].readMolecule("{!! $molecules[$i]->jmeDisplacement !!}");

                        @php
                            // echo "*DATOS<pre>";
                            // print_r($data['datos']);
                            // echo "</pre>*";
                        @endphp


                        /**si la busqueda se hizo por desplazamiento la variable $data['datos'] (en la que
                         * se encuentran todos los datos necesarios) existira*/
                        @if (isset($data['datos']))
                            index = "";

                            // Fix: Para corregir el problema de las busquedas combinadas por 1not2
                            @if (isset($data['datos'][$molecules[$i]->id]))
                                // /Fix: Para corregir el problema de las busquedas combinadas por 1not2

                                @for ($h = 0; $h < sizeof($data['datos'][$molecules[$i]->id]); $h++)

                                    @for ($x = 0; $x < sizeof($data['datos'][$molecules[$i]->id][$h]); $x++)

                                        diferencia = {{ $data['desplazamientos'][$molecules[$i]->id][$h] }} + 1;

                                        switch (diferencia) {
                                            case 1:
                                                diferencia = 5;
                                                break;
                                            case 2:
                                                diferencia = 4;
                                                break;
                                            case 3:
                                                diferencia = 3;
                                                break;
                                            case 4:
                                                diferencia = 2;
                                                break;
                                            case 5:
                                                diferencia = 1;
                                                break;
                                            case 6:
                                                diferencia = 6;
                                                break;
                                        }

                                        index += {{ $data['datos'][$molecules[$i]->id][$h][$x] }} + "," + diferencia + ",";

                                        saveAtomNumberProperties({{ $i }},
                                            {{ $data['numeracion'][$molecules[$i]->id][$h] }}, diferencia);
                                    @endfor
                                @endfor
                            @endif



                            guardarIndex(index, {{ $i }});
                            jsmeApplets["{!! $i !!}"].setAtomBackgroundColors(1, index);
                        @endif
                    @endfor
                    break;
            }
        }

        /**guarda en el formulario de spectrum datos de que atomo es el que se tendra que pintar**/
        function guardarIndex(index, pos) {
            spectrum = document.getElementById("formuOcultoSpec" + pos);

            oculto = document.createElement("input");
            oculto.setAttribute("type", 'text');
            //oculto.setAttribute("id","index");
            oculto.setAttribute("name", "atomos");
            oculto.setAttribute("value", index);
            oculto.hidden = true;

            spectrum.appendChild(oculto);
            addToProperties(index, pos);

        }
        /**guarda en el formulario de properties datos de que atomo es el que se tendra que pintar**/
        function addToProperties(index, pos) {
            properties = document.getElementById("formuOcultoProp" + pos);

            oculto = document.createElement("input");
            oculto.setAttribute("type", 'text');
            //oculto.setAttribute("id","index");
            oculto.setAttribute("name", "atomos");
            oculto.setAttribute("value", index);
            oculto.hidden = true;

            properties.appendChild(oculto);
        }

        /**guardara el numero del atomo y la tolerancia a pintar en la vista properties**/
        function saveAtomNumberProperties(pos, number, diferencia) {
            properties = document.getElementById("formuOcultoProp" + pos);

            numAto = document.createElement("input");
            numAto.setAttribute("type", 'text');
            //oculto.setAttribute("id","index");
            numAto.setAttribute("name", "numeracion[]");
            numAto.setAttribute("value", number);
            numAto.hidden = true;

            properties.appendChild(numAto);

            dif = document.createElement("input");
            dif.setAttribute("type", 'text');
            dif.setAttribute("name", "diferencia[]");
            dif.setAttribute("value", diferencia);
            dif.hidden = true;

            properties.appendChild(dif);
        }

        /**
         * Funcion que inicia tod lo necesario
         */
        function init() {
            /*$("#numeration").click(loadNumeration);
            $("#shift").click(loadDisplacement);
            $("#noNumeration").click(loadNoNumeration);*/

            //mantener el numero de compuestos
            var nMolecules = "{!! $count !!}";
            if (nMolecules != 0) {
                sessionStorage.setItem("numero", nMolecules);
            }
            if (nMolecules == 0) {
                sessionStorage.setItem("numero", 0);
            }


            //mantener los checkboxes apretados al cambiar de pagina
            checkboxValues = JSON.parse(localStorage.getItem('checkboxValues')) || {};
            $checkboxes = $("#resultadosnumdesp :radio");


            $checkboxes.on("change", function() {
                $checkboxes.each(function() {
                    checkboxValues[this.id] = this.checked;
                });
                localStorage.setItem("checkboxValues", JSON.stringify(checkboxValues));
            });
            $.each(checkboxValues, function(key, value) {
                $("#" + key).prop('checked', value);
            });
            numerar = document.getElementById('numeration2');
            numerar.addEventListener("change", cambiar, false);

            desplazar = document.getElementById('desplazamiento2');
            desplazar.addEventListener("change", cambiar, false);

            noNumerar = document.getElementById('nonumeration2');
            noNumerar.addEventListener("change", cambiar, false);
            //cambiar();
        }

        function cambiar() {
            if (numerar.checked) {
                loadNumeration();
            }
            if (desplazar.checked) {
                loadDisplacement();
            }
            if (noNumerar.checked) {
                loadNoNumeration();
            }
        }

        /**
         * Cambia al formato numerado
         */
        function loadNumeration() {
            type = 2;
            loadJmeFile();
            return false;
        }

        /**
         * Cambia al formato con desplazamiento
         */
        function loadDisplacement() {
            type = 3;
            loadJmeFile();
            return false;
        }

        /**
         * Cambia al formato sin numerar
         */
        function loadNoNumeration() {
            type = 1;
            loadJmeFile();
            return false;
        }

        /**
         * Inicializa el jsme
         */
        function jsmeOnLoad() {

            @for ($i = 0; $i < sizeof($molecules); $i++)

                var startingStructure = "{{ $molecules[$i]->jme }}";

                jsmeApplets["{!! $i !!}"] = new JSApplet.JSME("jsme_container" + "{{ $i }}", {
                    "options": "depict, number",
                    "jme": startingStructure,
                });
            @endfor
            cambiar();
        }

        function showNext() {
            var element = document.getElementById("mol{{ $i + 1 }}");
        }

        // Eliminado: uso de sessionStorage para "selected molecules"
        var selectedMols = [];
        
    </script>
@endsection

@section('mainContainer')
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-0 col-md-12">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.result.results') !!}: <span id="numMol">{{count($selectedMols)}}</span> {!! trans('applicationResource.result.compounds') !!}</b></h4>
                    </div>

                </div>

                <div class="row combinations" id="resultadosnumdesp">
                    <div class="col-xs-12 text-center">
                        <input type="radio" id="numeration2" name="resultados" /><label
                            for="numeration2">{!! trans('applicationResource.result.numeration') !!}</label>
                        <input type="radio" id="desplazamiento2" name="resultados" /><label
                            for="desplazamiento2">&delta;(ppm)</label>
                        <input type="radio" id="nonumeration2" name="resultados" /><label
                            for="nonumeration2">{!! trans('applicationResource.result.noNumeration') !!}</label>
                    </div>

                </div>

                @if (isset($data['desplazamientos']))
                    @include('layouts.toleranceTable')
                @endif
                

                <div class="row">
                    @for ($i = 0; $i < sizeof($molecules); $i++)
                        <div class="col-xs-12 col-sm-6 col-md-4 text-center" id="mol{{ $i }}">
                                <div class="jme jme2" id="jsme_container{{ $i }}"></div>

                                <div class="descripcion">
                                    <!--formulario en el que se van a guardar los datos ocultos para pasarselos al spectrum-->
                                    <form id="formuOcultoProp{{ $i }}" role="form" method="GET"
                                        action="{{ url('properties/' . $molecules[$i]->id) }}">
                                        <button class=" btn-danger" type="submit" name="submitBtn" value="submitBtn"
                                            style="padding: 2px; border-radius: 5px">
                                            <i class="fa fa-btn fa-user"></i>{!! trans('applicationResource.properties.properties') !!}
                                        </button>
                                    </form>

                                    <!--formulario en el que se van a guardar los datos ocultos para pasarselos al spectrum-->
                                    <form id="formuOcultoSpec{{ $i }}" role="form" method="GET"
                                        action="{{ url('spectrum/' . $molecules[$i]->id) }}">
                                        <button class=" btn-danger" type="submit" name="submitBtn" value="submitBtn"
                                            style="padding: 2px; border-radius: 5px">
                                            <i class="fa fa-btn fa-user"></i>{!! trans('applicationResource.molecule.spectrum') !!}
                                        </button>
                                    </form>

                                    @if (isset($molecules[$i]->doi) && !empty($molecules[$i]->doi))
                                        <a href="{{ $molecules[$i]->doi }}" class="btn btn-danger" target="_blank"
                                            style="padding: 1px; border-radius: 5px">DOI</a>
                                    @endif
                                    @if (Auth::user()->allowed && Auth::user())
                                        <span> {{ $molecules[$i]->reference }}</span>
                                    @endif
                                </div>


                                <div class="descripcion">
                                    <span> {{ $molecules[$i]->family }}</span>
                                    <span> {{ $molecules[$i]->subFamily }}</span>
                                    <span> {{ $molecules[$i]->subSubFamily }}</span>
                                    <span> {{ $molecules[$i]->solvent }} </span>
                                </div>
                        </div>
                </div>
                @endfor

            </div>

        </div>
        </div>
    </section>

    
@endsection
