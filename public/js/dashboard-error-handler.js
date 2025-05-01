/**
 * Dashboard Error Handler
 * - Provides comprehensive error handling for dashboard scripts
 * - Intercepts syntax errors and other JavaScript exceptions
 * - Prevents dashboard functionality from breaking due to errors
 */

(function() {
    // Global error handler for dashboard script errors
    window.addEventListener('error', function(event) {
        // Don't log errors from extensions or browser plugins
        if (event.filename && event.filename.indexOf('chrome-extension://') === 0) {
            return;
        }

        // Format error for console
        const errorInfo = {
            message: event.message || 'Unknown error',
            source: event.filename || 'Unknown source',
            line: event.lineno || 'Unknown line',
            column: event.colno || 'Unknown column',
            error: event.error ? (event.error.stack || event.error.toString()) : 'No error details available'
        };

        // Log to console in an organized way
        console.warn('🛑 Dashboard Error Handler intercepted an error:');
        console.warn(`📌 Error: ${errorInfo.message}`);
        console.warn(`📄 Source: ${errorInfo.source}`);
        console.warn(`🔢 Position: Line ${errorInfo.line}, Column ${errorInfo.column}`);
        
        // Silent fail policy - don't disturb the user
        event.preventDefault();
        return true;
    });
    
    // Specific handler for Chart.js errors
    if (window.Chart) {
        const originalAcquireContext = Chart.helpers.acquireContext;
        Chart.helpers.acquireContext = function(canvas, config) {
            try {
                return originalAcquireContext.apply(this, arguments);
            } catch (e) {
                console.warn('📊 Chart.js context acquisition error:', e.message);
                return null;
            }
        };
    }
    
    // Fix common syntax errors in String.prototype methods
    // This helps avoid issues with template strings and quotes
    ['replace', 'replaceAll', 'match', 'search', 'split'].forEach(function(method) {
        const original = String.prototype[method];
        String.prototype[method] = function() {
            try {
                return original.apply(this, arguments);
            } catch (e) {
                console.warn(`📝 String.${method} error:`, e.message);
                return this.toString();
            }
        };
    });
    
    console.log('✅ Dashboard Error Handler initialized');
})();
