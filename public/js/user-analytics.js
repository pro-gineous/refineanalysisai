/**
 * User Engagement Analytics - Real-time Firebase-like Analytics
 * 
 * This script manages the real-time analytics for user engagement,
 * including hourly activity charts, event type distribution,
 * and device/browser breakdowns.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts
    initializeCharts();
    
    // Handle time range changes
    const timeRangeSelect = document.getElementById('time-range');
    if (timeRangeSelect) {
        timeRangeSelect.addEventListener('change', function() {
            fetchAnalyticsData(this.value);
        });
    }
    
    // Handle manual refresh
    const refreshButton = document.getElementById('refresh-analytics');
    if (refreshButton) {
        refreshButton.addEventListener('click', function() {
            const hours = timeRangeSelect ? timeRangeSelect.value : 24;
            fetchAnalyticsData(hours);
            
            // Visual feedback for refresh
            refreshButton.classList.add('bg-indigo-200');
            refreshButton.innerHTML = '<svg class="animate-spin h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Refreshing...';
            
            // Restore button after refresh
            setTimeout(() => {
                refreshButton.classList.remove('bg-indigo-200');
                refreshButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Refresh Data';
            }, 1000);
        });
    }
    
    // Auto-refresh data every 60 seconds
    setInterval(function() {
        const hours = timeRangeSelect ? timeRangeSelect.value : 24;
        fetchAnalyticsData(hours);
    }, 60000);
});

/**
 * Fetch analytics data from the server
 */
function fetchAnalyticsData(hours = 24) {
    fetch(`/admin/analytics/metrics?hours=${hours}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        updateMetricsCards(data);
        updateCharts(data);
        updateTimestamps(data.timestamp);
    })
    .catch(error => console.error('Error fetching analytics data:', error));
}

/**
 * Update metrics cards with fresh data
 */
function updateMetricsCards(data) {
    // Update Active Users card
    if (document.getElementById('active-users-count')) {
        document.getElementById('active-users-count').textContent = data.active_users;
    }
    
    if (document.getElementById('active-users-percentage')) {
        document.getElementById('active-users-percentage').textContent = data.active_users_percentage + '%';
        document.getElementById('active-users-percentage').className = 'text-sm font-semibold ' + 
            (data.active_users_percentage > 20 ? 'text-green-600' : 'text-yellow-600');
    }
    
    if (document.getElementById('active-users-percentage-text')) {
        document.getElementById('active-users-percentage-text').textContent = 
            data.active_users_percentage > 20 ? 'Good' : (data.active_users_percentage > 10 ? 'Average' : 'Needs improvement');
    }
    
    if (document.getElementById('active-users-bar')) {
        document.getElementById('active-users-bar').style.width = Math.min(data.active_users_percentage, 100) + '%';
    }
    
    // Update Events Per User card
    if (document.getElementById('events-per-user-count')) {
        document.getElementById('events-per-user-count').textContent = data.events_per_user;
    }
    
    if (document.getElementById('total-events-count')) {
        document.getElementById('total-events-count').textContent = data.total_events;
    }
    
    if (document.getElementById('events-per-user-level')) {
        document.getElementById('events-per-user-level').textContent = 
            data.events_per_user > 5 ? 'High' : (data.events_per_user > 2 ? 'Moderate' : 'Low');
    }
    
    if (document.getElementById('events-per-user-bar')) {
        document.getElementById('events-per-user-bar').style.width = Math.min(data.events_per_user * 10, 100) + '%';
    }
    
    // Update Top Event Type card
    if (data.events_by_type && Object.keys(data.events_by_type).length > 0) {
        const topEventType = Object.keys(data.events_by_type)[0];
        const topEventCount = data.events_by_type[topEventType];
        const topEventPercentage = data.total_events > 0 ? Math.round((topEventCount / data.total_events) * 100) : 0;
        
        if (document.getElementById('top-event-type')) {
            document.getElementById('top-event-type').textContent = topEventType.replace('_', ' ');
        }
        
        if (document.getElementById('top-event-percentage')) {
            document.getElementById('top-event-percentage').textContent = topEventPercentage + '%';
        }
        
        if (document.getElementById('top-event-count')) {
            document.getElementById('top-event-count').textContent = topEventCount + ' events';
        }
        
        if (document.getElementById('top-event-bar')) {
            document.getElementById('top-event-bar').style.width = topEventPercentage + '%';
        }
    }
    
    // Update Top Page card
    if (data.events_by_page && Object.keys(data.events_by_page).length > 0) {
        const topPage = Object.keys(data.events_by_page)[0];
        const topPageCount = data.events_by_page[topPage];
        const topPagePercentage = data.total_events > 0 ? Math.round((topPageCount / data.total_events) * 100) : 0;
        const displayPage = topPage.includes('/') ? topPage.split('/').pop() : topPage;
        
        if (document.getElementById('top-page')) {
            document.getElementById('top-page').textContent = displayPage;
        }
        
        if (document.getElementById('top-page-percentage')) {
            document.getElementById('top-page-percentage').textContent = topPagePercentage + '%';
        }
        
        if (document.getElementById('top-page-count')) {
            document.getElementById('top-page-count').textContent = topPageCount + ' views';
        }
        
        if (document.getElementById('top-page-bar')) {
            document.getElementById('top-page-bar').style.width = topPagePercentage + '%';
        }
    }
}

// Charts objects
let hourlyChart, eventTypesChart, deviceTypeChart, browserChart;

/**
 * Initialize all charts
 */
function initializeCharts() {
    // Hourly Activity Chart
    const hourlyCtx = document.getElementById('hourlyActivityChart');
    if (hourlyCtx) {
        hourlyChart = new Chart(hourlyCtx, {
            type: 'line',
            data: {
                labels: Array.from({length: 24}, (_, i) => `${i}:00`),
                datasets: [{
                    label: 'User Events',
                    data: Array(24).fill(0),
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }
    
    // Event Types Distribution Chart
    const eventTypesCtx = document.getElementById('eventTypesChart');
    if (eventTypesCtx) {
        eventTypesChart = new Chart(eventTypesCtx, {
            type: 'doughnut',
            data: {
                labels: ['No data'],
                datasets: [{
                    data: [1],
                    backgroundColor: ['#e5e7eb'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            }
        });
    }
    
    // Device Type Distribution Chart
    const deviceTypeCtx = document.getElementById('deviceTypeChart');
    if (deviceTypeCtx) {
        deviceTypeChart = new Chart(deviceTypeCtx, {
            type: 'pie',
            data: {
                labels: ['No data'],
                datasets: [{
                    data: [1],
                    backgroundColor: ['#e5e7eb'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            }
        });
    }
    
    // Browser Distribution Chart
    const browserCtx = document.getElementById('browserChart');
    if (browserCtx) {
        browserChart = new Chart(browserCtx, {
            type: 'pie',
            data: {
                labels: ['No data'],
                datasets: [{
                    data: [1],
                    backgroundColor: ['#e5e7eb'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            }
        });
    }
}

/**
 * Update all charts with fresh data
 */
function updateCharts(data) {
    // Update Hourly Activity Chart
    if (hourlyChart && data.events_by_hour) {
        const labels = Object.keys(data.events_by_hour).map(hour => `${hour}:00`);
        const values = Object.values(data.events_by_hour);
        
        hourlyChart.data.labels = labels;
        hourlyChart.data.datasets[0].data = values;
        hourlyChart.update();
    }
    
    // Update Event Types Chart
    if (eventTypesChart && data.events_by_type && Object.keys(data.events_by_type).length > 0) {
        const labels = Object.keys(data.events_by_type).map(type => type.replace('_', ' '));
        const values = Object.values(data.events_by_type);
        
        // Generate colors
        const colors = generateColors(labels.length);
        
        eventTypesChart.data.labels = labels;
        eventTypesChart.data.datasets[0].data = values;
        eventTypesChart.data.datasets[0].backgroundColor = colors;
        eventTypesChart.update();
    }
    
    // Update Device Type Chart
    if (deviceTypeChart && data.device_breakdown && Object.keys(data.device_breakdown).length > 0) {
        const labels = Object.keys(data.device_breakdown);
        const values = Object.values(data.device_breakdown);
        
        // Generate colors
        const colors = [
            'rgba(79, 70, 229, 0.8)',  // indigo
            'rgba(16, 185, 129, 0.8)', // green
            'rgba(245, 158, 11, 0.8)'  // amber
        ];
        
        deviceTypeChart.data.labels = labels;
        deviceTypeChart.data.datasets[0].data = values;
        deviceTypeChart.data.datasets[0].backgroundColor = colors;
        deviceTypeChart.update();
    }
    
    // Update Browser Chart
    if (browserChart && data.browser_breakdown && Object.keys(data.browser_breakdown).length > 0) {
        const labels = Object.keys(data.browser_breakdown);
        const values = Object.values(data.browser_breakdown);
        
        // Generate colors
        const colors = generateColors(labels.length);
        
        browserChart.data.labels = labels;
        browserChart.data.datasets[0].data = values;
        browserChart.data.datasets[0].backgroundColor = colors;
        browserChart.update();
    }
}

/**
 * Update all timestamp display elements
 */
function updateTimestamps(timestamp) {
    document.querySelectorAll('.last-updated').forEach(el => {
        el.textContent = 'Last updated: ' + timestamp;
    });
}

/**
 * Generate chart colors
 */
function generateColors(count) {
    const colorSet = [
        'rgba(79, 70, 229, 0.8)',   // indigo
        'rgba(16, 185, 129, 0.8)',  // green
        'rgba(245, 158, 11, 0.8)',  // amber
        'rgba(220, 38, 38, 0.8)',   // red
        'rgba(59, 130, 246, 0.8)',  // blue
        'rgba(236, 72, 153, 0.8)',  // pink
        'rgba(139, 92, 246, 0.8)',  // purple
        'rgba(6, 182, 212, 0.8)',   // cyan
    ];
    
    // If we need more colors, generate them programmatically
    if (count > colorSet.length) {
        for (let i = colorSet.length; i < count; i++) {
            const r = Math.floor(Math.random() * 200) + 50;
            const g = Math.floor(Math.random() * 200) + 50;
            const b = Math.floor(Math.random() * 200) + 50;
            colorSet.push(`rgba(${r}, ${g}, ${b}, 0.8)`);
        }
    }
    
    return colorSet.slice(0, count);
}
