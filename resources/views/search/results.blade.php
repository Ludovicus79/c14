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
        var jsmeApplets = new Array();
        var type = 1;
        $(document).ready(init);

        function loadJmeFile() {
            switch (type) {
                case 1:
                    @for ($i = 0; $i < sizeof($molecules); $i++)
                        jsmeApplets["{!! $i !!}"].readMolecule("{!! $molecules[$i]->jme !!}");
                    @endfor
                    break;
                case 2:
                    @for ($i = 0; $i < sizeof($molecules); $i++)
                        jsmeApplets["{!! $i !!}"].readMolecule("{!! $molecules[$i]->jmeNumeration !!}");
                    @endfor
                    break;
                case 3:
                    @for ($i = 0; $i < sizeof($molecules); $i++)
                        jsmeApplets["{!! $i !!}"].readMolecule("{!! $molecules[$i]->jmeDisplacement !!}");
                        @if (isset($data['datos']))
                            index = "";
                            @if (isset($data['datos'][$molecules[$i]->id]))
                                @for ($h = 0; $h < sizeof($data['datos'][$molecules[$i]->id]); $h++)
                                    @for ($x = 0; $x < sizeof($data['datos'][$molecules[$i]->id][$h]); $x++)
                                        diferencia = {{ $data['desplazamientos'][$molecules[$i]->id][$h] }} + 1;
                                        switch (diferencia) {
                                            case 1: diferencia = 5; break;
                                            case 2: diferencia = 4; break;
                                            case 3: diferencia = 3; break;
                                            case 4: diferencia = 2; break;
                                            case 5: diferencia = 1; break;
                                            case 6: diferencia = 6; break;
                                        }
                                        index += {{ $data['datos'][$molecules[$i]->id][$h][$x] }} + "," + diferencia + ",";
                                        saveAtomNumberProperties({{ $i }}, {{ $data['numeracion'][$molecules[$i]->id][$h] }}, diferencia);
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

        function guardarIndex(index, pos) {
            spectrum = document.getElementById("formuOcultoSpec" + pos);
            oculto = document.createElement("input");
            oculto.setAttribute("type", 'text');
            oculto.setAttribute("name", "atomos");
            oculto.setAttribute("value", index);
            oculto.hidden = true;
            spectrum.appendChild(oculto);
            addToProperties(index, pos);
        }

        function addToProperties(index, pos) {
            properties = document.getElementById("formuOcultoProp" + pos);
            oculto = document.createElement("input");
            oculto.setAttribute("type", 'text');
            oculto.setAttribute("name", "atomos");
            oculto.setAttribute("value", index);
            oculto.hidden = true;
            properties.appendChild(oculto);
        }

        function saveAtomNumberProperties(pos, number, diferencia) {
            properties = document.getElementById("formuOcultoProp" + pos);
            numAto = document.createElement("input");
            numAto.setAttribute("type", 'text');
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

        function init() {
            var nMolecules = "{!! $count !!}";
            if (nMolecules != 0) {
                sessionStorage.setItem("numero", nMolecules);
            }
            if (nMolecules == 0) {
                sessionStorage.setItem("numero", 0);
            }
            var numeroDeMol = sessionStorage.getItem("numero");
            document.getElementById("numMol").innerHTML = numeroDeMol;

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
            if (numerar) numerar.addEventListener("change", cambiar, false);
            desplazar = document.getElementById('desplazamiento2');
            if (desplazar) desplazar.addEventListener("change", cambiar, false);
            noNumerar = document.getElementById('nonumeration2');
            if (noNumerar) noNumerar.addEventListener("change", cambiar, false);
        }

        function cambiar() {
            if (numerar && numerar.checked) loadNumeration();
            if (desplazar && desplazar.checked) loadDisplacement();
            if (noNumerar && noNumerar.checked) loadNoNumeration();
        }

        function loadNumeration() { type = 2; loadJmeFile(); return false; }
        function loadDisplacement() { type = 3; loadJmeFile(); return false; }
        function loadNoNumeration() { type = 1; loadJmeFile(); return false; }

        function jsmeOnLoad() {
            @for ($i = 0; $i < sizeof($molecules); $i++)
                var startingStructure = "{{ $molecules[$i]->jme }}";
                jsmeApplets["{!! $i !!}"] = new JSApplet.JSME("jsme_container" + "{{ $i }}", {
                    "options": "depict, number",
                    "fontSize": "16px",
                    "jme": startingStructure,
                });
            @endfor
            cambiar();
        }

        var selectedCheckboxes = [];
        var filterOnlySelected = false;

        function loadSelectionsFromStorage() {
            var sesion = localStorage.getItem('SelectedData');
            if (sesion && sesion.length > 0) {
                selectedCheckboxes = sesion.split(',').filter(function(id) { return id.trim() !== ''; });
            } else {
                selectedCheckboxes = [];
            }
            var filterFlag = localStorage.getItem('FilterOnlySelected');
            var selectedModeParam = getQueryParam('selectedMode');
            if (selectedModeParam === '1') {
                filterOnlySelected = true;
                localStorage.setItem('FilterOnlySelected', 'true');
            } else {
                filterOnlySelected = filterFlag === 'true';
                if (!selectedCheckboxes || selectedCheckboxes.length === 0) {
                    filterOnlySelected = false;
                    localStorage.setItem('FilterOnlySelected', 'false');
                }
            }
        }

        function saveSelectionsToStorage() {
            localStorage.setItem('SelectedData', selectedCheckboxes.join(','));
            localStorage.setItem('FilterOnlySelected', filterOnlySelected ? 'true' : 'false');
        }

        function addSelect(event) {
            var checkbox = event.target;
            var checkboxId = checkbox.id;
            if (checkbox.checked && !selectedCheckboxes.includes(checkboxId)) {
                selectedCheckboxes.push(checkboxId);
            } else if (!checkbox.checked && selectedCheckboxes.includes(checkboxId)) {
                selectedCheckboxes = selectedCheckboxes.filter(function(id){ return id !== checkboxId; });
            }
            saveSelectionsToStorage();
            if (filterOnlySelected) applySelectedFilter();
        }

        function markSelectedCheckboxes() {
            selectedCheckboxes.forEach(function(id){
                var cb = document.getElementById(id);
                if (cb) cb.checked = true;
            });
        }

        function toggleSelectedFilter() {
            filterOnlySelected = !filterOnlySelected;
            saveSelectionsToStorage();
            var selectedModeParam = getQueryParam('selectedMode');
            if (filterOnlySelected && selectedModeParam !== '1') {
                redirectWithParams({ selectedMode: '1', selectedMols: selectedCheckboxes.join(',') });
                return;
            }
            if (!filterOnlySelected && selectedModeParam === '1') {
                redirectWithoutParams(['selectedMode','selectedMols']);
                return;
            }
            applySelectedFilter();
            updateSelectedButtonLabel();
        }

        function updateSelectedButtonLabel() {
            var btn = document.getElementById('selectedToggle');
            if (!btn) return;
            btn.textContent = filterOnlySelected ? 'Show all' : '{!! trans('applicationResource.form.compare') !!}';
        }

        function applySelectedFilter() {
            var cards = document.querySelectorAll('[data-molid]');
            var visibleCount = 0;
            cards.forEach(function(card){
                var molId = card.getAttribute('data-molid');
                var shouldShow = !filterOnlySelected || selectedCheckboxes.includes(molId);
                card.style.display = shouldShow ? '' : 'none';
                if (shouldShow) visibleCount++;
            });
            var numMolSpan = document.getElementById('numMol');
            if (numMolSpan) {
                numMolSpan.innerHTML = filterOnlySelected ? visibleCount : sessionStorage.getItem('numero');
            }
            var pag = document.getElementById('paginationRow');
            if (pag) pag.style.display = filterOnlySelected ? 'none' : '';
        }

        function getQueryParam(name) {
            return new URLSearchParams(window.location.search).get(name);
        }

        function redirectWithParams(params) {
            var url = new URL(window.location.href);
            Object.keys(params).forEach(function(k){
                if (params[k] !== undefined && params[k] !== null) {
                    url.searchParams.set(k, params[k]);
                }
            });
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        function redirectWithoutParams(names) {
            var url = new URL(window.location.href);
            names.forEach(function(n){ url.searchParams.delete(n); });
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function(){
            loadSelectionsFromStorage();
            markSelectedCheckboxes();
            updateSelectedButtonLabel();
            applySelectedFilter();
        });
    </script>
@endsection

@section('mainContainer')
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-0 col-md-12">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.result.results') !!}: <span id="numMol"></span> {!! trans('applicationResource.result.compounds') !!}</b></h4>
                    </div>
                </div>

                <div class="row combinations" id="resultadosnumdesp">
                    <div class="col-xs-12 text-center">
                        <input type="radio" id="numeration2" name="resultados" /><label for="numeration2">{!! trans('applicationResource.result.numeration') !!}</label>
                        <input type="radio" id="desplazamiento2" name="resultados" /><label for="desplazamiento2">&delta;(ppm)</label>
                        <input type="radio" id="nonumeration2" name="resultados" /><label for="nonumeration2">{!! trans('applicationResource.result.noNumeration') !!}</label>
                    </div>
                </div>

                @if (isset($data['desplazamientos']))
                    @include('layouts.toleranceTable')
                @endif

                <br>

                <div class="row mt-3">
                    <div class="col-xs-12 text-center">
                        <button id="selectedToggle" class="btn btn-danger" type="button" onclick="toggleSelectedFilter()">
                            <i class="fa fa-btn fa-user"></i>{!! trans('applicationResource.form.compare') !!}
                        </button>
                    </div>
                </div>

                {{-- RESULTADOS CON PAGINACIÓN --}}
                <div class="row">
                    @foreach ($molecules as $i => $molecule)
                        <div class="col-xs-12 col-sm-6 col-md-4 text-center" id="mol{{ $i }}" data-molid="{{ $molecule->id }}" style="margin-bottom: 30px;">
                            
                            {{-- 1. VISUALIZADOR JSME (ARRIBA) --}}
                            <div style="position: relative; width: 100%; height: 280px; margin: 0 auto 15px auto; overflow: hidden;">
                                <div class="jme jme2" id="jsme_container{{ $i }}" style="width: 100%; height: 100%;"></div>
                            </div>

                            {{-- 2. INFORMACIÓN DE CLASIFICACIÓN --}}
                            <div style="margin-bottom: 10px; font-size: 14px; line-height: 1.4;">
                                <span>{{ $molecule->family }}</span>
                                <span>{{ $molecule->subFamily }}</span>
                                <span>{{ $molecule->subSubFamily }}</span>
                                <span style="color: #337ab7; font-weight: bold;">{{ $molecule->carbonType ?? 'C' }}</span>
                            </div>

                            {{-- 3. BOTONES --}}
                            <div style="margin-bottom: 15px;">
                                <a href="{{ url('properties/' . $molecule->id) }}" class="btn btn-danger btn-sm" style="background-color: #c9302c; border-color: #ac2925; margin: 0 2px; border-radius: 4px;">
                                    {!! trans('applicationResource.properties.properties') !!}
                                </a>
                                <a href="{{ url('spectrum/' . $molecule->id) }}" class="btn btn-danger btn-sm" style="background-color: #c9302c; border-color: #ac2925; margin: 0 2px; border-radius: 4px;">
                                    {!! trans('applicationResource.molecule.spectrum') !!}
                                </a>
                                @if (isset($molecule->doi) && !empty($molecule->doi))
                                    <a href="{{ $molecule->doi }}" class="btn btn-danger btn-sm" target="_blank" style="background-color: #c9302c; border-color: #ac2925; margin: 0 2px; border-radius: 4px;">
                                        DOI
                                    </a>
                                @else
                                    <span class="btn btn-danger btn-sm disabled" style="background-color: #c9302c; border-color: #ac2925; opacity: 0.6; margin: 0 2px; border-radius: 4px; cursor: not-allowed;">
                                        DOI
                                    </span>
                                @endif
                            </div>

                            {{-- Checkbox de selección --}}
                            <div style="margin-bottom: 10px;">
                                <input type="checkbox" id="{{ $molecule->id }}" onclick="addSelect(event)" style="transform: scale(1.2);">
                            </div>

                            {{-- REFERENCIA - SOLO PARA USUARIOS AUTENTICADOS CON PERMISOS --}}
                            @if (Auth::check() && Auth::user()->allowed)
                                <div style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                    {{ $molecule->reference }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- PAGINACIÓN --}}
                @if ($molecules->hasPages())
                <div class="row" id="paginationRow">
                    <div class="col-xs-12 text-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination" style="display: inline-flex; list-style: none; padding: 0; margin: 20px 0;">
                                
                                @if ($molecules->onFirstPage())
                                    <li style="margin: 0 2px;">
                                        <span style="display: block; padding: 8px 12px; color: #999; background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px;">&laquo;</span>
                                    </li>
                                @else
                                    <li style="margin: 0 2px;">
                                        <a href="{{ $molecules->previousPageUrl() }}" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;">&laquo;</a>
                                    </li>
                                @endif

                                @if ($molecules->currentPage() > 4)
                                    <li style="margin: 0 2px;">
                                        <a href="{{ $molecules->url(1) }}" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;">1</a>
                                    </li>
                                    @if ($molecules->currentPage() > 5)
                                        <li style="margin: 0 2px;">
                                            <span style="display: block; padding: 8px 12px; color: #999; background: #fff; border: 1px solid #ddd; border-radius: 4px;">...</span>
                                        </li>
                                    @endif
                                @endif

                                @php
                                    $start = max($molecules->currentPage() - 3, 1);
                                    $end = min($molecules->currentPage() + 3, $molecules->lastPage());
                                @endphp

                                @for ($page = $start; $page <= $end; $page++)
                                    @if ($page == $molecules->currentPage())
                                        <li style="margin: 0 2px;">
                                            <span style="display: block; padding: 8px 12px; color: #fff; background: #337ab7; border: 1px solid #337ab7; border-radius: 4px; font-weight: bold;">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li style="margin: 0 2px;">
                                            <a href="{{ $molecules->url($page) }}" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor

                                @if ($molecules->currentPage() < $molecules->lastPage() - 3)
                                    @if ($molecules->currentPage() < $molecules->lastPage() - 4)
                                        <li style="margin: 0 2px;">
                                            <span style="display: block; padding: 8px 12px; color: #999; background: #fff; border: 1px solid #ddd; border-radius: 4px;">...</span>
                                        </li>
                                    @endif
                                    <li style="margin: 0 2px;">
                                        <a href="{{ $molecules->url($molecules->lastPage() - 1) }}" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;">{{ $molecules->lastPage() - 1 }}</a>
                                    </li>
                                    <li style="margin: 0 2px;">
                                        <a href="{{ $molecules->url($molecules->lastPage()) }}" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;">{{ $molecules->lastPage() }}</a>
                                    </li>
                                @endif

                                @if ($molecules->hasMorePages())
                                    <li style="margin: 0 2px;">
                                        <a href="{{ $molecules->nextPageUrl() }}" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;">&raquo;</a>
                                    </li>
                                @else
                                    <li style="margin: 0 2px;">
                                        <span style="display: block; padding: 8px 12px; color: #999; background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px;">&raquo;</span>
                                    </li>
                                @endif

                            </ul>
                        </nav>
                        
                        <p style="color: #666; font-size: 14px; margin-top: 10px;">
                            Mostrando {{ $molecules->firstItem() }} - {{ $molecules->lastItem() }} de {{ $molecules->total() }} resultados
                        </p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>
@endsection