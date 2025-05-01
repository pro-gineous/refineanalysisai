/**
 * Chart Safety Utilities
 * Provides safety functions to prevent errors when initializing charts
 */

// Create a safe wrapper around Chart.js
window.ChartSafety = {
    /**
     * Safely initialize a chart, preventing errors for missing elements
     * @param {string} canvasId - The ID of the canvas element
     * @param {object} config - The Chart.js configuration object
     * @returns {Chart|null} - The Chart instance or null if initialization failed
     */
    // Track all chart instances by canvas ID
    chartInstances: {},
    
    /**
     * Destroy any existing chart on a canvas before creating a new one
     * @param {string} canvasId - The ID of the canvas element
     */
    destroyExistingChart: function(canvasId) {
        // Check if we have an existing chart on this canvas
        if (this.chartInstances[canvasId] && this.chartInstances[canvasId] instanceof Chart) {
            // Destroy the existing chart
            this.chartInstances[canvasId].destroy();
            // Remove the reference
            delete this.chartInstances[canvasId];
        }
        
        // Additionally, check for any chart instances from Chart.js registry
        const existingChart = Chart.getChart(canvasId);
        if (existingChart) {
            existingChart.destroy();
        }
    },
    
    init: function(canvasId, config) {
        const canvasElement = document.getElementById(canvasId);
        
        if (!canvasElement) {
            // Silently skip initialization without console messages
            // Only log in development mode if window.DEBUG_CHARTS is true
            if (window.DEBUG_CHARTS) {
                console.log(`Chart initialization skipped: Canvas element #${canvasId} not found`);
            }
            return null;
        }
        
        try {
            // First destroy any existing chart on this canvas
            this.destroyExistingChart(canvasId);
            
            const ctx = canvasElement.getContext('2d');
            if (!ctx) {
                console.log(`Chart initialization skipped: Could not get 2D context for #${canvasId}`);
                return null;
            }
            
            // Create the new chart
            const newChart = new Chart(ctx, config);
            
            // Store the instance for future reference
            this.chartInstances[canvasId] = newChart;
            
            return newChart;
        } catch (error) {
            console.error(`Error initializing chart #${canvasId}:`, error);
            return null;
        }
    },
    
    /**
     * Safely updates a chart if it exists
     * @param {Chart|null} chart - The Chart instance to update
     * @param {object} data - New data for the chart
     */
    update: function(chart, data) {
        if (!chart) {
            console.log('Chart update skipped: Chart instance is null');
            return;
        }
        
        try {
            if (data.labels) {
                chart.data.labels = data.labels;
            }
            
            if (data.datasets) {
                chart.data.datasets = data.datasets;
            } else if (data.data) {
                // Support for updating individual datasets
                data.data.forEach((dataSet, index) => {
                    if (chart.data.datasets[index]) {
                        chart.data.datasets[index].data = dataSet;
                    }
                });
            }
            
            chart.update();
        } catch (error) {
            console.error('Error updating chart:', error);
        }
    },
    
    /**
     * Safely destroys a chart if it exists
     * @param {Chart|null} chart - The Chart instance to destroy
     */
    destroy: function(chart) {
        if (!chart) {
            return;
        }
        
        try {
            chart.destroy();
        } catch (error) {
            console.error('Error destroying chart:', error);
        }
    }
};

// Add a global error handler for Chart.js
window.addEventListener('error', function(event) {
    if (event.error && event.error.message && event.error.message.includes('getContext')) {
        console.warn('Caught Chart.js canvas error. Make sure all canvas elements exist before initialization.');
        event.preventDefault(); // Prevent the error from propagating
    }
});
