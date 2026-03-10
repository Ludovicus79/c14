<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo asset('jsme/jsme.nocache.js'); ?>" type="text/javascript"></script>

    <script>
        var jme = "<?php echo $molecule->jme; ?>";
        var jmeNumeration = "<?php echo $molecule->jmeNumeration; ?>";
        var jmeDisplacement = "<?php echo $molecule->jmeDisplacement; ?>";
        var jsmeApplet;
        var selectedJme = jme;

        $(document).ready(init);

        /**
         * Funcion encargada de cargar la molecula
         */
        function loadJmeFile() {
            jsmeApplet.readMolecule(selectedJme);
            /**si la busqueda se hizo por desplazamiento*/
            <?php if(isset($atomos)): ?>
                jsmeApplet.setAtomBackgroundColors(1, "<?php echo e($atomos); ?>");
                paintTable();
            <?php endif; ?>
        }

        /**
         * Funcion encargada de cargar el JSME
         */
        function jsmeOnLoad() {

            jsmeApplet = new JSApplet.JSME("jsme_container", "500px", "350px", {
                "options": "depict, number",
                "fontSize": "16px"
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
            <?php if(isset($numeracion)): ?>
                <?php for($i=0; $i< sizeof($numeracion) ;$i++): ?>

                    fila=document.getElementById("atomo<?php echo e($numeracion[$i]); ?>");
                    fila.setAttribute("class","row diferencia<?php echo e($diferencia[$i]-1); ?>");

                <?php endfor; ?>
            <?php endif; ?>
        }

    </script>

	<script>
		// Al entrar en la vista de propiedades, resetear el filtro de "solo seleccionadas"
		// para que al volver a resultados no quede activado y no oculte moléculas.
		document.addEventListener('DOMContentLoaded', function() {
			try {
				localStorage.setItem('FilterOnlySelected', 'false');
			} catch (e) {
				// Ignorar si el navegador bloquea sessionStorage
			}
		});
	</script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContainer'); ?>
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b><?php echo trans('applicationResource.properties.properties'); ?></b></h4>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-11 col-md-offset-1 double-spaced">
                        <strong><?php echo trans('applicationResource.molData.name'); ?></strong>: <?php echo $molecule->name; ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-11 col-md-offset-1 double-spaced">
                        <strong><?php echo trans('applicationResource.criteria.semiName'); ?></strong>: <?php echo $molecule->semiSystematicName; ?>

                    </div>
                </div>
                <?php if(Auth::user() && Auth::user()->allowed): ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1 double-spaced">
                            <strong>Ref:</strong> <?php echo $molecule->reference; ?>

                        </div>
                    </div>

                <?php endif; ?>

                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-2 col-md-offset-1 double-spaced">
                        <strong><?php echo trans('applicationResource.molData.family'); ?>

                            :</strong> <?php echo $molecule->family; ?></div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-2 double-spaced">
                        <strong><?php echo trans('applicationResource.molData.group'); ?>

                            :</strong> <?php echo $molecule->subFamily; ?></div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1 double-spaced">
                        <strong><?php echo trans('applicationResource.molData.type'); ?>

                            :</strong> <?php echo $molecule->subSubFamily; ?></div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-md-offset-1 double-spaced">
                        <strong><?php echo trans('applicationResource.molData.solvent'); ?>

                            :</strong> <?php echo $solvent; ?></div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1 double-spaced">
                        <strong><?php echo trans('applicationResource.molData.formula'); ?>

                            :</strong> <?php echo $molecularFormula; ?></div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1 double-spaced">
                        <strong><?php echo trans('applicationResource.molData.weight'); ?>

                            :</strong> <?php echo $molecule->molecularWeight; ?></div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-11 col-md-offset-1 double-spaced">
                        <strong><?php echo trans('applicationResource.molData.bibliography'); ?>

                            :</strong> <?php echo $bibliography->authors; ?>

                        <i><?php echo $bibliography->magazine; ?></i>
                        (<?php echo $bibliography->year; ?>)
                        <i><?php echo $bibliography->volume; ?></i>,
                        <?php echo $bibliography->page; ?>

                    </div>

                </div>
                <hr>

                <!--si la busqueda se hizo por desplazamiento pone la tabla de tolerancias-->
                <?php if(isset($atomos)): ?>
                    <?php echo $__env->make('layouts.toleranceTable', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-xs-12 col-md-4 col-md-offset-1 ">
                        <strong><?php echo trans('applicationResource.molData.rmn'); ?></strong>
                    </div>
                    <div class="col-xs-12 col-md-4 col-md-offset-3">
                        <strong><?php echo trans('applicationResource.submenu.estructura'); ?></strong>
                    </div>

                </div>
                <br>

                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1 col-md-3 col-md-offset-1 double-spaced">
                        <div class="row">
                            <div class="col-xs-4 col-md-3 text-left"><strong>Num</strong></div>
                            <div class="col-xs-4 col-md-3 text-left"><strong>Num2</strong></div>
                            <div class="col-xs-4 col-md-3 text-left">
                                <strong><?php echo trans('applicationResource.properties.types'); ?></strong></div>
                            <div class="col-xs-4 col-md-3 text-right"><strong>&delta;(ppm)</strong></div>

                        </div>

                        <?php
                        
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
                        ?>

                        <?php $__currentLoopData = $carbonsOrdered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carbon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row" id="atomo<?php echo e($carbon['num2']); ?>">
                                <div class="col-xs-4 col-md-3 text-left"><?php echo $carbon['numeration']; ?></div>
                                <div class="col-xs-4 col-md-3 text-left"><?php echo $carbon['num2']; ?></div>
                                <div class="col-xs-4 col-md-3 text-left"><?php echo $carbon['carbonType']; ?></div>
                                <div class="col-xs-4 col-md-3 text-right">
                                    <?php if($carbon['shift'] == -9999): ?>
                                        -
                                    <?php else: ?>
                                        <?php echo number_format($carbon['shift'], 1); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="col-xs-12 col-sm-offset-1 col-sm-11 col-md-6 col-md-offset-2">
                        <div class="text-center" id="opcionesnumdesp">
                            <span><a style="outline: none;" href="#"
                               id="numeration"><?php echo trans('applicationResource.result.numeration'); ?></a></span>
                            <span><a style="outline: none;" href="#" id="shift">&delta;(ppm)</a></span>
                            <span><a style="outline: none;" href="#"
                                     id="noNumeration"><?php echo trans('applicationResource.result.noNumeration'); ?></a></span>
                        </div>
                        <div class="jmeProp" id="jsme_container">
                        </div>
                    </div>
                </div>

                <hr class="invisible">

                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-11 col-md-offset-1 double-spaced">
                        <strong><?php echo trans('applicationResource.molData.comments'); ?>: </strong> <?php echo $molecule->publicCom; ?>

                    </div>
                </div>


                <hr class="invisible">
                <div class="row text-center">
                    <button id="backBtn" class="btn btn-md btn-danger" onclick="window.history.back()">
                        <?php echo trans('applicationResource.button.back'); ?>

                    </button>
                    <hr class="invisible">
                    <?php if(Auth::user() && Auth::user()->allowed): ?>
                        <div class="col-xs-12 text-center">
                            <a href="<?php echo url('admin/molEdit/'.$molecule->id); ?>"
                                class="btn btn-danger"><?php echo trans('applicationResource.button.edit'); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                </div>


            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\c14-main\resources\views/search/properties.blade.php ENDPATH**/ ?>