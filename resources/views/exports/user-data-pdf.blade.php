<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Analytics Report</title>
    <style>
        @page {
            margin: 2.5cm 1.5cm 2cm 1.5cm;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #0f172a;
            margin: 0;
            padding: 0;
            font-size: 11pt;
            background-color: #ffffff;
        }
        /* Layout and structural elements */
        .container {
            max-width: 1024px;
            margin: 0 auto;
            padding: 0 30px;
            box-sizing: border-box;
        }
        .header {
            position: relative;
            margin-bottom: 2.5em;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 1.5em;
            page-break-inside: avoid;
        }
        .section {
            margin: 2.5em 0;
            page-break-inside: avoid;
            clear: both;
        }
        .section:after {
            content: "";
            display: block;
            height: 0;
            clear: both;
            visibility: hidden;
        }
        .section-divider {
            height: 3px;
            background: linear-gradient(to right, #0284c7, rgba(2, 132, 199, 0.1));
            margin: 2em 0;
            border-radius: 2px;
        }
        
        /* Typography */
        h1 {
            color: #0f172a;
            font-size: 26pt;
            font-weight: 700;
            margin: 0 0 0.2em 0;
            line-height: 1.2;
        }
        h2 {
            color: #0284c7;
            font-size: 18pt;
            font-weight: 600;
            margin: 1.5em 0 0.7em 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 0.3em;
            line-height: 1.3;
            position: relative;
        }
        h2:after {
            content: "";
            display: block;
            width: 80px;
            height: 3px;
            background-color: #0284c7;
            position: absolute;
            bottom: -2px;
            left: 0;
            border-radius: 3px;
        }
        h3 {
            color: #0369a1;
            font-size: 14pt;
            font-weight: 600;
            margin: 1.2em 0 0.6em 0;
            line-height: 1.3;
        }
        h4 {
            color: #0284c7;
            font-size: 12pt;
            font-weight: 600;
            margin: 0 0 0.4em 0;
            line-height: 1.3;
        }
        p {
            margin: 0.5em 0 1em 0;
            line-height: 1.6;
        }
        .text-small {
            font-size: 9pt;
        }
        .text-large {
            font-size: 14pt;
        }
        .text-xl {
            font-size: 18pt;
        }
        .text-bold {
            font-weight: 600;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-muted {
            color: #64748b;
            font-size: 10pt;
        }
        
        /* Card Elements */
        .card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        
        /* Progress Bars */
        .progress-bar {
            height: 8px;
            width: 100%;
            background-color: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, #0ea5e9, #0284c7);
            border-radius: 4px;
        }
        
        /* Visual Components */
        .stat-card {
            background-color: #f0f9ff;
            border-radius: 8px;
            padding: 15px;
            margin: 0;
            text-align: center;
            border: 1px solid #bae6fd;
        }
        .stat-value {
            font-size: 20pt;
            font-weight: 700;
            color: #0284c7;
            line-height: 1.1;
            margin: 0.2em 0;
        }
        .stat-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 11pt;
            font-weight: 600;
            background-color: #dbeafe;
            color: #1e40af;
            margin-right: 8px;
        }
        .flex-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 1.2em 0;
        }
        .flex-item {
            flex: 1;
            min-width: 130px;
        }
        .report-id {
            color: #0369a1;
            font-weight: 600;
            font-size: 11pt;
            margin: 0 0 5px 0;
        }
        
        /* Data Display Elements */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.2em 0;
            font-size: 10pt;
        }
        th, td {
            padding: 12px 8px;
            border: 1px solid #e2e8f0;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f1f5f9;
            font-weight: 600;
            color: #334155;
        }
        tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        tr:hover td {
            background-color: #f0f9ff;
        }
        
        /* Progress and Data Visualization */
        .progress-bar {
            height: 10px;
            background-color: #f1f5f9;
            border-radius: 5px;
            overflow: hidden;
            margin: 0.5em 0;
        }
        .progress-fill {
            height: 100%;
            background-color: #0ea5e9;
            border-radius: 5px;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 3em;
            padding-top: 1.5em;
            border-top: 1px solid #e2e8f0;
            font-size: 9pt;
            color: #64748b;
        }
        
        /* Responsive Design */
        @media screen and (max-width: 768px) {
            body {
                font-size: 10pt;
            }
            .container {
                padding: 0 20px;
            }
            .flex-container {
                flex-direction: column;
                gap: 10px;
            }
            .flex-item {
                width: 100%;
                min-width: 100%;
            }
            .header > div {
                flex-direction: column;
                text-align: center;
            }
            .header > div > div {
                flex: none;
                width: 100%;
                text-align: center;
                margin-bottom: 15px;
            }
            h1 {
                font-size: 22pt;
            }
            h2 {
                font-size: 16pt;
            }
            h3 {
                font-size: 13pt;
            }
            table {
                font-size: 9pt;
            }
            th, td {
                padding: 6px 4px;
            }
        }
        
        @media screen and (max-width: 480px) {
            body {
                font-size: 9pt;
            }
            .container {
                padding: 0 15px;
                max-width: 100%;
                margin: 0 auto;
            }
            h1 {
                font-size: 18pt;
            }
            h2 {
                font-size: 14pt;
            }
            .card {
                padding: 12px;
            }
            .stat-value {
                font-size: 16pt;
            }
        }
        
        /* Print Optimizations */
        @media print {
            .page-break {
                page-break-before: always;
            }
            .no-break {
                page-break-inside: avoid;
            }
            table { page-break-inside: auto }
            tr { page-break-inside: avoid; page-break-after: auto }
            thead { display: table-header-group }
            tfoot { display: table-footer-group }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="border-bottom: 2px solid #0284c7; padding-bottom: 15px; margin-bottom: 20px;">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center;" class="responsive-header">
                <div style="flex: 1; min-width: 200px;" class="logo-container">
                    @php
                        $svgPath = public_path('images/logos/refineanalysis.svg');
                        $svgData = '';
                        if (file_exists($svgPath)) {
                            $svgData = file_get_contents($svgPath);
                        }
                    @endphp
                    
                    @if(!empty($svgData))
                        <div style="max-width: 180px; margin: 0 auto;" class="logo">{!! $svgData !!}</div>
                    @else
                        <h2 style="color: #0284c7; font-size: 28px; margin-bottom: 5px; font-weight: bold; text-align: center;">REFINE ANALYSIS</h2>
                    @endif
                    <p style="color: #64748b; font-size: 14px; margin-top: 5px; text-align: center;">Professional Data Services</p>
                </div>
                
                <div style="text-align: right; flex: 1; min-width: 200px;" class="report-header-info">
                    <h3 style="color: #0284c7; font-size: 20px; margin-bottom: 8px;">Analytics Report</h3>
                    <div class="report-id" style="margin-bottom: 6px; padding: 4px 10px; background-color: #f0f9ff; display: inline-block; border-radius: 4px; border: 1px solid #bae6fd;">
                        {{ $data['site_info']['report_id'] }}
                    </div>
                    <p style="color: #64748b; font-size: 12px; margin-top: 5px;">Generated: {{ $data['site_info']['export_date'] }}</p>
                </div>
            </div>
            
            <div style="margin-top: 15px; padding-top: 10px; border-top: 1px dashed #e2e8f0; font-size: 11px; color: #64748b; text-align: center;">
                <p style="margin: 0;">{{ $data['site_info']['name'] }} v{{ $data['site_info']['version'] }} • {{ $data['site_info']['system_info']['php_version'] }} • {{ $data['site_info']['system_info']['laravel_version'] }}</p>
            </div>
        </div>

        
        <div class="section">
            <h2>Profile Information</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <td>{{ $data['profile']['id'] }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $data['profile']['name'] }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $data['profile']['email'] }}</td>
                </tr>
                <tr>
                    <th>Account Created</th>
                    <td>{{ $data['profile']['created_at'] }}</td>
                </tr>
                <tr>
                    <th>Last Updated</th>
                    <td>{{ $data['profile']['updated_at'] }}</td>
                </tr>
            </table>
        </div>
        
        @if(!empty($data['branding']))
        <div class="section">
            <h2>Branding Settings</h2>
            <table>
                @foreach($data['branding'] as $key => $value)
                    @if(!is_array($value))
                    <tr>
                        <th>{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                        <td>{{ $value }}</td>
                    </tr>
                    @endif
                @endforeach
            </table>
        </div>
        @endif
        
        @if(!empty($data['advanced_settings']))
        <div class="section">
            <h2>Advanced Settings</h2>
            <table>
                @foreach($data['advanced_settings'] as $key => $value)
                    <tr>
                        <th>{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                        <td>
                            @if(is_bool($value))
                                {{ $value ? 'Yes' : 'No' }}
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        @endif
        
        <!-- Account Activity Section -->
        @if(!empty($data['activity']))
        <div class="section">
            <h2>Account Activity</h2>
            
            <div style="margin-bottom: 20px;">
                <h3 style="color: #0369a1; font-size: 16px; margin-bottom: 10px;">Last 30 Days Summary</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                    @foreach($data['activity']['last_30_days'] as $activityName => $count)
                    <div style="flex: 1; min-width: 120px; background-color: #f0f9ff; padding: 15px; border-radius: 8px; text-align: center;">
                        <h4 style="margin: 0 0 5px 0; color: #0284c7; font-size: 14px;">{{ ucwords(str_replace('_', ' ', $activityName)) }}</h4>
                        <p style="font-size: 24px; font-weight: bold; margin: 0; color: #0369a1;">{{ $count }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <h3 style="color: #0369a1; font-size: 16px; margin-bottom: 10px;">Monthly Activity</h3>
            <div style="height: 200px; background-color: #f8fafc; padding: 20px; border-radius: 8px;">
                <!-- Activity Bar Chart -->
                <div style="display: flex; height: 150px; align-items: flex-end; justify-content: space-between;">
                    @foreach($data['activity']['monthly_activity'] as $month => $value)
                        @php 
                            $percentage = min(100, ($value / 30) * 100);
                            $height = max(5, $percentage * 1.5);
                        @endphp
                        <div style="flex: 1; text-align: center;">
                            <div style="margin: 0 auto; width: 30px; height: {{ $height }}px; background-color: #0284c7; border-radius: 4px 4px 0 0;"></div>
                            <p style="margin: 5px 0 0 0; font-size: 12px; color: #64748b;">{{ $month }}</p>
                            <p style="margin: 0; font-size: 10px; color: #94a3b8;">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        
        <!-- Milestones Section -->
        @if(!empty($data['milestones']))
        <div class="section">
            <h2>Milestones</h2>
            
            <div style="position: relative; padding-left: 30px; margin-top: 20px;">
                <!-- Vertical Timeline Line -->
                <div style="position: absolute; top: 0; bottom: 0; left: 10px; width: 2px; background-color: #e2e8f0;"></div>
                
                @foreach($data['milestones'] as $milestone)
                <div style="position: relative; margin-bottom: 30px;">
                    <!-- Milestone Dot -->
                    <div style="position: absolute; left: -30px; width: 20px; height: 20px; border-radius: 50%; 
                        background-color: {{ $milestone['status'] == 'completed' ? '#10b981' : ($milestone['status'] == 'pending' ? '#f59e0b' : '#94a3b8') }}; 
                        border: 3px solid #fff; box-shadow: 0 0 0 2px {{ $milestone['status'] == 'completed' ? '#d1fae5' : ($milestone['status'] == 'pending' ? '#fef3c7' : '#f1f5f9') }};"></div>
                    
                    <!-- Milestone Content -->
                    <div style="background-color: #f8fafc; border-radius: 8px; padding: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                            <h3 style="margin: 0; font-size: 16px; color: #0f172a;">{{ $milestone['title'] }}</h3>
                            <span style="font-size: 12px; color: #64748b;">{{ $milestone['date'] }}</span>
                        </div>
                        <p style="margin: 0; font-size: 14px; color: #475569;">{{ $milestone['description'] }}</p>
                        <div style="margin-top: 10px;">
                            <span style="display: inline-block; padding: 4px 8px; font-size: 12px; border-radius: 20px; 
                                background-color: {{ $milestone['status'] == 'completed' ? '#ecfdf5' : ($milestone['status'] == 'pending' ? '#fffbeb' : '#f8fafc') }}; 
                                color: {{ $milestone['status'] == 'completed' ? '#10b981' : ($milestone['status'] == 'pending' ? '#f59e0b' : '#94a3b8') }};">{{ ucfirst($milestone['status']) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Productivity Analysis -->
        <div class="section no-break">
            <h2>Productivity Analysis</h2>
            
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5em;">
                    <h3>System Engagement</h3>
                    
                    @php
                        $engagementScore = $data['profile']['engagement_score'] ?? 0;
                        $engagementColor = '#94a3b8'; // Default gray
                        $engagementClass = 'low';
                        
                        if ($engagementScore >= 80) {
                            $engagementColor = '#10b981'; // Green for high
                            $engagementClass = 'excellent';
                        } elseif ($engagementScore >= 50) {
                            $engagementColor = '#0284c7'; // Blue for medium
                            $engagementClass = 'good';
                        } elseif ($engagementScore >= 30) {
                            $engagementColor = '#f59e0b'; // Yellow for low-medium
                            $engagementClass = 'average';
                        } else {
                            $engagementColor = '#ef4444'; // Red for low
                            $engagementClass = 'low';
                        }
                    @endphp
                    
                    <div class="stat-badge" style="background-color: {{ $engagementColor }}; color: white;">
                        Engagement Score: {{ $engagementScore }}/100 ({{ ucfirst($engagementClass) }})
                    </div>
                </div>
                
                <!-- Productivity Stats -->
                <div class="flex-container">
                    @if(isset($data['profile']['productivity']))
                        <div class="flex-item">
                            <div class="stat-card">
                                <h4>Tasks Completed</h4>
                                <p class="stat-value">{{ $data['profile']['productivity']['completed_tasks'] }}/{{ $data['profile']['productivity']['total_tasks'] }}</p>
                                <p class="text-small text-muted">{{ $data['profile']['productivity']['task_completion_rate'] }}% completion rate</p>
                                
                                <!-- Task Completion Progress Bar -->
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $data['profile']['productivity']['task_completion_rate'] }}%;"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex-item">
                            <div class="stat-card">
                                <h4>Active Projects</h4>
                                <p class="stat-value">{{ $data['profile']['productivity']['active_projects'] }}</p>
                                @php
                                    $totalProjects = count($data['projects'] ?? []);
                                    $activePercentage = $totalProjects > 0 ? round(($data['profile']['productivity']['active_projects'] / $totalProjects) * 100) : 0;
                                @endphp
                                <p class="text-small text-muted">{{ $activePercentage }}% of total projects</p>
                                
                                <!-- Active Projects Progress Bar -->
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $activePercentage }}%; background-color: #6366f1;"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex-item">
                        <div class="stat-card">
                            <h4>Account Age</h4>
                            <p class="stat-value">{{ $data['profile']['account_age_days'] }}</p>
                            <p class="text-small text-muted">days ({{ $data['profile']['account_age_months'] }} months)</p>
                        </div>
                    </div>
                </div>
                
                <!-- Work Patterns Visualization -->
                @if(!empty($data['usage_patterns']))
                <div style="margin-top: 2.5em;" class="no-break">
                    <div class="section-divider"></div>
                    <h3>Usage Patterns Analysis</h3>
                    
                    <div class="card" style="padding: 20px; background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        @php
                            $patterns = $data['usage_patterns'];
                            $total = array_sum($patterns);
                            $maxValue = max($patterns);
                            
                            // Determine the peak time
                            $peakTime = 'evening';
                            foreach($patterns as $time => $value) {
                                if($value == $maxValue) {
                                    $peakTime = $time;
                                    break;
                                }
                            }
                            
                            $timeLabels = [
                                'morning' => '5am-12pm',
                                'afternoon' => '12pm-5pm',
                                'evening' => '5pm-10pm',
                                'night' => '10pm-5am'
                            ];
                            
                            $timeDescriptions = [
                                'morning' => 'Early sessions, fresh productivity',
                                'afternoon' => 'Business hours activity',
                                'evening' => 'After hours productivity',
                                'night' => 'Late night work sessions'
                            ];
                        @endphp
                        
                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                            <div style="flex: 3;">
                                <p class="text-bold" style="margin-bottom: 5px;">Peak Activity Time: <span style="color: #0284c7;">{{ ucfirst($peakTime) }}</span></p>
                                <p class="text-small text-muted" style="margin: 0;">{{ $timeDescriptions[$peakTime] }}</p>
                            </div>
                            <div style="flex: 1; text-align: right;">
                                <div class="stat-badge" style="margin: 0;">{{ round(($maxValue/$total) * 100) }}% of activity</div>
                            </div>
                        </div>
                        
                        <!-- Time pattern bars with enhanced visualization -->
                        <div style="height: 180px; display: flex; align-items: flex-end; justify-content: space-around; margin-top: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">
                            @foreach($patterns as $time => $value)
                                @php 
                                    $percentage = $total > 0 ? (($value / $total) * 100) : 0;
                                    $height = max(20, $percentage * 1.5);
                                    // Create gradient colors for bars
                                    if ($time == $peakTime) {
                                        $gradientColor = 'linear-gradient(to top, #0284c7, #38bdf8)';
                                    } else {
                                        $gradientColor = 'linear-gradient(to top, #64748b, #94a3b8)';
                                    }
                                @endphp
                                <div style="flex: 1; text-align: center; padding: 0 5px; position: relative;">
                                    <div style="margin: 0 auto; width: 45px; height: {{ $height }}px; background: {{ $gradientColor }}; border-radius: 6px 6px 0 0; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                        <div style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-weight: 600; color: {{ $time == $peakTime ? '#0284c7' : '#64748b' }};">{{ round($percentage) }}%</div>
                                    </div>
                                    <p style="margin: 10px 0 0 0; font-size: 12px; font-weight: 600; color: {{ $time == $peakTime ? '#0284c7' : '#475569' }};">{{ $timeLabels[$time] }}</p>
                                </div>
                            @endforeach
                        </div>
                        
                        <div style="margin-top: 15px; border-top: 1px dashed #e2e8f0; padding-top: 15px;">
                            <p class="text-small" style="color: #475569;"><span class="text-bold">Analysis:</span> User demonstrates {{ $peakTime == 'morning' ? 'early bird' : ($peakTime == 'night' ? 'night owl' : 'standard business hours') }} work patterns. {{ $maxValue > ($total/2) ? 'Activity is strongly concentrated during ' . $peakTime . ' hours.' : 'Activity is distributed across multiple time periods with a preference for ' . $peakTime . '.' }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Projects Section with Distribution Diagram -->
        @if(!empty($data['projects']) || !empty($data['project_distribution']))
        <div class="section">
            <h2>Projects Analysis</h2>
            
            <!-- Project Categories Distribution -->
            @if(!empty($data['project_categories']))
            <div style="margin-bottom: 30px;">
                <h3 style="color: #0369a1; font-size: 16px; margin-bottom: 15px;">Project Categories</h3>
                
                <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;" class="responsive-chart-container">
                    <!-- Horizontal Bar Chart -->
                    <div style="flex: 2; height: auto; min-width: 250px; width: 100%; padding: 15px;" class="chart-container">
                        @php
                            $categories = $data['project_categories'];
                            $maxCategory = max($categories) > 0 ? max($categories) : 1;
                            $colors = [
                                'analysis' => '#0369a1',
                                'reporting' => '#059669',
                                'research' => '#7c3aed',
                                'other' => '#94a3b8'
                            ];
                        @endphp
                        
                        <!-- Category bars with responsive design -->
                        @foreach($categories as $category => $count)
                            @php 
                                $width = ($count / $maxCategory) * 100;
                                $color = isset($colors[$category]) ? $colors[$category] : '#94a3b8';
                            @endphp
                            <div style="margin-bottom: 15px;" class="chart-bar">
                                <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 14px; color: #0f172a; margin-right: 10px;">{{ ucfirst($category) }}</span>
                                    <span style="font-size: 14px; color: #64748b;">{{ $count }}</span>
                                </div>
                                <div style="height: 14px; width: 100%; background-color: #f1f5f9; border-radius: 7px; overflow: hidden; box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);">
                                    <div style="height: 100%; width: {{ $width }}%; background: linear-gradient(to right, {{ $color }}DD, {{ $color }}); border-radius: 7px;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Project Status Distribution Pie Chart -->
            @if(!empty($data['project_distribution']))
            <div style="margin-bottom: 30px;">
                <h3 style="color: #0369a1; font-size: 16px; margin-bottom: 15px;">Project Status Distribution</h3>
                
                <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center;" class="responsive-chart">
                    <!-- Pie Chart Visualization - Responsive -->>
                    <div style="width: 240px; height: 240px; position: relative; margin: 0 auto 20px auto;" class="pie-chart-container">
                        @php
                            $total = array_sum($data['project_distribution']);
                            $colors = [
                                'active' => '#0284c7',     // Blue
                                'completed' => '#10b981', // Green
                                'pending' => '#f59e0b',   // Yellow
                                'archived' => '#94a3b8'   // Gray
                            ];
                            $startAngle = 0;
                        @endphp
                        
                        @if($total > 0)
                            <svg width="240" height="240" viewBox="0 0 240 240" style="max-width: 100%; height: auto;">
                                <!-- Background Circle with Shadow -->
                                <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
                                    <feDropShadow dx="0" dy="1" stdDeviation="2" flood-opacity="0.1" />
                                </filter>
                                <circle cx="120" cy="120" r="100" fill="#f8fafc" filter="url(#shadow)"/>

                                @foreach($data['project_distribution'] as $status => $count)
                                    @if($count > 0)
                                        @php
                                            $percentage = ($count / $total) * 100;
                                            $sliceAngle = ($percentage / 100) * 360;
                                            $endAngle = $startAngle + $sliceAngle;
                                            
                                            // Calculate SVG arc path
                                            $x1 = 120 + 100 * cos(deg2rad($startAngle - 90));
                                            $y1 = 120 + 100 * sin(deg2rad($startAngle - 90));
                                            $x2 = 120 + 100 * cos(deg2rad($endAngle - 90));
                                            $y2 = 120 + 100 * sin(deg2rad($endAngle - 90));
                                            
                                            $largeArcFlag = $sliceAngle > 180 ? 1 : 0;
                                            
                                            $path = "M 120 120 L $x1 $y1 A 100 100 0 $largeArcFlag 1 $x2 $y2 Z";
                                            
                                            // Calculate position for percentage label
                                            $midAngle = $startAngle + ($sliceAngle / 2);
                                            $labelRadius = 70; // Distance from center for label
                                            $labelX = 120 + $labelRadius * cos(deg2rad($midAngle - 90));
                                            $labelY = 120 + $labelRadius * sin(deg2rad($midAngle - 90));
                                            
                                            // Only show percentage labels for slices bigger than 10%
                                            $showLabel = $percentage >= 10;
                                        @endphp
                                        
                                        <path d="{{ $path }}" fill="{{ $colors[$status] }}" stroke="white" stroke-width="2" />
                                        
                                        @if($showLabel)
                                        <text x="{{ $labelX }}" y="{{ $labelY }}" text-anchor="middle" fill="white" font-weight="bold" font-size="12">
                                            {{ round($percentage) }}%
                                        </text>
                                        @endif
                                        
                                        @php
                                            $startAngle = $endAngle;
                                        @endphp
                                    @endif
                                @endforeach
                                
                                <!-- Center hole for donut chart with project count -->
                                <circle cx="120" cy="120" r="50" fill="white" stroke="#f1f5f9" stroke-width="1"/>
                                <text x="120" y="115" text-anchor="middle" font-size="14" font-weight="bold" fill="#0f172a">{{ $total }}</text>
                                <text x="120" y="135" text-anchor="middle" font-size="12" fill="#64748b">Projects</text>
                            </svg>
                        @else
                            <div style="display: flex; height: 100%; align-items: center; justify-content: center; text-align: center;">
                                <p style="color: #94a3b8;">No project data</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Legend - Responsive -->
                    <div style="padding: 0 15px; flex: 1; min-width: 200px;" class="chart-legend">
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-wrap: wrap; justify-content: center;">
                            @foreach($data['project_distribution'] as $status => $count)
                                @if($count > 0)
                                    @php
                                        $percentage = ($count / $total) * 100;
                                    @endphp
                                    <li style="display: flex; align-items: center; margin: 0 15px 15px 0; padding: 8px 12px; background-color: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                                        <span style="display: inline-block; width: 16px; height: 16px; border-radius: 4px; background-color: {{ $colors[$status] }}; margin-right: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);"></span>
                                        <div>
                                            <div style="color: #334155; font-size: 14px; font-weight: 600;">{{ ucfirst($status) }}</div>
                                            <div style="color: #64748b; font-size: 12px;">{{ $count }} ({{ round($percentage) }}%)</div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Project List -->
            @if(!empty($data['projects']))
            <h3 style="color: #0369a1; font-size: 16px; margin-bottom: 10px;">Project Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['projects'] as $project)
                    <tr>
                        <td>{{ $project['name'] }}</td>
                        <td>{{ $project['description'] ?? '-' }}</td>
                        <td>{{ ucfirst($project['status']) }}</td>
                        <td>{{ $project['created_at'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        @endif
        
        <!-- Enhanced Account Journey Section -->
        @if(!empty($data['account_journey']))
        <div class="section">
            <h2>Account Journey & System Usage</h2>
            
            <!-- Usage Summary -->
            <div class="card" style="margin-bottom: 25px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                    <h3 style="margin: 0;">System Usage Summary</h3>
                    <div class="stat-badge" style="background: linear-gradient(135deg, #0ea5e9, #0284c7); color: white;">
                        {{ $data['account_journey']['statistics']['activity_level'] }}% Activity Level
                    </div>
                </div>
                
                <div class="flex-container" style="margin: 20px 0;">
                    <div class="flex-item">
                        <div class="stat-card" style="background: linear-gradient(to bottom right, #f0f9ff, #e0f2fe);">
                            <h4>Total Time in System</h4>
                            <p class="stat-value">{{ $data['account_journey']['total_hours'] }}</p>
                            <p class="text-muted">hours</p>
                        </div>
                    </div>
                    
                    <div class="flex-item">
                        <div class="stat-card" style="background: linear-gradient(to bottom right, #f0f9ff, #e0f2fe);">
                            <h4>Active Days</h4>
                            <p class="stat-value">{{ $data['account_journey']['active_days'] }}</p>
                            <p class="text-muted">of {{ $data['account_journey']['total_days'] }} total days</p>
                            
                            <!-- Usage Ratio Bar -->
                            <div class="progress-bar" style="margin-top: 8px;">
                                <div class="progress-fill" style="width: {{ min(100, max(1, round(($data['account_journey']['active_days'] / max(1, $data['account_journey']['total_days'])) * 100))) }}%;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-item">
                        <div class="stat-card" style="background: linear-gradient(to bottom right, #f0f9ff, #e0f2fe);">
                            <h4>Daily Average</h4>
                            <p class="stat-value">{{ $data['account_journey']['statistics']['average_daily_hours'] }}</p>
                            <p class="text-muted">hours per active day</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Interactive Journey Timeline Visualization -->
            <div class="card no-break" style="margin-bottom: 25px; position: relative; overflow: hidden;">
                <h3>Account Timeline</h3>
                <p class="text-muted" style="margin-bottom: 20px;">Key milestones and events in your journey</p>
                
                <!-- Journey Path Visualization -->
                <div style="position: relative; height: 160px; margin: 40px 0 60px;">
                    <!-- Timeline Base Line with Gradient -->
                    <div style="position: absolute; top: 60px; left: 0; right: 0; height: 6px; background: linear-gradient(to right, #bfdbfe, #0ea5e9); border-radius: 3px; z-index: 1;"></div>
                    
                    <!-- Timeline Points from Journey Data -->
                    @foreach($data['account_journey']['journey_points'] as $point)
                        <div style="position: absolute; top: 40px; left: {{ $point['position'] }}%; transform: translateX(-50%); z-index: 2;">
                            <!-- Timeline Node with Icon -->
                            @php
                                // Icon selector based on point type
                                $iconHtml = '';
                                $iconColor = '#0284c7';
                                
                                if ($point['icon'] == 'account_creation') {
                                    $iconHtml = '<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>';
                                    $iconColor = '#0284c7';
                                } elseif ($point['icon'] == 'project') {
                                    $iconHtml = '<path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/>';
                                    $iconColor = '#059669';
                                } elseif ($point['icon'] == 'peak') {
                                    $iconHtml = '<path d="M14.4 6L14 4H5v17h2v-7h5.6l.4 2h7V6h-5.6z"/>';
                                    $iconColor = '#d97706';
                                } elseif ($point['icon'] == 'team') {
                                    $iconHtml = '<path d="M9 13.75c-2.34 0-7 1.17-7 3.5V19h14v-1.75c0-2.33-4.66-3.5-7-3.5zM4.34 17c.84-.58 2.87-1.25 4.66-1.25s3.82.67 4.66 1.25H4.34zM9 12c1.93 0 3.5-1.57 3.5-3.5S10.93 5 9 5 5.5 6.57 5.5 8.5 7.07 12 9 12zm0-5c.83 0 1.5.67 1.5 1.5S9.83 10 9 10s-1.5-.67-1.5-1.5S8.17 7 9 7zm7.04 6.81c1.16.84 1.96 1.96 1.96 3.44V19h4v-1.75c0-2.02-3.5-3.17-5.96-3.44zM15 12c1.93 0 3.5-1.57 3.5-3.5S16.93 5 15 5c-.54 0-1.04.13-1.5.35.63.89 1 1.98 1 3.15s-.37 2.26-1 3.15c.46.22.96.35 1.5.35z"/>';
                                    $iconColor = '#7c3aed';
                                } elseif ($point['icon'] == 'current') {
                                    $iconHtml = '<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>';
                                    $iconColor = '#6366f1';
                                }
                            @endphp
                            
                            <div style="position: relative;">
                                <div style="width: 40px; height: 40px; background-color: white; border: 2px solid {{ $iconColor }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 3px 6px rgba(0,0,0,0.12);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{ $iconColor }}">
                                        {!! $iconHtml !!}
                                    </svg>
                                </div>
                                
                                <!-- Progress Line from Dot to Label -->
                                <div style="position: absolute; top: 40px; left: 50%; width: 2px; height: 20px; background-color: {{ $iconColor }}; transform: translateX(-50%);"></div>
                                
                                <!-- Label Container -->
                                <div style="position: absolute; top: 60px; left: 50%; transform: translateX(-50%); width: 120px; background-color: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); text-align: center;">
                                    <p style="margin: 0 0 4px 0; font-size: 12px; font-weight: 600; color: {{ $iconColor }};">{{ $point['label'] }}</p>
                                    <p style="margin: 0; font-size: 11px; color: #64748b;">{{ $point['date'] }}</p>
                                </div>
                                
                                <!-- Description Popup (only for non-mobile) -->
                                <div style="position: absolute; width: 150px; top: -50px; left: 50%; transform: translateX(-50%); background-color: #1e293b; color: white; border-radius: 6px; padding: 8px; font-size: 11px; text-align: center; opacity: 0.9;">
                                    {{ $point['description'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- System Usage Diagram -->
                <div style="margin-top: 50px; padding-top: 20px; border-top: 1px dashed #e2e8f0;">
                    <h4 style="margin-bottom: 15px;">System Usage Statistics</h4>
                    
                    <div class="flex-container">
                        <div class="flex-item" style="flex: 2;">
                            <!-- Account Activity Diagram -->
                            <div style="background-color: #f8fafc; border-radius: 10px; padding: 15px; height: 160px; position: relative; overflow: hidden;">
                                <!-- Y-axis labels -->
                                <div style="position: absolute; left: 5px; top: 5px; bottom: 25px; width: 25px; display: flex; flex-direction: column; justify-content: space-between;">
                                    <span style="font-size: 9px; color: #64748b;">High</span>
                                    <span style="font-size: 9px; color: #64748b;">Med</span>
                                    <span style="font-size: 9px; color: #64748b;">Low</span>
                                </div>
                                
                                <!-- Activity Wave Pattern -->
                                <div style="position: absolute; left: 35px; right: 10px; top: 10px; bottom: 25px;">
                                    <svg width="100%" height="100%" viewBox="0 0 300 100" preserveAspectRatio="none">
                                        <!-- Background Grid -->
                                        <line x1="0" y1="0" x2="300" y2="0" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2,2" />
                                        <line x1="0" y1="50" x2="300" y2="50" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2,2" />
                                        <line x1="0" y1="100" x2="300" y2="100" stroke="#e2e8f0" stroke-width="1" />
                                        
                                        <!-- Activity Wave (generated based on journey points) -->
                                        @php
                                            // Generate wave points based on journey
                                            $wavePoints = "0,100 "; // Start at bottom left
                                            $journeyLength = count($data['account_journey']['journey_points']);
                                            $activityLevel = $data['account_journey']['statistics']['activity_level'];
                                            
                                            // Account start (low activity)
                                            $wavePoints .= "30,90 ";
                                            
                                            // Progressive increase in activity
                                            $wavePoints .= "60," . (100 - min(80, $activityLevel)) . " ";
                                            
                                            // Peak activity
                                            $peakActivity = 100 - min(95, max(30, $activityLevel + 10));
                                            $wavePoints .= "150," . $peakActivity . " ";
                                            
                                            // Recent activity level
                                            $recentLevel = 100 - min(90, max(20, $activityLevel));
                                            $wavePoints .= "250," . $recentLevel . " ";
                                            
                                            // Complete the path
                                            $wavePoints .= "300," . $recentLevel . " 300,100 0,100";
                                        @endphp
                                        
                                        <defs>
                                            <linearGradient id="activityGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                                <stop offset="0%" stop-color="#0ea5e9" stop-opacity="0.7" />
                                                <stop offset="100%" stop-color="#e0f2fe" stop-opacity="0.3" />
                                            </linearGradient>
                                        </defs>
                                        
                                        <!-- Fill area -->
                                        <path d="{{ $wavePoints }}" fill="url(#activityGradient)" />
                                        
                                        <!-- Stroke line -->
                                        <path d="{{ substr($wavePoints, 0, strrpos($wavePoints, ' 300,100 0,100')) }}" fill="none" stroke="#0284c7" stroke-width="2" />
                                    </svg>
                                </div>
                                
                                <!-- X-axis labels -->
                                <div style="position: absolute; left: 35px; right: 10px; bottom: 5px; display: flex; justify-content: space-between;">
                                    <span style="font-size: 9px; color: #64748b;">Start</span>
                                    <span style="font-size: 9px; color: #64748b;">Mid Journey</span>
                                    <span style="font-size: 9px; color: #64748b;">Current</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex-item" style="flex: 1;">
                            <!-- Account Metrics -->
                            <div style="height: 100%;">
                                <div style="margin-bottom: 15px; padding: 12px; background-color: #f0f9ff; border-radius: 8px; border-left: 4px solid #0284c7;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 13px; font-weight: 600; color: #0f172a;">Projects Created</span>
                                        <span style="font-size: 16px; font-weight: 700; color: #0284c7;">{{ $data['account_journey']['projects_created'] }}</span>
                                    </div>
                                </div>
                                
                                <div style="margin-bottom: 15px; padding: 12px; background-color: #f0f9ff; border-radius: 8px; border-left: 4px solid #0284c7;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 13px; font-weight: 600; color: #0f172a;">Team Size</span>
                                        <span style="font-size: 16px; font-weight: 700; color: #0284c7;">{{ $data['account_journey']['team_size'] }}</span>
                                    </div>
                                </div>
                                
                                <div style="padding: 12px; background-color: #f0f9ff; border-radius: 8px; border-left: 4px solid #0284c7;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 13px; font-weight: 600; color: #0f172a;">Login Frequency</span>
                                        <span style="font-size: 16px; font-weight: 700; color: #0284c7;">{{ number_format($data['account_journey']['statistics']['login_frequency'], 2) }}</span>
                                    </div>
                                    <p style="margin: 5px 0 0 0; font-size: 11px; color: #64748b;">logins per day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- User Journey Timeline -->
        @if(!empty($data['usage_timeline']))
        <div class="section">
            <h2>Account Journey</h2>
            <div style="margin: 20px 0; padding: 15px; background-color: #f8fafc; border-radius: 8px;">
                <!-- Linear Journey Timeline -->
                <div style="position: relative; height: 80px; margin: 20px 0;">
                    <!-- Timeline Base Line -->
                    <div style="position: absolute; top: 40px; left: 0; right: 0; height: 4px; background-color: #e2e8f0; border-radius: 2px;"></div>
                    
                    <!-- Timeline Points -->
                    @php
                        $points = [
                            'signup' => ['label' => 'Account Created', 'position' => 0],
                            'first_quarter' => ['label' => 'First Quarter', 'position' => 25],
                            'mid_point' => ['label' => 'Mid Journey', 'position' => 50], 
                            'current' => ['label' => 'Current', 'position' => 100],
                        ];
                    @endphp
                    
                    @foreach($points as $key => $point)
                        <div style="position: absolute; top: 30px; left: {{ $point['position'] }}%; transform: translateX(-50%);">
                            <!-- Timeline Dot -->
                            <div style="width: 16px; height: 16px; background-color: #0284c7; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px #bae6fd; margin: 0 auto;"></div>
                            
                            <!-- Label -->
                            <div style="text-align: center; margin-top: 10px;">
                                <p style="margin: 0; font-size: 12px; font-weight: bold; color: #0f172a;">{{ $point['label'] }}</p>
                                <p style="margin: 0; font-size: 10px; color: #64748b;">{{ $data['usage_timeline'][$key] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Journey Stats -->
                <div style="margin-top: 30px; display: flex; flex-wrap: wrap; gap: 15px; justify-content: space-around;">
                    <div style="text-align: center; padding: 10px;">
                        <p style="margin: 0; font-size: 12px; color: #64748b;">Account Age</p>
                        <p style="margin: 0; font-size: 18px; font-weight: bold; color: #0284c7;">{{ $data['profile']['account_age_days'] }} days</p>
                    </div>
                    
                    <div style="text-align: center; padding: 10px;">
                        <p style="margin: 0; font-size: 12px; color: #64748b;">Login Count</p>
                        <p style="margin: 0; font-size: 18px; font-weight: bold; color: #0284c7;">{{ $data['profile']['login_count'] }}</p>
                    </div>
                    
                    <div style="text-align: center; padding: 10px;">
                        <p style="margin: 0; font-size: 12px; color: #64748b;">Projects</p>
                        <p style="margin: 0; font-size: 18px; font-weight: bold; color: #0284c7;">{{ count($data['projects'] ?? []) }}</p>
                    </div>
                    
                    <div style="text-align: center; padding: 10px;">
                        <p style="margin: 0; font-size: 12px; color: #64748b;">Team Members</p>
                        <p style="margin: 0; font-size: 18px; font-weight: bold; color: #0284c7;">{{ count($data['team_members'] ?? []) }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        @if(!empty($data['team_members']))
        <div class="section">
            <h2>Team Members</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Added On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['team_members'] as $member)
                    <tr>
                        <td>{{ $member['name'] }}</td>
                        <td>{{ $member['email'] }}</td>
                        <td>{{ ucfirst($member['role']) }}</td>
                        <td>{{ ucfirst($member['status']) }}</td>
                        <td>{{ $member['created_at'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</body>
</html>
