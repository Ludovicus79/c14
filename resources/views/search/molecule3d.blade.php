<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>3D Molecule - {{ $molecule->name ?? 'Molecule' }}</title>
    
    <!-- 3Dmol.js -->
    <script src="https://3Dmol.csb.pitt.edu/build/3Dmol-min.js"></script>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 100%);
            min-height: 100vh;
            color: white;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        h1 {
            margin: 0 0 10px 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .meta {
            color: #888;
            font-size: 14px;
        }
        
        .meta span {
            margin-right: 20px;
        }
        
        .btn-close {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s;
            flex-shrink: 0;
        }
        
        .btn-close:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }
        
        .viewer-container {
            background: #000;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0,0,0,0.6);
            height: 650px;
            position: relative;
        }
        
        #viewport {
            width: 100%;
            height: 100%;
            position: relative;
        }
        
        /* IMPORTANTE: El canvas debe tener pointer-events activos */
        #viewport canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }
        
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 10;
        }
        
        .loading .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255,255,255,0.1);
            border-top: 4px solid #00d4ff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Controles horizontales tipo Molstar */
        .controls {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            background: rgba(10,10,30,0.95);
            padding: 14px 20px;
            border-radius: 14px;
            backdrop-filter: blur(20px);
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            z-index: 100;
        }
        
        .controls::-webkit-scrollbar {
            height: 6px;
        }
        
        .controls::-webkit-scrollbar-thumb {
            background: rgba(0,212,255,0.5);
            border-radius: 3px;
        }
        
        .controls button {
            background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
            border: 1px solid rgba(255,255,255,0.15);
            color: white;
            padding: 12px 22px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }
        
        .controls button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .controls button:hover::before {
            left: 100%;
        }
        
        .controls button:hover {
            background: linear-gradient(145deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,212,255,0.3);
            border-color: rgba(0,212,255,0.5);
        }
        
        .controls button.active {
            background: linear-gradient(145deg, #00d4ff, #0099cc);
            border-color: #00d4ff;
            box-shadow: 0 5px 20px rgba(0,212,255,0.4);
        }
        
        /* Info panel */
        .info-panel {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(10,10,30,0.95);
            padding: 20px;
            border-radius: 14px;
            backdrop-filter: blur(20px);
            min-width: 240px;
            max-width: 320px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            z-index: 100;
        }
        
        .info-panel h3 {
            margin: 0 0 15px 0;
            font-size: 13px;
            color: #00d4ff;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }
        
        .atom-info {
            font-size: 12px;
            color: #aaa;
            line-height: 1.8;
        }
        
        .atom-info .label {
            color: #666;
            display: inline-block;
            width: 80px;
        }
        
        .atom-info .value {
            color: #fff;
            font-weight: 500;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 12px;
            letter-spacing: 1px;
        }
        
        .status-badge.loading {
            background: linear-gradient(145deg, #f39c12, #e67e22);
            color: #000;
        }
        
        .status-badge.ready {
            background: linear-gradient(145deg, #00d4ff, #0099cc);
            color: #000;
        }
        
        .status-badge.error {
            background: linear-gradient(145deg, #e74c3c, #c0392b);
            color: white;
        }
        
        /* Tooltip - POSICIONADO EN PANTALLA */
        .atom-tooltip {
            position: fixed;
            background: rgba(10,10,30,0.98);
            border: 2px solid #00d4ff;
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            font-size: 13px;
            pointer-events: none;
            display: none;
            z-index: 10000;
            box-shadow: 0 15px 50px rgba(0,212,255,0.5);
            min-width: 220px;
            backdrop-filter: blur(20px);
        }
        
        .atom-tooltip .atom-header {
            font-size: 16px;
            font-weight: bold;
            color: #00d4ff;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0,212,255,0.3);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .atom-tooltip .atom-number {
            background: #00d4ff;
            color: #000;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 12px;
        }
        
        .atom-tooltip .coord-section {
            margin-top: 8px;
        }
        
        .atom-tooltip .coord-label {
            color: #00d4ff;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .atom-tooltip .coord-line {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
            padding: 6px 10px;
            background: rgba(255,255,255,0.1);
            border-radius: 6px;
        }
        
        .atom-tooltip .coord-axis {
            color: #888;
            font-weight: 600;
            min-width: 25px;
        }
        
        .atom-tooltip .coord-value {
            color: white;
            font-weight: 500;
            font-family: 'SF Mono', 'Courier New', monospace;
            font-size: 13px;
        }
        
        /* Error message */
        .error-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 10;
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
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .error-message button:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>{{ $molecule->name ?? 'Molecule' }}</h1>
                <div class="meta">
                    @if(isset($molecule->molecularFormula))
                    <span><strong>Formula:</strong> {{ $molecule->molecularFormula }}</span>
                    @endif
                    @if(isset($molecule->molecularWeight))
                    <span><strong>MW:</strong> {{ $molecule->molecularWeight }}</span>
                    @endif
                </div>
            </div>
            <button class="btn-close" onclick="window.close()">✕ Close</button>
        </div>
        
        <div class="viewer-container">
            <div id="viewport">
                <div id="loading" class="loading">
                    <div class="spinner"></div>
                    <div style="color: #00d4ff; font-weight: 600;">Loading 3D structure...</div>
                </div>
            </div>
            
            <!-- Controles -->
            <div class="controls">
                <button id="btn-stick" class="active" onclick="setStyle('stick')">🥢 Stick</button>
                <button id="btn-ballstick" onclick="setStyle('ball-and-stick')">⚪ Ball & Stick</button>
                <button id="btn-line" onclick="setStyle('line')">📏 Line</button>
                <button id="btn-spacefill" onclick="setStyle('spacefill')">🔮 Spacefill</button>
                <button id="btn-spin" onclick="toggleSpin()">🔄 Spin</button>
                <button onclick="resetView()">🎯 Reset</button>
                <button id="btn-labels" onclick="toggleLabels()">🏷️ Labels</button>
            </div>
            
            <!-- Panel de información -->
            <div class="info-panel">
                <h3>📊 Structure Info</h3>
                <div class="atom-info">
                    <div><span class="label">Atoms:</span> <span class="value" id="atom-count">-</span></div>
                    <div><span class="label">Bonds:</span> <span class="value" id="bond-count">-</span></div>
                    <div><span class="label">Source:</span> <span class="value" id="source-info">-</span></div>
                </div>
                <div id="status-badge" class="status-badge loading">Loading</div>
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
        </div>
    </div>

    <script>
        var viewer;
        var currentStyle = 'stick';
        var structureLoaded = false;
        var isSpinning = false;
        var labelsVisible = false;
        var atomDataList = [];
        var model = null;
        
        var smilesData = "{{ $molecule->smiles ?? '' }}";

        window.onload = function() {
            initViewer();
        };
        
        function initViewer() {
            var element = document.getElementById('viewport');
            var config = { 
                backgroundColor: 'black',
                antialias: true
            };
            viewer = $3Dmol.createViewer(element, config);
            
            if (smilesData) {
                loadFromSMILES(smilesData);
            } else {
                showError('No structure available', 'SMILES data not found');
            }
        }
        
        function loadFromSMILES(smiles) {
            updateStatus('loading', 'Fetching...');
            
            fetch('https://cactus.nci.nih.gov/chemical/structure/' + encodeURIComponent(smiles) + '/sdf')
                .then(response => {
                    if (!response.ok) throw new Error('Failed to fetch');
                    return response.text();
                })
                .then(sdf => {
                    loadStructure(sdf, 'NCI Cactus');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Failed to load 3D structure', 'Could not generate structure from SMILES');
                });
        }
        
        function loadStructure(sdfData, source) {
            try {
                var info = parseSDFInfo(sdfData);
                document.getElementById('atom-count').textContent = info.atoms || '?';
                document.getElementById('bond-count').textContent = info.bonds || '?';
                document.getElementById('source-info').textContent = source;
                
                viewer.clear();
                model = viewer.addModel(sdfData, 'sdf');
                
                // Guardar referencia a los átomos
                atomDataList = model.selectedAtoms({});
                
                setStyle('stick');
                viewer.zoomTo();
                viewer.render();
                
                structureLoaded = true;
                updateStatus('ready', 'Ready');
                hideLoading();
                
                // Configurar eventos de mouse manualmente
                setupMouseTracking();
                
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
        
        // Configurar tracking de mouse manual
        function setupMouseTracking() {
            var canvas = document.querySelector('#viewport canvas');
            var tooltip = document.getElementById('atom-tooltip');
            
            if (!canvas || !viewer) return;
            
            // Variables para control
            var isDragging = false;
            var mouseDown = false;
            
            canvas.addEventListener('mousedown', function() {
                mouseDown = true;
                isDragging = false;
            });
            
            canvas.addEventListener('mousemove', function(e) {
                if (mouseDown) isDragging = true;
                
                // Solo mostrar tooltip si no está arrastrando
                if (!isDragging && structureLoaded) {
                    checkAtomUnderMouse(e);
                }
            });
            
            canvas.addEventListener('mouseup', function() {
                mouseDown = false;
                setTimeout(function() { isDragging = false; }, 50);
            });
            
            canvas.addEventListener('mouseleave', function() {
                hideTooltip();
                mouseDown = false;
                isDragging = false;
            });
        }
        
        // Verificar qué átomo está bajo el cursor
        function checkAtomUnderMouse(e) {
            if (!viewer || !model) return;
            
            var canvas = document.querySelector('#viewport canvas');
            var rect = canvas.getBoundingClientRect();
            
            // Calcular posición relativa al canvas
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;
            
            // Usar el método de picking de 3Dmol
            var atoms = model.selectedAtoms({});
            var closestAtom = null;
            var closestDist = Infinity;
            var threshold = 30; // Radio de detección en píxeles
            
            for (var i = 0; i < atoms.length; i++) {
                var atom = atoms[i];
                
                // Proyección 3D a 2D
                var screenPos = viewer.modelToScreen(atom);
                
                if (screenPos) {
                    var dx = screenPos.x - x;
                    var dy = screenPos.y - y;
                    var dist = Math.sqrt(dx * dx + dy * dy);
                    
                    if (dist < threshold && dist < closestDist) {
                        closestDist = dist;
                        closestAtom = atom;
                        closestAtom.index = i; // Guardar índice
                    }
                }
            }
            
            if (closestAtom) {
                showTooltip(closestAtom, e);
            } else {
                hideTooltip();
            }
        }
        
        function showTooltip(atom, event) {
            var tooltip = document.getElementById('atom-tooltip');
            
            // Actualizar contenido
            document.getElementById('tooltip-atom-num').textContent = (atom.index + 1);
            document.getElementById('tooltip-element').textContent = atom.elem || 'C';
            document.getElementById('tooltip-x').textContent = atom.x.toFixed(3);
            document.getElementById('tooltip-y').textContent = atom.y.toFixed(3);
            document.getElementById('tooltip-z').textContent = atom.z.toFixed(3);
            
            // Posicionar tooltip
            var x = event.clientX + 20;
            var y = event.clientY - 100;
            
            // Evitar salir de pantalla
            if (x + 240 > window.innerWidth) x = event.clientX - 260;
            if (y < 0) y = event.clientY + 20;
            
            tooltip.style.left = x + 'px';
            tooltip.style.top = y + 'px';
            tooltip.style.display = 'block';
        }
        
        function hideTooltip() {
            document.getElementById('atom-tooltip').style.display = 'none';
        }
        
        function setStyle(style) {
            if (!viewer || !structureLoaded) return;
            
            currentStyle = style;
            viewer.removeAllLabels();
            viewer.setStyle({}, {});
            
            switch(style) {
                case 'stick':
                    viewer.setStyle({}, {
                        stick: { radius: 0.15, colorscheme: 'rasmol' }
                    });
                    break;
                case 'ball-and-stick':
                    viewer.setStyle({}, {
                        sphere: { scale: 0.3, colorscheme: 'rasmol' },
                        stick: { radius: 0.2, colorscheme: 'rasmol' }
                    });
                    break;
                case 'line':
                    viewer.setStyle({}, {
                        line: { linewidth: 2, colorscheme: 'rasmol' }
                    });
                    break;
                case 'spacefill':
                    viewer.setStyle({}, {
                        sphere: { scale: 1.0, colorscheme: 'rasmol' }
                    });
                    break;
            }
            
            if (labelsVisible) addLabels();
            viewer.render();
            updateActiveButton(style);
        }
        
        function updateActiveButton(style) {
            var buttons = document.querySelectorAll('.controls button');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            var btnMap = {
                'stick': 'btn-stick',
                'ball-and-stick': 'btn-ballstick',
                'line': 'btn-line',
                'spacefill': 'btn-spacefill'
            };
            
            var btn = document.getElementById(btnMap[style]);
            if (btn) btn.classList.add('active');
        }
        
        function toggleSpin() {
            if (!viewer) return;
            isSpinning = !isSpinning;
            viewer.spin(isSpinning);
            
            var btn = document.getElementById('btn-spin');
            btn.classList.toggle('active', isSpinning);
            btn.innerHTML = isSpinning ? '⏹ Stop' : '🔄 Spin';
        }
        
        function resetView() {
            if (!viewer) return;
            viewer.zoomTo();
            viewer.render();
        }
        
        function toggleLabels() {
            if (!viewer || !structureLoaded) return;
            labelsVisible = !labelsVisible;
            
            var btn = document.getElementById('btn-labels');
            btn.classList.toggle('active', labelsVisible);
            
            if (labelsVisible) {
                addLabels();
            } else {
                viewer.removeAllLabels();
            }
            viewer.render();
        }
        
        function addLabels() {
            if (!viewer || !atomDataList.length) return;
            
            for (var i = 0; i < atomDataList.length; i++) {
                var atom = atomDataList[i];
                
                viewer.addLabel((i + 1).toString(), {
                    position: atom,
                    backgroundColor: 'rgba(255,255,255,0.9)',
                    backgroundOpacity: 0.95,
                    fontColor: 'black',
                    fontSize: 14,
                    fontWeight: 'bold',
                    borderColor: '#00d4ff',
                    borderThickness: 1,
                    radius: 1.0,
                    inFront: true
                });
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