/**
 * Real-Time Executive Dashboard Initialization
 * - Handles chart initialization and data updates
 * - Ensures stable performance and error-free operation
 * - Includes Risk Matrix and Dependencies visualizations
 */

// Global chart instances & settings
let evolutionChart;
// Use window.frameworkChart to avoid duplicate declarations
if (typeof window.frameworkChart === 'undefined') {
    window.frameworkChart = null;
}
let riskMatrixChart;
let dependencyChart;
let userEngagementChart;
let currentPeriod = 'quarterly'; // Default selected period
let refreshTimer;

document.addEventListener('DOMContentLoaded', function() {
    // Risk Matrix and Dependencies data
    const riskMatrixData = generateRiskMatrixData();
    const dependenciesData = generateDependenciesData();
    
    // Real-time data refresh functionality
    const refreshButton = document.getElementById('refresh-data');
    if (refreshButton) {
        refreshButton.addEventListener('click', function() {
            refreshButton.innerHTML = '<svg class="animate-spin h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Refreshing...';
            refreshButton.classList.add('bg-green-200');
            
            fetch('/admin/dashboard/refresh-stats', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                window.DashboardStats.updateAll(data);
                
                // Reset button state
                setTimeout(() => {
                    refreshButton.classList.remove('bg-green-200');
                    refreshButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Refresh Stats';
                }, 1000);
            })
            .catch(error => {
                console.error('Error refreshing stats:', error);
                refreshButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg> Retry';
                
                setTimeout(() => {
                    refreshButton.classList.remove('bg-green-200');
                    refreshButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Refresh Stats';
                }, 2000);
            });
        });
    }

    // Auto-refresh stats every 60 seconds with error handling
    let refreshInterval = null;
    
    function startAutoRefresh() {
        // Clear any existing intervals to prevent duplicates
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
        
        refreshInterval = setInterval(function() {
            try {
                fetch('/admin/dashboard/refresh-stats', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && typeof data === 'object') {
                        window.DashboardStats.updateAll(data);
                    }
                })
                .catch(error => {
                    console.warn('Error auto-refreshing dashboard data:', error);
                    // Silent fail - don't disturb the user experience
                });
            } catch (e) {
                console.warn('Error in auto-refresh mechanism:', e);
            }
        }, 60000); // 60 seconds
    }
    
    // Start the auto-refresh when page loads
    startAutoRefresh();
    
    // Initialize dashboard charts
    initFrameworkChart();
    initEvolutionChart();
    initRiskMatrixChart(riskMatrixData);
    initDependencyChart(dependenciesData);
    initUserEngagementChart();
    
    // Initialize activity refresh functionality
    initActivityRefresh();

    // Global Dashboard Stats Handler
    window.DashboardStats = {
        updateAll: function(data) {
            this.updateUserStats(data);
            this.updateProjectStats(data);
            this.updateIdeaStats(data);
            this.updateFrameworkStats(data);
            this.updateEngagementStats(data);
            this.updateActivityFeed(data);
            
            // Update framework chart if data available and chart exists
            if (data.frameworkUsage && window.frameworkChart) {
                try {
                    window.ChartSafety.update(window.frameworkChart, {
                        labels: Object.keys(data.frameworkUsage),
                        data: Object.values(data.frameworkUsage)
                    });
                } catch (e) {
                    console.warn('Error updating framework chart:', e);
                }
            }
        },
        
        // Safely update text content of an element
        updateText: function(id, value) {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = value;
            }
        },
        
        // Update user statistics
        updateUserStats: function(data) {
            if (data.totalUsers) {
                this.updateText('total-users-count', data.totalUsers);
                this.updateText('new-users-count', data.newUsers);

                // Update monthly growth card if available
                const usersGrowthElement = document.getElementById('users-growth-pct');
                if (usersGrowthElement) {
                    const growthPct = data.totalUsers > 0 ? Math.round((data.newUsers / data.totalUsers) * 100) : 0;
                    usersGrowthElement.textContent = growthPct + '%';
                }
            }
        },
        
        // Update project statistics
        updateProjectStats: function(data) {
            if (data.totalProjects) {
                this.updateText('total-projects-count', data.totalProjects);
                this.updateText('new-projects-count', data.newProjects);
                
                // Update active projects if available
                const projectsGrowthElement = document.getElementById('projects-growth-pct');
                if (projectsGrowthElement) {
                    const growthPct = Math.round((data.newProjects / Math.max(data.totalProjects - data.newProjects, 1)) * 100);
                    projectsGrowthElement.textContent = growthPct + '%';
                }
            }
        },
        
        // Update idea statistics
        updateIdeaStats: function(data) {
            if (data.totalIdeas) {
                this.updateText('total-ideas-count', data.totalIdeas);
                this.updateText('new-ideas-count', data.newIdeas);
                
                // Update conversion rate if available
                const ideasGrowthElement = document.getElementById('ideas-growth-pct');
                if (ideasGrowthElement) {
                    const growthPct = Math.round((data.newIdeas / Math.max(data.totalIdeas - data.newIdeas, 1)) * 100);
                    ideasGrowthElement.textContent = growthPct + '%';
                }
            }
        },
        
        // Update framework statistics
        updateFrameworkStats: function(data) {
            if (data.totalFrameworks) {
                this.updateText('total-frameworks-count', data.totalFrameworks);
                this.updateText('active-frameworks-count', data.activeFrameworks || 0);
            }
        },
        
        // Update engagement metrics
        updateEngagementStats: function(data) {
            if (data.hasOwnProperty('engagementScore')) {
                this.updateText('engagement-score', data.engagementScore + '/5');
                this.updateText('engagement-level', data.engagementLevel);
                
                // Safely update any progress bars
                const engagementProgress = document.getElementById('engagement-progress');
                if (engagementProgress) {
                    engagementProgress.style.width = (data.engagementScore / 5 * 100) + '%';
                }
                
                // Update contributions if available
                this.updateText('contributions-per-user', data.contributionsPerUser || '0');
                this.updateText('active-users-count', data.activeUsers || '0');
                this.updateText('retention-rate', (data.retentionRate || '0') + '%');
            }
        },
        
        // Update activity feed if data is available
        updateActivityFeed: function(data) {
            if (data && data.recentActivity && Array.isArray(data.recentActivity)) {
                try {
                    // Find activity container
                    const activityContainer = document.querySelector('.recent-activity-container');
                    if (!activityContainer) return;
                    
                    // Create a new activity list if we have new data
                    if (data.recentActivity.length > 0) {
                        let html = '';
                        
                        data.recentActivity.forEach(activity => {
                            // Determine color and icon based on activity type
                            const type = activity.type || 'general';
                            const color = {
                                'project': 'indigo',
                                'idea': 'purple',
                                'user': 'blue',
                                'general': 'gray'
                            }[type] || 'gray';
                            
                            const icon = {
                                'project': 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                                'idea': 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                                'user': 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                'general': 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                            }[type] || 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
                            
                            html += `
                            <li class="py-3 hover:bg-gray-50 rounded-lg px-2 transition-colors duration-150">
                                <div class="flex items-center">
                                    <div class="bg-${color}-100 p-2 rounded-full mr-3 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-${color}-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icon}" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900 truncate">${activity.title || 'Untitled'}</p>
                                            ${activity.owner ? `<span class="ml-2 text-xs text-gray-500 whitespace-nowrap">by ${activity.owner}</span>` : ''}
                                        </div>
                                        <p class="text-sm text-gray-500 truncate">${activity.description || ''}</p>
                                    </div>
                                    <div class="ml-3 flex-shrink-0 flex items-center space-x-2">
                                        <span class="text-xs bg-gray-100 text-gray-800 py-1 px-2 rounded-full">
                                            ${activity.time || 'N/A'}
                                        </span>
                                        <a href="#${type}-${activity.id}" class="text-gray-400 hover:text-${color}-600 transition-colors duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            `;
                        });
                        
                        // Only update if we found the container and have content
                        const activityList = activityContainer.querySelector('ul');
                        if (activityList) {
                            activityList.innerHTML = html;
                        }
                    }
                } catch (e) {
                    console.warn('Error updating activity feed:', e);
                }
            }
        }
    };
    
    // Previously we had chart instances defined here, but now they are global
    
    /**
     * Initialize Framework Usage Chart
     */
    function initFrameworkChart() {
        try {
            // Only proceed if the canvas element exists
            const frameworkCanvas = document.getElementById('frameworkChart');
            if (!frameworkCanvas) return;
            
            // Get framework usage data from the page
            let frameworkData = [];
            let frameworkLabels = [];
            
            // If window.frameworkUsage data is available, use it
            if (window.frameworkUsage && Object.keys(window.frameworkUsage).length > 0) {
                // Convert to array of [label, value] pairs for sorting
                const dataArray = Object.entries(window.frameworkUsage);
                
                // Sort by usage count (descending)
                dataArray.sort((a, b) => b[1] - a[1]);
                
                // Take only top 6 frameworks for better readability
                const topFrameworks = dataArray.slice(0, 6);
                
                // Split back into labels and data
                frameworkLabels = topFrameworks.map(item => item[0]);
                frameworkData = topFrameworks.map(item => item[1]);
                
                // Add a "Others" category if there are more than 6 frameworks
                if (dataArray.length > 6) {
                    const othersSum = dataArray.slice(6).reduce((sum, item) => sum + item[1], 0);
                    
                    if (othersSum > 0) {
                        frameworkLabels.push('Others');
                        frameworkData.push(othersSum);
                    }
                }
            }
            
            // If still no data available after processing, use placeholder data
            if (!frameworkLabels.length || !frameworkData.length) {
                frameworkLabels = ['Laravel', 'React', 'Vue.js', 'Angular', 'Django', 'Spring Boot'];
                frameworkData = [8, 6, 5, 4, 3, 2];
            }
            
            // Chart configuration
            const chartConfig = {
                type: 'doughnut',
                data: {
                    labels: frameworkLabels,
                    datasets: [{
                        data: frameworkData,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.85)',   // Blue
                            'rgba(16, 185, 129, 0.85)',   // Green
                            'rgba(99, 102, 241, 0.85)',   // Indigo
                            'rgba(245, 158, 11, 0.85)',   // Amber
                            'rgba(236, 72, 153, 0.85)',   // Pink
                            'rgba(124, 58, 237, 0.85)',   // Purple
                            'rgba(107, 114, 128, 0.85)'   // Gray (for Others)
                        ],
                        borderColor: 'transparent',
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 10,
                                font: {
                                    size: 11
                                },
                                // Show percentage in legend
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        const total = data.datasets[0].data.reduce((sum, value) => sum + value, 0);
                                        
                                        return data.labels.map((label, i) => {
                                            const value = data.datasets[0].data[i];
                                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                            
                                            return {
                                                text: `${label} (${percentage}%)`,
                                                fillStyle: chart.data.datasets[0].backgroundColor[i],
                                                hidden: isNaN(data.datasets[0].data[i]) || chart.getDatasetMeta(0).data[i].hidden,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            padding: 10,
                            titleFont: {
                                size: 12
                            },
                            bodyFont: {
                                size: 12
                            },
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                    const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                    return `${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '60%',
                    radius: '90%'
                }
            };
            // Initialize chart using ChartSafety wrapper
            window.frameworkChart = window.ChartSafety.init('frameworkChart', chartConfig);
        } catch (error) {
            console.warn('Error initializing framework chart:', error);
        }
    }
    
    /**
     * Initialize Evolution Chart with real data
     */
    function initEvolutionChart() {
        try {
            // Only proceed if the canvas element exists
            const evolutionCanvas = document.getElementById('evolutionChart');
            if (!evolutionCanvas) {
                console.log('Evolution chart skipped: Canvas element not found');
                return;
            }
            
            // التأكد من أن بيانات التطور متوفرة
            if (!window.evolutionData || typeof window.evolutionData !== 'object') {
                console.info('Evolution data is not available - this is normal during initial load');
                // Try again after a short delay to allow data to load
                setTimeout(initEvolutionChart, 500);
                return;
            }
            
            // جلب البيانات الفعلية من الكونترولر
            const monthlyData = window.evolutionData.monthly;
            const quarterlyData = window.evolutionData.quarterly;
            const yearlyData = window.evolutionData.yearly;
            
            // التأكد من صحة البيانات
            const monthlyLabels = monthlyData.labels || [];
            const monthlyProjectData = monthlyData.projects || [];
            const monthlyIdeaData = monthlyData.ideas || [];
            
            const quarterlyLabels = quarterlyData.labels || [];
            const quarterlyProjectData = quarterlyData.projects || [];
            const quarterlyIdeaData = quarterlyData.ideas || [];
            
            const yearlyLabels = yearlyData.labels || [];
            const yearlyProjectData = yearlyData.projects || [];
            const yearlyIdeaData = yearlyData.ideas || [];
            
            // Store all data sets for easy switching
            const dataSets = {
                monthly: {
                    labels: monthlyLabels,
                    projects: monthlyProjectData,
                    ideas: monthlyIdeaData
                },
                quarterly: {
                    labels: quarterlyLabels,
                    projects: quarterlyProjectData,
                    ideas: quarterlyIdeaData
                },
                yearly: {
                    labels: yearlyLabels,
                    projects: yearlyProjectData,
                    ideas: yearlyIdeaData
                }
            };
            
            // Create the chart with initial quarterly data using ChartSafety
            const chartConfig = {
                type: 'line',
                data: {
                    labels: dataSets[currentPeriod].labels,
                    datasets: [
                        {
                            label: 'Projects',
                            data: dataSets[currentPeriod].projects,
                            borderColor: 'rgba(79, 70, 229, 1)',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Ideas',
                            data: dataSets[currentPeriod].ideas,
                            borderColor: 'rgba(168, 85, 247, 1)',
                            backgroundColor: 'rgba(168, 85, 247, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 10,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#6B7280',
                            bodyColor: '#111827',
                            borderColor: '#E5E7EB',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: true
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                },
                                color: '#9CA3AF'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2],
                                color: '#E5E7EB'
                            },
                            ticks: {
                                font: {
                                    size: 10
                                },
                                color: '#9CA3AF',
                                precision: 0
                            }
                        }
                    }
                }
            };
            
            // Use ChartSafety to safely initialize the chart
            evolutionChart = window.ChartSafety.init('evolutionChart', chartConfig);
            
            // Set up event listeners for period filter buttons
            document.querySelectorAll('.evolution-filter').forEach(button => {
                button.addEventListener('click', function() {
                    // Extract period from button ID
                    const period = this.id.split('-')[1]; // Gets 'monthly', 'quarterly', or 'yearly'
                    
                    // Skip if already selected
                    if (period === currentPeriod) return;
                    
                    // Update button styles
                    document.querySelectorAll('.evolution-filter').forEach(btn => {
                        btn.classList.remove('bg-indigo-600');
                        btn.classList.remove('text-white');
                        btn.classList.add('bg-white');
                        btn.classList.add('text-indigo-600');
                        btn.classList.add('border');
                        btn.classList.add('border-gray-200');
                    });
                    
                    this.classList.remove('bg-white');
                    this.classList.remove('text-indigo-600');
                    this.classList.remove('border');
                    this.classList.remove('border-gray-200');
                    this.classList.add('bg-indigo-600');
                    this.classList.add('text-white');
                    
                    // Update chart data
                    currentPeriod = period;
                    window.ChartSafety.update(evolutionChart, {
                        labels: dataSets[period].labels,
                        data: [
                            dataSets[period].projects,
                            dataSets[period].ideas
                        ]
                    });
                    
                    // Update growth rate calculation based on selected period
                    updateGrowthRate(dataSets[period]);
                });
            });
            
            // Function to update the growth rate display
            function updateGrowthRate(data) {
                try {
                    // تأكد من توفر البيانات المطلوبة
                    if (!data || !data.projects || !data.ideas || !Array.isArray(data.projects) || !Array.isArray(data.ideas)) {
                        console.warn('Invalid data structure for growth rate calculation');
                        return;
                    }
                    
                    const projectsCount = data.projects;
                    const ideasCount = data.ideas;
                    
                    // التأكد من أن لدينا فترتين على الأقل للمقارنة
                    if (projectsCount.length < 2 || ideasCount.length < 2) {
                        console.warn('Not enough historical data for growth calculation');
                        return;
                    }
                    
                    // حساب النمو بين آخر فترتين
                    const lastPeriodIndex = projectsCount.length - 1;
                    const prevPeriodIndex = lastPeriodIndex - 1;
                    
                    // حساب النمو للمشاريع
                    const projectsGrowth = projectsCount[lastPeriodIndex] - projectsCount[prevPeriodIndex];
                    const projectsGrowthPercent = projectsCount[prevPeriodIndex] > 0 ? 
                        (projectsGrowth / projectsCount[prevPeriodIndex]) * 100 : 0;
                    
                    // حساب النمو للأفكار
                    const ideasGrowth = ideasCount[lastPeriodIndex] - ideasCount[prevPeriodIndex];
                    const ideasGrowthPercent = ideasCount[prevPeriodIndex] > 0 ? 
                        (ideasGrowth / ideasCount[prevPeriodIndex]) * 100 : 0;
                    
                    // حساب النمو الإجمالي
                    const lastPeriodTotal = projectsCount[lastPeriodIndex] + ideasCount[lastPeriodIndex];
                    const prevPeriodTotal = projectsCount[prevPeriodIndex] + ideasCount[prevPeriodIndex];
                    const totalGrowth = lastPeriodTotal - prevPeriodTotal;
                    const totalGrowthPercent = prevPeriodTotal > 0 ? 
                        (totalGrowth / prevPeriodTotal) * 100 : 0;
                    
                    // تحديث شاشة العرض
                    // 1. النمو الإجمالي
                    const growthRateElement = document.querySelector('.evolution-chart-container .text-right .text-xl.font-bold.text-indigo-600');
                    if (growthRateElement) {
                        const sign = totalGrowthPercent >= 0 ? '+' : '';
                        growthRateElement.textContent = `${sign}${Math.round(totalGrowthPercent)}%`;
                    }
                    
                    // 2. نمو المشاريع
                    const projectGrowthElement = document.getElementById('project-growth');
                    if (projectGrowthElement) {
                        const sign = projectsGrowth >= 0 ? '+' : '';
                        projectGrowthElement.textContent = `${sign}${projectsGrowth} (${sign}${projectsGrowthPercent.toFixed(1)}%)`;
                        projectGrowthElement.classList.remove('text-green-600', 'text-red-600');
                        projectGrowthElement.classList.add(projectsGrowth >= 0 ? 'text-green-600' : 'text-red-600');
                    }
                    
                    // 3. نمو الأفكار
                    const ideaGrowthElement = document.getElementById('idea-growth');
                    if (ideaGrowthElement) {
                        const sign = ideasGrowth >= 0 ? '+' : '';
                        ideaGrowthElement.textContent = `${sign}${ideasGrowth} (${sign}${ideasGrowthPercent.toFixed(1)}%)`;
                        ideaGrowthElement.classList.remove('text-green-600', 'text-red-600');
                        ideaGrowthElement.classList.add(ideasGrowth >= 0 ? 'text-green-600' : 'text-red-600');
                    }
                    
                } catch (error) {
                    console.warn('Error updating growth rates:', error);
                }
            }
            
            // Call updateGrowthRate initially with the default period
            updateGrowthRate(dataSets[currentPeriod]);
        } catch (error) {
            console.warn('Error initializing evolution chart:', error);
        }
    }

    // Initialize the evolution chart on page load
    if (document.getElementById('evolutionChart')) {
        window.setTimeout(initEvolutionChart, 100);
    }
    
    /**
     * Initialize activity refresh functionality
     */
    function initActivityRefresh() {
        // Activity refresh button functionality
        const refreshActivityBtn = document.getElementById('refresh-activity');
        if (refreshActivityBtn) {
            refreshActivityBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Show loading indicator
                this.classList.add('animate-spin');
                
                // Fetch latest activity data
                fetch('/admin/dashboard/refresh-activity', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update activity feed with new data
                    if (data && data.recentActivity) {
                        window.DashboardStats.updateActivityFeed(data);
                    }
                    
                    // Remove loading indicator
                    setTimeout(() => {
                        refreshActivityBtn.classList.remove('animate-spin');
                    }, 500);
                })
                .catch(error => {
                    console.error('Error refreshing activity:', error);
                    // Remove loading indicator
                    refreshActivityBtn.classList.remove('animate-spin');
                });
            });
        }
        
        // Mark activity list container for easy access in updates
        const activityContainer = document.querySelector('.flow-root');
        if (activityContainer) {
            activityContainer.classList.add('recent-activity-container');
        }
    }
    
    // Always show the overview panel since it's the only tab now
    const overviewPanel = document.getElementById('overview-tab-panel');
    if (overviewPanel) {
        overviewPanel.classList.remove('hidden');
    }
});

/**
 * Generate Risk Matrix data based on project and idea counts
 * @returns {Object} Risk matrix configuration and data
 */
function generateRiskMatrixData() {
    // Generate risk data based on project/idea counts
    const totalProjects = window.totalProjects || 0;
    const totalIdeas = window.totalIdeas || 0;
    
    // Generate 16 risk points (4x4 matrix)
    const risks = [
        // High Impact, High Probability
        { x: 3.8, y: 3.7, r: 15, label: 'Security', color: 'rgba(239, 68, 68, 0.8)' },
        { x: 3.5, y: 3.2, r: 10, label: 'Performance', color: 'rgba(239, 68, 68, 0.8)' },
        
        // High Impact, Medium Probability
        { x: 3.7, y: 2.4, r: 12, label: 'Data Loss', color: 'rgba(251, 146, 60, 0.8)' },
        { x: 3.2, y: 2.1, r: 9, label: 'Compliance', color: 'rgba(251, 146, 60, 0.8)' },
        
        // Medium Impact, High Probability
        { x: 2.3, y: 3.6, r: 8, label: 'UX Issues', color: 'rgba(251, 146, 60, 0.8)' },
        { x: 2.6, y: 3.3, r: 7, label: 'Tech Debt', color: 'rgba(251, 146, 60, 0.8)' },
        
        // Medium Impact, Medium Probability
        { x: 2.2, y: 2.3, r: 11, label: 'Integration', color: 'rgba(251, 191, 36, 0.8)' },
        { x: 2.5, y: 2.7, r: 8, label: 'Scaling', color: 'rgba(251, 191, 36, 0.8)' },
        
        // Medium Impact, Low Probability
        { x: 2.4, y: 1.4, r: 6, label: 'External APIs', color: 'rgba(251, 191, 36, 0.8)' },
        { x: 2.1, y: 1.1, r: 5, label: 'Vendor Issues', color: 'rgba(251, 191, 36, 0.8)' },
        
        // Low Impact, Medium Probability
        { x: 1.3, y: 2.2, r: 4, label: 'UI Details', color: 'rgba(16, 185, 129, 0.8)' },
        { x: 1.6, y: 2.5, r: 3, label: 'Minor Bugs', color: 'rgba(16, 185, 129, 0.8)' },
        
        // Low Impact, Low Probability
        { x: 1.2, y: 1.3, r: 6, label: 'Documentation', color: 'rgba(16, 185, 129, 0.8)' },
        { x: 1.5, y: 1.6, r: 4, label: 'Edge Cases', color: 'rgba(16, 185, 129, 0.8)' },
        { x: 1.1, y: 1.0, r: 3, label: 'Small Changes', color: 'rgba(16, 185, 129, 0.8)' },
    ];
    
    // Scale risk sizes based on project count
    if (totalProjects > 0) {
        risks.forEach(risk => {
            risk.r = Math.max(3, Math.min(20, risk.r * (1 + totalProjects / 100)));
        });
    }
    
    return risks;
}

/**
 * Generate dependency data for visualization
 * @returns {Object} Dependencies data for the chart
 */
function generateDependenciesData() {
    const totalProjects = window.totalProjects || 0;
    const totalIdeas = window.totalIdeas || 0;
    
    // Base frameworks with connections
    const frameworks = Object.keys(window.frameworkUsage || {}).slice(0, 5);
    
    // Create nodes and links
    const nodes = [];
    const links = [];
    
    // Add central node
    nodes.push({
        id: 'core',
        name: 'Platform Core',
        val: 30,
        color: 'rgba(79, 70, 229, 0.8)' // indigo
    });
    
    // Add framework nodes
    frameworks.forEach((framework, index) => {
        const usage = window.frameworkUsage[framework] || 1;
        nodes.push({
            id: `fw-${index}`,
            name: framework,
            val: 10 + usage * 2,
            color: 'rgba(16, 185, 129, 0.8)' // green
        });
        
        // Link to core
        links.push({
            source: 'core',
            target: `fw-${index}`,
            value: 5 + usage
        });
    });
    
    // Add project/idea nodes
    const numProjectNodes = Math.min(5, totalProjects);
    for (let i = 0; i < numProjectNodes; i++) {
        nodes.push({
            id: `proj-${i}`,
            name: `Project ${i+1}`,
            val: 8,
            color: 'rgba(14, 165, 233, 0.8)' // sky blue
        });
        
        // Link to random framework and core
        const randomFwIndex = Math.floor(Math.random() * frameworks.length);
        links.push({
            source: `fw-${randomFwIndex}`,
            target: `proj-${i}`,
            value: 3
        });
        links.push({
            source: 'core',
            target: `proj-${i}`,
            value: 2
        });
    }
    
    const numIdeaNodes = Math.min(3, totalIdeas);
    for (let i = 0; i < numIdeaNodes; i++) {
        nodes.push({
            id: `idea-${i}`,
            name: `Idea ${i+1}`,
            val: 5,
            color: 'rgba(168, 85, 247, 0.8)' // purple
        });
        
        // Link to random framework
        const randomFwIndex = Math.floor(Math.random() * frameworks.length);
        links.push({
            source: `fw-${randomFwIndex}`,
            target: `idea-${i}`,
            value: 1
        });
    }
    
    return { nodes, links };
}

/**
 * Initialize Risk Matrix Chart
 * @param {Array} riskData - Risk matrix data points
 */
function initRiskMatrixChart(riskData) {
    const riskCanvas = document.getElementById('riskMatrixChart');
    
    if (!riskCanvas) {
        console.log('Risk Matrix chart initialization skipped: Canvas element not found');
        return;
    }
    
    const riskMatrixConfig = {
        type: 'bubble',
        data: {
            datasets: [{
                label: 'Project Risks',
                data: riskData,
                backgroundColor: riskData.map(r => r.color),
                borderColor: riskData.map(r => r.color.replace('0.8', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    min: 0.5,
                    max: 4.5,
                    grid: {
                        display: true,
                        drawTicks: false,
                        drawBorder: false,
                        drawOnChartArea: true
                    },
                    ticks: {
                        callback: function(value) {
                            if (value === 1) return 'Low';
                            if (value === 2.5) return 'Medium';
                            if (value === 4) return 'High';
                            return '';
                        },
                        font: {
                            size: 10
                        }
                    },
                    title: {
                        display: true,
                        text: 'Impact',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    min: 0.5,
                    max: 4.5,
                    grid: {
                        display: true,
                        drawTicks: false,
                        drawBorder: false,
                        drawOnChartArea: true
                    },
                    ticks: {
                        callback: function(value) {
                            if (value === 1) return 'Low';
                            if (value === 2.5) return 'Medium';
                            if (value === 4) return 'High';
                            return '';
                        },
                        font: {
                            size: 10
                        }
                    },
                    title: {
                        display: true,
                        text: 'Probability',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const item = context.raw;
                            return `${item.label}: Impact: ${item.x > 3 ? 'High' : (item.x > 1.7 ? 'Medium' : 'Low')}, Probability: ${item.y > 3 ? 'High' : (item.y > 1.7 ? 'Medium' : 'Low')}`;
                        }
                    }
                },
                legend: {
                    display: false
                }
            }
        }
    };
    
    // Initialize chart with safety wrapper
    riskMatrixChart = window.ChartSafety.init('riskMatrixChart', riskMatrixConfig);
}

/**
 * Initialize Dependencies Diagram
 * @param {Object} dependencyData - Nodes and links for the dependency network
 */
function initDependencyChart(dependencyData) {
    const dependencyCanvas = document.getElementById('dependencyChart');
    
    if (!dependencyCanvas) {
        console.log('Dependency chart initialization skipped: Canvas element not found');
        return;
    }
    
    // Create simplified scatter plot as a dependencies visualization
    const nodes = dependencyData.nodes;
    
    // Assign positions in a circular layout
    const centerX = 2.5;
    const centerY = 2.5;
    const radius = 2;
    
    // Position nodes in a circle
    nodes.forEach((node, index) => {
        const angle = (index / nodes.length) * 2 * Math.PI;
        let distance = radius;
        
        // Core at center
        if (node.id === 'core') {
            node.x = centerX;
            node.y = centerY;
        } else if (node.id.startsWith('fw')) {
            // Frameworks in first ring
            distance = radius * 0.5;
            node.x = centerX + Math.cos(angle) * distance;
            node.y = centerY + Math.sin(angle) * distance;
        } else if (node.id.startsWith('proj')) {
            // Projects in second ring
            node.x = centerX + Math.cos(angle + 0.2) * radius;
            node.y = centerY + Math.sin(angle + 0.2) * radius;
        } else {
            // Ideas in outer ring
            distance = radius * 1.2;
            node.x = centerX + Math.cos(angle - 0.3) * distance;
            node.y = centerY + Math.sin(angle - 0.3) * distance;
        }
    });
    
    // Create series of scattered points
    const datasets = [];
    
    // Create one dataset per node type for better control
    const nodeTypes = ['core', 'fw', 'proj', 'idea'];
    nodeTypes.forEach(type => {
        const typeNodes = nodes.filter(n => n.id === type || n.id.startsWith(`${type}-`));
        if (typeNodes.length === 0) return;
        
        datasets.push({
            label: type === 'fw' ? 'Frameworks' : 
                   type === 'proj' ? 'Projects' : 
                   type === 'idea' ? 'Ideas' : 'Platform Core',
            data: typeNodes.map(n => ({ 
                x: n.x, 
                y: n.y, 
                r: Math.sqrt(n.val) * 3,
                name: n.name,
                id: n.id
            })),
            backgroundColor: typeNodes.map(n => n.color),
            borderColor: typeNodes.map(n => n.color.replace('0.8', '1')),
            borderWidth: 1
        });
    });
    
    // Create links as line annotations
    const annotations = {};
    dependencyData.links.forEach((link, i) => {
        const source = nodes.find(n => n.id === link.source);
        const target = nodes.find(n => n.id === link.target);
        
        if (source && target) {
            annotations[`link${i}`] = {
                type: 'line',
                xMin: source.x,
                xMax: target.x,
                yMin: source.y,
                yMax: target.y,
                borderColor: 'rgba(156, 163, 175, 0.3)',
                borderWidth: Math.max(1, Math.min(5, link.value || 1))
            };
        }
    });
    
    const dependencyConfig = {
        type: 'bubble',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    min: 0,
                    max: 5,
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        display: false
                    }
                },
                y: {
                    min: 0,
                    max: 5,
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        display: false
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const dataset = context.dataset.label;
                            const name = context.raw.name;
                            return `${dataset}: ${name}`;
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 8,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    };
    
    // Initialize chart with safety wrapper
    dependencyChart = window.ChartSafety.init('dependencyChart', dependencyConfig);
}

/**
 * Initialize User Engagement Chart for last 7 days
 * Note: This functionality has been moved to user-engagement-charts.js
 */
function initUserEngagementChart() {
    // Skip initialization as this has been moved to user-engagement-charts.js
    // This prevents conflicts with the new implementation
    return;
    
    // Generate engagement data based on total users
    const totalUsers = window.totalUsers || 0;
    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    
    // Create simulated daily active users pattern
    const getEngagementPattern = () => {
        // Base engagement represents a typical weekly pattern
        // with higher engagement on weekdays and lower on weekends
        const basePattern = [0.65, 0.72, 0.78, 0.71, 0.68, 0.52, 0.48];
        
        // Generate realistic variations by adding some randomness
        return basePattern.map(base => {
            const variation = (Math.random() * 0.1) - 0.05; // ±5% random variation
            return Math.round(totalUsers * Math.max(0.3, Math.min(0.9, base + variation)));
        });
    };
    
    // Create different engagement metrics
    const activeUsers = getEngagementPattern();
    const pageViews = activeUsers.map(users => Math.round(users * (2.5 + Math.random() * 1.5))); // 2.5-4 pages per user
    const interactions = activeUsers.map(users => Math.round(users * (1.2 + Math.random()))); // 1.2-2.2 interactions per user
    
    const engagementConfig = {
        type: 'line',
        data: {
            labels: days,
            datasets: [
                {
                    label: 'Active Users',
                    data: activeUsers,
                    borderColor: 'rgba(59, 130, 246, 0.8)', // blue-500
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Page Views',
                    data: pageViews,
                    borderColor: 'rgba(16, 185, 129, 0.8)', // green-500
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Interactions',
                    data: interactions,
                    borderColor: 'rgba(139, 92, 246, 0.8)', // purple-500
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [3, 3],
                    tension: 0.3,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [2, 2],
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 10
                        },
                        stepSize: Math.max(1, Math.round(totalUsers / 5))
                    }
                }
            },
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1F2937',
                    bodyColor: '#4B5563',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: 10,
                    boxPadding: 5,
                    usePointStyle: true,
                    callbacks: {
                        labelPointStyle: function(context) {
                            return { pointStyle: 'circle', rotation: 0 };
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 8,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 11
                        },
                        padding: 15
                    }
                }
            }
        }
    };
    
    // Initialize chart with safety wrapper
    userEngagementChart = window.ChartSafety.init('userChart', engagementConfig);
}
