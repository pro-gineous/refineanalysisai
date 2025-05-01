<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display the combined Ideas & Projects overview page
     * 
     * @return \Illuminate\Http\Response
     */
    public function ideasProjects(Request $request)
    {
        $user = auth()->user();
        
        // Get filter parameter, default to 'all'
        $filter = $request->input('filter', 'all');
        
        // Get all team members for assignment lookups
        $teamMembers = TeamMember::all();
        
        // Get combined list of all ideas and projects for the dashboard
        $combinedItems = collect();
        
        // Get user's ideas with more details - only if filter is 'all' or 'ideas'
        $ideas = collect();
        if ($filter == 'all' || $filter == 'ideas') {
            $ideas = $user->ideas()
                ->with(['owner']) // Eager load related models
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        // Get user's projects with more details - only if filter is 'all' or 'projects'
        $projects = collect();
        if ($filter == 'all' || $filter == 'projects') {
            $projects = $user->projects()
                ->with(['user', 'teamMembers']) // Eager load related models
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        // Get runs if filter is 'run'
        $runs = collect();
        if ($filter == 'run') {
            // Aquí normalmente buscaríamos test runs en la base de datos
            // Por ahora, crearemos algunos datos de prueba para demostrar la funcionalidad
            $runs = collect([
                [
                    'id' => 1001,
                    'name' => 'API Integration Test',
                    'submitter' => [
                        'name' => $user->name,
                        'initials' => strtoupper(substr($user->name, 0, 1) . (strpos($user->name, ' ') ? substr(strrchr($user->name, ' '), 1, 1) : ''))
                    ],
                    'type' => 'run',
                    'framework' => 'Laravel/PHPUnit',
                    'status' => 'completed',
                    'priority' => 'high',
                    'assigned_to' => null,
                    'submit_date' => date('d-m-Y', strtotime('-3 days')),
                    'due_date' => date('d-m-Y', strtotime('+7 days')),
                    'aging' => 3,
                    'progress' => 100,
                    'effort_estimate' => 8,
                    'cost_estimate' => 1200,
                    'potential_roi' => 4500,
                    'roi_percentage' => 275,
                    'risk_level' => 'low',
                    'approval_status' => 'approved',
                    'decision_date' => date('d-m-Y', strtotime('-5 days')),
                    'comments' => 'All tests passed successfully',
                    'last_updated' => date('d-m-Y', strtotime('-1 day')),
                    'success_metrics' => '98% coverage, 0 failures',
                    'dependencies' => 'None',
                    'stakeholder_feedback' => 'Excellent results'
                ],
                [
                    'id' => 1002,
                    'name' => 'Performance Benchmark Test',
                    'submitter' => [
                        'name' => $user->name,
                        'initials' => strtoupper(substr($user->name, 0, 1) . (strpos($user->name, ' ') ? substr(strrchr($user->name, ' '), 1, 1) : ''))
                    ],
                    'type' => 'run',
                    'framework' => 'JMeter',
                    'status' => 'in_progress',
                    'priority' => 'medium',
                    'assigned_to' => null,
                    'submit_date' => date('d-m-Y', strtotime('-1 day')),
                    'due_date' => date('d-m-Y', strtotime('+3 days')),
                    'aging' => 1,
                    'progress' => 65,
                    'effort_estimate' => 12,
                    'cost_estimate' => 2000,
                    'potential_roi' => 5000,
                    'roi_percentage' => 150,
                    'risk_level' => 'medium',
                    'approval_status' => 'pending',
                    'decision_date' => null,
                    'comments' => 'Running load tests with 1000 concurrent users',
                    'last_updated' => date('d-m-Y'),
                    'success_metrics' => 'Response time < 200ms, 99.9% uptime',
                    'dependencies' => 'Database optimization',
                    'stakeholder_feedback' => 'Waiting for results'
                ]
            ]);
        }
            
        // Process each project to calculate extra metrics and format for display
        foreach ($projects as $project) {
            // Format dates for display
            $submitDate = $project->created_at->format('d-m-Y');
            $dueDate = $project->due_date ? date('d-m-Y', strtotime($project->due_date)) : null;
            
            // Calculate aging (days since creation)
            $aging = $project->created_at->diffInDays(now());
            
            // Calculate ROI if we have cost and potential value
            $roi = null;
            if ($project->cost_estimate && $project->potential_roi && $project->cost_estimate > 0) {
                $roi = round((($project->potential_roi - $project->cost_estimate) / $project->cost_estimate) * 100);
            }
            
            // Get assigned team member if any
            $assignedTo = null;
            if ($project->assigned_to) {
                $assignedMember = $teamMembers->where('id', $project->assigned_to)->first();
                if ($assignedMember) {
                    $assignedTo = [
                        'id' => $assignedMember->id,
                        'name' => $assignedMember->name,
                        'initials' => strtoupper(substr($assignedMember->name, 0, 1) . (strpos($assignedMember->name, ' ') ? substr(strrchr($assignedMember->name, ' '), 1, 1) : ''))
                    ];
                }
            }
            
            // Add computed properties
            $project->submit_date = $submitDate;
            $project->formatted_due_date = $dueDate;
            $project->aging = $aging;
            $project->roi_percentage = $roi;
            $project->assigned_to_details = $assignedTo;
            
            // Add to combined items collection
            $combinedItems->push([
                'id' => $project->id,
                'type' => 'project',
                'name' => $project->name,
                'submitter' => [
                    'name' => $project->user->name,
                    'initials' => strtoupper(substr($project->user->name, 0, 1) . (strpos($project->user->name, ' ') ? substr(strrchr($project->user->name, ' '), 1, 1) : ''))
                ],
                'framework' => $project->framework,
                'status' => $project->status,
                'priority' => $project->priority,
                'assigned_to' => $project->assigned_to_details,
                'submit_date' => $project->submit_date,
                'due_date' => $project->formatted_due_date,
                'aging' => $project->aging,
                'progress' => $project->progress,
                'effort_estimate' => $project->effort_estimate,
                'cost_estimate' => $project->cost_estimate,
                'potential_roi' => $project->potential_roi,
                'roi_percentage' => $project->roi_percentage,
                'risk_level' => $project->risk_level,
                'approval_status' => $project->approval_status,
                'decision_date' => $project->decision_date ? date('d-m-Y', strtotime($project->decision_date)) : null,
                'comments' => $project->description,
                'last_updated' => $project->updated_at->format('d-m-Y'),
                'success_metrics' => $project->success_metrics,
                'dependencies' => $project->dependencies,
                'stakeholder_feedback' => $project->stakeholder_feedback
            ]);
        }
        
        // Process each idea similar to projects
        foreach ($ideas as $idea) {
            $submitDate = $idea->created_at->format('d-m-Y');
            
            // Add to combined items collection
            $combinedItems->push([
                'id' => $idea->id,
                'type' => 'idea',
                'name' => $idea->title,
                'submitter' => [
                    'name' => $idea->owner->name,
                    'initials' => strtoupper(substr($idea->owner->name, 0, 1) . (strpos($idea->owner->name, ' ') ? substr(strrchr($idea->owner->name, ' '), 1, 1) : ''))
                ],
                'framework' => $idea->framework,
                'status' => $idea->status,
                'priority' => $idea->priority,
                'assigned_to' => null,
                'submit_date' => $submitDate,
                'due_date' => null,
                'aging' => $idea->created_at->diffInDays(now()),
                'progress' => 0, // Ideas start at 0% progress
                'effort_estimate' => $idea->effort_estimate,
                'cost_estimate' => $idea->cost_estimate,
                'potential_roi' => $idea->potential_roi,
                'roi_percentage' => $idea->roi_percentage ?? null,
                'risk_level' => $idea->risk_level,
                'approval_status' => $idea->approval_status,
                'decision_date' => null,
                'comments' => $idea->description,
                'last_updated' => $idea->updated_at->format('d-m-Y'),
                'success_metrics' => $idea->success_metrics,
                'dependencies' => $idea->dependencies,
                'stakeholder_feedback' => null
            ]);
        }
        
        // Add runs to combined items if we have any
        foreach ($runs as $run) {
            $combinedItems->push($run);
        }
        
        // Sort combined items by priority and then submit date
        $combinedItems = $combinedItems->sortByDesc(function ($item) {
            return [$item['priority'], $item['submit_date']];
        })->values()->all();
        
        // Get ideas by status (for the stat counters)
        $ideasByStatus = [
            'draft' => $user->ideas()->where('status', 'draft')->count(),
            'active' => $user->ideas()->where('status', 'active')->count(),
            'completed' => $user->ideas()->where('status', 'completed')->count(),
            'archived' => $user->ideas()->where('status', 'archived')->count(),
        ];
        
        // Get projects by status (for the stat counters)
        $projectsByStatus = [
            'planning' => $user->projects()->where('status', 'planning')->count(),
            'in_progress' => $user->projects()->where('status', 'in_progress')->count(),
            'review' => $user->projects()->where('status', 'review')->count(),
            'completed' => $user->projects()->where('status', 'completed')->count(),
            'archived' => $user->projects()->where('status', 'archived')->count(),
        ];
        
        // Filter-specific information to pass to the view
        $filterInfo = [
            'current' => $filter,
            'counts' => [
                'all' => $projects->count() + $ideas->count() + ($filter == 'run' ? $runs->count() : 0),
                'ideas' => $ideas->count(),
                'projects' => $projects->count(),
                'run' => $filter == 'run' ? $runs->count() : 0
            ]
        ];
        
        return view('user.ideas-projects', compact('combinedItems', 'ideas', 'projects', 'ideasByStatus', 'projectsByStatus', 'teamMembers', 'filterInfo'));
    }
    
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $projects = $user->projects;
        
        // Get projects from team members
        $teamMembers = $user->teamMembers()->where('status', 'accepted')->get();
        $teamMemberProjects = collect();
        foreach ($teamMembers as $member) {
            $memberProjects = $member->teamMember->projects;
            $teamMemberProjects = $teamMemberProjects->merge($memberProjects);
        }
        
        $projects = $projects->merge($teamMemberProjects)->unique('id');
        
        return view('user.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('user.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();
        $project = $user->projects()->create($request->all());

        return redirect()->route('user.projects.show', $project)->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $user = Auth::user();
        $canAccess = $project->user_id === $user->id;
        
        if (!$canAccess) {
            $teamMembers = $user->teamMembers()->where('status', 'accepted')->get();
            foreach ($teamMembers as $member) {
                if ($project->user_id === $member->team_member_id) {
                    $canAccess = true;
                    break;
                }
            }
        }
        
        if (!$canAccess) {
            $teamMemberOf = $user->teamMemberOf()->where('status', 'accepted')->get();
            foreach ($teamMemberOf as $member) {
                if ($project->user_id === $member->user_id) {
                    $canAccess = true;
                    break;
                }
            }
        }
        
        if (!$canAccess) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('user.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $user = Auth::user();
        if ($project->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('user.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $user = Auth::user();
        if ($project->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $project->update($request->all());
        
        return redirect()->route('user.projects.show', $project)->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $user = Auth::user();
        if ($project->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $project->delete();
        
        return redirect()->route('user.projects.index')->with('success', 'Project deleted successfully.');
    }
}
