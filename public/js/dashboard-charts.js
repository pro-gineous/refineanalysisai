/**
 * Dashboard Charts Management
 * Provides safe initialization and management for all dashboard charts
 */

// Dashboard Charts Management System
const DashboardCharts = {
    // Maintain references to all chart instances
    instances: {},
    
    /**
     * Safely initialize a chart with error handling
     * @param {string} id - The ID of the canvas element
     * @param {object} config - Chart.js configuration
     * @returns {Chart|null} The chart instance or null if initialization failed
     */
    init: function(id, config) {
        try {
            // First try to get from cache if already initialized
            if (this.instances[id]) {
                this.destroy(id); // Destroy existing instance to prevent memory leaks
            }
            
            // Use ChartSafety to safely initialize
            const chart = window.ChartSafety.init(id, config);
            
            // Cache the instance
            if (chart) {
                this.instances[id] = chart;
            }
            
            return chart;
        } catch (error) {
            console.warn(`Error initializing chart '${id}':`, error);
            return null;
        }
    },
    
    /**
     * Update an existing chart with new data
     * @param {string} id - The chart ID to update
     * @param {object} data - New data for the chart
     */
    update: function(id, data) {
        try {
            const chart = this.instances[id];
            if (!chart) {
                console.warn(`Cannot update chart '${id}': Chart not found`);
                return;
            }
            
            // Use ChartSafety to update
            window.ChartSafety.update(chart, data);
        } catch (error) {
            console.warn(`Error updating chart '${id}':`, error);
        }
    },
    
    /**
     * Destroy a chart instance and clean up
     * @param {string} id - The chart ID to destroy
     */
    destroy: function(id) {
        try {
            const chart = this.instances[id];
            if (chart) {
                chart.destroy();
                delete this.instances[id];
            }
        } catch (error) {
            console.warn(`Error destroying chart '${id}':`, error);
        }
    },
    
    /**
     * Initialize all charts in the dashboard
     */
    initAll: function() {
        // Initialize all chart elements on the page
        document.querySelectorAll('canvas[data-chart-type]').forEach(canvas => {
            const chartType = canvas.getAttribute('data-chart-type');
            const chartId = canvas.id;
            
            if (chartType && chartId) {
                switch (chartType) {
                    case 'evolution':
                        this.initEvolutionChart();
                        break;
                    // Add other chart types as needed
                }
            }
        });
        
        // Try to call known initialization functions
        try {
            if (typeof initEvolutionChart === 'function') {
                initEvolutionChart();
            }
        } catch (e) {
            console.log('Some chart initialization functions not found');
        }
    }
};

// Initialize all charts when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Use setTimeout to ensure this runs after all other initializations
    setTimeout(() => {
        DashboardCharts.initAll();
    }, 100);
});

// Add global chart resize handler for responsive charts
window.addEventListener('resize', function() {
    // Debounce the resize event
    if (this.resizeTimeout) {
        clearTimeout(this.resizeTimeout);
    }
    
    this.resizeTimeout = setTimeout(() => {
        for (const chartId in DashboardCharts.instances) {
            const chart = DashboardCharts.instances[chartId];
            if (chart) {
                chart.resize();
            }
        }
    }, 200);
});
