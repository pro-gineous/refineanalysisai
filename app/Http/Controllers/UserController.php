<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Búsqueda completa para datos del usuario
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = [];

        if (!$query || strlen($query) < 2) {
            return view('user.search-results', [
                'query' => $query,
                'results' => []
            ]);
        }

        // Obtener el ID del usuario actual
        $userId = Auth::id();
        
        // Usar datos simulados ya que las tablas reales no existen
        // Datos de ejemplo para proyectos
        $demoProjects = [
            [
                'id' => 1,
                'title' => 'Dashboard Development',
                'description' => 'Project to develop and enhance the user dashboard with all required features',
                'status' => 'In Progress',
                'created_at' => '2025-04-20',
                'updated_at' => '2025-04-27'
            ],
            [
                'id' => 2,
                'title' => 'Client Needs Analysis',
                'description' => 'Analyzing client requirements and documenting system functional specifications',
                'status' => 'Completed',
                'created_at' => '2025-04-15',
                'updated_at' => '2025-04-23'
            ],
            [
                'id' => 3,
                'title' => 'User Interface Development',
                'description' => 'Designing and developing a user-friendly and responsive interface',
                'status' => 'On Hold',
                'created_at' => '2025-04-22',
                'updated_at' => '2025-04-26'
            ]
        ];
        
        // Filtrar proyectos según la consulta
        foreach ($demoProjects as $project) {
            if (
                strpos(strtolower($project['title']), strtolower($query)) !== false ||
                strpos(strtolower($project['description']), strtolower($query)) !== false ||
                strpos(strtolower($project['status']), strtolower($query)) !== false
            ) {
                $results[] = [
                    'id' => $project['id'],
                    'title' => $project['title'],
                    'description' => mb_substr($project['description'], 0, 100) . (mb_strlen($project['description']) > 100 ? '...' : ''),
                    'type' => 'Project',
                    'url' => route('user.projects') . '?id=' . $project['id'],
                    'date' => $project['updated_at']
                ];
            }
        }
        
        // Datos de ejemplo para tareas
        $demoTasks = [
            [
                'id' => 1,
                'title' => 'Update Design',
                'description' => 'Update dashboard design to match new requirements',
                'status' => 'In Progress',
                'created_at' => '2025-04-24',
                'updated_at' => '2025-04-27'
            ],
            [
                'id' => 2,
                'title' => 'Fix Display Issue',
                'description' => 'Fix a display issue in the projects section',
                'status' => 'Completed',
                'created_at' => '2025-04-20',
                'updated_at' => '2025-04-21'
            ],
            [
                'id' => 3,
                'title' => 'Test Search Functionality',
                'description' => 'Comprehensive testing of search functions to ensure they work correctly',
                'status' => 'On Hold',
                'created_at' => '2025-04-26',
                'updated_at' => '2025-04-26'
            ]
        ];
        
        // Filtrar tareas según la consulta
        foreach ($demoTasks as $task) {
            if (
                strpos(strtolower($task['title']), strtolower($query)) !== false ||
                strpos(strtolower($task['description']), strtolower($query)) !== false ||
                strpos(strtolower($task['status']), strtolower($query)) !== false
            ) {
                $results[] = [
                    'id' => $task['id'],
                    'title' => $task['title'],
                    'description' => mb_substr($task['description'], 0, 100) . (mb_strlen($task['description']) > 100 ? '...' : ''),
                    'type' => 'Task',
                    'url' => route('user.projects') . '?task=' . $task['id'],
                    'date' => $task['updated_at']
                ];
            }
        }
        
        // Datos de ejemplo para habilidades
        $demoSkills = [
            [
                'id' => 1,
                'name' => 'Project Management',
                'level' => 'Expert',
                'description' => 'Ability to manage complex projects and coordinate teams',
                'created_at' => '2025-03-15',
                'updated_at' => '2025-04-26'
            ],
            [
                'id' => 2,
                'name' => 'Agile Methodologies',
                'level' => 'Advanced',
                'description' => 'Application of agile methodologies in project management and development',
                'created_at' => '2025-03-20',
                'updated_at' => '2025-04-25'
            ],
            [
                'id' => 3,
                'name' => 'Collaboration Skills',
                'level' => 'Intermediate',
                'description' => 'Ability to work effectively within a team and promote collaboration',
                'created_at' => '2025-03-25',
                'updated_at' => '2025-04-24'
            ]
        ];
        
        // Filtrar habilidades según la consulta
        foreach ($demoSkills as $skill) {
            if (
                strpos(strtolower($skill['name']), strtolower($query)) !== false ||
                strpos(strtolower($skill['level']), strtolower($query)) !== false ||
                strpos(strtolower($skill['description']), strtolower($query)) !== false
            ) {
                $results[] = [
                    'id' => $skill['id'],
                    'title' => $skill['name'],
                    'description' => $skill['level'] . ' - ' . mb_substr($skill['description'], 0, 100) . (mb_strlen($skill['description']) > 100 ? '...' : ''),
                    'type' => 'Skill',
                    'url' => route('user.profile') . '#skills',
                    'date' => $skill['updated_at']
                ];
            }
        }

        return view('user.search-results', [
            'query' => $query,
            'results' => $results
        ]);
    }

    /**
     * API para búsqueda en tiempo real
     */
    public function apiSearch(Request $request)
    {
        $query = $request->input('query');
        $results = [];

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        // Usar datos simulados como en la función de búsqueda completa
        $demoProjects = [
            [
                'id' => 1,
                'title' => 'Dashboard Development',
                'description' => 'Project to develop and enhance the user dashboard',
                'status' => 'In Progress'
            ],
            [
                'id' => 2,
                'title' => 'Client Needs Analysis',
                'description' => 'Analyzing client requirements and specifications',
                'status' => 'Completed'
            ],
            [
                'id' => 3,
                'title' => 'User Interface Development',
                'description' => 'Designing an easy-to-use interface',
                'status' => 'On Hold'
            ]
        ];
        
        // Filtrar proyectos
        foreach ($demoProjects as $project) {
            if (
                strpos(strtolower($project['title']), strtolower($query)) !== false ||
                strpos(strtolower($project['description']), strtolower($query)) !== false ||
                strpos(strtolower($project['status']), strtolower($query)) !== false
            ) {
                $results[] = [
                    'id' => $project['id'],
                    'title' => $project['title'],
                    'type' => 'Project',
                    'url' => route('user.projects') . '?id=' . $project['id']
                ];
            }
        }
        
        // Datos de ejemplo para tareas
        $demoTasks = [
            [
                'id' => 1,
                'title' => 'Update Design',
                'description' => 'Update the dashboard design',
                'status' => 'In Progress'
            ],
            [
                'id' => 2,
                'title' => 'Fix Display Issue',
                'description' => 'Fix an issue in data display',
                'status' => 'Completed'
            ],
            [
                'id' => 3,
                'title' => 'Test Search Functionality',
                'description' => 'Comprehensive testing of search functions',
                'status' => 'On Hold'
            ]
        ];
        
        // Filtrar tareas
        foreach ($demoTasks as $task) {
            if (
                strpos(strtolower($task['title']), strtolower($query)) !== false ||
                strpos(strtolower($task['description']), strtolower($query)) !== false ||
                strpos(strtolower($task['status']), strtolower($query)) !== false
            ) {
                $results[] = [
                    'id' => $task['id'],
                    'title' => $task['title'],
                    'type' => 'Task',
                    'url' => route('user.projects') . '?task=' . $task['id']
                ];
            }
        }
        
        // Datos de ejemplo para habilidades
        $demoSkills = [
            [
                'id' => 1,
                'name' => 'Project Management',
                'level' => 'Expert',
                'description' => 'Ability to manage complex projects'
            ],
            [
                'id' => 2,
                'name' => 'Agile Methodologies',
                'level' => 'Advanced',
                'description' => 'Application of agile methodologies in projects'
            ],
            [
                'id' => 3,
                'name' => 'Collaboration Skills',
                'level' => 'Intermediate',
                'description' => 'Ability to work within a team'
            ]
        ];
        
        // Filtrar habilidades
        foreach ($demoSkills as $skill) {
            if (
                strpos(strtolower($skill['name']), strtolower($query)) !== false ||
                strpos(strtolower($skill['level']), strtolower($query)) !== false ||
                strpos(strtolower($skill['description']), strtolower($query)) !== false
            ) {
                $results[] = [
                    'id' => $skill['id'],
                    'title' => $skill['name'],
                    'type' => 'Skill',
                    'url' => route('user.profile') . '#skills'
                ];
            }
        }

        // Limitar a un total de 10 resultados para la API
        $results = array_slice($results, 0, 10);
        
        return response()->json($results);
    }

    public function dashboard()
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
        
        return view('user.dashboard', compact('projects'));
    }
}
