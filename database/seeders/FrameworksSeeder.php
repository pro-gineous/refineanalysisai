<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FrameworksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lista completa de frameworks
        $frameworks = [
            // Project Management Frameworks
            ['name' => 'PMBOK (Project Management Body of Knowledge)', 'category' => 'Project Management'],
            ['name' => 'PRINCE2 (Projects IN Controlled Environments)', 'category' => 'Project Management'],
            ['name' => 'PM² (European Commission Methodology)', 'category' => 'Project Management'],
            ['name' => 'PMP Essentials (Project Management Professional)', 'category' => 'Project Management'],
            ['name' => 'IPMA ICB (International Competence Baseline)', 'category' => 'Project Management'],
            ['name' => 'Waterfall Model', 'category' => 'Project Management'],
            ['name' => 'Hybrid Project Management', 'category' => 'Project Management'],
            
            // Agile Frameworks
            ['name' => 'Scrum', 'category' => 'Agile'],
            ['name' => 'SAFe (Scaled Agile Framework)', 'category' => 'Agile'],
            ['name' => 'Agile', 'category' => 'Agile'],
            ['name' => 'Disciplined Agile Delivery (DAD)', 'category' => 'Agile'],
            ['name' => 'LeSS (Large-Scale Scrum)', 'category' => 'Agile'],
            ['name' => 'Nexus Framework', 'category' => 'Agile'],
            ['name' => 'Spotify Model', 'category' => 'Agile'],
            
            // Business Analysis Frameworks
            ['name' => 'BABOK (Business Analysis Body of Knowledge)', 'category' => 'Business Analysis'],
            ['name' => 'Business Process Modeling (BPMN)', 'category' => 'Business Analysis'],
            ['name' => 'Business Analysis Planning', 'category' => 'Business Analysis'],
            ['name' => 'Requirements Management Framework', 'category' => 'Business Analysis'],
            ['name' => 'Context Diagram Modeling', 'category' => 'Business Analysis'],
            ['name' => 'Entity Relationship Modeling', 'category' => 'Business Analysis'],
            ['name' => 'Business Motivation Model (BMM)', 'category' => 'Business Analysis'],
            
            // Risk Management Frameworks
            ['name' => 'ISO 31000 Risk Management Standard', 'category' => 'Risk Management'],
            ['name' => 'Failure Mode and Effects Analysis (FMEA)', 'category' => 'Risk Management'],
            ['name' => 'Risk Breakdown Structure (RBS)', 'category' => 'Risk Management'],
            ['name' => 'Risk Response Planning', 'category' => 'Risk Management'],
            ['name' => 'Monte Carlo Simulation', 'category' => 'Risk Management'],
            ['name' => 'Bowtie Risk Analysis', 'category' => 'Risk Management'],
            ['name' => 'Enterprise Risk Management (ERM)', 'category' => 'Risk Management'],
            
            // Transformation and Architecture Frameworks
            ['name' => 'TOGAF (The Open Group Architecture Framework)', 'category' => 'Transformation and Architecture'],
            ['name' => 'Digital Transformation Models', 'category' => 'Transformation and Architecture'],
            ['name' => 'Lean Transformation', 'category' => 'Transformation and Architecture'],
            ['name' => 'Six Sigma DMAIC', 'category' => 'Transformation and Architecture'],
            ['name' => 'ITIL (Information Technology Infrastructure Library)', 'category' => 'Transformation and Architecture'],
            ['name' => 'COBIT (Control Objectives for Information and Related Technologies)', 'category' => 'Transformation and Architecture'],
            
            // Innovation and Customer Experience Frameworks
            ['name' => 'Design Thinking', 'category' => 'Innovation and Customer Experience'],
            ['name' => 'Idea Management Framework', 'category' => 'Innovation and Customer Experience'],
            ['name' => 'Customer Journey Mapping', 'category' => 'Innovation and Customer Experience'],
            ['name' => 'Net Promoter Score (NPS) Program', 'category' => 'Innovation and Customer Experience'],
            ['name' => 'Service Design Thinking', 'category' => 'Innovation and Customer Experience'],
            ['name' => 'Human-Centered Design (HCD)', 'category' => 'Innovation and Customer Experience'],
            
            // Operational Excellence Frameworks
            ['name' => 'Total Quality Management (TQM)', 'category' => 'Operational Excellence'],
            ['name' => 'Kaizen', 'category' => 'Operational Excellence'],
            ['name' => 'Lean', 'category' => 'Operational Excellence'],
            ['name' => 'System Thinking', 'category' => 'Operational Excellence'],
            ['name' => 'Business Process Reengineering (BPR)', 'category' => 'Operational Excellence'],
            ['name' => 'Continuous Improvement Process (CIP)', 'category' => 'Operational Excellence'],
        ];

        // Insertar los frameworks en la base de datos
        foreach ($frameworks as $framework) {
            // Verificar si el framework ya existe
            $exists = DB::table('frameworks')
                ->where('name', $framework['name'])
                ->exists();
            
            // Solo insertar si no existe
            if (!$exists) {
                DB::table('frameworks')->insert([
                    'name' => $framework['name'],
                    'category' => $framework['category'],
                    'description' => 'A comprehensive framework for ' . strtolower(str_replace('(', '', explode(' ', $framework['name'])[0])) . ' methodologies and practices.',
                    'short_description' => 'Framework for ' . strtolower(str_replace('(', '', explode(' ', $framework['name'])[0])) . ' implementation.',
                    'comprehensive_description' => 'This framework provides a structured approach to ' . strtolower(str_replace('(', '', explode(' ', $framework['name'])[0])) . ' implementation, with best practices, methodologies, and tools for successful project delivery.',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        
        // Mensajes de información
        $this->command->info('Total de frameworks añadidos/actualizados: ' . count($frameworks));
    }
}
