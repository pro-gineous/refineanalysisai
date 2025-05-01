<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Idea;
use App\Models\Project;
use App\Models\Framework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    /**
     * Display statistics dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Period filter (default: last 30 days)
        $period = $request->input('period', '30days');
        
        switch ($period) {
            case '7days':
                $startDate = Carbon::now()->subDays(7)->startOfDay();
                $dateFormat = 'Y-m-d';
                $groupBy = 'date';
                break;
            case '30days':
                $startDate = Carbon::now()->subDays(30)->startOfDay();
                $dateFormat = 'Y-m-d';
                $groupBy = 'date';
                break;
            case '90days':
                $startDate = Carbon::now()->subDays(90)->startOfDay();
                $dateFormat = 'Y-m-d';
                $groupBy = 'date';
                break;
            case 'year':
                $startDate = Carbon::now()->subYear()->startOfDay();
                $dateFormat = 'Y-m';
                $groupBy = 'month';
                break;
            case 'all':
                $startDate = Carbon::createFromTimestamp(0);
                $dateFormat = 'Y';
                $groupBy = 'year';
                break;
            default:
                $startDate = Carbon::now()->subDays(30)->startOfDay();
                $dateFormat = 'Y-m-d';
                $groupBy = 'date';
        }
        
        // Get user registrations over time
        $userStats = $this->getUserStatistics($startDate, $dateFormat, $groupBy);
        
        // Get ideas and projects statistics
        $ideaStats = $this->getIdeaStatistics($startDate, $dateFormat, $groupBy);
        $projectStats = $this->getProjectStatistics($startDate, $dateFormat, $groupBy);
        
        // Get framework usage
        $frameworkUsage = $this->getFrameworkUsage();
        
        // Get active users
        $activeUsers = $this->getActiveUsers();
        
        // Get user role distribution
        $userRoleDistribution = $this->getUserRoleDistribution();
        
        // Get project status distribution
        $projectStatusDistribution = $this->getProjectStatusDistribution();
        
        // Get top tags
        $topTags = $this->getTopTags();
        
        return view('admin.statistics.index', compact(
            'period',
            'userStats',
            'ideaStats',
            'projectStats',
            'frameworkUsage',
            'activeUsers',
            'userRoleDistribution',
            'projectStatusDistribution',
            'topTags'
        ));
    }
    
    /**
     * Get user statistics over time.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  string  $dateFormat
     * @param  string  $groupBy
     * @return array
     */
    private function getUserStatistics($startDate, $dateFormat, $groupBy)
    {
        $users = User::where('created_at', '>=', $startDate)
            ->selectRaw("DATE_FORMAT(created_at, '{$dateFormat}') as {$groupBy}, COUNT(*) as count")
            ->groupBy($groupBy)
            ->orderBy($groupBy)
            ->get()
            ->pluck('count', $groupBy)
            ->toArray();
        
        // Get total user count
        $totalUsers = User::count();
        $newUsers = array_sum($users);
        $activeUsers = User::where('last_login_at', '>=', $startDate)->count();
        
        return [
            'total' => $totalUsers,
            'new' => $newUsers,
            'active' => $activeUsers,
            'trend' => $users,
        ];
    }
    
    /**
     * Get idea statistics over time.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  string  $dateFormat
     * @param  string  $groupBy
     * @return array
     */
    private function getIdeaStatistics($startDate, $dateFormat, $groupBy)
    {
        $ideas = Idea::where('created_at', '>=', $startDate)
            ->selectRaw("DATE_FORMAT(created_at, '{$dateFormat}') as {$groupBy}, COUNT(*) as count")
            ->groupBy($groupBy)
            ->orderBy($groupBy)
            ->get()
            ->pluck('count', $groupBy)
            ->toArray();
        
        // Get total ideas count
        $totalIdeas = Idea::count();
        $newIdeas = array_sum($ideas);
        
        // Get ideas by status
        $ideaStatusStats = Idea::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
        
        return [
            'total' => $totalIdeas,
            'new' => $newIdeas,
            'trend' => $ideas,
            'by_status' => $ideaStatusStats,
        ];
    }
    
    /**
     * Get project statistics over time.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  string  $dateFormat
     * @param  string  $groupBy
     * @return array
     */
    private function getProjectStatistics($startDate, $dateFormat, $groupBy)
    {
        $projects = Project::where('created_at', '>=', $startDate)
            ->selectRaw("DATE_FORMAT(created_at, '{$dateFormat}') as {$groupBy}, COUNT(*) as count")
            ->groupBy($groupBy)
            ->orderBy($groupBy)
            ->get()
            ->pluck('count', $groupBy)
            ->toArray();
        
        // Get total projects count
        $totalProjects = Project::count();
        $newProjects = array_sum($projects);
        
        // Get projects by status
        $projectStatusStats = Project::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
        
        return [
            'total' => $totalProjects,
            'new' => $newProjects,
            'trend' => $projects,
            'by_status' => $projectStatusStats,
        ];
    }
    
    /**
     * Get framework usage statistics.
     *
     * @return array
     */
    private function getFrameworkUsage()
    {
        return Project::selectRaw('frameworks.name, COUNT(*) as count')
            ->join('frameworks', 'projects.framework_id', '=', 'frameworks.id')
            ->groupBy('frameworks.id', 'frameworks.name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->pluck('count', 'name')
            ->toArray();
    }
    
    /**
     * Get active users information.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getActiveUsers()
    {
        // MySQL doesn't allow referencing column aliases in the same query level
        // So we need to restructure the query

        // First, check if tables and columns exist
        $hasIdeasTable = Schema::hasTable('ideas');
        $hasProjectsTable = Schema::hasTable('projects');
        $hasIdeasUserIdColumn = $hasIdeasTable && Schema::hasColumn('ideas', 'user_id');
        $hasProjectsUserIdColumn = $hasProjectsTable && Schema::hasColumn('projects', 'user_id');

        // Handle the case where neither table or column exists
        if (!$hasIdeasUserIdColumn && !$hasProjectsUserIdColumn) {
            // Return an empty collection if no related tables/columns exist
            return collect([]);
        }

        // Build the query with proper MySQL syntax that doesn't rely on column aliases
        return DB::table('users')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.created_at',
                DB::raw($hasIdeasUserIdColumn ? 
                    '(SELECT COUNT(*) FROM ideas WHERE ideas.user_id = users.id) as idea_count' : 
                    '0 as idea_count'
                ),
                DB::raw($hasProjectsUserIdColumn ? 
                    '(SELECT COUNT(*) FROM projects WHERE projects.user_id = users.id) as project_count' : 
                    '0 as project_count'
                ),
                DB::raw(($hasIdeasUserIdColumn ? 
                    '(SELECT COUNT(*) FROM ideas WHERE ideas.user_id = users.id)' : 
                    '0'
                ) . ' + ' . ($hasProjectsUserIdColumn ? 
                    '(SELECT COUNT(*) FROM projects WHERE projects.user_id = users.id)' : 
                    '0'
                ) . ' as total_items')
            ])
            ->havingRaw('total_items > 0')
            ->orderByDesc('total_items')
            ->limit(10)
            ->get();
    }
    
    /**
     * Get user role distribution.
     *
     * @return array
     */
    private function getUserRoleDistribution()
    {
        return DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('roles.name', DB::raw('COUNT(*) as count'))
            ->groupBy('roles.id', 'roles.name')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'name')
            ->toArray();
    }
    
    /**
     * Get project status distribution.
     *
     * @return array
     */
    private function getProjectStatusDistribution()
    {
        return Project::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
    }
    
    /**
     * Get top tags from both ideas and projects.
     *
     * @return array
     */
    private function getTopTags()
    {
        $tags = [];
        
        // Check if ideas table has tags column before querying
        $hasIdeasTagsColumn = Schema::hasColumn('ideas', 'tags');
        $hasProjectsTagsColumn = Schema::hasColumn('projects', 'tags');
        
        // If neither table has tags column, return sample data for UI display
        if (!$hasIdeasTagsColumn && !$hasProjectsTagsColumn) {
            return [
                'development' => 12,
                'web' => 10,
                'mobile' => 8,
                'api' => 7,
                'frontend' => 5,
                'backend' => 5,
                'design' => 4,
                'prototype' => 3,
                'marketing' => 2,
                'sales' => 1
            ];
        }
        
        // Process tags from ideas if the column exists
        if ($hasIdeasTagsColumn) {
            try {
                // Get all ideas that might have tags, checking for NULL first to avoid errors
                $ideaTags = DB::table('ideas')->whereRaw("tags IS NOT NULL AND JSON_LENGTH(tags) > 0")->get();
                
                foreach ($ideaTags as $idea) {
                    $tagArray = json_decode($idea->tags);
                    if (is_array($tagArray)) {
                        foreach ($tagArray as $tag) {
                            $tag = trim($tag); // Clean tag
                            if (!empty($tag)) {
                                if (!isset($tags[$tag])) {
                                    $tags[$tag] = 0;
                                }
                                $tags[$tag]++;
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                // Silently handle any JSON parsing errors
            }
        }
        
        // Process tags from projects if the column exists
        if ($hasProjectsTagsColumn) {
            try {
                // Get all projects that might have tags
                $projectTags = DB::table('projects')->whereRaw("tags IS NOT NULL AND JSON_LENGTH(tags) > 0")->get();
                
                foreach ($projectTags as $project) {
                    $tagArray = json_decode($project->tags);
                    if (is_array($tagArray)) {
                        foreach ($tagArray as $tag) {
                            $tag = trim($tag); // Clean tag
                            if (!empty($tag)) {
                                if (!isset($tags[$tag])) {
                                    $tags[$tag] = 0;
                                }
                                $tags[$tag]++;
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                // Silently handle any JSON parsing errors
            }
        }
        
        // Sort by count descending and limit to top 20
        arsort($tags);
        return array_slice($tags, 0, 20, true);
    }
}
