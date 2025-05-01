/**
 * Enhanced User Engagement Charts
 * Provides detailed visualization of user activity and engagement metrics
 */

// Global chart instances for user engagement
let userSegmentsChart = null;
let userActivityChart = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize user engagement charts if elements exist
    if (document.getElementById('userSegmentsChart')) {
        initializeUserSegmentsChart();
    } else {
        console.log('User Segments chart initialization skipped: Canvas element not found');
    }
    
    if (document.getElementById('userActivityChart')) {
        initializeUserActivityChart();
    } else {
        console.log('User Activity chart initialization skipped: Canvas element not found');
    }
    
    // Set up initial data fetch and periodic refresh
    fetchEngagementData();
    
    // Set up interval to refresh data every 60 seconds if not already set
    if (!window.engagementRefreshInterval) {
        window.engagementRefreshInterval = setInterval(fetchEngagementData, 60000);
    }
});

// User Segments Doughnut Chart
function initializeUserSegmentsChart() {
    const ctx = document.getElementById('userSegmentsChart').getContext('2d');
    
    // Destroy existing chart if it exists
    if (userSegmentsChart) {
        userSegmentsChart.destroy();
    }
    
    userSegmentsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['High Engagement', 'Moderate', 'Low Engagement'],
            datasets: [{
                data: [0, 0, 0], // Will be updated with real data
                backgroundColor: [
                    'rgb(59, 130, 246)', // Blue
                    'rgb(99, 102, 241)', // Indigo
                    'rgb(168, 85, 247)'  // Purple
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${context.label}: ${value} users (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// User Activity Line Chart
function initializeUserActivityChart() {
    const ctx = document.getElementById('userActivityChart').getContext('2d');
    
    // Destroy existing chart if it exists
    if (userActivityChart) {
        userActivityChart.destroy();
    }
    
    userActivityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: Array(24).fill(''), // Will be updated with hour labels
            datasets: [{
                label: 'Current Period',
                data: Array(24).fill(0), // Will be updated with real data
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointRadius: 0,
                pointHoverRadius: 3
            },
            {
                label: 'Previous Period',
                data: Array(24).fill(0), // Will be updated with real data
                borderColor: 'rgb(209, 213, 219)',
                borderDash: [5, 5],
                borderWidth: 1.5,
                fill: false,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 10,
                        usePointStyle: true,
                        font: {
                            size: 11
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw} events`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 8,
                        font: {
                            size: 9
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        precision: 0,
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });
}

// Fetch engagement data from the server
function fetchEngagementData() {
    fetch('/admin/dashboard/refresh-stats', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        updateEngagementMetrics(data);
    })
    .catch(error => {
        console.error('Error fetching engagement data:', error);
    });
}

// Update engagement metrics and charts with new data
function updateEngagementMetrics(data) {
    try {
        // Update timestamp
        const timestampEl = document.getElementById('engagement-updated-time');
        if (timestampEl) {
            timestampEl.innerHTML = `
                <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse mr-1"></span>
                Updated ${new Date().toLocaleTimeString()}
            `;
        }
        
        // Update engagement score
        const scoreEl = document.getElementById('engagement-score-display');
        if (scoreEl) {
            scoreEl.textContent = data.engagement_score || '0.0';
        }
        
        // Update active users count and growth
        const activeUsersEl = document.getElementById('active-users-count');
        if (activeUsersEl) {
            activeUsersEl.textContent = data.active_users || 0;
        }
        
        const activeUsersGrowth = data.active_users_growth || 0;
        const activeUsersGrowthEl = document.getElementById('active-users-growth');
        if (activeUsersGrowthEl) {
            activeUsersGrowthEl.textContent = `${activeUsersGrowth > 0 ? '+' : ''}${activeUsersGrowth}%`;
            activeUsersGrowthEl.className = `text-xs font-medium ${activeUsersGrowth >= 0 ? 'text-green-600' : 'text-red-600'} flex items-center`;
        }
        
        // Update events per user and growth
        const eventsPerUserEl = document.getElementById('events-per-user');
        if (eventsPerUserEl) {
            eventsPerUserEl.textContent = data.events_per_user || '0.0';
        }
        
        const eventsPerUserGrowth = data.events_per_user_growth || 0;
        const eventsPerUserGrowthEl = document.getElementById('events-per-user-growth');
        if (eventsPerUserGrowthEl) {
            eventsPerUserGrowthEl.textContent = `${eventsPerUserGrowth > 0 ? '+' : ''}${eventsPerUserGrowth}%`;
            eventsPerUserGrowthEl.className = `text-xs font-medium ${eventsPerUserGrowth >= 0 ? 'text-green-600' : 'text-red-600'} flex items-center`;
        }
        
        // Update user segments percentages
        const segments = data.engagement_segments || { 
            highly_engaged: { percentage: 0 },
            moderately_engaged: { percentage: 0 },
            low_engaged: { percentage: 0 }
        };
        
        const highEngagementEl = document.getElementById('high-engagement-percent');
        if (highEngagementEl) {
            highEngagementEl.textContent = `${segments.highly_engaged.percentage || 0}%`;
        }
        
        const moderateEngagementEl = document.getElementById('moderate-engagement-percent');
        if (moderateEngagementEl) {
            moderateEngagementEl.textContent = `${segments.moderately_engaged.percentage || 0}%`;
        }
        
        const lowEngagementEl = document.getElementById('low-engagement-percent');
        if (lowEngagementEl) {
            lowEngagementEl.textContent = `${segments.low_engaged.percentage || 0}%`;
        }
        
        // Update user segments chart
        if (userSegmentsChart) {
            userSegmentsChart.data.datasets[0].data = [
                segments.highly_engaged.count || 0,
                segments.moderately_engaged.count || 0,
                segments.low_engaged.count || 0
            ];
            userSegmentsChart.update();
        }
        
        // Update user activity chart
        if (userActivityChart && data.hour_labels && data.events_by_hour) {
            userActivityChart.data.labels = data.hour_labels;
            userActivityChart.data.datasets[0].data = data.events_by_hour.current || Array(24).fill(0);
            userActivityChart.data.datasets[1].data = data.events_by_hour.previous || Array(24).fill(0);
            userActivityChart.update();
        }
        
        // Update header card elements if they exist
        updateHeaderCardElements(data);
    } catch (error) {
        console.error('Error updating engagement metrics:', error);
    }
}

// Update the elements in the header card
function updateHeaderCardElements(data) {
    // Update engagement score in the header card
    const headerEngagementScore = document.getElementById('engagement-score');
    if (headerEngagementScore) {
        headerEngagementScore.textContent = `${data.engagement_score || 0}/10`;
    }
    
    // Update engagement level
    const headerEngagementLevel = document.getElementById('engagement-level');
    if (headerEngagementLevel) {
        const score = data.engagement_score || 0;
        let level = 'average';
        if (score >= 7) level = 'excellent';
        else if (score >= 5) level = 'good';
        headerEngagementLevel.textContent = level;
    }
    
    // Update active users in header
    const headerActiveUsers = document.getElementById('active-users');
    if (headerActiveUsers) {
        headerActiveUsers.textContent = `${data.active_users || 0} (${data.active_users_percentage || 0}%)`;
    }
    
    // Update contributions per user
    const contributionsPerUser = document.getElementById('contributions-per-user');
    if (contributionsPerUser) {
        contributionsPerUser.textContent = data.avgContributionsPerUser || '0.0';
    }
    
    // Update progress bars if they exist
    const contributionsBar = document.getElementById('contributions-bar');
    if (contributionsBar) {
        const eventsPerUser = data.events_per_user || 0;
        contributionsBar.style.width = `${Math.min(eventsPerUser * 10, 100)}%`;
    }
    
    const activeUsersBar = document.getElementById('active-users-bar');
    if (activeUsersBar) {
        activeUsersBar.style.width = `${data.active_users_percentage || 0}%`;
    }
    
    const eventsPerUserBar = document.getElementById('events-per-user-bar');
    if (eventsPerUserBar) {
        const eventsPerUser = data.events_per_user || 0;
        eventsPerUserBar.style.width = `${Math.min(eventsPerUser * 10, 100)}%`;
    }
}
