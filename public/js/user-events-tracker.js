/**
 * User Events Tracker
 * 
 * Cliente JavaScript para enviar eventos personalizados de interacción del usuario
 * a nuestro sistema de análisis en tiempo real similar a Firebase.
 */

class UserEventsTracker {
    /**
     * Inicializa el rastreador de eventos de usuario
     * 
     * @param {Object} options - Opciones de configuración
     * @param {string} options.endpoint - Endpoint API para enviar eventos
     * @param {number} options.userId - ID del usuario actual
     * @param {boolean} options.debug - Activar mensajes de depuración
     */
    constructor(options = {}) {
        this.endpoint = options.endpoint || '/admin/analytics/track-event';
        this.userId = options.userId || null;
        this.debug = options.debug || false;
        this.queue = [];
        this.flushInterval = null;
        
        // Iniciar el proceso de envío en segundo plano
        this.startBackgroundFlush();
        
        if (this.debug) {
            console.log('UserEventsTracker inicializado');
        }
    }
    
    /**
     * Establece el ID del usuario actual
     * 
     * @param {number} userId - ID del usuario
     */
    setUserId(userId) {
        this.userId = userId;
        if (this.debug) {
            console.log(`ID de usuario establecido: ${userId}`);
        }
    }
    
    /**
     * Registra un evento de usuario
     * 
     * @param {string} eventType - Tipo de evento (view, click, interaction, etc.)
     * @param {string} eventName - Nombre descriptivo del evento
     * @param {Object} metadata - Datos adicionales sobre el evento
     */
    trackEvent(eventType, eventName, metadata = {}) {
        if (!this.userId) {
            if (this.debug) {
                console.warn('No se puede registrar el evento: ID de usuario no establecido');
            }
            return;
        }
        
        // Crear objeto de evento
        const event = {
            user_id: this.userId,
            event_type: eventType,
            event_name: eventName,
            page: window.location.pathname,
            metadata: {
                ...metadata,
                url: window.location.href,
                referrer: document.referrer,
                screen_width: window.innerWidth,
                screen_height: window.innerHeight,
                timestamp: new Date().toISOString()
            }
        };
        
        // Añadir a la cola para envío
        this.queue.push(event);
        
        if (this.debug) {
            console.log('Evento registrado:', event);
        }
        
        // Si la cola es muy grande, enviarla inmediatamente
        if (this.queue.length >= 10) {
            this.flush();
        }
    }
    
    /**
     * Envía eventos pendientes al servidor
     */
    flush() {
        if (this.queue.length === 0) {
            return;
        }
        
        const eventsToSend = [...this.queue];
        this.queue = [];
        
        fetch(this.endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(eventsToSend),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al enviar eventos');
            }
            return response.json();
        })
        .then(data => {
            if (this.debug) {
                console.log('Eventos enviados correctamente:', data);
            }
        })
        .catch(error => {
            // En caso de error, devolver los eventos a la cola
            this.queue = [...eventsToSend, ...this.queue];
            if (this.debug) {
                console.error('Error al enviar eventos:', error);
            }
        });
    }
    
    /**
     * Inicia el proceso de envío en segundo plano
     */
    startBackgroundFlush() {
        // Enviar eventos pendientes cada 30 segundos
        this.flushInterval = setInterval(() => {
            this.flush();
        }, 30000);
        
        // Enviar eventos pendientes antes de que la página se cierre
        window.addEventListener('beforeunload', () => {
            this.flush();
        });
    }
    
    /**
     * Detiene el proceso de envío en segundo plano
     */
    stopBackgroundFlush() {
        if (this.flushInterval) {
            clearInterval(this.flushInterval);
        }
    }
    
    /**
     * Registra un evento de vista de página
     * 
     * @param {string} pageName - Nombre de la página
     * @param {Object} metadata - Datos adicionales
     */
    trackPageView(pageName, metadata = {}) {
        this.trackEvent('view', `page_view_${pageName}`, metadata);
    }
    
    /**
     * Registra un evento de clic
     * 
     * @param {string} elementId - ID o descripción del elemento
     * @param {Object} metadata - Datos adicionales
     */
    trackClick(elementId, metadata = {}) {
        this.trackEvent('click', `click_${elementId}`, metadata);
    }
    
    /**
     * Configura el rastreo automático de clics para elementos específicos
     * 
     * @param {string} selector - Selector CSS para los elementos a rastrear
     * @param {Function} getElementId - Función para extraer el ID del elemento
     */
    autoTrackClicks(selector, getElementId = (el) => el.id || el.getAttribute('data-track-id')) {
        document.querySelectorAll(selector).forEach(element => {
            element.addEventListener('click', () => {
                const elementId = getElementId(element);
                if (elementId) {
                    this.trackClick(elementId, {
                        element_text: element.innerText || element.value,
                        element_class: element.className
                    });
                }
            });
        });
    }
}

// Exportar para uso global
window.UserEventsTracker = UserEventsTracker;

// Inicializar instancia global si existe el meta tag de usuario
document.addEventListener('DOMContentLoaded', () => {
    const userIdMeta = document.querySelector('meta[name="user-id"]');
    if (userIdMeta) {
        window.tracker = new UserEventsTracker({
            userId: userIdMeta.getAttribute('content'),
            debug: false
        });
        
        // Registrar vista de página actual
        const pageName = document.querySelector('meta[name="page-name"]')?.getAttribute('content') || 
            window.location.pathname.replace(/\//g, '_').replace(/^_|_$/g, '') || 'unknown';
        
        window.tracker.trackPageView(pageName);
    }
});
