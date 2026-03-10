<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/spin.js')); ?>"></script>
    <script src="<?php echo e(asset('js/loadingScreen.js')); ?>"></script>
    <script src="<?php echo e(asset('jsme/jsme.nocache.js')); ?>"></script>
    <script src="<?php echo e(asset('jsme/hideResult.js')); ?>"></script>
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
                    <?php for($i = 0; $i < sizeof($molecules); $i++): ?>
                        jsmeApplets["<?php echo $i; ?>"].readMolecule("<?php echo $molecules[$i]->jme; ?>");
                    <?php endfor; ?>
                    break;
                case 2:
                    <?php for($i = 0; $i < sizeof($molecules); $i++): ?>
                        jsmeApplets["<?php echo $i; ?>"].readMolecule("<?php echo $molecules[$i]->jmeNumeration; ?>");
                    <?php endfor; ?>
                    break;
                case 3:
                    <?php for($i = 0; $i < sizeof($molecules); $i++): ?>
                        jsmeApplets["<?php echo $i; ?>"].readMolecule("<?php echo $molecules[$i]->jmeDisplacement; ?>");
                        <?php if(isset($data['datos'])): ?>
                            index = "";
                            <?php if(isset($data['datos'][$molecules[$i]->id])): ?>
                                <?php for($h = 0; $h < sizeof($data['datos'][$molecules[$i]->id]); $h++): ?>
                                    <?php for($x = 0; $x < sizeof($data['datos'][$molecules[$i]->id][$h]); $x++): ?>
                                        diferencia = <?php echo e($data['desplazamientos'][$molecules[$i]->id][$h]); ?> + 1;
                                        switch (diferencia) {
                                            case 1: diferencia = 5; break;
                                            case 2: diferencia = 4; break;
                                            case 3: diferencia = 3; break;
                                            case 4: diferencia = 2; break;
                                            case 5: diferencia = 1; break;
                                            case 6: diferencia = 6; break;
                                        }
                                        index += <?php echo e($data['datos'][$molecules[$i]->id][$h][$x]); ?> + "," + diferencia + ",";
                                        saveAtomNumberProperties(<?php echo e($i); ?>, <?php echo e($data['numeracion'][$molecules[$i]->id][$h]); ?>, diferencia);
                                    <?php endfor; ?>
                                <?php endfor; ?>
                            <?php endif; ?>
                            guardarIndex(index, <?php echo e($i); ?>);
                            jsmeApplets["<?php echo $i; ?>"].setAtomBackgroundColors(1, index);
                        <?php endif; ?>
                    <?php endfor; ?>
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
            var nMolecules = "<?php echo $count; ?>";
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
            <?php for($i = 0; $i < sizeof($molecules); $i++): ?>
                var startingStructure = "<?php echo e($molecules[$i]->jme); ?>";
                jsmeApplets["<?php echo $i; ?>"] = new JSApplet.JSME("jsme_container" + "<?php echo e($i); ?>", {
                    "options": "depict, number",
                    "fontSize": "16px",
                    "jme": startingStructure,
                });
            <?php endfor; ?>
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
            btn.textContent = filterOnlySelected ? 'Show all' : '<?php echo trans('applicationResource.form.compare'); ?>';
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContainer'); ?>
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-0 col-md-12">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b><?php echo trans('applicationResource.result.results'); ?>: <span id="numMol"></span> <?php echo trans('applicationResource.result.compounds'); ?></b></h4>
                    </div>
                </div>

                <div class="row combinations" id="resultadosnumdesp">
                    <div class="col-xs-12 text-center">
                        <input type="radio" id="numeration2" name="resultados" /><label for="numeration2"><?php echo trans('applicationResource.result.numeration'); ?></label>
                        <input type="radio" id="desplazamiento2" name="resultados" /><label for="desplazamiento2">&delta;(ppm)</label>
                        <input type="radio" id="nonumeration2" name="resultados" /><label for="nonumeration2"><?php echo trans('applicationResource.result.noNumeration'); ?></label>
                    </div>
                </div>

                <?php if(isset($data['desplazamientos'])): ?>
                    <?php echo $__env->make('layouts.toleranceTable', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>

                <br>

                <div class="row mt-3">
                    <div class="col-xs-12 text-center">
                        <button id="selectedToggle" class="btn btn-danger" type="button" onclick="toggleSelectedFilter()">
                            <i class="fa fa-btn fa-user"></i><?php echo trans('applicationResource.form.compare'); ?>

                        </button>
                    </div>
                </div>

                
                <div class="row">
                    <?php $__currentLoopData = $molecules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $molecule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 text-center" id="mol<?php echo e($i); ?>" data-molid="<?php echo e($molecule->id); ?>" style="margin-bottom: 30px;">
                            
                            
                            <div style="position: relative; width: 100%; height: 280px; margin: 0 auto 15px auto; overflow: hidden;">
                                <div class="jme jme2" id="jsme_container<?php echo e($i); ?>" style="width: 100%; height: 100%;"></div>
                            </div>

                            
                            <div style="margin-bottom: 10px; font-size: 14px; line-height: 1.4;">
                                <span><?php echo e($molecule->family); ?></span>
                                <span><?php echo e($molecule->subFamily); ?></span>
                                <span><?php echo e($molecule->subSubFamily); ?></span>
                                <span style="color: #337ab7; font-weight: bold;"><?php echo e($molecule->carbonType ?? 'C'); ?></span>
                            </div>

                            
                            <div style="margin-bottom: 15px;">
                                <a href="<?php echo e(url('properties/' . $molecule->id)); ?>" class="btn btn-danger btn-sm" style="background-color: #c9302c; border-color: #ac2925; margin: 0 2px; border-radius: 4px;">
                                    <?php echo trans('applicationResource.properties.properties'); ?>

                                </a>
                                <a href="<?php echo e(url('spectrum/' . $molecule->id)); ?>" class="btn btn-danger btn-sm" style="background-color: #c9302c; border-color: #ac2925; margin: 0 2px; border-radius: 4px;">
                                    <?php echo trans('applicationResource.molecule.spectrum'); ?>

                                </a>
                                <?php if(isset($molecule->doi) && !empty($molecule->doi)): ?>
                                    <a href="<?php echo e($molecule->doi); ?>" class="btn btn-danger btn-sm" target="_blank" style="background-color: #c9302c; border-color: #ac2925; margin: 0 2px; border-radius: 4px;">
                                        DOI
                                    </a>
                                <?php else: ?>
                                    <span class="btn btn-danger btn-sm disabled" style="background-color: #c9302c; border-color: #ac2925; opacity: 0.6; margin: 0 2px; border-radius: 4px; cursor: not-allowed;">
                                        DOI
                                    </span>
                                <?php endif; ?>
                            </div>

                            
                            <div style="margin-bottom: 10px;">
                                <input type="checkbox" id="<?php echo e($molecule->id); ?>" onclick="addSelect(event)" style="transform: scale(1.2);">
                            </div>

                            
                            <?php if(Auth::check() && Auth::user()->allowed): ?>
                                <div style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                    <?php echo e($molecule->reference); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <?php if($molecules->hasPages()): ?>
                <div class="row" id="paginationRow">
                    <div class="col-xs-12 text-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination" style="display: inline-flex; list-style: none; padding: 0; margin: 20px 0;">
                                
                                <?php if($molecules->onFirstPage()): ?>
                                    <li style="margin: 0 2px;">
                                        <span style="display: block; padding: 8px 12px; color: #999; background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px;">&laquo;</span>
                                    </li>
                                <?php else: ?>
                                    <li style="margin: 0 2px;">
                                        <a href="<?php echo e($molecules->previousPageUrl()); ?>" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;">&laquo;</a>
                                    </li>
                                <?php endif; ?>

                                <?php if($molecules->currentPage() > 4): ?>
                                    <li style="margin: 0 2px;">
                                        <a href="<?php echo e($molecules->url(1)); ?>" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;">1</a>
                                    </li>
                                    <?php if($molecules->currentPage() > 5): ?>
                                        <li style="margin: 0 2px;">
                                            <span style="display: block; padding: 8px 12px; color: #999; background: #fff; border: 1px solid #ddd; border-radius: 4px;">...</span>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php
                                    $start = max($molecules->currentPage() - 3, 1);
                                    $end = min($molecules->currentPage() + 3, $molecules->lastPage());
                                ?>

                                <?php for($page = $start; $page <= $end; $page++): ?>
                                    <?php if($page == $molecules->currentPage()): ?>
                                        <li style="margin: 0 2px;">
                                            <span style="display: block; padding: 8px 12px; color: #fff; background: #337ab7; border: 1px solid #337ab7; border-radius: 4px; font-weight: bold;"><?php echo e($page); ?></span>
                                        </li>
                                    <?php else: ?>
                                        <li style="margin: 0 2px;">
                                            <a href="<?php echo e($molecules->url($page)); ?>" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;"><?php echo e($page); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if($molecules->currentPage() < $molecules->lastPage() - 3): ?>
                                    <?php if($molecules->currentPage() < $molecules->lastPage() - 4): ?>
                                        <li style="margin: 0 2px;">
                                            <span style="display: block; padding: 8px 12px; color: #999; background: #fff; border: 1px solid #ddd; border-radius: 4px;">...</span>
                                        </li>
                                    <?php endif; ?>
                                    <li style="margin: 0 2px;">
                                        <a href="<?php echo e($molecules->url($molecules->lastPage() - 1)); ?>" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;"><?php echo e($molecules->lastPage() - 1); ?></a>
                                    </li>
                                    <li style="margin: 0 2px;">
                                        <a href="<?php echo e($molecules->url($molecules->lastPage())); ?>" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;"><?php echo e($molecules->lastPage()); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if($molecules->hasMorePages()): ?>
                                    <li style="margin: 0 2px;">
                                        <a href="<?php echo e($molecules->nextPageUrl()); ?>" style="display: block; padding: 8px 12px; color: #337ab7; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;">&raquo;</a>
                                    </li>
                                <?php else: ?>
                                    <li style="margin: 0 2px;">
                                        <span style="display: block; padding: 8px 12px; color: #999; background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px;">&raquo;</span>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </nav>
                        
                        <p style="color: #666; font-size: 14px; margin-top: 10px;">
                            Mostrando <?php echo e($molecules->firstItem()); ?> - <?php echo e($molecules->lastItem()); ?> de <?php echo e($molecules->total()); ?> resultados
                        </p>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\c14-main\resources\views/search/results.blade.php ENDPATH**/ ?>