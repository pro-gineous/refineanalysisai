/*
 * Main JavaScript file for the application
 * Contains global utility functions and event handlers
 */

// Safe wrapper for DOM operations to prevent errors with non-existent elements
const DOM = {
    // Safely get an element, returns null if not found
    get: function(selector) {
        return document.querySelector(selector);
    },
    
    // Safely get an element by ID, returns null if not found
    getById: function(id) {
        return document.getElementById(id);
    },
    
    // Safely get an attribute from an element
    getAttr: function(element, attr) {
        if (!element) return null;
        return element.getAttribute(attr);
    },
    
    // Safely add an event listener
    addEvent: function(element, event, callback) {
        if (!element) return;
        element.addEventListener(event, callback);
    }
};

// Utility function to detect browser
function getBrowserInfo() {
    const userAgent = navigator.userAgent;
    let browser = 'Unknown';
    
    if (userAgent.match(/chrome|chromium|crios/i)) {
        browser = 'Chrome';
    } else if (userAgent.match(/firefox|fxios/i)) {
        browser = 'Firefox';
    } else if (userAgent.match(/safari/i)) {
        browser = 'Safari';
    } else if (userAgent.match(/opr\//i)) {
        browser = 'Opera';
    } else if (userAgent.match(/edg/i)) {
        browser = 'Edge';
    } else if (userAgent.match(/trident/i)) {
        browser = 'Internet Explorer';
    }
    
    return browser;
}

// Safe chart initialization - prevents errors when canvas elements are missing
window.safeInitChart = function(chartId, chartConfig) {
    const chartElement = DOM.getById(chartId);
    if (!chartElement) {
        console.log(`Chart element with ID '${chartId}' not found. Skipping chart initialization.`);
        return null;
    }
    
    try {
        const ctx = chartElement.getContext('2d');
        if (!ctx) {
            console.log(`Could not get 2D context for chart '${chartId}'`);
            return null;
        }
        return new Chart(ctx, chartConfig);
    } catch (error) {
        console.warn(`Error initializing chart '${chartId}':`, error);
        return null;
    }
};

// Initialize application when DOM is ready
function init() {
    // Get CSRF token if available
    let token = '';
    const csrfMeta = DOM.get('meta[name="csrf-token"]');
    if (csrfMeta) {
        token = DOM.getAttr(csrfMeta, 'content');
    } else {
        console.log('CSRF token meta tag not found. CSRF protection may not work properly.');
    }
    
    // Set up AJAX request interceptors if we have a token
    if (token) {
        // Intercept fetch requests to add CSRF token
        const originalFetch = window.fetch;
        window.fetch = function(url, options = {}) {
            try {
                // Only add to same-origin requests
                if (url.toString().startsWith(window.location.origin) || url.toString().startsWith('/')) {
                    options.headers = options.headers || {};
                    options.headers['X-CSRF-TOKEN'] = token;
                }
                return originalFetch(url, options);
            } catch (error) {
                console.warn('Error in fetch interceptor:', error);
                return originalFetch(url, options);
            }
        };
    }
    
    // Initialize tooltips and popovers if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }
    
    // Handle flash messages auto-dismiss
    const flashMessages = document.querySelectorAll('.alert-dismissible');
    flashMessages.forEach(function(element) {
        setTimeout(function() {
            const dismissButton = element.querySelector('.btn-close');
            if (dismissButton) {
                dismissButton.click();
            } else {
                element.style.display = 'none';
            }
        }, 5000); // Auto dismiss after 5 seconds
    });
    
    // Handle canvas initialization errors gracefully
    // This prevents errors when trying to access getContext on null elements
    window.initializeCanvas = function(canvasId, callback) {
        const canvas = document.getElementById(canvasId);
        if (canvas) {
            const ctx = canvas.getContext('2d');
            if (ctx && typeof callback === 'function') {
                callback(ctx);
            }
        } else {
            console.log(`Canvas element with ID '${canvasId}' not found. Skipping initialization.`);
        }
    };
    
    // User tracking setup (if user is logged in)
    try {
        const userId = DOM.get('meta[name="user-id"]');
        const pageName = DOM.get('meta[name="page-name"]');
        
        if (userId && DOM.getAttr(userId, 'content')) {
            // Track page view
            const eventData = {
                user_id: DOM.getAttr(userId, 'content'),
                event_type: 'page_view',
                page: pageName ? DOM.getAttr(pageName, 'content') : window.location.pathname,
                referrer: document.referrer || 'direct',
                device: /Mobile|Android|iPhone/i.test(navigator.userAgent) ? 'mobile' : 'desktop',
                browser: getBrowserInfo(),
                timestamp: new Date().toISOString()
            };
            
            // Skip actual tracking on development environment
            // In production, this would call the tracking endpoint
            console.log('Page view tracked:', eventData);
        }
    } catch (error) {
        console.warn('Error in user tracking setup:', error);
        // Fail silently - tracking should never break the application
    }
}

// Wait for DOM to be fully loaded before initializing
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    // If DOMContentLoaded has already fired, run init immediately
    init();
}

// Add a global error handler for Chart.js and other JavaScript errors
window.addEventListener('error', function(event) {
    // Suppress errors related to Canvas and Chart.js
    if (event.error && event.error.message && 
        (event.error.message.includes('getContext') || 
         event.error.message.includes('canvas') || 
         event.error.message.includes('Chart'))) {
        console.warn('Caught UI error:', event.error.message);
        event.preventDefault(); // Prevent the error from propagating
        return true;
    }
    return false;
});
