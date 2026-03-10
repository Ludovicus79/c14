<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>3D Molecule - {{ $molecule->name ?? 'Molecule' }}</title>
    
    <!-- NGL Viewer -->
    <script src="https://cdn.jsdelivr.net/gh/arose/ngl@v2.0.0-dev.37/dist/ngl.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            color: white;
            overflow-x: hidden;
        }
        
        /* Header simplificado - SOLO NOMBRE */
        .header {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 20px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 100;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,212,255,0.5), transparent);
        }
        
        .header-content h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            background: linear-gradient(135deg, #00d4ff 0%, #7b2cbf 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-close {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255,75,43,0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-close:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255,75,43,0.4);
        }
        
        /* Contenedor principal */
        .main-container {
            padding: 20px 32px 32px 32px;
            display: flex;
            gap: 24px;
            min-height: calc(100vh - 80px);
        }
        
        /* Panel del visor */
        .viewer-panel {
            flex: 1;
            background: rgba(0,0,0,0.4);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            min-height: 600px;
        }
        
        /* El canvas de NGL */
        #viewport {
            width: 100%;
            height: 100%;
            min-height: 600px;
            position: relative;
        }
        
        /* Controles flotantes - TODOS EN UNA LÍNEA */
        .controls-bar {
            position: absolute;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            background: rgba(10,10,30,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 14px 20px;
            border-radius: 16px;
            border: 1px solid rgba(0,212,255,0.2);
            box-shadow: 0 10px 40px rgba(0,0,0,0.4), 0 0 20px rgba(0,212,255,0.1);
            z-index: 50;
            white-space: nowrap;
            max-width: 95%;
            overflow-x: auto;
        }
        
        .controls-bar button {
            background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 10px 16px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            flex-shrink: 0;
        }
        
        .controls-bar button:hover {
            background: linear-gradient(145deg, rgba(0,212,255,0.2), rgba(0,212,255,0.1));
            border-color: rgba(0,212,255,0.4);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,212,255,0.2);
        }
        
        .controls-bar button.active {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            border-color: #00d4ff;
            box-shadow: 0 4px 15px rgba(0,212,255,0.4);
        }
        
        /* Sidebar info - SOLO ESTADÍSTICAS */
        .info-sidebar {
            width: 300px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .info-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(255,255,255,0.05);
        }
        
        .info-card h3 {
            margin: 0 0 20px 0;
            font-size: 14px;
            color: #00d4ff;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .stat-row:last-child {
            border-bottom: none;
        }
        
        .stat-label {
            color: rgba(255,255,255,0.5);
            font-size: 13px;
        }
        
        .stat-value {
            color: white;
            font-weight: 600;
            font-size: 14px;
            font-family: 'SF Mono', monospace;
        }
        
        /* Status badge */
        .status-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .status-badge.loading {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: #000;
            animation: pulse 2s infinite;
        }
        
        .status-badge.ready {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: #000;
        }
        
        .status-badge.error {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        /* Tooltip moderno */
        .atom-tooltip {
            position: fixed;
            background: rgba(10,10,30,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0,212,255,0.3);
            color: white;
            padding: 20px 24px;
            border-radius: 16px;
            font-size: 14px;
            pointer-events: none;
            display: none;
            z-index: 10000;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 30px rgba(0,212,255,0.1);
            min-width: 240px;
        }
        
        .atom-tooltip .atom-header {
            font-size: 18px;
            font-weight: 700;
            color: #00d4ff;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(0,212,255,0.2);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .atom-tooltip .atom-number {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: #000;
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
        }
        
        .atom-tooltip .coord-section {
            margin-top: 12px;
        }
        
        .atom-tooltip .coord-label {
            color: rgba(0,212,255,0.8);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        
        .atom-tooltip .coord-line {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 10px 14px;
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.05);
        }
        
        .atom-tooltip .coord-axis {
            color: rgba(255,255,255,0.5);
            font-weight: 600;
            min-width: 30px;
        }
        
        .atom-tooltip .coord-value {
            color: white;
            font-weight: 500;
            font-family: 'SF Mono', monospace;
            font-size: 14px;
        }
        
        /* Loading */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.8);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 40;
        }
        
        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(0,212,255,0.1);
            border-top: 4px solid #00d4ff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loading-text {
            color: #00d4ff;
            font-weight: 600;
            font-size: 16px;
        }
        
        /* Error message */
        .error-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 50;
        }
        
        .error-message .icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        
        .error-message h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #e74c3c;
        }
        
        .error-message p {
            color: #aaa;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .error-message button {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .error-message button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(231,76,60,0.4);
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .info-sidebar {
                width: 260px;
            }
        }
        
        @media (max-width: 900px) {
            .main-container {
                flex-direction: column;
                height: auto;
                min-height: auto;
            }
            
            .info-sidebar {
                width: 100%;
            }
            
            .viewer-panel {
                height: 500px;
                min-height: 400px;
            }
            
            .controls-bar {
                bottom: 16px;
                padding: 12px 16px;
                gap: 6px;
            }
            
            .controls-bar button {
                padding: 8px 12px;
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <!-- Header simplificado - SOLO NOMBRE -->
    <div class="header">
        <div class="header-content">
            <h1>{{ $molecule->name ?? 'Molecule' }}</h1>
        </div>
        <button class="btn-close" onclick="window.close()">
            <span>✕</span> Close
        </button>
    </div>
    
    <div class="main-container">
        <div class="viewer-panel" id="viewer-panel-inner">
            <div id="viewport"></div>
            
            <!-- Loading -->
            <div id="loading" class="loading-overlay">
                <div class="loading-spinner"></div>
                <div class="loading-text">Loading 3D structure...</div>
            </div>
            
            <!-- Controles flotantes - TODOS EN UNA LÍNEA -->
            <div class="controls-bar">
                <button id="btn-stick" class="active" onclick="setStyle('stick')">
                    <span>🥢</span> Stick
                </button>
                <button id="btn-ballstick" onclick="setStyle('ball-and-stick')">
                    <span>⚪</span> Ball & Stick
                </button>
                <button id="btn-line" onclick="setStyle('line')">
                    <span>📏</span> Line
                </button>
                <button id="btn-spacefill" onclick="setStyle('spacefill')">
                    <span>🔮</span> Spacefill
                </button>
                <button id="btn-spin" onclick="toggleSpin()">
                    <span>🔄</span> Spin
                </button>
                <button onclick="resetView()">
                    <span>🎯</span> Reset
                </button>
                <button id="btn-labels" onclick="toggleLabels()">
                    <span>🏷️</span> Labels
                </button>
            </div>
        </div>
        
        <!-- Sidebar info - SOLO ESTADÍSTICAS -->
        <div class="info-sidebar">
            <div class="info-card">
                <h3>📊 Statistics</h3>
                <div class="stat-row">
                    <span class="stat-label">Name</span>
                    <span class="stat-value">{{ $molecule->name ?? '-' }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Formula</span>
                    <span class="stat-value">{{ $molecule->molecularFormula ?? '-' }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Molecular Weight</span>
                    <span class="stat-value">{{ $molecule->molecularWeight ?? '-' }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Database ID</span>
                    <span class="stat-value">#{{ $molecule->id ?? '-' }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Atoms</span>
                    <span class="stat-value" id="atom-count">-</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Bonds</span>
                    <span class="stat-value" id="bond-count">-</span>
                </div>
                <div class="status-container">
                    <div id="status-badge" class="status-badge loading">Loading</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tooltip -->
    <div id="atom-tooltip" class="atom-tooltip">
        <div class="atom-header">
            <span class="atom-number">#<span id="tooltip-atom-num">1</span></span>
            <span id="tooltip-element">C</span>
        </div>
        <div class="coord-section">
            <div class="coord-label">Position (Å)</div>
            <div class="coord-line">
                <span class="coord-axis">X:</span>
                <span class="coord-value" id="tooltip-x">0.000</span>
            </div>
            <div class="coord-line">
                <span class="coord-axis">Y:</span>
                <span class="coord-value" id="tooltip-y">0.000</span>
            </div>
            <div class="coord-line">
                <span class="coord-axis">Z:</span>
                <span class="coord-value" id="tooltip-z">0.000</span>
            </div>
        </div>
    </div>

    <script>
        var stage;
        var structureComponent;
        var representation;
        var labelRepresentation = null;
        var currentStyle = 'stick';
        var isSpinning = false;
        var labelsVisible = false;
        var atomDataList = [];
        
        var smilesData = "{{ $molecule->smiles ?? '' }}";
        var molData = @json($molecule->mol ?? null);
        
        // Inicializar NGL Viewer
        document.addEventListener('DOMContentLoaded', function() {
            initViewer();
        });
        
        function initViewer() {
            var viewport = document.getElementById('viewport');
            
            // Crear Stage de NGL
            stage = new NGL.Stage(viewport, {
                backgroundColor: 'black',
                clipNear: 0,
                clipFar: 100,
                fogNear: 50,
                fogFar: 100
            });
            
            // Manejar resize
            window.addEventListener('resize', function() {
                stage.handleResize();
            });
            
            // Verificar si hay datos MOL directos
            if (molData && molData.trim() !== '' && molData !== 'null') {
                console.log('Loading from MOL data');
                loadStructure(molData, 'Database');
                return;
            }
            
            // Si no, intentar con SMILES
            if (smilesData && smilesData.trim() !== '') {
                console.log('Loading from SMILES');
                loadFromSMILES(smilesData);
            } else {
                showError('No structure available', 'No MOL or SMILES data found');
            }
        }
        
        // Servicios para generar 3D desde SMILES, en orden de prioridad
        var smilesServices = [
            {
                name: 'NCI Cactus',
                url: smiles => 'https://cactus.nci.nih.gov/chemical/structure/' + encodeURIComponent(smiles) + '/sdf'
            },
            {
                name: 'Cactus (InChI fallback)',
                url: smiles => 'https://cactus.nci.nih.gov/chemical/structure/' + encodeURIComponent(smiles) + '/sdf?operator=inchi'
            },
            {
                name: 'PubChem',
                // PubChem: primero obtener CID, luego descargar SDF 3D
                url: null,
                fetch: async function(smiles) {
                    const cidResp = await fetch(
                        'https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/smiles/' +
                        encodeURIComponent(smiles) + '/cids/JSON'
                    );
                    if (!cidResp.ok) throw new Error('No CID');
                    const cidData = await cidResp.json();
                    const cid = cidData.IdentifierList?.CID?.[0];
                    if (!cid) throw new Error('CID not found');
                    const sdfResp = await fetch(
                        'https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/CID/' + cid + '/SDF?record_type=3d'
                    );
                    if (!sdfResp.ok) throw new Error('No 3D SDF');
                    return await sdfResp.text();
                }
            }
        ];

        async function loadFromSMILES(smiles) {
            updateStatus('loading', 'Fetching 3D structure...');

            for (var i = 0; i < smilesServices.length; i++) {
                var service = smilesServices[i];
                try {
                    var sdf;
                    if (service.fetch) {
                        sdf = await service.fetch(smiles);
                    } else {
                        var resp = await fetch(service.url(smiles));
                        if (!resp.ok) throw new Error('HTTP ' + resp.status);
                        sdf = await resp.text();
                    }
                    if (sdf && sdf.trim().length > 10 && (sdf.indexOf('M  END') !== -1 || sdf.indexOf('$$$$') !== -1) && sdf.indexOf('<html') === -1) {
                        console.log('3D loaded from ' + service.name);
                        loadStructure(sdf, service.name);
                        return;
                    }
                    throw new Error('Empty SDF');
                } catch(e) {
                    console.warn(service.name + ' failed:', e.message);
                }
            }

            // Todos los servicios fallaron — mostrar vista 2D con JSME como fallback
            console.warn('All 3D services failed, showing 2D fallback');
            show2DFallback();
        }
        
        function loadStructure(sdfData, source) {
            try {
                var info = parseSDFInfo(sdfData);
                document.getElementById('atom-count').textContent = info.atoms || '?';
                document.getElementById('bond-count').textContent = info.bonds || '?';
                
                // Crear blob del SDF
                var blob = new Blob([sdfData], {type: 'chemical/x-mdl-sdfile'});
                
                // Cargar en NGL
                stage.loadFile(blob, {ext: 'sdf', defaultRepresentation: false})
                    .then(function(component) {
                        structureComponent = component;
                        
                        // Guardar datos de átomos
                        var structure = component.structure;
                        atomDataList = [];
                        
                        structure.eachAtom(function(ap) {
                            atomDataList.push({
                                index: ap.index,
                                atomNumber: ap.serial + 1,
                                element: ap.element,
                                x: ap.x,
                                y: ap.y,
                                z: ap.z,
                                atomProxy: ap
                            });
                        });
                        
                        // Aplicar estilo inicial (Stick por defecto)
                        setStyle('stick');
                        
                        // Auto zoom
                        stage.autoView();
                        
                        // Configurar hover
                        setupHover();
                        
                        updateStatus('ready', 'Ready');
                        hideLoading();
                    })
                    .catch(function(error) {
                        console.error('Load error:', error);
                        showError('Error loading structure', error.message);
                    });
                
            } catch(e) {
                console.error('Load error:', e);
                showError('Error loading structure', e.message);
            }
        }
        
        function parseSDFInfo(sdfData) {
            var lines = sdfData.split('\n');
            var atoms = 0, bonds = 0;
            
            for (var i = 0; i < Math.min(lines.length, 10); i++) {
                var line = lines[i];
                if (line.indexOf('V2000') !== -1) {
                    var parts = line.trim().split(/\s+/);
                    if (parts.length >= 2) {
                        atoms = parseInt(parts[0]) || 0;
                        bonds = parseInt(parts[1]) || 0;
                    }
                    break;
                }
                if (i === 3 && line.length >= 6) {
                    atoms = parseInt(line.substring(0, 3).trim()) || 0;
                    bonds = parseInt(line.substring(3, 6).trim()) || 0;
                    if (atoms > 0) break;
                }
            }
            
            return { atoms: atoms, bonds: bonds };
        }
        
        // Configurar hover con picking nativo de NGL
        function setupHover() {
            var lastAtom = null;
            
            stage.mouseControls.add('hover', function(stage, pickingProxy) {
                if (pickingProxy && pickingProxy.atom) {
                    var atomProxy = pickingProxy.atom;
                    var atomIndex = atomProxy.index;
                    var atomData = atomDataList[atomIndex];
                    
                    if (atomData && (!lastAtom || lastAtom.index !== atomData.index)) {
                        lastAtom = atomData;
                        
                        var mx = stage.mouseObserver.x;
                        var my = stage.mouseObserver.y;
                        
                        showTooltip(atomData, mx, my);
                    }
                } else {
                    lastAtom = null;
                    hideTooltip();
                }
            });
        }
        
        function showTooltip(atom, mouseX, mouseY) {
            var tooltip = document.getElementById('atom-tooltip');
            
            document.getElementById('tooltip-atom-num').textContent = atom.atomNumber;
            document.getElementById('tooltip-element').textContent = atom.element || 'C';
            document.getElementById('tooltip-x').textContent = atom.x.toFixed(3);
            document.getElementById('tooltip-y').textContent = atom.y.toFixed(3);
            document.getElementById('tooltip-z').textContent = atom.z.toFixed(3);
            
            var x = mouseX + 20;
            var y = mouseY - 120;
            
            var tooltipWidth = 240;
            var tooltipHeight = 180;
            
            if (x + tooltipWidth > window.innerWidth) {
                x = mouseX - tooltipWidth - 20;
            }
            if (y < 0) {
                y = mouseY + 20;
            }
            
            tooltip.style.left = x + 'px';
            tooltip.style.top = y + 'px';
            tooltip.style.display = 'block';
        }
        
        function hideTooltip() {
            document.getElementById('atom-tooltip').style.display = 'none';
        }
        
        // FUNCIÓN CORREGIDA - setStyle con Stick y Ball & Stick funcionando correctamente
        function setStyle(style) {
            if (!structureComponent) {
                console.warn('Structure not loaded yet');
                return;
            }
            
            currentStyle = style;
            
            // Remover TODAS las representaciones existentes
            structureComponent.removeAllRepresentations();
            labelRepresentation = null;
            
            // Crear nueva representación según el estilo
            switch(style) {
                case 'stick':
                    // Stick puro: líneas delgadas sin esferas visibles
                    representation = structureComponent.addRepresentation('licorice', {
                        colorScheme: 'element',
                        radius: 0.15,
                        multipleBond: 'symmetric'
                    });
                    break;
                    
                case 'ball-and-stick':
                    // Ball & Stick CORREGIDO: usar 'ball+stick' con parámetros correctos
                    representation = structureComponent.addRepresentation('ball+stick', {
                        aspectRatio: 1.5,
                        radiusSize: 0.3,
                        ballScale: 0.5,
                        colorScheme: 'element',
                        multipleBond: 'symmetric'
                    });
                    break;
                    
                case 'line':
                    representation = structureComponent.addRepresentation('line', {
                        colorScheme: 'element',
                        linewidth: 2
                    });
                    break;
                    
                case 'spacefill':
                    representation = structureComponent.addRepresentation('spacefill', {
                        colorScheme: 'element'
                    });
                    break;
            }
            
            // Restaurar labels si estaban activos
            if (labelsVisible) {
                setTimeout(function() {
                    addLabels();
                }, 50);
            }
            
            updateActiveButton(style);
        }
        
        function updateActiveButton(style) {
            // Quitar active de todos
            var buttons = document.querySelectorAll('.controls-bar button');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Mapeo de estilos a IDs de botones
            var btnMap = {
                'stick': 'btn-stick',
                'ball-and-stick': 'btn-ballstick',
                'line': 'btn-line',
                'spacefill': 'btn-spacefill'
            };
            
            var btnId = btnMap[style];
            if (btnId) {
                var btn = document.getElementById(btnId);
                if (btn) btn.classList.add('active');
            }
        }
        
        function toggleSpin() {
            if (!stage) return;
            isSpinning = !isSpinning;
            
            if (isSpinning) {
                stage.setSpin(true);
            } else {
                stage.setSpin(false);
            }
            
            var btn = document.getElementById('btn-spin');
            btn.classList.toggle('active', isSpinning);
            btn.innerHTML = isSpinning ? '<span>⏹</span> Stop' : '<span>🔄</span> Spin';
        }
        
        function resetView() {
            if (!stage) return;
            stage.autoView();
        }
        
        function toggleLabels() {
            if (!structureComponent) return;
            labelsVisible = !labelsVisible;
            
            var btn = document.getElementById('btn-labels');
            btn.classList.toggle('active', labelsVisible);
            
            if (labelsVisible) {
                addLabels();
            } else {
                removeLabels();
            }
        }
        
        function addLabels() {
            if (!structureComponent || !atomDataList.length) return;
            
            // Eliminar labels anteriores si existen
            if (labelRepresentation) {
                structureComponent.removeRepresentation(labelRepresentation);
            }
            
            // Crear array de labels
            var labelText = [];
            var labelPosition = [];
            
            atomDataList.forEach(function(atom) {
                labelText.push(atom.atomNumber.toString());
                labelPosition.push([atom.x, atom.y, atom.z]);
            });
            
            labelRepresentation = structureComponent.addRepresentation('label', {
                labelType: 'text',
                labelText: labelText,
                position: labelPosition,
                color: 'white',
                backgroundColor: 'black',
                backgroundOpacity: 0.8,
                borderColor: '#00d4ff',
                borderWidth: 0.5,
                radiusSize: 1.5,
                showBackground: true,
                zOffset: 2
            });
        }
        
        function removeLabels() {
            if (labelRepresentation) {
                structureComponent.removeRepresentation(labelRepresentation);
                labelRepresentation = null;
            }
        }
        
        function show2DFallback() {
            hideLoading();
            updateStatus('error', '2D only');
            // Ocultar visor NGL y mostrar JSME 2D
            document.getElementById('viewport').style.display = 'none';
            document.querySelector('.controls-bar').style.display = 'none';

            var jmeData = "{{ $molecule->jmeDisplacement ?? $molecule->smiles ?? '' }}";
            var fallbackDiv = document.createElement('div');
            fallbackDiv.style.cssText = 'width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#111;padding:20px;';
            fallbackDiv.innerHTML =
                '<p style="color:#aaa;margin-bottom:12px;font-size:13px;">⚠️ 3D not available — showing 2D structure</p>' +
                '<div id="jsme_fallback" style="width:500px;height:400px;"></div>';
            document.getElementById('viewer-panel-inner').appendChild(fallbackDiv);

            // Cargar JSME con la molécula en 2D
            if (typeof JSApplet !== 'undefined' && jmeData) {
                var app = new JSApplet.JSME("jsme_fallback", "500px", "400px", {"options":"depict"});
                setTimeout(function(){ app.readMolecule(jmeData); }, 600);
            }
        }

        function updateStatus(type, message) {
            var badge = document.getElementById('status-badge');
            badge.className = 'status-badge ' + type;
            badge.textContent = message;
        }
        
        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
        }
        
        function showError(title, detail) {
            hideLoading();
            document.getElementById('viewport').innerHTML = 
                '<div class="error-message">' +
                '<div class="icon">⚠️</div>' +
                '<h2>' + (title || 'Error') + '</h2>' +
                '<p>' + (detail || 'An error occurred') + '</p>' +
                '<button onclick="location.reload()">🔄 Retry</button>' +
                '</div>';
        }
    </script>
</body>
</html>