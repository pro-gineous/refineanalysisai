<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Framework;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Project::query()->with(['owner', 'framework']);
        
        // Apply filters
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('status', 'like', $searchTerm);
            });
        }
        
        // Manejar consistentemente el filtro de framework (acepta tanto 'framework' como 'framework_id')
        if ($request->has('framework') && !empty($request->input('framework'))) {
            $query->where('framework_id', $request->input('framework'));
        } elseif ($request->has('framework_id') && !empty($request->input('framework_id'))) {
            $query->where('framework_id', $request->input('framework_id'));
        }
        
        // Filtro de estado
        if ($request->has('status') && !empty($request->input('status'))) {
            $query->where('status', $request->input('status'));
        }
        
        // Manejar consistentemente el filtro de propietario (acepta tanto 'user' como 'owner_id')
        // Además, usar la clave foránea correcta 'owner_id' definida en el modelo
        if ($request->has('user') && !empty($request->input('user'))) {
            $query->where('owner_id', $request->input('user'));
        } elseif ($request->has('owner_id') && !empty($request->input('owner_id'))) {
            $query->where('owner_id', $request->input('owner_id'));
        }
        
        // Verificar campos para ordenamiento
        $allowedSortFields = ['title', 'status', 'created_at', 'updated_at', 'owner_id', 'framework_id'];
        
        $sortField = $request->input('sort', 'created_at');
        
        // Validar que el campo de ordenamiento sea válido
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at'; // Valor por defecto seguro
        }
        
        $sortDirection = $request->input('direction', 'desc');
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'desc'; // Valor por defecto seguro
        }
        
        $query->orderBy($sortField, $sortDirection);
        
        // Paginate results
        $projects = $query->paginate(15)->withQueryString();
        
        // Get frameworks and users for filter dropdowns
        $frameworks = Framework::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        
        // Get status options
        $statuses = Project::distinct('status')->pluck('status');
        
        return view('admin.projects.index', compact('projects', 'frameworks', 'users', 'statuses'));
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $frameworks = Framework::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        
        return view('admin.projects.create', compact('frameworks', 'users'));
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id', // Mantener para validación, pero renombrar antes de crear
            'framework_id' => 'required|exists:frameworks,id',
            'status' => 'required|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'attachments.*' => 'nullable|file|max:10240',
            'tags' => 'nullable|string',
        ]);
        
        // Corregir la inconsistencia entre user_id y owner_id
        // El modelo Project usa owner_id, pero el formulario envía user_id
        if (isset($validated['user_id'])) {
            $validated['owner_id'] = $validated['user_id'];
            unset($validated['user_id']);
        }
        
        // Process tags if provided
        if (isset($validated['tags'])) {
            $validated['tags'] = explode(',', $validated['tags']);
        }
        
        // Create the project
        $project = Project::create($validated);
        
        // Handle attachments if any
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $path = $attachment->store('project-attachments', 'public');
                $project->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $attachment->getClientOriginalName(),
                    'file_size' => $attachment->getSize(),
                    'file_type' => $attachment->getMimeType(),
                ]);
            }
        }
        
        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function show(Project $project)
    {
        // Cargar las relaciones necesarias
        $project->load(['owner', 'framework']);
        
        // Calcular el progreso general del proyecto basado en la fecha de inicio y fin
        $progress = 0;
        if ($project->start_date && $project->end_date) {
            $startDate = new \DateTime($project->start_date);
            $endDate = new \DateTime($project->end_date); 
            $currentDate = new \DateTime();
            
            $totalDuration = $startDate->diff($endDate)->days;
            $elapsedDuration = $startDate->diff($currentDate)->days;
            
            if ($totalDuration > 0) {
                $progress = min(100, max(0, ($elapsedDuration / $totalDuration) * 100));
            }
        }
        
        // Calcular días restantes para completar el proyecto
        $daysRemaining = 0;
        if ($project->end_date) {
            $endDate = new \DateTime($project->end_date);
            $currentDate = new \DateTime();
            $daysRemaining = max(0, $currentDate->diff($endDate)->days);
        }
        
        // Obtener miembros del equipo (simulado por ahora)
        $teamMembers = User::limit(5)->get();
        
        // Crear hitos de proyecto basados en datos reales (o crear algunos predeterminados si no existen)
        $milestones = [
            [
                'title' => 'Project Charter',
                'due_date' => date('Y-m-d', strtotime($project->start_date . ' +15 days')),
                'progress' => 75
            ],
            [
                'title' => 'Project Management Plan',
                'due_date' => date('Y-m-d', strtotime($project->start_date . ' +30 days')),
                'progress' => 25
            ],
            [
                'title' => 'Execution Phase',
                'due_date' => date('Y-m-d', strtotime($project->end_date . ' -30 days')),
                'progress' => 0
            ],
        ];
        
        return view('admin.projects.show', compact('project', 'progress', 'daysRemaining', 'teamMembers', 'milestones'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project)
    {
        $frameworks = Framework::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        
        // Intentar cargar los attachments si la tabla existe
        try {
            $project->load('attachments');
        } catch (\Exception $e) {
            // La tabla de attachments puede no existir todavía, continuamos sin cargarlos
        }
        
        return view('admin.projects.edit', compact('project', 'frameworks', 'users'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'framework_id' => 'required|exists:frameworks,id',
            'status' => 'required|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'attachments.*' => 'nullable|file|max:10240',
            'tags' => 'nullable|string',
        ]);
        
        // Process tags if provided
        if (isset($validated['tags'])) {
            $validated['tags'] = explode(',', $validated['tags']);
        }
        
        // Update the project
        $project->update($validated);
        
        // Handle attachments if any
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $path = $attachment->store('project-attachments', 'public');
                $project->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $attachment->getClientOriginalName(),
                    'file_size' => $attachment->getSize(),
                    'file_type' => $attachment->getMimeType(),
                ]);
            }
        }
        
        // Handle deleted attachments
        if ($request->has('delete_attachments')) {
            $attachmentIds = $request->input('delete_attachments');
            $attachments = $project->attachments()->whereIn('id', $attachmentIds)->get();
            
            foreach ($attachments as $attachment) {
                Storage::disk('public')->delete($attachment->file_path);
                $attachment->delete();
            }
        }
        
        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        // Delete the project
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
