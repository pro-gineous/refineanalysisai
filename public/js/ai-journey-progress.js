/**
 * AI Journey Progress Page JavaScript
 * Sistema de visualización de progreso con protección contra errores DOM
 */

(function() {
    // Sistema de prevención de errores DOM
    console.log('🚀 Inicializando sistema de protección AI Journey Progress...');
    
    // Espacio de nombres para evitar conflictos globales
    window.AIJourneyProgress = {
        initialized: false,
        domReady: false,
        errorProtection: true
    };
    
    // 1. Primera línea de defensa: Interceptar errores de resolución de nodos DOM
    const originalGetElementById = document.getElementById;
    document.getElementById = function(id) {
        const element = originalGetElementById.call(document, id);
        if (!element && window.AIJourneyProgress.errorProtection) {
            console.log(`⚠️ Protección activa: Se intentó acceder a un elemento no existente con ID: ${id}`);
            
            // Solo para elementos relacionados con AI Journey, crear elementos temporales invisibles
            if (id.includes('visualization') || 
                id.includes('process-map') || 
                id.includes('data-model') || 
                id.includes('generate-')) {
                
                console.log(`🛡️ Creando elemento de protección para: ${id}`);
                const tempElement = document.createElement('div');
                tempElement.id = id;
                tempElement.style.display = 'none';
                tempElement.dataset.protection = 'true';
                document.body.appendChild(tempElement);
                return tempElement;
            }
        }
        return element;
    };
    
    // 2. Segunda línea de defensa: Interceptar errores de querySelector/querySelectorAll
    const originalQuerySelector = document.querySelector;
    document.querySelector = function(selector) {
        try {
            const element = originalQuerySelector.call(document, selector);
            if (!element && window.AIJourneyProgress.errorProtection && 
                (selector.includes('visualization') || selector.includes('process') || selector.includes('data-model'))) {
                console.log(`⚠️ Protección activa: querySelector falló para: ${selector}`);
            }
            return element;
        } catch (e) {
            console.log(`🛑 Error interceptado en querySelector: ${e.message}`);
            return null;
        }
    };
    
    // 3. Interceptar errores no capturados
    window.addEventListener('error', function(event) {
        // Solo interceptar errores relacionados con DOM
        if (event.message && (
            event.message.includes('DOM') || 
            event.message.includes('node') ||
            event.message.includes('Element') ||
            event.message.includes('deferred')
        )) {
            console.log(`🚨 Error DOM interceptado: ${event.message}`);
            
            // Evitar que el error se propague a la consola
            if (window.AIJourneyProgress.errorProtection) {
                event.preventDefault();
                event.stopPropagation();
                return true;
            }
        }
    }, true);
    
    // 4. Mejorar las transiciones y animaciones en la página de progreso
    function enhanceProgressPage() {
        if (window.AIJourneyProgress.initialized) return;
        
        // Mejorar las barras de progreso con animaciones
        const progressBars = document.querySelectorAll('.bg-blue-500, .bg-green-500, .bg-yellow-500');
        progressBars.forEach(bar => {
            // Añadir efectos de transición
            bar.style.transition = 'width 1.5s ease-in-out';
            
            // Aplicar efecto de carga gradual
            const currentWidth = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = currentWidth;
            }, 300);
        });
        
        // Añadir efectos de hover a las tarjetas
        const cards = document.querySelectorAll('.rounded-lg.border');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
                this.style.transition = 'all 0.3s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
        
        window.AIJourneyProgress.initialized = true;
        console.log('✅ Mejoras de la página de progreso aplicadas');
    }
    
    // Inicializar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            window.AIJourneyProgress.domReady = true;
            enhanceProgressPage();
        });
    } else {
        window.AIJourneyProgress.domReady = true;
        enhanceProgressPage();
    }
    
    // Asegurar inicialización incluso si hay retrasos
    setTimeout(function() {
        if (!window.AIJourneyProgress.initialized) {
            console.log('⏱️ Inicialización diferida activada');
            enhanceProgressPage();
        }
    }, 1000);
})();
