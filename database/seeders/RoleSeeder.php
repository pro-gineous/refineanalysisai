<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'permissions' => json_encode(['all'])],
            ['name' => 'Framework Expert', 'permissions' => json_encode(['manage_frameworks', 'view_projects'])],
            ['name' => 'Idea Owner', 'permissions' => json_encode(['manage_ideas', 'manage_projects'])],
            ['name' => 'SME', 'permissions' => json_encode(['answer_questions', 'view_projects'])],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}