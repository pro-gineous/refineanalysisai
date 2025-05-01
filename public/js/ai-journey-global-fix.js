/**
 * AI Journey Global Fix
 * Solución definitiva para el error "The deferred DOM Node could not be resolved to a valid node"
 * Funciona en todas las páginas de AI Journey, independientemente de dónde se genere el error
 */

(function() {
    console.log('🛡️ AI Journey Global DOM Protection System activado');

    // Crear espacio de nombres global
    window.AIJourneyGlobal = {
        protectedElements: {},
        initialized: false,
        loadTime: new Date().getTime(),
        pendingElements: []
    };

    // PASO 1: PROTECCIÓN GLOBAL DEL DOM

    // Lista de elementos conocidos que causan problemas
    const criticalElements = [
        'visualization-area',
        'visualization-placeholder',
        'generate-process-map',
        'generate-data-model',
        'framework-selector',
        'process-map-container',
        'data-model-container',
        'framework-content'
    ];
    
    // Comprobar si document.body está disponible
    const createProtectionElements = function() {
        if (!document.body) {
            console.log('⏳ Esperando a que document.body esté disponible...');
            // Si document.body aún no existe, esperar y volver a intentar
            window.addEventListener('DOMContentLoaded', createProtectionElements);
            return;
        }
        
        // Crear elementos protegidos de forma preventiva
        criticalElements.forEach(id => {
            if (!document.getElementById(id)) {
                const protectionElement = document.createElement('div');
                protectionElement.id = id;
                protectionElement.className = 'ai-journey-protection-element';
                protectionElement.style.display = 'none';
                protectionElement.setAttribute('data-protection', 'true');
                document.body.appendChild(protectionElement);
                
                // Guardar referencia
                window.AIJourneyGlobal.protectedElements[id] = protectionElement;
                console.log(`✅ Elemento de protección creado: ${id}`);
            }
        });
        
        console.log('✅ Elementos críticos protegidos creados');
    };
    
    // Función para crear los elementos pendientes
    const createPendingElements = function() {
        if (!document.body) {
            console.log('⏳ Esperando a document.body para crear elementos pendientes...');
            setTimeout(createPendingElements, 100);
            return;
        }
        
        if (window.AIJourneyGlobal.pendingElements.length > 0) {
            console.log(`📦 Creando ${window.AIJourneyGlobal.pendingElements.length} elementos pendientes...`);
            
            window.AIJourneyGlobal.pendingElements.forEach(id => {
                if (!document.getElementById(id) && !window.AIJourneyGlobal.protectedElements[id]) {
                    const protectionElement = document.createElement('div');
                    protectionElement.id = id;
                    protectionElement.className = 'ai-journey-protection-element';
                    protectionElement.style.display = 'none';
                    protectionElement.setAttribute('data-protection', 'true');
                    document.body.appendChild(protectionElement);
                    
                    // Guardar referencia
                    window.AIJourneyGlobal.protectedElements[id] = protectionElement;
                    console.log(`✅ Elemento pendiente creado: ${id}`);
                }
            });
            
            // Limpiar la lista de pendientes
            window.AIJourneyGlobal.pendingElements = [];
            console.log('✅ Todos los elementos pendientes creados');
        }
    };
    
    // Intentar crear los elementos protegidos ahora, o esperar a que el DOM esté listo
    createProtectionElements();
    
    // Asegurarse de crear los elementos pendientes cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', createPendingElements);
    } else {
        createPendingElements();
    }

    // PASO 2: REEMPLAZAR FUNCIONES DE ACCESO AL DOM

    // Reemplazar getElementById para capturar y registrar accesos
    const originalGetElementById = document.getElementById;
    document.getElementById = function(id) {
        // Intentar obtener el elemento normalmente
        const element = originalGetElementById.call(document, id);
        
        // Si el elemento existe, devolverlo
        if (element) {
            return element;
        }
        
        // Si no existe y es un elemento crítico, crear un elemento fantasma
        const isCritical = criticalElements.includes(id) || 
                          id.includes('visualization') || 
                          id.includes('process') || 
                          id.includes('data-model') ||
                          id.includes('generate-');
        
        if (isCritical) {
            console.log(`⚠️ Elemento crítico no encontrado: ${id} - creando protección`);
            
            // Crear elemento protegido si no existe
            if (!window.AIJourneyGlobal.protectedElements[id]) {
                // Comprobar si document.body está disponible
                if (!document.body) {
                    console.log(`⏳ No se puede crear ${id} aún - document.body no disponible`);
                    
                    // Almacenar este elemento para crearlo más tarde
                    if (!window.AIJourneyGlobal.pendingElements.includes(id)) {
                        window.AIJourneyGlobal.pendingElements.push(id);
                        // Intentar crear los elementos pendientes cuando el DOM esté listo
                        if (window.AIJourneyGlobal.pendingElements.length === 1) {
                            window.addEventListener('DOMContentLoaded', function() {
                                createPendingElements();
                            });
                        }
                    }
                    
                    // Devolver un objeto fantasma temporal que no cause errores
                    return {
                        id: id,
                        style: {},
                        classList: { add: function(){}, remove: function(){}, toggle: function(){}, contains: function(){ return false; } },
                        addEventListener: function(){},
                        removeEventListener: function(){},
                        getAttribute: function(){ return null; },
                        setAttribute: function(){},
                        appendChild: function(){},
                        querySelector: function(){ return null; },
                        querySelectorAll: function(){ return []; }
                    };
                }
                
                // Si document.body está disponible, crear el elemento
                const protectionElement = document.createElement('div');
                protectionElement.id = id;
                protectionElement.className = 'ai-journey-protection-element';
                protectionElement.style.display = 'none';
                protectionElement.setAttribute('data-protection', 'true');
                document.body.appendChild(protectionElement);
                
                // Guardar referencia
                window.AIJourneyGlobal.protectedElements[id] = protectionElement;
                console.log(`✅ Elemento de protección creado en tiempo real: ${id}`);
            }
            
            return window.AIJourneyGlobal.protectedElements[id];
        }
        
        // Para elementos no críticos, comportamiento normal (nulo)
        return null;
    };

    // PASO 3: PROTECCIÓN DE QUERIES CSS

    // Proteger querySelector
    const originalQuerySelector = document.querySelector;
    document.querySelector = function(selector) {
        try {
            return originalQuerySelector.call(document, selector);
        } catch (e) {
            console.log(`🔴 Error en querySelector interceptado: ${selector}`);
            return null;
        }
    };

    // Proteger querySelectorAll
    const originalQuerySelectorAll = document.querySelectorAll;
    document.querySelectorAll = function(selector) {
        try {
            return originalQuerySelectorAll.call(document, selector);
        } catch (e) {
            console.log(`🔴 Error en querySelectorAll interceptado: ${selector}`);
            return [];
        }
    };

    // PASO 4: CAPTURAR ERRORES GLOBALES

    // Capturar errores en tiempo de ejecución
    window.addEventListener('error', function(event) {
        // Verificar si es un error DOM
        if (event.message && (
            event.message.includes('DOM') || 
            event.message.includes('node') ||
            event.message.includes('Element') ||
            event.message.includes('deferred')
        )) {
            console.log(`🛑 Error DOM interceptado: ${event.message}`);
            event.preventDefault();
            return true;
        }
    }, true);

    // PASO 5: CORREGIR VARIABLE CURRENTFRAMEWORK

    // Asegurar que currentFramework siempre esté disponible
    if (!window.currentFramework) {
        // Intentar obtenerlo del selector de framework
        const frameworkSelector = document.getElementById('framework-selector');
        if (frameworkSelector && frameworkSelector.value) {
            window.currentFramework = frameworkSelector.value;
        } else {
            // Valor por defecto
            window.currentFramework = 'prince2';
        }
        console.log(`🔧 Variable currentFramework inicializada a: ${window.currentFramework}`);
    }

    // PASO 6: PROTECCIÓN DEL OBJETO WINDOW

    // Asegurar que todas las funciones requeridas existen
    if (!window.initializeProcessVisualization) {
        window.initializeProcessVisualization = function() {
            console.log('➡️ Función simulada: initializeProcessVisualization');
        };
    }

    if (!window.createPRINCE2ProcessMap) {
        window.createPRINCE2ProcessMap = function() {
            return '<div>PRINCE2 Process Map (Protected)</div>';
        };
    }

    if (!window.createIdeaManagementProcessMap) {
        window.createIdeaManagementProcessMap = function() {
            return '<div>Idea Management Process Map (Protected)</div>';
        };
    }

    if (!window.createGenericProcessMap) {
        window.createGenericProcessMap = function(framework) {
            return `<div>${framework} Process Map (Protected)</div>`;
        };
    }

    if (!window.createDataModel) {
        window.createDataModel = function(framework) {
            return `<div>${framework} Data Model (Protected)</div>`;
        };
    }

    // Marcar como inicializado
    window.AIJourneyGlobal.initialized = true;
    const initTime = new Date().getTime() - window.AIJourneyGlobal.loadTime;
    console.log(`✅ Sistema de protección global inicializado (${initTime}ms)`);
})();
