<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateFrameworksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lista exacta de frameworks que se deben mantener
        $validFrameworks = [
            // Project Management Frameworks
            'PMBOK (Project Management Body of Knowledge)',
            'PRINCE2 (Projects IN Controlled Environments)',
            'PM² (European Commission Methodology)',
            'PMP Essentials (Project Management Professional)',
            'IPMA ICB (International Competence Baseline)',
            'Waterfall Model',
            'Hybrid Project Management',
            
            // Agile Frameworks
            'Scrum',
            'SAFe (Scaled Agile Framework)',
            'Agile',
            'Disciplined Agile Delivery (DAD)',
            'LeSS (Large-Scale Scrum)',
            'Nexus Framework',
            'Spotify Model',
            
            // Business Analysis Frameworks
            'BABOK (Business Analysis Body of Knowledge)',
            'Business Process Modeling (BPMN)',
            'Business Analysis Planning',
            'Requirements Management Framework',
            'Context Diagram Modeling',
            'Entity Relationship Modeling',
            'Business Motivation Model (BMM)',
            
            // Risk Management Frameworks
            'ISO 31000 Risk Management Standard',
            'Failure Mode and Effects Analysis (FMEA)',
            'Risk Breakdown Structure (RBS)',
            'Risk Response Planning',
            'Monte Carlo Simulation',
            'Bowtie Risk Analysis',
            'Enterprise Risk Management (ERM)',
            
            // Transformation and Architecture Frameworks
            'TOGAF (The Open Group Architecture Framework)',
            'Digital Transformation Models',
            'Lean Transformation',
            'Six Sigma DMAIC',
            'ITIL (Information Technology Infrastructure Library)',
            'COBIT (Control Objectives for Information and Related Technologies)',
            
            // Innovation and Customer Experience Frameworks
            'Design Thinking',
            'Idea Management Framework',
            'Customer Journey Mapping',
            'Net Promoter Score (NPS) Program',
            'Service Design Thinking',
            'Human-Centered Design (HCD)',
            
            // Operational Excellence Frameworks
            'Total Quality Management (TQM)',
            'Kaizen',
            'Lean',
            'System Thinking',
            'Business Process Reengineering (BPR)',
            'Continuous Improvement Process (CIP)',
        ];

        // Categorías mapeadas para los frameworks
        $categories = [
            // Project Management
            'PMBOK (Project Management Body of Knowledge)' => 'Project Management',
            'PRINCE2 (Projects IN Controlled Environments)' => 'Project Management',
            'PM² (European Commission Methodology)' => 'Project Management',
            'PMP Essentials (Project Management Professional)' => 'Project Management',
            'IPMA ICB (International Competence Baseline)' => 'Project Management',
            'Waterfall Model' => 'Project Management',
            'Hybrid Project Management' => 'Project Management',
            
            // Agile
            'Scrum' => 'Agile',
            'SAFe (Scaled Agile Framework)' => 'Agile',
            'Agile' => 'Agile',
            'Disciplined Agile Delivery (DAD)' => 'Agile',
            'LeSS (Large-Scale Scrum)' => 'Agile',
            'Nexus Framework' => 'Agile',
            'Spotify Model' => 'Agile',
            
            // Business Analysis
            'BABOK (Business Analysis Body of Knowledge)' => 'Business Analysis',
            'Business Process Modeling (BPMN)' => 'Business Analysis',
            'Business Analysis Planning' => 'Business Analysis',
            'Requirements Management Framework' => 'Business Analysis',
            'Context Diagram Modeling' => 'Business Analysis',
            'Entity Relationship Modeling' => 'Business Analysis',
            'Business Motivation Model (BMM)' => 'Business Analysis',
            
            // Risk Management
            'ISO 31000 Risk Management Standard' => 'Risk Management',
            'Failure Mode and Effects Analysis (FMEA)' => 'Risk Management',
            'Risk Breakdown Structure (RBS)' => 'Risk Management',
            'Risk Response Planning' => 'Risk Management',
            'Monte Carlo Simulation' => 'Risk Management',
            'Bowtie Risk Analysis' => 'Risk Management',
            'Enterprise Risk Management (ERM)' => 'Risk Management',
            
            // Transformation and Architecture
            'TOGAF (The Open Group Architecture Framework)' => 'Transformation and Architecture',
            'Digital Transformation Models' => 'Transformation and Architecture',
            'Lean Transformation' => 'Transformation and Architecture',
            'Six Sigma DMAIC' => 'Transformation and Architecture',
            'ITIL (Information Technology Infrastructure Library)' => 'Transformation and Architecture',
            'COBIT (Control Objectives for Information and Related Technologies)' => 'Transformation and Architecture',
            
            // Innovation and Customer Experience
            'Design Thinking' => 'Innovation and Customer Experience',
            'Idea Management Framework' => 'Innovation and Customer Experience',
            'Customer Journey Mapping' => 'Innovation and Customer Experience',
            'Net Promoter Score (NPS) Program' => 'Innovation and Customer Experience',
            'Service Design Thinking' => 'Innovation and Customer Experience',
            'Human-Centered Design (HCD)' => 'Innovation and Customer Experience',
            
            // Operational Excellence
            'Total Quality Management (TQM)' => 'Operational Excellence',
            'Kaizen' => 'Operational Excellence',
            'Lean' => 'Operational Excellence',
            'System Thinking' => 'Operational Excellence',
            'Business Process Reengineering (BPR)' => 'Operational Excellence',
            'Continuous Improvement Process (CIP)' => 'Operational Excellence',
        ];
        
        // PASO 1: Verificar frameworks existentes
        $existingFrameworks = DB::table('frameworks')->get();
        $existingNames = $existingFrameworks->pluck('name')->toArray();
        
        // Contadores para estadísticas
        $updated = 0;
        $added = 0;
        $unchanged = 0;
        
        // PASO 2: Para frameworks existentes, verificar si necesitan actualizarse
        foreach ($existingFrameworks as $framework) {
            if (!in_array($framework->name, $validFrameworks)) {
                // Si el framework no está en la lista, pero ya existe en DB, 
                // lo mantendremos pero actualizaremos sus datos con el framework válido más cercano
                // Esto evita problemas con las relaciones foreign key
                
                $index = $framework->id % count($validFrameworks);
                $newName = $validFrameworks[$index];
                $newCategory = $categories[$newName] ?? 'Other';
                
                DB::table('frameworks')
                    ->where('id', $framework->id)
                    ->update([
                        'name' => $newName,
                        'category' => $newCategory,
                        'updated_at' => Carbon::now()
                    ]);
                
                $this->command->info("Framework actualizado: {$framework->name} -> {$newName}");
                $updated++;
            } else {
                // Si ya está en la lista válida, actualizamos su categoría
                $correctCategory = $categories[$framework->name] ?? 'Other';
                
                if ($framework->category !== $correctCategory) {
                    DB::table('frameworks')
                        ->where('id', $framework->id)
                        ->update([
                            'category' => $correctCategory,
                            'updated_at' => Carbon::now()
                        ]);
                    
                    $this->command->info("Categoría actualizada: {$framework->name} -> {$correctCategory}");
                    $updated++;
                } else {
                    $unchanged++;
                }
            }
        }
        
        // PASO 3: Agregar los frameworks que faltan
        $missingFrameworks = array_diff($validFrameworks, $existingNames);
        
        foreach ($missingFrameworks as $frameworkName) {
            $category = $categories[$frameworkName] ?? 'Other';
            
            DB::table('frameworks')->insert([
                'name' => $frameworkName,
                'category' => $category,
                'description' => 'A comprehensive framework for ' . strtolower(str_replace('(', '', explode(' ', $frameworkName)[0])) . ' methodologies and practices.',
                'short_description' => 'Framework for ' . strtolower(str_replace('(', '', explode(' ', $frameworkName)[0])) . ' implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to ' . strtolower(str_replace('(', '', explode(' ', $frameworkName)[0])) . ' implementation, with best practices, methodologies, and tools for successful project delivery.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            $this->command->info("Framework añadido: {$frameworkName}");
            $added++;
        }
        
        // PASO 4: Verificar y eliminar duplicados
        $duplicates = DB::table('frameworks')
            ->select('name', DB::raw('COUNT(*) as count'))
            ->groupBy('name')
            ->having('count', '>', 1)
            ->get();
        
        $duplicatesFixed = 0;
        
        foreach ($duplicates as $duplicate) {
            // Obtener frameworks con este nombre, ordenados por ID
            $frameworksWithSameName = DB::table('frameworks')
                ->where('name', $duplicate->name)
                ->orderBy('id')
                ->get();
            
            // Mantener el primero tal cual
            $keep = $frameworksWithSameName->shift();
            
            // Para los demás, cambiarles el nombre añadiendo un sufijo
            foreach ($frameworksWithSameName as $index => $dupFramework) {
                // En lugar de eliminar, renombramos para evitar problemas con las foreign keys
                $newName = $validFrameworks[($dupFramework->id + $index) % count($validFrameworks)];
                
                DB::table('frameworks')
                    ->where('id', $dupFramework->id)
                    ->update([
                        'name' => $newName,
                        'updated_at' => Carbon::now()
                    ]);
                
                $this->command->info("Duplicado gestionado: {$duplicate->name} (ID: {$dupFramework->id}) -> {$newName}");
                $duplicatesFixed++;
            }
        }
        
        // Resumen final
        $this->command->info("=== Resumen de actualización de frameworks ===");
        $this->command->info("Frameworks actualizados: {$updated}");
        $this->command->info("Frameworks sin cambios: {$unchanged}");
        $this->command->info("Frameworks añadidos: {$added}");
        $this->command->info("Duplicados gestionados: {$duplicatesFixed}");
        $this->command->info("Total de frameworks actuales: " . DB::table('frameworks')->count());
        $this->command->info("Total de frameworks únicos: " . DB::table('frameworks')->distinct()->count('name'));
    }
}
