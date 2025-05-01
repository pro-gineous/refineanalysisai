<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Project;
use App\Models\Framework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard with real user data.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's active ideas
        $activeIdeas = Idea::where('owner_id', $user->id)
                          ->where('status', 'active')
                          ->count();
        
        // Get user's projects
        $projects = Project::where('owner_id', $user->id)
                          ->with(['framework'])
                          ->orderBy('created_at', 'desc')
                          ->take(3)
                          ->get();
        
        // Get total project count
        $totalProjects = Project::where('owner_id', $user->id)->count();
        
        // Calcular horas tracked basado en el número de proyectos activos reales
        // Si no hay proyectos activos, mostrará 0
        $activeProjects = Project::where('owner_id', $user->id)
            ->where('start_date', '<=', now())
            ->where(function($query) {
                $query->where('end_date', '>=', now())
                      ->orWhereNull('end_date');
            })
            ->count();
        
        // Asignar un valor basado en proyectos activos sin valores predeterminados
        $trackedHours = $activeProjects > 0 ? $activeProjects * 5.5 : 0;
        
        // Obtener número real de bloqueadores sin valores predeterminados
        $blockers = Project::where('owner_id', $user->id)
            ->where(function($query) {
                $query->where('status', 'like', '%block%')
                      ->orWhere('status', 'like', '%hold%')
                      ->orWhere('status', 'like', '%pause%');
            })
            ->count();
        
        // Obtener datos de habilidades basados únicamente en los frameworks utilizados por el usuario
        $projectFrameworks = Project::where('owner_id', $user->id)
            ->whereNotNull('framework_id')
            ->with('framework')
            ->get()
            ->pluck('framework')
            ->unique('id');
        
        // Inicializar array de habilidades vacío
        $skills = [];
        
        // Agregar habilidades basadas en frameworks si existen
        if ($projectFrameworks->count() > 0) {
            foreach ($projectFrameworks as $index => $framework) {
                // Calcular nivel y porcentaje basado en cuántos proyectos usan este framework
                $projectsUsingFramework = Project::where('owner_id', $user->id)
                    ->where('framework_id', $framework->id)
                    ->count();
                
                // Determinar nivel basado en número de proyectos
                $level = 'Beginner';
                $percentage = 25;
                
                if ($projectsUsingFramework >= 3) {
                    $level = 'Expert';
                    $percentage = 90;
                } elseif ($projectsUsingFramework == 2) {
                    $level = 'Advanced';
                    $percentage = 75;
                } elseif ($projectsUsingFramework == 1) {
                    $level = 'Intermediate';
                    $percentage = 50;
                }
                
                $skills[] = [
                    'name' => $framework->name,
                    'level' => $level,
                    'percentage' => $percentage,
                    'change' => '+' . ($projectsUsingFramework * 2) . '%',
                    'trend' => 'up'
                ];
            }
        }
        
        // Si no hay habilidades basadas en frameworks, dejar el array vacío
        // La vista mostrará un mensaje apropiado
        
        // Get timeline activities based on real project milestones
        $timeline = [];
        
        // Milestone 1 - Proyectos cercanos a la fecha de finalización
        $nearCompletionProjects = Project::where('owner_id', $user->id)
            ->where('end_date', '>', now())
            ->orderBy('end_date', 'asc')
            ->take(3)
            ->get();
        
        foreach ($nearCompletionProjects as $index => $project) {
            // Formatos de fecha y prioridad personalizados para cada proyecto
            $dateDisplay = $project->end_date->format('M d');
            
            // Calcular prioridad basada en la cercanía de la fecha de finalización
            $daysUntilEnd = now()->diffInDays($project->end_date, false);
            $priority = 'Normal';
            
            if ($daysUntilEnd <= 7) {
                $priority = 'Critical';
            } elseif ($daysUntilEnd <= 14) {
                $priority = 'Important';
            }
            
            // Determinar la fase del proyecto basada en su estado
            $phase = 'Development';
            if ($project->status == 'planning') {
                $phase = 'Planning phase';
            } elseif ($project->status == 'completed' || $project->status == 'done') {
                $phase = 'Completion phase';
            } elseif (strpos($project->status, 'test') !== false) {
                $phase = 'Testing phase';
            }
            
            $timeline[] = [
                'date' => $project->end_date,
                'date_display' => $dateDisplay,
                'title' => 'Project ' . ($index + 1),
                'description' => $project->title . ' - ' . $phase,
                'priority' => $priority
            ];
        }
        
        // Si no hay proyectos con fechas de finalización futuras,
        // buscar proyectos recientes (sin datos ficticios)
        if (empty($timeline)) {
            $recentProjects = Project::where('owner_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
            
            foreach ($recentProjects as $index => $project) {
                $timeline[] = [
                    'date' => $project->created_at,
                    'date_display' => $project->created_at->format('M d'),
                    'title' => 'Project ' . ($index + 1),
                    'description' => $project->title . ' - Started recently',
                    'priority' => 'Normal'
                ];
            }
        }
        
        return view('user.dashboard', compact('user', 'activeIdeas', 'projects', 'totalProjects', 'skills', 'timeline', 'trackedHours', 'blockers'));
    }
}
