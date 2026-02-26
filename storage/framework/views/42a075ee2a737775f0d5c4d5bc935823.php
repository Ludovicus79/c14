<?php $__env->startSection('scripts'); ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="<?php echo e(asset('jsme/jsme.nocache.js')); ?>"></script>

    <style>
        .spectrum-container {
            background: white;
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .molecule-column {
            padding-right: 20px;
        }
        
        .charts-column {
            padding-left: 20px;
        }
        
        .molecule-info {
            text-align: center;
            margin-bottom: 10px;
        }
        
        .molecule-info h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .molecule-info .solvent {
            font-size: 13px;
            color: #666;
        }
        
        .molecule-viewer {
            border: 2px solid #000;
            background: white;
            padding: 5px;
            margin-bottom: 15px;
            position: relative;
            min-height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-view-3d {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-view-3d:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }
        
        .chart-wrapper {
            margin-bottom: 20px;
        }
        
        .chart-container {
            min-height: 280px;
            width: 100%;
        }
        
        .action-buttons {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
        }
        
        .action-buttons .btn {
            margin: 0 10px;
            padding: 10px 30px;
            font-size: 14px;
        }
        
        @media print {
            .btn, .action-buttons {
                display: none !important;
            }
        }
        
        @media (max-width: 768px) {
            .molecule-column,
            .charts-column {
                padding: 0;
            }
        }
    </style>

    <script>
        var jme = "<?php echo $molecule->jmeDisplacement; ?>";
        var jsmeApplet;

        window.addEventListener('load', function() {
            console.log('Inicializando espectro...');
            init();
        });

        /**
         * Cargar JSME
         */
        function jsmeOnLoad() {
            console.log('Cargando JSME...');
            try {
                jsmeApplet = new JSApplet.JSME("jsme_container", "100%", "340px", {
                    "options": "depict, number"
                });
                
                setTimeout(function() {
                    if (jsmeApplet && jme) {
                        jsmeApplet.readMolecule(jme);
                        console.log('Molécula cargada correctamente');
                        
                        <?php if(isset($atomos)): ?>
                            jsmeApplet.setAtomBackgroundColors(1, "<?php echo e($atomos); ?>");
                        <?php endif; ?>
                    }
                }, 500);
            } catch(e) {
                console.error('Error cargando JSME:', e);
            }
        }

        /**
         * Inicialización
         */
        function init() {
            // Renderizar gráficos en orden correcto
            <?php if(isset($charts) && is_array($charts)): ?>
                <?php if(isset($charts[2])): ?>
                    renderTopChart();
                <?php endif; ?>
                <?php if(isset($charts[1])): ?>
                    renderMiddleChart();
                <?php endif; ?>
                <?php if(isset($charts[0])): ?>
                    renderLowerChart();
                <?php endif; ?>
            <?php endif; ?>
        }

        // GRÁFICO TOP (CH, CH2, CH3) - BARRAS VERTICALES
        <?php if(isset($charts[2])): ?>
        function renderTopChart() {
            try {
                var chartConfig = <?php echo json_encode($charts[2]); ?>;
                
                // Asegurar que sea columna (barras verticales)
                chartConfig.chart = {
                    type: 'column',
                    backgroundColor: '#ffffff'
                };
                
                // Procesar eventos para resaltar átomos
                processChartEvents(chartConfig);
                
                Highcharts.chart('topLinechart', chartConfig);
                console.log('Gráfico superior renderizado (columnas)');
            } catch(e) {
                console.error('Error en gráfico superior:', e);
            }
        }
        <?php endif; ?>

        // GRÁFICO MIDDLE (Solo CH) - BARRAS VERTICALES
        <?php if(isset($charts[1])): ?>
        function renderMiddleChart() {
            try {
                var chartConfig = <?php echo json_encode($charts[1]); ?>;
                
                chartConfig.chart = {
                    type: 'column',
                    backgroundColor: '#ffffff'
                };
                
                processChartEvents(chartConfig);
                Highcharts.chart('middleLinechart', chartConfig);
                console.log('Gráfico medio renderizado (columnas)');
            } catch(e) {
                console.error('Error en gráfico medio:', e);
            }
        }
        <?php endif; ?>

        // GRÁFICO LOWER (Todos + Solvente) - BARRAS VERTICALES
        <?php if(isset($charts[0])): ?>
        function renderLowerChart() {
            try {
                var chartConfig = <?php echo json_encode($charts[0]); ?>;
                
                chartConfig.chart = {
                    type: 'column',
                    backgroundColor: '#ffffff'
                };
                
                processChartEvents(chartConfig);
                Highcharts.chart('lowerLinechart', chartConfig);
                console.log('Gráfico inferior renderizado (columnas)');
            } catch(e) {
                console.error('Error en gráfico inferior:', e);
            }
        }
        <?php endif; ?>

        /**
         * Procesar eventos de mouse para resaltar átomos
         */
        function processChartEvents(chartConfig) {
            if (!chartConfig.series) return;
            
            chartConfig.series.forEach(function(serie) {
                if (!serie.data) return;
                
                serie.data.forEach(function(point) {
                    if (!point.events) return;
                    
                    // Convertir strings a funciones
                    if (typeof point.events.mouseOver === 'string') {
                        try {
                            point.events.mouseOver = eval('(' + point.events.mouseOver + ')');
                        } catch(e) {
                            console.error('Error procesando mouseOver:', e);
                        }
                    }
                    
                    if (typeof point.events.mouseOut === 'string') {
                        try {
                            point.events.mouseOut = eval('(' + point.events.mouseOut + ')');
                        } catch(e) {
                            console.error('Error procesando mouseOut:', e);
                        }
                    }
                });
            });
        }

        /**
         * Abrir molécula en 3D (SOLO LA MOLÉCULA, NO EL ESPECTRO)
         */
        function open3DMolecule() {
            var moleculeId = '<?php echo e($molecule->id); ?>';
            var url = '/spectrum/' + moleculeId + '/molecule3d';
            var features = 'width=900,height=700,menubar=no,toolbar=no,location=no,status=no,resizable=yes';
            window.open(url, '3DMolecule', features);
        }

        /**
         * Imprimir / PDF
         */
        function printSpectrum() {
            window.print();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContainer'); ?>
    <section class="container-fluid spectrum-container">
        <div class="row">
            
            <!-- COLUMNA IZQUIERDA: Molécula -->
            <div class="col-xs-12 col-md-4 molecule-column">
                
                <!-- Información -->
                <div class="molecule-info">
                    <?php if(isset($molecule->name) && !empty($molecule->name)): ?>
                        <h4>Trivial Name: <?php echo e($molecule->name); ?></h4>
                    <?php endif; ?>
                    <?php if(isset($molecule->solvent) && !empty($molecule->solvent)): ?>
                        <div class="solvent">Solvent: <?php echo e($molecule->solvent); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Visor 2D con JSME -->
                <div class="molecule-viewer">
                    <div id="jsme_container" style="width: 100%; height: 340px;"></div>
                </div>
                
                <!-- Botón para ver en 3D (SOLO LA MOLÉCULA) -->
                <button class="btn-view-3d" onclick="open3DMolecule()">
                    <i class="fa fa-cube"></i> Ver Molécula en 3D
                </button>
                
            </div>

            <!-- COLUMNA DERECHA: Gráficos (BARRAS VERTICALES) -->
            <div class="col-xs-12 col-md-8 charts-column">
                
                <!-- Gráfico 1: CH, CH2, CH3 -->
                <?php if(isset($charts[2])): ?>
                <div class="chart-wrapper">
                    <div class="chart-container" id="topLinechart"></div>
                </div>
                <?php endif; ?>

                <!-- Gráfico 2: Solo CH -->
                <?php if(isset($charts[1])): ?>
                <div class="chart-wrapper">
                    <div class="chart-container" id="middleLinechart"></div>
                </div>
                <?php endif; ?>

                <!-- Gráfico 3: Todos + Solvente -->
                <?php if(isset($charts[0])): ?>
                <div class="chart-wrapper">
                    <div class="chart-container" id="lowerLinechart"></div>
                </div>
                <?php endif; ?>

                <!-- Botones de acción -->
                <div class="action-buttons">
                    <button class="btn btn-danger" onclick="printSpectrum()">
                        <i class="fa fa-print"></i> Print / Download PDF
                    </button>
                    <button class="btn btn-default" onclick="window.history.back()">
                        <i class="fa fa-arrow-left"></i> Back
                    </button>
                </div>

            </div>
            
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/search/spectrum.blade.php ENDPATH**/ ?>