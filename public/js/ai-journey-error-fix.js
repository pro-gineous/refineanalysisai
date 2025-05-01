/**
 * AI Journey Error Fix
 * Este script arregla los errores de sintaxis en la página AI Journey
 * sobrescribiendo las funciones problemáticas con implementaciones limpias.
 */

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
    
    // Intentar corregir la estructura anidada incorrecta que podría estar causando el error de sintaxis
    try {
        // Buscar cualquier función initializeProcessVisualization en la página y ejecutar la versión corregida
        setTimeout(function() {
            if (document.getElementById('generate-process-map') && document.getElementById('generate-data-model')) {
                console.log('Ejecutando visualización corregida...');
                window.initializeProcessVisualization();
            }
        }, 500);
    } catch (e) {
        console.error('Error al aplicar correcciones:', e);
    }
});
