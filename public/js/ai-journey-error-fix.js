/**
 * AI Journey Error Fix
 * Este script arregla los errores de sintaxis en la página AI Journey
 * sobrescribiendo las funciones problemáticas con implementaciones limpias.
 */

// Inicializar almacenamiento global para elementos DOM
window.AIJourneyElements = {
    elements: {},        // Cache de nodos DOM
    attempts: 0,         // Contador de intentos
    maxAttempts: 15,     // Máximo número de intentos antes de inyectar elementos
    pollingInterval: 300, // Intervalo inicial entre intentos (ms)
    loaded: false        // Indicador de carga completada
};

// Ejecutar cuando el documento esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('Aplicando correcciones de emergencia para AI Journey...');
    
    // Reemplazar funciones problemáticas
    window.initializeProcessVisualization = function() {
        console.log('Usando implementación corregida de initializeProcessVisualization');
        
        const generateProcessMapBtn = document.getElementById('generate-process-map');
        const generateDataModelBtn = document.getElementById('generate-data-model');
        const visualizationArea = document.getElementById('visualization-area');
        const visualizationPlaceholder = document.getElementById('visualization-placeholder');
        
        if (!generateProcessMapBtn || !generateDataModelBtn || !visualizationArea) {
            console.warn('Elementos de visualización no encontrados');
            return;
        }
        
        // Process Map Button
        generateProcessMapBtn.addEventListener('click', function() {
            if (!window.currentFramework) {
                alert('Por favor selecciona un framework primero');
                return;
            }
            
            if (visualizationPlaceholder) {
                visualizationPlaceholder.classList.add('hidden');
            }
            
            visualizationArea.innerHTML = '<div class="flex justify-center items-center h-full"><div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-green-500"></div></div>';
            visualizationArea.classList.remove('hidden');
            
            setTimeout(function() {
                let processMap = '';
                
                if (typeof window.createPRINCE2ProcessMap === 'function' &&
                    typeof window.createIdeaManagementProcessMap === 'function' &&
                    typeof window.createGenericProcessMap === 'function') {
                    
                    if (window.currentFramework === 'prince2') {
                        processMap = window.createPRINCE2ProcessMap();
                    } else if (window.currentFramework === 'idea-management') {
                        processMap = window.createIdeaManagementProcessMap();
                    } else {
                        processMap = window.createGenericProcessMap(window.currentFramework);
                    }
                    
                    visualizationArea.innerHTML = processMap;
                    
                    if (typeof window.addMessage === 'function') {
                        window.addMessage('ai', '<div class="bg-green-50 border-l-4 border-green-500 p-4"><p class="text-green-700">Process map generated successfully.</p></div>', true);
                    }
                } else {
                    console.error('Las funciones de visualización no están disponibles');
                    visualizationArea.innerHTML = '<div class="p-4 text-red-500">Error: No se pudieron cargar las funciones de visualización</div>';
                }
            }, 1000);
        });
        
        // Data Model Button
        generateDataModelBtn.addEventListener('click', function() {
            if (!window.currentFramework) {
                alert('Por favor selecciona un framework primero');
                return;
            }
            
            if (visualizationPlaceholder) {
                visualizationPlaceholder.classList.add('hidden');
            }
            
            visualizationArea.innerHTML = '<div class="flex justify-center items-center h-full"><div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-green-500"></div></div>';
            visualizationArea.classList.remove('hidden');
            
            setTimeout(function() {
                if (typeof window.createDataModel === 'function') {
                    const dataModel = window.createDataModel(window.currentFramework);
                    visualizationArea.innerHTML = dataModel;
                    
                    if (typeof window.addMessage === 'function') {
                        window.addMessage('ai', '<div class="bg-green-50 border-l-4 border-green-500 p-4"><p class="text-green-700">Data model generated successfully.</p></div>', true);
                    }
                } else {
                    console.error('La función createDataModel no está disponible');
                    visualizationArea.innerHTML = '<div class="p-4 text-red-500">Error: No se pudo cargar la función de modelo de datos</div>';
                }
            }, 1000);
        });
    };
    
    /**
     * Sistema avanzado de resolución de elementos DOM que evita completamente el error
     * 'The deferred DOM Node could not be resolved to a valid node'
     */
    try {
        // Función para encontrar elementos DOM de forma segura con cache
        const getElement = function(id) {
            // Si ya tenemos este elemento en caché, devolverlo
            if (window.AIJourneyElements.elements[id]) {
                return window.AIJourneyElements.elements[id];
            }
            
            // Intentar encontrar el elemento
            const element = document.getElementById(id);
            if (element) {
                // Almacenar en cache para uso futuro
                window.AIJourneyElements.elements[id] = element;
                console.log(`✅ Elemento '${id}' encontrado y cacheado`);
                return element;
            }
            
            console.log(`⚠️ Elemento '${id}' no disponible en el DOM`);
            return null;
        };
        
        // Función para verificar todos los elementos necesarios
        const checkAllRequiredElements = function() {
            // Lista de todos los elementos que necesitamos para el funcionamiento
            const requiredIds = [
                'generate-process-map',
                'generate-data-model',
                'visualization-area',
                'visualization-placeholder',
                'framework-selector',
                'chatMessages',
                'user-message',
                'chat-form'
            ];
            
            // Verificar cada elemento y contar cuántos tenemos
            let foundCount = 0;
            let missingIds = [];
            
            requiredIds.forEach(id => {
                const element = getElement(id);
                if (element) {
                    foundCount++;
                } else {
                    missingIds.push(id);
                }
            });
            
            // Registrar estado actual
            console.log(`🔍 Verificación de elementos: ${foundCount}/${requiredIds.length} encontrados`);
            if (missingIds.length > 0) {
                console.log(`⚠️ Elementos faltantes: ${missingIds.join(', ')}`);
            }
            
            // Comprobar si tenemos los elementos críticos mínimos para funcionar
            const criticalElements = [
                'generate-process-map',
                'generate-data-model',
                'visualization-area'
            ];
            
            const hasCriticalElements = criticalElements.every(id => getElement(id) !== null);
            return {
                complete: (foundCount === requiredIds.length),
                critical: hasCriticalElements,
                foundCount: foundCount,
                totalCount: requiredIds.length,
                missingIds: missingIds
            };
        };
        
        // Función para intentar inicializar las visualizaciones
        const attemptInitialization = function() {
            // Aumentar contador de intentos
            window.AIJourneyElements.attempts++;
            
            // Obtener estado actual de los elementos
            const elementStatus = checkAllRequiredElements();
            
            // Mostrar estado en la consola con formato mejorado
            console.log(`🔄 Intento #${window.AIJourneyElements.attempts}: ${elementStatus.foundCount}/${elementStatus.totalCount} elementos disponibles`);
            
            // Si tenemos todos los elementos o al menos los críticos
            if (elementStatus.critical) {
                console.log('✅ Elementos críticos disponibles - iniciando visualización');
                
                // Configurar framework si está disponible
                const frameworkSelector = getElement('framework-selector');
                if (frameworkSelector && frameworkSelector.value && !window.currentFramework) {
                    window.currentFramework = frameworkSelector.value;
                    console.log('🔧 Framework establecido a:', window.currentFramework);
                }
                
                // Inicializar visualización
                if (typeof window.initializeProcessVisualization === 'function') {
                    window.initializeProcessVisualization();
                    console.log('🎉 Visualización inicializada correctamente');
                    window.AIJourneyElements.loaded = true;
                    return true;
                }
            }
            
            // Si no hemos alcanzado el máximo de intentos, programar otro intento
            if (window.AIJourneyElements.attempts < window.AIJourneyElements.maxAttempts) {
                console.log(`⏳ Programando siguiente intento en ${window.AIJourneyElements.pollingInterval}ms...`);
                setTimeout(attemptInitialization, window.AIJourneyElements.pollingInterval);
                // Aumentar gradualmente el intervalo para evitar sobrecarga
                window.AIJourneyElements.pollingInterval = Math.min(2000, window.AIJourneyElements.pollingInterval * 1.2);
                return false;
            } else {
                console.warn(`❌ Se alcanzó el límite de ${window.AIJourneyElements.maxAttempts} intentos sin éxito`);
                injectMissingElements();
                return false;
            }
        };
        
        // Función para crear e inyectar elementos faltantes como último recurso
        const injectMissingElements = function() {
            console.log('🛠️ Creando elementos faltantes como último recurso...');
            
            // Buscar un contenedor donde podamos colocar los elementos
            const possibleContainers = [
                document.querySelector('.ai-journey-container'),
                document.querySelector('.container'),
                document.body
            ];
            
            let container = null;
            for (let i = 0; i < possibleContainers.length; i++) {
                if (possibleContainers[i]) {
                    container = possibleContainers[i];
                    break;
                }
            }
            
            if (!container) {
                console.error('❌ No se encontró ningún contenedor para inyectar elementos');
                return;
            }
            
            console.log('📦 Usando contenedor:', container.tagName || 'unknown');
            
            // Crear elementos faltantes
            if (!getElement('visualization-area')) {
                const visualArea = document.createElement('div');
                visualArea.id = 'visualization-area';
                visualArea.className = 'hidden mt-4 p-4 border rounded-lg';
                container.appendChild(visualArea);
                window.AIJourneyElements.elements['visualization-area'] = visualArea;
                console.log('✅ Creado: visualization-area');
            }
            
            if (!getElement('visualization-placeholder')) {
                const placeholder = document.createElement('div');
                placeholder.id = 'visualization-placeholder';
                placeholder.className = 'flex flex-col items-center justify-center p-6 text-gray-500';
                placeholder.innerHTML = '<p>Selecciona visualizar mapa de proceso o modelo de datos</p>';
                container.appendChild(placeholder);
                window.AIJourneyElements.elements['visualization-placeholder'] = placeholder;
                console.log('✅ Creado: visualization-placeholder');
            }
            
            // Intentar inicializar de nuevo tras crear los elementos
            setTimeout(function() {
                window.AIJourneyElements.attempts = 0; // Reiniciar contador
                attemptInitialization();
            }, 500);
        };
        
        // Iniciar el proceso después de un corto retraso
        console.log('🚀 Iniciando sistema mejorado de carga para AI Journey...');
        setTimeout(attemptInitialization, 800);
    } catch (e) {
        console.error('Error al aplicar correcciones:', e);
    }
});
