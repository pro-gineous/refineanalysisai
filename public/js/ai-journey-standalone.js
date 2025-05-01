/**
 * AI Journey Standalone Visualization
 * Sistema independiente que funciona sin depender de elementos DOM preexistentes
 * Solución definitiva para el error "The deferred DOM Node could not be resolved to a valid node"
 */

(function() {
    // ------------------ CONFIGURACIÓN INICIAL ------------------
    console.log('🚀 Iniciando sistema autónomo de visualización AI Journey...');
    
    // Crear espacio de nombres para evitar conflictos
    window.AIJourneyStandalone = {
        initialized: false,
        container: null,
        visualizationArea: null,
        currentFramework: null,
        eventHandlers: {},
        processMaps: {}
    };
    
    // ------------------ INICIALIZACIÓN SEGURA ------------------
    
    // Función para inicializar todo el sistema autónomo
    function initialize() {
        if (window.AIJourneyStandalone.initialized) {
            console.log('Sistema ya inicializado');
            return;
        }
        
        console.log('Iniciando inicialización segura...');
        
        // Crear contenedor root si no existe o encontrar un lugar donde ponerlo
        createRootContainer();
        
        // Registrar eventos globales
        setupEventListeners();
        
        // Inicializar mapas de procesos
        initializeProcessMaps();
        
        window.AIJourneyStandalone.initialized = true;
        console.log('✅ Sistema autónomo inicializado correctamente');
    }
    
    // Función para crear el contenedor raíz
    function createRootContainer() {
        // Buscar el lugar más apropiado para insertar nuestro contenedor
        let targetContainer = findSuitableContainer();
        
        // Crear contenedor principal con todos los elementos necesarios
        const container = document.createElement('div');
        container.className = 'ai-journey-standalone mt-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200';
        container.innerHTML = `
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Visualización del Proceso</h3>
                <div class="flex space-x-2">
                    <button id="standalone-process-map" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                        Ver Mapa de Proceso
                    </button>
                    <button id="standalone-data-model" class="px-3 py-1 text-sm bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">
                        Ver Modelo de Datos
                    </button>
                </div>
            </div>
            <div id="standalone-visualization-area" class="border rounded-lg p-4 bg-gray-50 min-h-[300px] flex items-center justify-center">
                <div id="standalone-placeholder" class="text-gray-500 text-center">
                    <p>Selecciona un framework y haz clic en una opción de visualización</p>
                </div>
            </div>
        `;
        
        // Insertar en el lugar apropiado del DOM
        targetContainer.appendChild(container);
        
        // Guardar referencia
        window.AIJourneyStandalone.container = container;
        window.AIJourneyStandalone.visualizationArea = container.querySelector('#standalone-visualization-area');
        
        console.log('✅ Contenedor autónomo creado exitosamente');
    }
    
    // Encontrar el lugar más adecuado para insertar nuestro contenedor
    function findSuitableContainer() {
        // Opciones ordenadas por prioridad
        const containers = [
            document.querySelector('.ai-journey-container'),
            document.querySelector('.process-visualization-panel'),
            document.querySelector('.w-full.lg\\:w-3\\/4'),
            document.querySelector('main .container'),
            document.getElementById('app'),
            document.body
        ];
        
        // Usar el primer contenedor válido
        for (const container of containers) {
            if (container) {
                console.log('Contenedor encontrado:', container.tagName || 'unknown');
                return container;
            }
        }
        
        // Si no encontramos ninguno, usar body
        console.log('⚠️ No se encontró contenedor específico, usando body');
        return document.body;
    }
    
    // Configurar los event listeners
    function setupEventListeners() {
        const container = window.AIJourneyStandalone.container;
        if (!container) return;
        
        // Botón de mapa de proceso
        const processMapBtn = container.querySelector('#standalone-process-map');
        if (processMapBtn) {
            processMapBtn.addEventListener('click', function() {
                showProcessMap();
            });
            
            // Guardar referencia
            window.AIJourneyStandalone.eventHandlers.processMap = processMapBtn;
        }
        
        // Botón de modelo de datos
        const dataModelBtn = container.querySelector('#standalone-data-model');
        if (dataModelBtn) {
            dataModelBtn.addEventListener('click', function() {
                showDataModel();
            });
            
            // Guardar referencia
            window.AIJourneyStandalone.eventHandlers.dataModel = dataModelBtn;
        }
        
        // Detectar cambios en el selector de framework original
        const frameworkSelector = document.getElementById('framework-selector');
        if (frameworkSelector) {
            frameworkSelector.addEventListener('change', function() {
                window.AIJourneyStandalone.currentFramework = this.value;
                console.log('Framework cambiado a:', this.value);
            });
        }
        
        console.log('✅ Event listeners configurados');
    }
    
    // ------------------ MAPAS DE PROCESOS ------------------
    
    // Inicializar mapas de procesos disponibles
    function initializeProcessMaps() {
        // Definir mapas de proceso para cada framework
        window.AIJourneyStandalone.processMaps = {
            'prince2': createPRINCE2ProcessMap(),
            'idea-management': createIdeaManagementProcessMap(),
            'scrum': createGenericProcessMap('Scrum'),
            'six-sigma': createGenericProcessMap('Six Sigma'),
            'togaf': createGenericProcessMap('TOGAF'),
            'itil': createGenericProcessMap('ITIL'),
            'lean-startup': createGenericProcessMap('Lean Startup'),
            'functional-test': createGenericProcessMap('Functional Testing'),
            'usability-test': createGenericProcessMap('Usability Testing'),
            'performance-test': createGenericProcessMap('Performance Testing')
        };
        
        // Definir modelos de datos para cada framework
        window.AIJourneyStandalone.dataModels = {
            'prince2': createDataModel('PRINCE2'),
            'idea-management': createDataModel('Idea Management'),
            'scrum': createDataModel('Scrum'),
            'six-sigma': createDataModel('Six Sigma'),
            'togaf': createDataModel('TOGAF'),
            'itil': createDataModel('ITIL'),
            'lean-startup': createDataModel('Lean Startup')
        };
        
        console.log('✅ Mapas de proceso inicializados');
    }
    
    // Mostrar mapa de proceso según el framework seleccionado
    function showProcessMap() {
        const visualizationArea = window.AIJourneyStandalone.visualizationArea;
        if (!visualizationArea) return;
        
        // Obtener framework actual
        const framework = getSelectedFramework();
        if (!framework) {
            visualizationArea.innerHTML = `
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 text-yellow-700">
                    <p>Por favor selecciona un framework primero.</p>
                </div>
            `;
            return;
        }
        
        // Mostrar animación de carga
        visualizationArea.innerHTML = `
            <div class="flex justify-center items-center h-full">
                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-green-500"></div>
            </div>
        `;
        
        // Simular tiempo de procesamiento y mostrar el mapa
        setTimeout(function() {
            // Obtener el mapa de proceso correspondiente
            const processMap = window.AIJourneyStandalone.processMaps[framework];
            
            if (processMap) {
                visualizationArea.innerHTML = `
                    <div class="text-center">
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Mapa de Proceso: ${getFrameworkDisplayName(framework)}</h4>
                        <div class="process-map-container overflow-auto">
                            ${processMap}
                        </div>
                    </div>
                `;
            } else {
                visualizationArea.innerHTML = `
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 text-red-700">
                        <p>No se pudo generar el mapa de proceso para ${framework}.</p>
                    </div>
                `;
            }
        }, 1000);
    }
    
    // Mostrar modelo de datos según el framework seleccionado
    function showDataModel() {
        const visualizationArea = window.AIJourneyStandalone.visualizationArea;
        if (!visualizationArea) return;
        
        // Obtener framework actual
        const framework = getSelectedFramework();
        if (!framework) {
            visualizationArea.innerHTML = `
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 text-yellow-700">
                    <p>Por favor selecciona un framework primero.</p>
                </div>
            `;
            return;
        }
        
        // Mostrar animación de carga
        visualizationArea.innerHTML = `
            <div class="flex justify-center items-center h-full">
                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-purple-500"></div>
            </div>
        `;
        
        // Simular tiempo de procesamiento y mostrar el modelo
        setTimeout(function() {
            // Obtener el modelo de datos correspondiente
            const dataModel = window.AIJourneyStandalone.dataModels[framework];
            
            if (dataModel) {
                visualizationArea.innerHTML = `
                    <div class="text-center">
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Modelo de Datos: ${getFrameworkDisplayName(framework)}</h4>
                        <div class="data-model-container overflow-auto">
                            ${dataModel}
                        </div>
                    </div>
                `;
            } else {
                visualizationArea.innerHTML = `
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 text-red-700">
                        <p>No se pudo generar el modelo de datos para ${framework}.</p>
                    </div>
                `;
            }
        }, 1000);
    }
    
    // Obtener el framework seleccionado de múltiples fuentes posibles
    function getSelectedFramework() {
        // Primera opción: framework guardado en nuestro namespace
        if (window.AIJourneyStandalone.currentFramework) {
            return window.AIJourneyStandalone.currentFramework;
        }
        
        // Segunda opción: framework guardado en window global (compatibilidad)
        if (window.currentFramework) {
            return window.currentFramework;
        }
        
        // Tercera opción: obtener del selector de framework
        const frameworkSelector = document.getElementById('framework-selector');
        if (frameworkSelector && frameworkSelector.value) {
            // Guardar para uso futuro
            window.AIJourneyStandalone.currentFramework = frameworkSelector.value;
            return frameworkSelector.value;
        }
        
        return null;
    }
    
    // Convertir ID de framework a nombre de visualización
    function getFrameworkDisplayName(frameworkId) {
        const displayNames = {
            'prince2': 'PRINCE2',
            'idea-management': 'Idea Management',
            'scrum': 'Scrum',
            'six-sigma': 'Six Sigma',
            'togaf': 'TOGAF',
            'itil': 'ITIL',
            'lean-startup': 'Lean Startup',
            'functional-test': 'Functional Testing',
            'usability-test': 'Usability Testing',
            'performance-test': 'Performance Testing'
        };
        
        return displayNames[frameworkId] || frameworkId;
    }
    
    // ------------------ IMPLEMENTACIONES DE MAPAS ------------------
    
    // PRINCE2 Process Map
    function createPRINCE2ProcessMap() {
        return `
        <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
            <style>
                .box { fill: #E5E7EB; stroke: #4F46E5; stroke-width: 2; }
                .arrow { stroke: #6D28D9; stroke-width: 2; fill: none; marker-end: url(#arrowhead); }
                .label { font-family: Arial; font-size: 12px; fill: #1F2937; text-anchor: middle; }
                .title { font-family: Arial; font-size: 14px; font-weight: bold; fill: #4338CA; text-anchor: middle; }
            </style>
            <defs>
                <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="#6D28D9" />
                </marker>
            </defs>
            <rect x="10" y="50" width="120" height="60" rx="5" class="box" />
            <text x="70" y="85" class="label">Starting up a Project</text>

            <rect x="170" y="50" width="120" height="60" rx="5" class="box" />
            <text x="230" y="85" class="label">Directing a Project</text>
            
            <rect x="330" y="50" width="120" height="60" rx="5" class="box" />
            <text x="390" y="85" class="label">Initiating a Project</text>
            
            <rect x="490" y="50" width="120" height="60" rx="5" class="box" />
            <text x="550" y="85" class="label">Controlling a Stage</text>
            
            <rect x="650" y="50" width="120" height="60" rx="5" class="box" />
            <text x="710" y="85" class="label">Managing Product Delivery</text>
            
            <rect x="330" y="150" width="120" height="60" rx="5" class="box" />
            <text x="390" y="185" class="label">Managing Stage Boundaries</text>
            
            <rect x="490" y="150" width="120" height="60" rx="5" class="box" />
            <text x="550" y="185" class="label">Closing a Project</text>
            
            <path d="M130 80 L170 80" class="arrow" />
            <path d="M290 80 L330 80" class="arrow" />
            <path d="M450 80 L490 80" class="arrow" />
            <path d="M610 80 L650 80" class="arrow" />
            <path d="M550 110 L550 150" class="arrow" />
            <path d="M450 180 L490 180" class="arrow" />
            <path d="M390 150 L390 110" class="arrow" />
            <path d="M650 120 C650 230, 450 230, 450 180" class="arrow" />
            
            <text x="400" y="20" class="title">PRINCE2 Process Model</text>
        </svg>
        `;
    }
    
    // Idea Management Process Map
    function createIdeaManagementProcessMap() {
        return `
        <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
            <style>
                .box { fill: #E0F2FE; stroke: #0284C7; stroke-width: 2; }
                .arrow { stroke: #0369A1; stroke-width: 2; fill: none; marker-end: url(#arrowhead); }
                .label { font-family: Arial; font-size: 12px; fill: #0C4A6E; text-anchor: middle; }
                .title { font-family: Arial; font-size: 14px; font-weight: bold; fill: #0369A1; text-anchor: middle; }
            </style>
            <defs>
                <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="#0369A1" />
                </marker>
            </defs>
            
            <circle cx="70" cy="80" r="40" class="box" />
            <text x="70" y="85" class="label">Idea Generation</text>
            
            <rect x="160" y="50" width="100" height="60" rx="5" class="box" />
            <text x="210" y="85" class="label">Idea Collection</text>
            
            <rect x="310" y="50" width="100" height="60" rx="5" class="box" />
            <text x="360" y="85" class="label">Initial Screening</text>
            
            <rect x="460" y="50" width="100" height="60" rx="5" class="box" />
            <text x="510" y="85" class="label">Evaluation</text>
            
            <polygon points="600,50 670,50 685,80 670,110 600,110" class="box" />
            <text x="635" y="85" class="label">Decision</text>
            
            <rect x="460" y="150" width="100" height="60" rx="5" class="box" />
            <text x="510" y="185" class="label">Implementation</text>
            
            <circle cx="635" cy="180" r="40" class="box" />
            <text x="635" y="185" class="label">Results & Feedback</text>
            
            <path d="M110 80 L160 80" class="arrow" />
            <path d="M260 80 L310 80" class="arrow" />
            <path d="M410 80 L460 80" class="arrow" />
            <path d="M560 80 L600 80" class="arrow" />
            <path d="M635 110 L635 140" class="arrow" />
            <path d="M595 180 L510 180" class="arrow" />
            <path d="M460 180 L360 180" class="arrow" />
            <path d="M360 180 L360 110" class="arrow" />
            
            <text x="400" y="20" class="title">Idea Management Process</text>
        </svg>
        `;
    }
    
    // Generic Process Map for other frameworks
    function createGenericProcessMap(framework) {
        return `
        <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
            <style>
                .box { fill: #F3F4F6; stroke: #10B981; stroke-width: 2; }
                .arrow { stroke: #059669; stroke-width: 2; fill: none; marker-end: url(#arrowhead); }
                .label { font-family: Arial; font-size: 12px; fill: #064E3B; text-anchor: middle; }
                .title { font-family: Arial; font-size: 14px; font-weight: bold; fill: #047857; text-anchor: middle; }
            </style>
            <defs>
                <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="#059669" />
                </marker>
            </defs>
            
            <rect x="50" y="80" width="120" height="60" rx="5" class="box" />
            <text x="110" y="115" class="label">Stage 1: Planning</text>
            
            <rect x="240" y="80" width="120" height="60" rx="5" class="box" />
            <text x="300" y="115" class="label">Stage 2: Analysis</text>
            
            <rect x="430" y="80" width="120" height="60" rx="5" class="box" />
            <text x="490" y="115" class="label">Stage 3: Implementation</text>
            
            <rect x="620" y="80" width="120" height="60" rx="5" class="box" />
            <text x="680" y="115" class="label">Stage 4: Evaluation</text>
            
            <path d="M170 110 L240 110" class="arrow" />
            <path d="M360 110 L430 110" class="arrow" />
            <path d="M550 110 L620 110" class="arrow" />
            <path d="M680 140 L680 180 L110 180 L110 140" class="arrow" />
            
            <text x="400" y="35" class="title">${framework} Process Model</text>
            <text x="400" y="220" class="label">Process Flow Visualization</text>
        </svg>
        `;
    }
    
    // Data Model visualization for frameworks
    function createDataModel(framework) {
        return `
        <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
            <style>
                .entity { fill: #EFF6FF; stroke: #2563EB; stroke-width: 2; }
                .relation { stroke: #3B82F6; stroke-width: 1.5; fill: none; marker-end: url(#arrowhead); }
                .label { font-family: Arial; font-size: 12px; fill: #1E3A8A; text-anchor: middle; }
                .title { font-family: Arial; font-size: 14px; font-weight: bold; fill: #1D4ED8; text-anchor: middle; }
                .field { font-family: Arial; font-size: 10px; fill: #3B82F6; text-anchor: middle; }
            </style>
            <defs>
                <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="#3B82F6" />
                </marker>
            </defs>
            
            <rect x="120" y="50" width="140" height="80" rx="5" class="entity" />
            <text x="190" y="75" class="label">Project</text>
            <text x="190" y="95" class="field">id, name, status, start_date</text>
            <text x="190" y="110" class="field">budget, timeline, owner_id</text>
            
            <rect x="400" y="50" width="140" height="80" rx="5" class="entity" />
            <text x="470" y="75" class="label">Deliverable</text>
            <text x="470" y="95" class="field">id, name, description, due_date</text>
            <text x="470" y="110" class="field">status, project_id, assigned_to</text>
            
            <rect x="120" y="180" width="140" height="80" rx="5" class="entity" />
            <text x="190" y="205" class="label">Resource</text>
            <text x="190" y="225" class="field">id, name, role, department</text>
            <text x="190" y="240" class="field">availability, skills, cost</text>
            
            <rect x="400" y="180" width="140" height="80" rx="5" class="entity" />
            <text x="470" y="205" class="label">Risk</text>
            <text x="470" y="225" class="field">id, description, probability</text>
            <text x="470" y="240" class="field">impact, project_id, mitigation</text>
            
            <path d="M260 90 L400 90" class="relation" />
            <path d="M190 130 L190 180" class="relation" />
            <path d="M470 130 L470 180" class="relation" />
            <path d="M260 220 C330 220, 330 160, 400 160, 400 190" class="relation" />
            
            <text x="400" y="20" class="title">${framework} Data Model</text>
        </svg>
        `;
    }
    
    // ------------------ INICIAR EL SISTEMA ------------------
    
    // Esperar a que el DOM esté completamente cargado
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        // Si el DOM ya está cargado, inicializar inmediatamente
        initialize();
    }
    
    // También intentar después de un tiempo para asegurar que todo esté cargado
    setTimeout(initialize, 1000);
    
    // Exponer funciones públicas
    window.AIJourneyStandalone.showProcessMap = showProcessMap;
    window.AIJourneyStandalone.showDataModel = showDataModel;
})();
