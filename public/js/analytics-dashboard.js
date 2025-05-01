/**
 * Analytics Dashboard JavaScript
 * Script para actualizar y gestionar los gráficos y métricas del dashboard de analíticas en tiempo real.
 */

// Almacenar los gráficos para actualizarlos después
let hourlyChart, eventTypeChart, deviceChart;

// Inicializar gráficos cuando la página cargue
document.addEventListener('DOMContentLoaded', function() {
    initCharts();
    // Actualizar datos cada 60 segundos
    setInterval(fetchAnalyticsData, 60000);
    
    // Configurar eventos
    document.getElementById('refresh-analytics').addEventListener('click', fetchAnalyticsData);
    document.getElementById('time-range').addEventListener('change', fetchAnalyticsData);
});

// Inicializar todos los gráficos
function initCharts() {
    initHourlyChart();
    initEventTypeChart();
    initDeviceChart();
    fetchAnalyticsData();
}

// Gráfico de actividad por hora
function initHourlyChart() {
    const ctx = document.getElementById('hourlyActivityChart').getContext('2d');
    hourlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: Array.from({length: 24}, (_, i) => `${i}:00`),
            datasets: [{
                label: 'Eventos por hora',
                data: Array(24).fill(0),
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Gráfico de distribución de tipos de eventos
function initEventTypeChart() {
    const ctx = document.getElementById('eventTypeChart').getContext('2d');
    eventTypeChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['View', 'Create', 'Update', 'Delete', 'Login', 'Other'],
            datasets: [{
                data: [0, 0, 0, 0, 0, 0],
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(209, 213, 219, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                }
            },
            cutout: '70%'
        }
    });
}

// Gráfico de distribución de dispositivos
function initDeviceChart() {
    const ctx = document.getElementById('deviceChart').getContext('2d');
    deviceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Desktop', 'Mobile', 'Tablet'],
            datasets: [{
                label: 'Usuarios por dispositivo',
                data: [0, 0, 0],
                backgroundColor: [
                    'rgba(99, 102, 241, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(245, 158, 11, 0.7)'
                ],
                borderWidth: 0,
                borderRadius: 4,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Obtener datos de analíticas desde el servidor
function fetchAnalyticsData() {
    const timeRange = document.getElementById('time-range').value;
    const url = ANALYTICS_METRICS_URL + '?hours=' + timeRange;
    
    // Actualizar indicador de carga
    document.querySelectorAll('.last-updated').forEach(el => {
        el.textContent = 'Updating...';
    });
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            updateMetricCards(data);
            updateHourlyChart(data.hourly_data);
            updateEventTypeChart(data.events_by_type);
            updateDeviceChart(data.device_distribution);
            updateRecentActivity(data.recent_events);
            
            // Actualizar tiempo de última actualización
            const timestamp = new Date().toLocaleTimeString();
            document.querySelectorAll('.last-updated').forEach(el => {
                el.textContent = `Last updated: ${timestamp}`;
            });
        })
        .catch(error => {
            console.error('Error fetching analytics:', error);
            document.querySelectorAll('.last-updated').forEach(el => {
                el.textContent = `Update failed at ${new Date().toLocaleTimeString()}`;
            });
        });
}

// Actualizar tarjetas de métricas
function updateMetricCards(data) {
    // Active Users Card
    document.getElementById('active-users-count').textContent = data.active_users;
    document.getElementById('active-users-percentage').textContent = `${data.active_users_percentage}%`;
    document.getElementById('active-users-percentage').className = `text-sm font-semibold ${data.active_users_percentage > 20 ? 'text-green-600' : 'text-yellow-600'}`;
    document.getElementById('active-users-percentage-text').textContent = data.active_users_percentage > 20 ? 'Good' : (data.active_users_percentage > 10 ? 'Average' : 'Needs improvement');
    document.getElementById('active-users-bar').style.width = `${Math.min(data.active_users_percentage, 100)}%`;
    
    // Events Per User Card
    document.getElementById('events-per-user-count').textContent = data.events_per_user;
    document.getElementById('total-events-count').textContent = data.total_events;
    document.getElementById('events-per-user-level').textContent = data.events_per_user > 5 ? 'High' : (data.events_per_user > 2 ? 'Moderate' : 'Low');
    document.getElementById('events-per-user-bar').style.width = `${Math.min(data.events_per_user * 10, 100)}%`;
    
    // Top Event Type Card
    const topEventType = Object.keys(data.events_by_type)[0] || 'N/A';
    const topEventCount = data.events_by_type[topEventType] || 0;
    const topEventPercentage = data.total_events > 0 ? Math.round((topEventCount / data.total_events) * 100) : 0;
    
    document.getElementById('top-event-type').textContent = topEventType.replace('_', ' ');
    document.getElementById('top-event-percentage').textContent = `${topEventPercentage}%`;
    document.getElementById('top-event-count').textContent = `${topEventCount} events`;
    document.getElementById('top-event-bar').style.width = `${topEventPercentage}%`;
    
    // Top Page Card
    const topPage = Object.keys(data.events_by_page)[0] || 'N/A';
    const topPageCount = data.events_by_page[topPage] || 0;
    const topPagePercentage = data.total_events > 0 ? Math.round((topPageCount / data.total_events) * 100) : 0;
    const displayPage = topPage === 'N/A' ? 'N/A' : (topPage.includes('/') ? topPage.split('/').pop() : topPage);
    
    document.getElementById('top-page').textContent = displayPage;
    document.getElementById('top-page-percentage').textContent = `${topPagePercentage}%`;
    document.getElementById('top-page-count').textContent = `${topPageCount} views`;
    document.getElementById('top-page-bar').style.width = `${topPagePercentage}%`;
}

// Actualizar gráfico de actividad horaria
function updateHourlyChart(hourlyData) {
    if (!hourlyChart || !hourlyData) return;
    
    const hours = Object.keys(hourlyData).sort((a, b) => parseInt(a) - parseInt(b));
    const counts = hours.map(hour => hourlyData[hour]);
    
    hourlyChart.data.labels = hours.map(hour => `${hour}:00`);
    hourlyChart.data.datasets[0].data = counts;
    hourlyChart.update();
}

// Actualizar gráfico de tipos de eventos
function updateEventTypeChart(eventTypes) {
    if (!eventTypeChart || !eventTypes) return;
    
    const labels = Object.keys(eventTypes);
    const data = labels.map(label => eventTypes[label]);
    
    eventTypeChart.data.labels = labels.map(label => label.replace('_', ' '));
    eventTypeChart.data.datasets[0].data = data;
    eventTypeChart.update();
}

// Actualizar gráfico de dispositivos
function updateDeviceChart(deviceData) {
    if (!deviceChart || !deviceData) return;
    
    const desktop = deviceData.desktop || 0;
    const mobile = deviceData.mobile || 0;
    const tablet = deviceData.tablet || 0;
    
    deviceChart.data.datasets[0].data = [desktop, mobile, tablet];
    deviceChart.update();
}

// Actualizar tabla de actividad reciente
function updateRecentActivity(recentEvents) {
    if (!recentEvents || !recentEvents.length) return;
    
    const tableBody = document.getElementById('recent-activity-table');
    if (!tableBody) return;
    
    // Limpiar tabla existente si está vacía
    if (tableBody.querySelector('td[colspan="4"]')) {
        tableBody.innerHTML = '';
    }
    
    // Añadir nuevos eventos al inicio
    recentEvents.forEach(event => {
        // Verificar si el evento ya existe en la tabla
        const existingRows = tableBody.querySelectorAll(`tr[data-event-id="${event.id}"]`);
        if (existingRows.length > 0) return;
        
        const row = document.createElement('tr');
        row.setAttribute('data-event-id', event.id);
        
        // Usuario
        const userCell = document.createElement('td');
        userCell.className = 'px-6 py-4 whitespace-nowrap';
        userCell.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0 h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-indigo-800">${event.user_name ? event.user_name.charAt(0) : 'U'}</span>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">${event.user_name || 'Unknown User'}</div>
                    <div class="text-xs text-gray-500">ID: ${event.user_id}</div>
                </div>
            </div>
        `;
        
        // Evento
        const eventCell = document.createElement('td');
        eventCell.className = 'px-6 py-4 whitespace-nowrap';
        eventCell.innerHTML = `
            <div class="text-sm text-gray-900 capitalize">${event.event_name.replace('_', ' ')}</div>
            <div class="text-xs text-gray-500">${event.event_type}</div>
        `;
        
        // Página
        const pageCell = document.createElement('td');
        pageCell.className = 'px-6 py-4 whitespace-nowrap';
        pageCell.innerHTML = `
            <div class="text-sm text-gray-900">${event.page}</div>
            <div class="text-xs text-gray-500">${event.section || ''}</div>
        `;
        
        // Tiempo
        const timeCell = document.createElement('td');
        timeCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
        timeCell.textContent = event.time_ago;
        
        // Añadir celdas a la fila
        row.appendChild(userCell);
        row.appendChild(eventCell);
        row.appendChild(pageCell);
        row.appendChild(timeCell);
        
        // Insertar al inicio de la tabla
        tableBody.insertBefore(row, tableBody.firstChild);
        
        // Mantener solo los últimos 10 eventos
        if (tableBody.children.length > 10) {
            tableBody.removeChild(tableBody.lastChild);
        }
    });
}
