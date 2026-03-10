<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/highcharts.js')); ?>"></script>
    <script src="<?php echo e(asset('js/exporting.js')); ?>"></script>
    <script src="<?php echo e(asset('jsme/JSME_2024-04-29/jsme/jsme.nocache.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('estilos'); ?>
<style>
    .spectrum-wrapper { 
        padding: 15px 15px 15px 20px; 
        background: white; 
        margin:80px; }
        
    .spectrum-wrapper > .row {
        display: flex;
        flex-wrap: nowrap;
        align-items: flex-start;
    }
    .molecule-column {
        width: 33%;
        flex: 0 0 33%;
        max-width: 33%;
        padding-right: 10px;
        box-sizing: border-box;
    }
    .charts-column {
        width: 67%;
        flex: 0 0 67%;
        max-width: 67%;
        padding-left: 5px;
        box-sizing: border-box;
    }
    @media (max-width: 767px) {
        .spectrum-wrapper > .row { flex-wrap: wrap; }
        .molecule-column, .charts-column { width: 100%; flex: 0 0 100%; max-width: 100%; }
    }
    .charts-title { text-align: left; margin-bottom: 5px; }
    .charts-title h4 { margin: 0 0 2px 0; font-size: 15px; font-weight: 600; color: #333; }
    .charts-title .solvent { font-size: 12px; color: #666; }
    .molecule-viewer {
        border: 2px solid #000;
        background: white;
        padding: 5px;
        margin-bottom: 10px;
        height: 300px;
        overflow: hidden;
    }
    .btn-view-3d {
        width: 100%; padding: 8px; background-color: #3498db;
        color: white; border: none; border-radius: 4px;
        font-size: 13px; font-weight: 600; cursor: pointer;
    }
    .btn-view-3d:hover { background-color: #2980b9; }
    .chart-wrapper { margin-bottom: 5px; }
    .chart-container { height: 270px; width: 100%; }
    .action-buttons { text-align: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0; }
    .action-buttons .btn { margin: 0 8px; padding: 8px 25px; }
    @media print { .btn, .action-buttons { display: none !important; } }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContainer'); ?>
<div class="spectrum-wrapper">
    <div class="row">

        
        <div class="molecule-column">
            <div class="molecule-viewer">
                <div id="jsme_container" style="width:100%; height:290px;"></div>
            </div>
            <button class="btn-view-3d" onclick="open3DMolecule()">
                <i class="fa fa-cube"></i> Ver Molécula en 3D
            </button>
        </div>

        
        <div class="charts-column">

            
            <div class="charts-title">
                <?php if(!empty($molecule->name)): ?>
                    <h4>Trivial Name: <?php echo e($molecule->name); ?></h4>
                <?php endif; ?>
                <?php if(!empty($molecule->solvent)): ?>
                    <div class="solvent">Solvent: <?php echo e($molecule->solvent); ?></div>
                <?php endif; ?>
            </div>

            <?php if(isset($charts[2])): ?>
            <div class="chart-wrapper">
                <div class="chart-container" id="topLinechart"></div>
            </div>
            <?php endif; ?>

            <?php if(isset($charts[1])): ?>
            <div class="chart-wrapper">
                <div class="chart-container" id="middleLinechart"></div>
            </div>
            <?php endif; ?>

            <?php if(isset($charts[0])): ?>
            <div class="chart-wrapper">
                <div class="chart-container" id="lowerLinechart"></div>
            </div>
            <?php endif; ?>

            <div class="action-buttons">
                <button class="btn btn-danger" onclick="printSpectrum()">
                    <i class="fa fa-print"></i> <?php echo trans('applicationResource.menu.print'); ?>

                </button>
                <button class="btn btn-default" onclick="window.history.back()">
                    <i class="fa fa-arrow-left"></i> <?php echo trans('applicationResource.button.back'); ?>

                </button>
            </div>

        </div>
    </div>
</div>

<script>
    var jme = "<?php echo $molecule->jmeDisplacement; ?>";
    var jsmeApplet;

    // Mapa de colores igual que la web original
    var colorMap = {
        'CH':      '#FF0000',  // rojo
        'CH2':     '#008000',  // verde
        'CH3':     '#800080',  // morado
        'C':       '#0000FF',  // azul
        'Solvent': '#000000'   // negro
    };

    function jsmeOnLoad() {
        try {
            jsmeApplet = new JSApplet.JSME("jsme_container", "100%", "290px", {
                "options": "depict, number"
            });
            setTimeout(function() {
                if (jsmeApplet && jme) {
                    jsmeApplet.readMolecule(jme);
                    <?php if(isset($atomos)): ?>
                        jsmeApplet.setAtomBackgroundColors(1, "<?php echo e($atomos); ?>");
                    <?php endif; ?>
                }
            }, 500);
        } catch(e) { console.error('JSME error:', e); }
    }

    function buildChart(containerId, rawConfig) {
        var el = document.getElementById(containerId);
        if (!el) return;

        // Aplicar colores y ancho fino a cada serie
        var series = (rawConfig.series || []).map(function(s) {
            var clone = JSON.parse(JSON.stringify(s));
            clone.color = colorMap[clone.name] || '#999999';
            clone.pointWidth = 2;
            return clone;
        });

        new Highcharts.Chart({
            chart: {
                renderTo: el,
                type: 'column',
                backgroundColor: '#ffffff',
                zoomType: 'x',
                resetZoomButton: {
                    position: { align: 'right', x: -10, y: 10 }
                }
            },
            title: { text: null },
            tooltip: {
                headerFormat: '',
                pointFormat: '<b>{point.x}</b> ppm<br/><b>Num: {point.id}</b><br/>'
            },
            xAxis: rawConfig.xAxis || {
                reversed: true,
                title: { text: 'Shift (ppm)' },
                min: 0, max: 235, tickInterval: 20
            },
            yAxis: {
                labels: { enabled: false },
                title: { text: null }
            },
            plotOptions: {
                column: {
                    groupPadding: 0,
                    pointPadding: 0,
                    borderWidth: 0,
                    pointWidth: 2,
                    dataLabels: {
                        enabled: true,
                        rotation: -45,
                        y: -15,
                        crop: false,
                        overflow: 'none',
                        format: '{point.x}',
                        style: { fontSize: '10px', fontWeight: 'normal' }
                    }
                }
            },
            legend: { enabled: true },
            credits: { enabled: true },
            series: series
        });
    }

    window.addEventListener('load', function() {
        <?php if(isset($charts[2])): ?>
        try { buildChart('topLinechart', <?php echo json_encode($charts[2]); ?>); } catch(e) { console.error(e); }
        <?php endif; ?>
        <?php if(isset($charts[1])): ?>
        try { buildChart('middleLinechart', <?php echo json_encode($charts[1]); ?>); } catch(e) { console.error(e); }
        <?php endif; ?>
        <?php if(isset($charts[0])): ?>
        try { buildChart('lowerLinechart', <?php echo json_encode($charts[0]); ?>); } catch(e) { console.error(e); }
        <?php endif; ?>
    });

    function open3DMolecule() {
        window.open('/spectrum/<?php echo e($molecule->id); ?>/molecule3d', '3DMolecule',
            'width=900,height=700,menubar=no,toolbar=no,location=no,status=no,resizable=yes');
    }

    function printSpectrum() { window.print(); }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\c14-main\resources\views/search/spectrum.blade.php ENDPATH**/ ?>