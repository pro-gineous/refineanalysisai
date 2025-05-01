<?php

namespace Database\Seeders;

use App\Models\Framework;
use App\Models\Idea;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear rol si no existe
        $userRole = Role::firstOrCreate([
            'name' => 'user',
        ], [
            'permissions' => json_encode(['dashboard' => true, 'projects' => true]),
        ]);
        
        // Crear usuario de prueba
        $user = User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'is_active' => true,
        ]);
        
        // Crear frameworks
        $frameworks = [
            ['name' => 'Laravel', 'category' => 'Backend', 'description' => 'PHP Framework'],
            ['name' => 'Vue.js', 'category' => 'Frontend', 'description' => 'JavaScript Framework'],
            ['name' => 'React', 'category' => 'Frontend', 'description' => 'JavaScript Library'],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'description' => 'CSS Framework'],
            ['name' => 'Angular', 'category' => 'Frontend', 'description' => 'JavaScript Framework'],
        ];
        
        foreach ($frameworks as $framework) {
            Framework::firstOrCreate(
                ['name' => $framework['name']],
                [
                    'category' => $framework['category'],
                    'description' => $framework['description']
                ]
            );
        }
        
        // Crear ideas
        $ideas = [
            [
                'title' => 'E-commerce Platform',
                'description' => 'Build a modern e-commerce platform with Laravel and Vue.js',
                'status' => 'active',
            ],
            [
                'title' => 'Project Management Tool',
                'description' => 'Create a project management tool for small teams',
                'status' => 'active',
            ],
            [
                'title' => 'Learning Management System',
                'description' => 'Develop an LMS for online courses',
                'status' => 'planning',
            ],
            [
                'title' => 'Real-time Chat Application',
                'description' => 'Build a real-time chat application with websockets',
                'status' => 'on_hold',
            ],
        ];
        
        // Limpiar ideas existentes del usuario
        Idea::where('owner_id', $user->id)->delete();
        
        // Crear nuevas ideas
        foreach ($ideas as $idea) {
            Idea::create([
                'title' => $idea['title'],
                'description' => $idea['description'],
                'owner_id' => $user->id,
                'status' => $idea['status'],
            ]);
        }
        
        // Limpiar proyectos existentes del usuario
        Project::where('owner_id', $user->id)->delete();
        
        // Crear proyectos basados en ideas y frameworks
        $laravelFramework = Framework::where('name', 'Laravel')->first();
        $vueFramework = Framework::where('name', 'Vue.js')->first();
        $reactFramework = Framework::where('name', 'React')->first();
        
        $ecommerceIdea = Idea::where('title', 'E-commerce Platform')->where('owner_id', $user->id)->first();
        $projectManagementIdea = Idea::where('title', 'Project Management Tool')->where('owner_id', $user->id)->first();
        $lmsIdea = Idea::where('title', 'Learning Management System')->where('owner_id', $user->id)->first();
        
        // Proyectos de ejemplo
        $projects = [
            [
                'title' => 'Online Store Frontend',
                'description' => 'Frontend implementation of the e-commerce platform',
                'idea_id' => $ecommerceIdea ? $ecommerceIdea->id : null,
                'framework_id' => $vueFramework ? $vueFramework->id : null,
                'status' => 'active',
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonth(),
            ],
            [
                'title' => 'E-commerce API',
                'description' => 'Backend API for the e-commerce platform',
                'idea_id' => $ecommerceIdea ? $ecommerceIdea->id : null,
                'framework_id' => $laravelFramework ? $laravelFramework->id : null,
                'status' => 'in_progress',
                'start_date' => now()->subMonth(),
                'end_date' => now()->addMonths(2),
            ],
            [
                'title' => 'Project Dashboard',
                'description' => 'Main dashboard for the project management tool',
                'idea_id' => $projectManagementIdea ? $projectManagementIdea->id : null,
                'framework_id' => $reactFramework ? $reactFramework->id : null,
                'status' => 'planning',
                'start_date' => now()->addDays(15),
                'end_date' => now()->addMonths(3),
            ],
        ];
        
        foreach ($projects as $project) {
            Project::create([
                'title' => $project['title'],
                'description' => $project['description'],
                'idea_id' => $project['idea_id'],
                'framework_id' => $project['framework_id'],
                'owner_id' => $user->id,
                'status' => $project['status'],
                'start_date' => $project['start_date'],
                'end_date' => $project['end_date'],
            ]);
        }
    }
}
