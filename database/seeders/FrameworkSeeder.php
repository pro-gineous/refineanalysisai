<?php

namespace Database\Seeders;

use App\Models\Framework;
use Illuminate\Database\Seeder;

class FrameworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $frameworks = [
            ['name' => 'PRINCE2', 'category' => 'Project Management', 'description' => 'Projects in Controlled Environments'],
            ['name' => 'Scrum', 'category' => 'Agile', 'description' => 'Iterative and incremental framework for software development'],
            ['name' => 'TOGAF', 'category' => 'Enterprise Architecture', 'description' => 'The Open Group Architecture Framework'],
            ['name' => 'Six Sigma', 'category' => 'Quality Management', 'description' => 'Data-driven methodology for eliminating defects'],
            ['name' => 'Kanban', 'category' => 'Workflow Management', 'description' => 'Visual system for managing work as it moves through a process'],
            ['name' => 'Blockchain Supply Chain', 'category' => 'Supply Chain', 'description' => 'Blockchain-based supply chain management framework'],
            ['name' => 'Design Thinking', 'category' => 'Innovation', 'description' => 'User-centered approach to problem-solving and design'],
        ];

        foreach ($frameworks as $framework) {
            Framework::create($framework);
        }
    }
}