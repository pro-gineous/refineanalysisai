<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAnalyticsController extends Controller
{
    /**
     * Display the user engagement analytics dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get engagement metrics for the dashboard
        $metrics = UserEvent::getEngagementMetrics(24); // Last 24 hours

        // Add additional metrics
        $metrics['total_users'] = User::count();
        $metrics['active_users_percentage'] = $metrics['total_users'] > 0 
            ? round(($metrics['active_users'] / $metrics['total_users']) * 100, 1) 
            : 0;

        // Get recent user events for the activity feed
        $recentEvents = UserEvent::with('user')
            ->orderBy('event_time', 'desc')
            ->limit(10)
            ->get();

        // Get device breakdown
        $deviceBreakdown = UserEvent::where('event_time', '>=', now()->subHours(24))
            ->select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'device_type')
            ->toArray();

        // Get browser breakdown
        $browserBreakdown = UserEvent::where('event_time', '>=', now()->subHours(24))
            ->select('browser', DB::raw('count(*) as count'))
            ->groupBy('browser')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->pluck('count', 'browser')
            ->toArray();

        return view('admin.analytics.engagement', compact(
            'metrics',
            'recentEvents',
            'deviceBreakdown',
            'browserBreakdown'
        ));
    }

    /**
     * Get real-time engagement metrics as JSON for AJAX requests
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMetrics(Request $request)
    {
        // Hours to look back (default 24 hours)
        $hours = $request->input('hours', 24);
        
        // Get engagement metrics
        $metrics = UserEvent::getEngagementMetrics($hours);
        
        // Add additional metrics
        $metrics['total_users'] = User::count();
        $metrics['active_users_percentage'] = $metrics['total_users'] > 0 
            ? round(($metrics['active_users'] / $metrics['total_users']) * 100, 1) 
            : 0;
        
        // Return as JSON
        return response()->json($metrics);
    }

    /**
     * Track a user event
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trackEvent(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_type' => 'required|string|max:255',
            'event_name' => 'required|string|max:255',
            'page' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'action' => 'nullable|string|max:255',
            'metadata' => 'nullable|array',
        ]);
        
        // Record the event
        $event = UserEvent::recordEvent(
            $validated['user_id'],
            $validated['event_type'],
            $validated['event_name'],
            array_filter($validated) // Remove null values
        );
        
        // Return success response
        return response()->json([
            'success' => true,
            'event_id' => $event->id,
            'timestamp' => $event->event_time->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Get event breakdown by type for a specific time period
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventsByType(Request $request)
    {
        // Hours to look back (default 24 hours)
        $hours = $request->input('hours', 24);
        $startTime = now()->subHours($hours);
        
        // Get events by type
        $eventsByType = UserEvent::where('event_time', '>=', $startTime)
            ->select('event_type', DB::raw('count(*) as count'))
            ->groupBy('event_type')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'event_type')
            ->toArray();
        
        // Return as JSON
        return response()->json([
            'events_by_type' => $eventsByType,
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Get hourly engagement data for the last N hours
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHourlyData(Request $request)
    {
        // Hours to look back (default 24 hours)
        $hours = $request->input('hours', 24);
        $startTime = now()->subHours($hours);
        
        // Get events by hour
        $eventsByHour = UserEvent::where('event_time', '>=', $startTime)
            ->select(DB::raw('HOUR(event_time) as hour'), DB::raw('count(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour')
            ->toArray();
        
        // Fill in missing hours
        $hourlyData = [];
        $hourLabels = [];
        for ($i = 0; $i < $hours; $i++) {
            $hourDate = now()->subHours($hours - $i);
            $hour = $hourDate->format('H');
            $hourLabels[] = $hourDate->format('H:00');
            $hourlyData[] = $eventsByHour[$hour] ?? 0;
        }
        
        // Return as JSON
        return response()->json([
            'labels' => $hourLabels,
            'data' => $hourlyData,
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
