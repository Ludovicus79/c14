<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $molecule->name ?? 'Molecule' }} - 3D View</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            overflow: hidden;
        }
        
        #container-3dmol {
            width: 100vw;
            height: 100vh;
            position: relative;
        }
        
        .controls-panel {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            z-index: 100;
            min-width: 280px;
        }
        
        .controls-panel h3 {
            margin: 0 0 15px 0;
            font-size: 18px;
            color: #333;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        
        .molecule-name {
            font-size: 16px;
            font-weight: 600;
            color: #3498db;
            margin-bottom: 15px;
            padding: 10px;
            background: #f0f8ff;
            border-radius: 5px;
            text-align: center;
        }
        
        .control-group {
            margin-bottom: 15px;
        }
        
        .control-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            color: #555;
            font-weight: 600;
        }
        
        .control-group select,
        .control-group button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .control-group select {
            background: white;
        }
        
        .control-group button {
            background: #3498db;
            color: white;
            border: none;
            font-weight: 600;
        }
        
        .control-group button:hover {
            background: #2980b9;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .control-group input[type="checkbox"] {
            margin-right: 8px;
        }
        
        .btn-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(203, 2, 35, 0.95);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 100;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-close:hover {
            background: rgba(203, 2, 35, 1);
            transform: scale(1.05);
        }
        
        .info-panel {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.95);
            padding: 15px 20px;
            border-radius: 5px;
            font-size: 13px;
            color: #555;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .info-panel strong {
            color: #3498db;
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }
        
        #loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 24px;
            z-index: 50;
            text-align: center;
        }
        
        .spinner {
            border: 4px solid rgba(255,255,255,0.3);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="container-3dmol"></div>
    
    <div id="loading">
        <div class="spinner"></div>
        Cargando molécula en 3D...
    </div>
    
    <button class="btn-close" onclick="window.close()">
        ✕ Cerrar
    </button>
    
    <div class="controls-panel">
        <h3>🧪 Visualizador Molecular 3D</h3>
        
        <div class="molecule-name">
            {{ $molecule->name ?? 'Molécula' }}
        </div>
        
        <div class="control-group">
            <label>Estilo de Representación</label>
            <select id="styleSelect" onchange="changeStyle()">
                <option value="stick">Stick (Palitos)</option>
                <option value="sphere">Sphere (Esferas)</option>
                <option value="cartoon">Cartoon (Cintas)</option>
                <option value="line">Line (Líneas)</option>
                <option value="cross">Cross (Cruces)</option>
            </select>
        </div>
        
        <div class="control-group">
            <label>Esquema de Color</label>
            <select id="colorSelect" onchange="changeColor()">
                <option value="default">Por Elemento</option>
                <option value="carbon">Carbono Gris</option>
                <option value="ss">Estructura Secundaria</option>
                <option value="spectrum">Arcoíris</option>
            </select>
        </div>
        
        <div class="control-group">
            <label>
                <input type="checkbox" id="showLabels" onchange="toggleLabels()">
                Mostrar Números de Átomo
            </label>
        </div>
        
        <div class="control-group">
            <label>
                <input type="checkbox" id="spin" onchange="toggleSpin()">
                Rotación Automática
            </label>
        </div>
        
        <div class="control-group">
            <button onclick="resetView()">
                🔄 Resetear Vista
            </button>
        </div>
        
        <div class="control-group">
            <button onclick="downloadImage()">
                📷 Capturar Imagen
            </button>
        </div>
    </div>
    
    <div class="info-panel">
        <strong>Controles:</strong>
        🖱️ Click + Arrastrar: Rotar<br>
        🖱️ Rueda: Zoom<br>
        🖱️ Click derecho: Mover<br>
        @if(isset($molecule->molecularFormula))
        <br><strong>Fórmula:</strong> {{ $molecule->molecularFormula }}
        @endif
    </div>

    <!-- 3Dmol.js -->
    <script src="https://3Dmol.csb.pitt.edu/build/3Dmol-min.js"></script>
    
    <script>
        let viewer;
        let currentStyle = 'stick';
        let currentColor = 'default';
        
        // Datos de la molécula
        const moleculeData = {
            jme: "{!! $molecule->jmeDisplacement ?? $molecule->jme ?? '' !!}",
            smiles: "{{ $molecule->smiles ?? '' }}",
            name: "{{ $molecule->name ?? 'Molecule' }}"
        };
        
        window.addEventListener('load', function() {
            initViewer();
        });
        
        function initViewer() {
            try {
                // Crear visor 3D
                let element = document.getElementById('container-3dmol');
                let config = { 
                    backgroundColor: 'black',
                    antialias: true
                };
                viewer = $3Dmol.createViewer(element, config);
                
                // Cargar molécula desde SMILES
                if (moleculeData.smiles) {
                    loadFromSMILES(moleculeData.smiles);
                } else {
                    document.getElementById('loading').innerHTML = 
                        '<div style="color: #e74c3c;">No se pudo cargar la estructura molecular.<br>SMILES no disponible.</div>';
                }
                
            } catch(e) {
                console.error('Error inicializando visor:', e);
                document.getElementById('loading').innerHTML = 
                    '<div style="color: #e74c3c;">Error al inicializar el visor 3D</div>';
            }
        }
        
        function loadFromSMILES(smiles) {
            try {
                // Generar coordenadas 3D desde SMILES usando servicio web
                fetch('https://cactus.nci.nih.gov/chemical/structure/' + encodeURIComponent(smiles) + '/sdf')
                    .then(response => {
                        if (!response.ok) throw new Error('Error obteniendo estructura');
                        return response.text();
                    })
                    .then(sdf => {
                        viewer.addModel(sdf, 'sdf');
                        viewer.setStyle({}, {stick: {colorscheme: 'default'}});
                        viewer.zoomTo();
                        viewer.render();
                        document.getElementById('loading').style.display = 'none';
                        console.log('Molécula cargada exitosamente');
                    })
                    .catch(error => {
                        console.error('Error cargando desde SMILES:', error);
                        // Fallback: intentar cargar como estructura 2D simple
                        loadFallback();
                    });
            } catch(e) {
                console.error('Error:', e);
                loadFallback();
            }
        }
        
        function loadFallback() {
            // Molécula de ejemplo si no se puede cargar la real
            const exampleMol = `
     RDKit          3D

 24 25  0  0  0  0  0  0  0  0999 V2000
    1.2990    0.0000    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0
    0.6495   -1.1249    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0
   -0.6495   -1.1249    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0
   -1.2990    0.0000    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0
   -0.6495    1.1249    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0
    0.6495    1.1249    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0
  1  2  1  0  0  0  0
  2  3  1  0  0  0  0
  3  4  1  0  0  0  0
  4  5  1  0  0  0  0
  5  6  1  0  0  0  0
  6  1  1  0  0  0  0
M  END`;
            
            viewer.addModel(exampleMol, 'mol');
            viewer.setStyle({}, {stick: {colorscheme: 'default'}});
            viewer.zoomTo();
            viewer.render();
            document.getElementById('loading').innerHTML = 
                '<div style="color: #f39c12;">Mostrando estructura de ejemplo<br>(No se pudo cargar la estructura original)</div>';
            setTimeout(() => {
                document.getElementById('loading').style.display = 'none';
            }, 3000);
        }
        
        function changeStyle() {
            currentStyle = document.getElementById('styleSelect').value;
            applyStyle();
        }
        
        function changeColor() {
            currentColor = document.getElementById('colorSelect').value;
            applyStyle();
        }
        
        function applyStyle() {
            viewer.setStyle({}, {});
            
            let styleConfig = {};
            let colorScheme = currentColor === 'default' ? 'default' : 
                             currentColor === 'carbon' ? 'grayCarbon' :
                             currentColor === 'ss' ? 'ss' : 'spectrum';
            
            switch(currentStyle) {
                case 'stick':
                    styleConfig = {stick: {colorscheme: colorScheme, radius: 0.15}};
                    break;
                case 'sphere':
                    styleConfig = {sphere: {colorscheme: colorScheme}};
                    break;
                case 'cartoon':
                    styleConfig = {cartoon: {colorscheme: colorScheme}};
                    break;
                case 'line':
                    styleConfig = {line: {colorscheme: colorScheme}};
                    break;
                case 'cross':
                    styleConfig = {cross: {colorscheme: colorScheme}};
                    break;
            }
            
            viewer.setStyle({}, styleConfig);
            viewer.render();
        }
        
        function toggleLabels() {
            const showLabels = document.getElementById('showLabels').checked;
            
            if (showLabels) {
                viewer.addPropertyLabels('serial', {}, {
                    fontSize: 12,
                    fontColor: 'white',
                    backgroundColor: 'black',
                    backgroundOpacity: 0.5
                });
            } else {
                viewer.removeAllLabels();
            }
            viewer.render();
        }
        
        function toggleSpin() {
            const spin = document.getElementById('spin').checked;
            if (spin) {
                viewer.spin(true);
            } else {
                viewer.spin(false);
            }
        }
        
        function resetView() {
            viewer.zoomTo();
            viewer.rotate(0);
            viewer.render();
        }
        
        function downloadImage() {
            viewer.pngURI(function(uri) {
                const link = document.createElement('a');
                link.href = uri;
                link.download = moleculeData.name.replace(/\s+/g, '_') + '_3D.png';
                link.click();
            });
        }
    </script>
</body>
</html>
