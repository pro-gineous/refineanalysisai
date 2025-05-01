<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserEvent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'event_type',
        'event_name',
        'page',
        'section',
        'action',
        'metadata',
        'session_id',
        'ip_address',
        'device_type',
        'browser',
        'os',
        'event_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'event_time' => 'datetime',
    ];

    /**
     * Get the user that owns the event.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Record a new user event
     *
     * @param int $userId
     * @param string $eventType
     * @param string $eventName
     * @param array $attributes
     * @return \App\Models\UserEvent
     */
    public static function recordEvent($userId, $eventType, $eventName, array $attributes = [])
    {
        $event = new static();
        $event->user_id = $userId;
        $event->event_type = $eventType;
        $event->event_name = $eventName;
        $event->event_time = now();
        
        // Optional attributes
        if (isset($attributes['page'])) $event->page = $attributes['page'];
        if (isset($attributes['section'])) $event->section = $attributes['section'];
        if (isset($attributes['action'])) $event->action = $attributes['action'];
        if (isset($attributes['metadata'])) $event->metadata = $attributes['metadata'];
        
        // Session and device info (if available in request)
        $request = request();
        if ($request) {
            $event->session_id = $request->session()->getId();
            $event->ip_address = $request->ip();
            
            $agent = $request->userAgent();
            if ($agent) {
                // Simple device detection
                if (preg_match('/(tablet|ipad|playbook)/i', $agent)) {
                    $event->device_type = 'tablet';
                } else if (preg_match('/(mobile|android|iphone)/i', $agent)) {
                    $event->device_type = 'mobile';
                } else {
                    $event->device_type = 'desktop';
                }
                
                // Basic browser detection
                if (preg_match('/MSIE/i', $agent) || preg_match('/Trident/i', $agent)) {
                    $event->browser = 'Internet Explorer';
                } else if (preg_match('/Edge/i', $agent)) {
                    $event->browser = 'Microsoft Edge';
                } else if (preg_match('/Firefox/i', $agent)) {
                    $event->browser = 'Firefox';
                } else if (preg_match('/Chrome/i', $agent)) {
                    $event->browser = 'Chrome';
                } else if (preg_match('/Safari/i', $agent)) {
                    $event->browser = 'Safari';
                } else if (preg_match('/Opera/i', $agent)) {
                    $event->browser = 'Opera';
                } else {
                    $event->browser = 'Unknown';
                }
                
                // OS detection
                if (preg_match('/Windows/i', $agent)) {
                    $event->os = 'Windows';
                } else if (preg_match('/Mac/i', $agent)) {
                    $event->os = 'MacOS';
                } else if (preg_match('/Linux/i', $agent)) {
                    $event->os = 'Linux';
                } else if (preg_match('/Android/i', $agent)) {
                    $event->os = 'Android';
                } else if (preg_match('/iOS/i', $agent) || preg_match('/iPhone/i', $agent) || preg_match('/iPad/i', $agent)) {
                    $event->os = 'iOS';
                } else {
                    $event->os = 'Unknown';
                }
            }
        }
        
        $event->save();
        return $event;
    }
    
    /**
     * Get detailed real-time engagement metrics
     * 
     * @param int $limit Hours to look back
     * @return array
     */
    public static function getEngagementMetrics($limit = 24)
    {
        $startTime = now()->subHours($limit);
        $previousPeriodStart = now()->subHours($limit * 2);
        
        // Active users in current time period
        $activeUsers = static::where('event_time', '>=', $startTime)
            ->distinct('user_id')
            ->count('user_id');
            
        // Active users in previous time period (for comparison)
        $previousActiveUsers = static::where('event_time', '>=', $previousPeriodStart)
            ->where('event_time', '<', $startTime)
            ->distinct('user_id')
            ->count('user_id');
            
        // Active users growth percentage
        $activeUsersGrowth = $previousActiveUsers > 0 
            ? round((($activeUsers - $previousActiveUsers) / $previousActiveUsers) * 100, 1) 
            : ($activeUsers > 0 ? 100 : 0);
            
        // Total events in time period
        $totalEvents = static::where('event_time', '>=', $startTime)->count();
        
        // Total events in previous time period
        $previousTotalEvents = static::where('event_time', '>=', $previousPeriodStart)
            ->where('event_time', '<', $startTime)
            ->count();
            
        // Events growth percentage
        $eventsGrowth = $previousTotalEvents > 0 
            ? round((($totalEvents - $previousTotalEvents) / $previousTotalEvents) * 100, 1) 
            : ($totalEvents > 0 ? 100 : 0);
        
        // Events per user (engagement ratio)
        $eventsPerUser = $activeUsers > 0 ? round($totalEvents / $activeUsers, 2) : 0;
        
        // Previous period events per user
        $previousEventsPerUser = $previousActiveUsers > 0 
            ? round($previousTotalEvents / $previousActiveUsers, 2) 
            : 0;
            
        // Events per user growth
        $eventsPerUserGrowth = $previousEventsPerUser > 0 
            ? round((($eventsPerUser - $previousEventsPerUser) / $previousEventsPerUser) * 100, 1) 
            : ($eventsPerUser > 0 ? 100 : 0);
        
        // Calculate retention rate (users active in both periods)
        $retainedUsers = DB::table('user_events as current')
            ->join('user_events as previous', 'current.user_id', '=', 'previous.user_id')
            ->where('current.event_time', '>=', $startTime)
            ->where('previous.event_time', '>=', $previousPeriodStart)
            ->where('previous.event_time', '<', $startTime)
            ->distinct('current.user_id')
            ->count('current.user_id');
            
        $retentionRate = $previousActiveUsers > 0 
            ? round(($retainedUsers / $previousActiveUsers) * 100, 1) 
            : 0;
            
        // Calculate new user rate
        $newUsers = $activeUsers - $retainedUsers;
        $newUserRate = $activeUsers > 0 
            ? round(($newUsers / $activeUsers) * 100, 1) 
            : 0;
        
        // Get user segments by engagement level
        $userEngagementLevels = DB::table('user_events')
            ->select('user_id', DB::raw('COUNT(*) as event_count'))
            ->where('event_time', '>=', $startTime)
            ->groupBy('user_id')
            ->get();
            
        $highlyEngaged = 0;
        $moderatelyEngaged = 0;
        $lowEngaged = 0;
        
        foreach ($userEngagementLevels as $user) {
            if ($user->event_count >= 10) {
                $highlyEngaged++;
            } elseif ($user->event_count >= 5) {
                $moderatelyEngaged++;
            } else {
                $lowEngaged++;
            }
        }
        
        $engagementSegments = [
            'highly_engaged' => [
                'count' => $highlyEngaged,
                'percentage' => $activeUsers > 0 ? round(($highlyEngaged / $activeUsers) * 100, 1) : 0
            ],
            'moderately_engaged' => [
                'count' => $moderatelyEngaged,
                'percentage' => $activeUsers > 0 ? round(($moderatelyEngaged / $activeUsers) * 100, 1) : 0
            ],
            'low_engaged' => [
                'count' => $lowEngaged,
                'percentage' => $activeUsers > 0 ? round(($lowEngaged / $activeUsers) * 100, 1) : 0
            ]
        ];
        
        // Events by type (categorized)
        $eventsByType = static::where('event_time', '>=', $startTime)
            ->select('event_type', DB::raw('count(*) as count'))
            ->groupBy('event_type')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'event_type')
            ->toArray();
            
        // Events by page with growth comparison
        $currentPageEvents = static::where('event_time', '>=', $startTime)
            ->select('page', DB::raw('count(*) as count'))
            ->whereNotNull('page')
            ->groupBy('page')
            ->orderBy('count', 'desc')
            ->limit(8)
            ->get();
            
        $previousPageEvents = static::where('event_time', '>=', $previousPeriodStart)
            ->where('event_time', '<', $startTime)
            ->select('page', DB::raw('count(*) as count'))
            ->whereNotNull('page')
            ->groupBy('page')
            ->pluck('count', 'page')
            ->toArray();
            
        $eventsByPage = [];
        foreach ($currentPageEvents as $page) {
            $previousCount = $previousPageEvents[$page->page] ?? 0;
            $growth = $previousCount > 0 
                ? round((($page->count - $previousCount) / $previousCount) * 100, 1) 
                : ($page->count > 0 ? 100 : 0);
                
            $eventsByPage[$page->page] = [
                'count' => $page->count,
                'previous' => $previousCount,
                'growth' => $growth
            ];
        }
        
        // Get device distribution
        $deviceDistribution = static::where('event_time', '>=', $startTime)
            ->select('device_type', DB::raw('count(distinct user_id) as user_count'))
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->get()
            ->pluck('user_count', 'device_type')
            ->toArray();
            
        // Get browser distribution
        $browserDistribution = static::where('event_time', '>=', $startTime)
            ->select('browser', DB::raw('count(distinct user_id) as user_count'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->get()
            ->pluck('user_count', 'browser')
            ->toArray();
            
        // Get OS distribution
        $osDistribution = static::where('event_time', '>=', $startTime)
            ->select('os', DB::raw('count(distinct user_id) as user_count'))
            ->whereNotNull('os')
            ->groupBy('os')
            ->get()
            ->pluck('user_count', 'os')
            ->toArray();
        
        // Generate hourly event data for each hour (with 24-hour time format)
        $hourlyData = [];
        $hourLabels = [];
        
        // Query hourly data for the current period
        $currentHourlyData = static::where('event_time', '>=', $startTime)
            ->select(DB::raw('HOUR(event_time) as hour'), DB::raw('count(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour')
            ->toArray();
            
        // Query hourly data for the previous period
        $previousHourlyData = static::where('event_time', '>=', $previousPeriodStart)
            ->where('event_time', '<', $startTime)
            ->select(DB::raw('HOUR(event_time) as hour'), DB::raw('count(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour')
            ->toArray();
        
        for ($i = 0; $i < 24; $i++) {
            $hour = ($i + now()->hour) % 24;
            $hourLabels[] = sprintf('%02d:00', $hour);
            $hourlyData['current'][] = $currentHourlyData[$hour] ?? 0;
            $hourlyData['previous'][] = $previousHourlyData[$hour] ?? 0;
        }
        
        // Calculate engagement score (1-10 scale)
        $engagementScore = min(round($eventsPerUser * 1.5, 1), 10);
        
        return [
            // Summary metrics
            'active_users' => $activeUsers,
            'active_users_growth' => $activeUsersGrowth,
            'total_events' => $totalEvents,
            'events_growth' => $eventsGrowth,
            'events_per_user' => $eventsPerUser,
            'events_per_user_growth' => $eventsPerUserGrowth,
            'engagement_score' => $engagementScore,
            'retention_rate' => $retentionRate,
            'new_user_rate' => $newUserRate,
            
            // Detailed breakdown
            'engagement_segments' => $engagementSegments,
            'events_by_type' => $eventsByType,
            'events_by_page' => $eventsByPage,
            'device_distribution' => $deviceDistribution,
            'browser_distribution' => $browserDistribution,
            'os_distribution' => $osDistribution,
            
            // Time-series data
            'hour_labels' => $hourLabels,
            'events_by_hour' => $hourlyData,
            
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ];
    }
}
