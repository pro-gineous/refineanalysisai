<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Idea;
use App\Models\Project;
use App\Models\Framework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use Excel;

class ReportController extends Controller
{
    /**
     * Display the reports page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get report types
        $reportTypes = [
            'user_activity' => 'User Activity Report',
            'project_summary' => 'Project Summary Report',
            'idea_summary' => 'Idea Summary Report',
            'framework_usage' => 'Framework Usage Report',
            'system_usage' => 'System Usage Report',
        ];
        
        // Get date ranges
        $dateRanges = [
            'last_7_days' => 'Last 7 Days',
            'last_30_days' => 'Last 30 Days',
            'last_90_days' => 'Last 90 Days',
            'this_year' => 'This Year',
            'last_year' => 'Last Year',
            'all_time' => 'All Time',
            'custom' => 'Custom Range',
        ];
        
        // Get users for filter
        $users = User::orderBy('name')->get();
        
        // Get frameworks for filter
        $frameworks = Framework::orderBy('name')->get();
        
        return view('admin.reports.index', compact(
            'reportTypes',
            'dateRanges',
            'users',
            'frameworks'
        ));
    }
    
    /**
     * Generate the requested report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|string',
            'date_range' => 'required|string',
            'start_date' => 'required_if:date_range,custom|nullable|date',
            'end_date' => 'required_if:date_range,custom|nullable|date|after_or_equal:start_date',
            'user_id' => 'nullable|exists:users,id',
            'framework_id' => 'nullable|exists:frameworks,id',
            'output_format' => 'required|in:html,pdf,csv,excel',
        ]);
        
        // Calculate date range
        [$startDate, $endDate] = $this->calculateDateRange($validated['date_range'], $validated['start_date'] ?? null, $validated['end_date'] ?? null);
        
        // Generate the report data based on type
        $reportMethod = 'generate' . str_replace('_', '', ucwords($validated['report_type'], '_')) . 'Report';
        if (method_exists($this, $reportMethod)) {
            $reportData = $this->$reportMethod($startDate, $endDate, $request);
        } else {
            return back()->with('error', 'Invalid report type specified.');
        }
        
        // Output the report in the requested format
        return $this->outputReport(
            $reportData, 
            $validated['output_format'],
            $validated['report_type'],
            $startDate,
            $endDate
        );
    }
    
    /**
     * Calculate start and end dates based on the selected range.
     *
     * @param  string  $dateRange
     * @param  string|null  $startDate
     * @param  string|null  $endDate
     * @return array
     */
    private function calculateDateRange($dateRange, $startDate = null, $endDate = null)
    {
        $endDate = Carbon::now();
        
        switch ($dateRange) {
            case 'last_7_days':
                $startDate = Carbon::now()->subDays(7)->startOfDay();
                break;
            case 'last_30_days':
                $startDate = Carbon::now()->subDays(30)->startOfDay();
                break;
            case 'last_90_days':
                $startDate = Carbon::now()->subDays(90)->startOfDay();
                break;
            case 'this_year':
                $startDate = Carbon::now()->startOfYear();
                break;
            case 'last_year':
                $startDate = Carbon::now()->subYear()->startOfYear();
                $endDate = Carbon::now()->subYear()->endOfYear();
                break;
            case 'all_time':
                $startDate = Carbon::createFromTimestamp(0);
                break;
            case 'custom':
                $startDate = Carbon::parse($startDate)->startOfDay();
                $endDate = Carbon::parse($endDate)->endOfDay();
                break;
            default:
                $startDate = Carbon::now()->subDays(30)->startOfDay();
        }
        
        return [$startDate, $endDate];
    }
    
    /**
     * Generate User Activity Report.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function generateUserActivityReport($startDate, $endDate, $request)
    {
        $query = User::whereBetween('created_at', [$startDate, $endDate]);
        
        // Apply filters if any
        if ($request->filled('user_id')) {
            $query->where('id', $request->input('user_id'));
        }
        
        $users = $query->get();
        
        // Get related data for each user
        foreach ($users as $user) {
            $user->ideas_count = Idea::where('user_id', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
                
            $user->projects_count = Project::where('user_id', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
                
            $user->last_activity = DB::table(DB::raw('(
                    SELECT user_id, created_at FROM ideas WHERE user_id = ' . $user->id . '
                    UNION ALL
                    SELECT user_id, created_at FROM projects WHERE user_id = ' . $user->id . '
                ) as activity'))
                ->orderBy('created_at', 'desc')
                ->first()->created_at ?? null;
        }
        
        return [
            'title' => 'User Activity Report',
            'description' => 'User activity from ' . $startDate->format('M d, Y') . ' to ' . $endDate->format('M d, Y'),
            'users' => $users,
            'total_users' => $users->count(),
            'total_ideas' => $users->sum('ideas_count'),
            'total_projects' => $users->sum('projects_count'),
            'columns' => [
                'id' => 'ID',
                'name' => 'Name',
                'email' => 'Email',
                'ideas_count' => 'Ideas Created',
                'projects_count' => 'Projects Created',
                'created_at' => 'Registration Date',
                'last_activity' => 'Last Activity',
            ],
        ];
    }
    
    /**
     * Generate Project Summary Report.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function generateProjectSummaryReport($startDate, $endDate, $request)
    {
        $query = Project::with(['owner', 'framework'])
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        // Apply filters if any
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }
        
        if ($request->filled('framework_id')) {
            $query->where('framework_id', $request->input('framework_id'));
        }
        
        $projects = $query->get();
        
        // Get status distribution
        $statusDistribution = $projects->groupBy('status')
            ->map(function ($items) {
                return $items->count();
            })
            ->toArray();
        
        return [
            'title' => 'Project Summary Report',
            'description' => 'Projects created from ' . $startDate->format('M d, Y') . ' to ' . $endDate->format('M d, Y'),
            'projects' => $projects,
            'total_projects' => $projects->count(),
            'status_distribution' => $statusDistribution,
            'columns' => [
                'id' => 'ID',
                'title' => 'Title',
                'owner.name' => 'Owner',
                'framework.name' => 'Framework',
                'status' => 'Status',
                'created_at' => 'Created Date',
                'updated_at' => 'Last Updated',
            ],
        ];
    }
    
    /**
     * Generate Idea Summary Report.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function generateIdeaSummaryReport($startDate, $endDate, $request)
    {
        $query = Idea::with(['owner'])
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        // Apply filters if any
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }
        
        $ideas = $query->get();
        
        // Get status distribution
        $statusDistribution = $ideas->groupBy('status')
            ->map(function ($items) {
                return $items->count();
            })
            ->toArray();
        
        return [
            'title' => 'Idea Summary Report',
            'description' => 'Ideas created from ' . $startDate->format('M d, Y') . ' to ' . $endDate->format('M d, Y'),
            'ideas' => $ideas,
            'total_ideas' => $ideas->count(),
            'status_distribution' => $statusDistribution,
            'columns' => [
                'id' => 'ID',
                'title' => 'Title',
                'owner.name' => 'Owner',
                'status' => 'Status',
                'created_at' => 'Created Date',
                'updated_at' => 'Last Updated',
            ],
        ];
    }
    
    /**
     * Generate Framework Usage Report.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function generateFrameworkUsageReport($startDate, $endDate, $request)
    {
        // Get frameworks
        $query = Framework::withCount(['projects' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }]);
        
        // Apply filters if any
        if ($request->filled('framework_id')) {
            $query->where('id', $request->input('framework_id'));
        }
        
        $frameworks = $query->get();
        
        // Calculate usage percent
        $total = $frameworks->sum('projects_count');
        foreach ($frameworks as $framework) {
            $framework->usage_percent = $total > 0 ? round(($framework->projects_count / $total) * 100, 2) : 0;
        }
        
        return [
            'title' => 'Framework Usage Report',
            'description' => 'Framework usage from ' . $startDate->format('M d, Y') . ' to ' . $endDate->format('M d, Y'),
            'frameworks' => $frameworks,
            'total_frameworks' => $frameworks->count(),
            'total_projects' => $total,
            'columns' => [
                'id' => 'ID',
                'name' => 'Framework Name',
                'category' => 'Category',
                'projects_count' => 'Projects Count',
                'usage_percent' => 'Usage (%)',
            ],
        ];
    }
    
    /**
     * Generate System Usage Report.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function generateSystemUsageReport($startDate, $endDate, $request)
    {
        // Count new users, ideas, and projects in the date range
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $newIdeas = Idea::whereBetween('created_at', [$startDate, $endDate])->count();
        $newProjects = Project::whereBetween('created_at', [$startDate, $endDate])->count();
        
        // Calculate daily metrics
        $dailyStats = [];
        $currentDate = clone $startDate;
        
        while ($currentDate <= $endDate) {
            $dayStart = (clone $currentDate)->startOfDay();
            $dayEnd = (clone $currentDate)->endOfDay();
            
            $dayStats = [
                'date' => $currentDate->format('Y-m-d'),
                'new_users' => User::whereBetween('created_at', [$dayStart, $dayEnd])->count(),
                'new_ideas' => Idea::whereBetween('created_at', [$dayStart, $dayEnd])->count(),
                'new_projects' => Project::whereBetween('created_at', [$dayStart, $dayEnd])->count(),
                'total_activity' => 0,
            ];
            
            $dayStats['total_activity'] = $dayStats['new_users'] + $dayStats['new_ideas'] + $dayStats['new_projects'];
            
            $dailyStats[] = $dayStats;
            $currentDate->addDay();
        }
        
        return [
            'title' => 'System Usage Report',
            'description' => 'System usage from ' . $startDate->format('M d, Y') . ' to ' . $endDate->format('M d, Y'),
            'total_users' => User::count(),
            'total_ideas' => Idea::count(),
            'total_projects' => Project::count(),
            'new_users' => $newUsers,
            'new_ideas' => $newIdeas,
            'new_projects' => $newProjects,
            'daily_stats' => $dailyStats,
            'columns' => [
                'date' => 'Date',
                'new_users' => 'New Users',
                'new_ideas' => 'New Ideas',
                'new_projects' => 'New Projects',
                'total_activity' => 'Total Activity',
            ],
        ];
    }
    
    /**
     * Output the report in the requested format.
     *
     * @param  array  $data
     * @param  string  $format
     * @param  string  $reportType
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return \Illuminate\Http\Response
     */
    private function outputReport($data, $format, $reportType, $startDate, $endDate)
    {
        $fileName = str_replace('_', '-', $reportType) . '-' . $startDate->format('Y-m-d') . '-to-' . $endDate->format('Y-m-d');
        
        switch ($format) {
            case 'html':
                // Render the report view
                $viewName = 'admin.reports.templates.' . $reportType;
                
                // Check if view exists, otherwise use a generic template
                if (!view()->exists($viewName)) {
                    $viewName = 'admin.reports.templates.generic';
                }
                
                return view($viewName, $data);
                
            case 'pdf':
                // Generate PDF using the HTML view
                $viewName = 'admin.reports.templates.' . $reportType;
                
                // Check if view exists, otherwise use a generic template
                if (!view()->exists($viewName)) {
                    $viewName = 'admin.reports.templates.generic';
                }
                
                $pdf = PDF::loadView($viewName, $data);
                return $pdf->download($fileName . '.pdf');
                
            case 'csv':
                // Return CSV download
                // Implementation would depend on your CSV generation library
                
                return response()->json([
                    'success' => true,
                    'message' => 'CSV download functionality to be implemented.',
                ]);
                
            case 'excel':
                // Return Excel download
                // Implementation would depend on your Excel generation library
                
                return response()->json([
                    'success' => true,
                    'message' => 'Excel download functionality to be implemented.',
                ]);
                
            default:
                return back()->with('error', 'Invalid output format specified.');
        }
    }
}
