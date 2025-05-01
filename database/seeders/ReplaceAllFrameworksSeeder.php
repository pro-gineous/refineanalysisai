<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReplaceAllFrameworksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lista oficial de frameworks
        $frameworksList = [
            // Project Management Frameworks
            [
                'name' => 'PMBOK (Project Management Body of Knowledge)',
                'category' => 'Project Management',
                'description' => 'A comprehensive framework for project management methodologies and practices.',
                'short_description' => 'Framework for project management implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to project management implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'PRINCE2 (Projects IN Controlled Environments)',
                'category' => 'Project Management',
                'description' => 'A comprehensive framework for prince2 methodologies and practices.',
                'short_description' => 'Framework for prince2 implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to prince2 implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'PM² (European Commission Methodology)',
                'category' => 'Project Management',
                'description' => 'A comprehensive framework for pm² methodologies and practices.',
                'short_description' => 'Framework for pm² implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to pm² implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'PMP Essentials (Project Management Professional)',
                'category' => 'Project Management',
                'description' => 'A comprehensive framework for pmp methodologies and practices.',
                'short_description' => 'Framework for pmp implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to pmp implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'IPMA ICB (International Competence Baseline)',
                'category' => 'Project Management',
                'description' => 'A comprehensive framework for ipma methodologies and practices.',
                'short_description' => 'Framework for ipma implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to ipma implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Waterfall Model',
                'category' => 'Project Management',
                'description' => 'A comprehensive framework for waterfall methodologies and practices.',
                'short_description' => 'Framework for waterfall implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to waterfall implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Hybrid Project Management',
                'category' => 'Project Management',
                'description' => 'A comprehensive framework for hybrid methodologies and practices.',
                'short_description' => 'Framework for hybrid implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to hybrid implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            
            // Agile Frameworks
            [
                'name' => 'Scrum',
                'category' => 'Agile',
                'description' => 'A comprehensive framework for scrum methodologies and practices.',
                'short_description' => 'Framework for scrum implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to scrum implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'SAFe (Scaled Agile Framework)',
                'category' => 'Agile',
                'description' => 'A comprehensive framework for safe methodologies and practices.',
                'short_description' => 'Framework for safe implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to safe implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Agile',
                'category' => 'Agile',
                'description' => 'A comprehensive framework for agile methodologies and practices.',
                'short_description' => 'Framework for agile implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to agile implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Disciplined Agile Delivery (DAD)',
                'category' => 'Agile',
                'description' => 'A comprehensive framework for disciplined methodologies and practices.',
                'short_description' => 'Framework for disciplined implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to disciplined implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'LeSS (Large-Scale Scrum)',
                'category' => 'Agile',
                'description' => 'A comprehensive framework for less methodologies and practices.',
                'short_description' => 'Framework for less implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to less implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Nexus Framework',
                'category' => 'Agile',
                'description' => 'A comprehensive framework for nexus methodologies and practices.',
                'short_description' => 'Framework for nexus implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to nexus implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Spotify Model',
                'category' => 'Agile',
                'description' => 'A comprehensive framework for spotify methodologies and practices.',
                'short_description' => 'Framework for spotify implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to spotify implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            
            // Business Analysis Frameworks
            [
                'name' => 'BABOK (Business Analysis Body of Knowledge)',
                'category' => 'Business Analysis',
                'description' => 'A comprehensive framework for babok methodologies and practices.',
                'short_description' => 'Framework for babok implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to babok implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Business Process Modeling (BPMN)',
                'category' => 'Business Analysis',
                'description' => 'A comprehensive framework for business methodologies and practices.',
                'short_description' => 'Framework for business implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to business implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Business Analysis Planning',
                'category' => 'Business Analysis',
                'description' => 'A comprehensive framework for business methodologies and practices.',
                'short_description' => 'Framework for business implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to business implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Requirements Management Framework',
                'category' => 'Business Analysis',
                'description' => 'A comprehensive framework for requirements methodologies and practices.',
                'short_description' => 'Framework for requirements implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to requirements implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Context Diagram Modeling',
                'category' => 'Business Analysis',
                'description' => 'A comprehensive framework for context methodologies and practices.',
                'short_description' => 'Framework for context implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to context implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Entity Relationship Modeling',
                'category' => 'Business Analysis',
                'description' => 'A comprehensive framework for entity methodologies and practices.',
                'short_description' => 'Framework for entity implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to entity implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Business Motivation Model (BMM)',
                'category' => 'Business Analysis',
                'description' => 'A comprehensive framework for business methodologies and practices.',
                'short_description' => 'Framework for business implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to business implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            
            // Risk Management Frameworks
            [
                'name' => 'ISO 31000 Risk Management Standard',
                'category' => 'Risk Management',
                'description' => 'A comprehensive framework for iso methodologies and practices.',
                'short_description' => 'Framework for iso implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to iso implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Failure Mode and Effects Analysis (FMEA)',
                'category' => 'Risk Management',
                'description' => 'A comprehensive framework for failure methodologies and practices.',
                'short_description' => 'Framework for failure implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to failure implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Risk Breakdown Structure (RBS)',
                'category' => 'Risk Management',
                'description' => 'A comprehensive framework for risk methodologies and practices.',
                'short_description' => 'Framework for risk implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to risk implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Risk Response Planning',
                'category' => 'Risk Management',
                'description' => 'A comprehensive framework for risk methodologies and practices.',
                'short_description' => 'Framework for risk implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to risk implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Monte Carlo Simulation',
                'category' => 'Risk Management',
                'description' => 'A comprehensive framework for monte methodologies and practices.',
                'short_description' => 'Framework for monte implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to monte implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Bowtie Risk Analysis',
                'category' => 'Risk Management',
                'description' => 'A comprehensive framework for bowtie methodologies and practices.',
                'short_description' => 'Framework for bowtie implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to bowtie implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Enterprise Risk Management (ERM)',
                'category' => 'Risk Management',
                'description' => 'A comprehensive framework for enterprise methodologies and practices.',
                'short_description' => 'Framework for enterprise implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to enterprise implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            
            // Transformation and Architecture Frameworks
            [
                'name' => 'TOGAF (The Open Group Architecture Framework)',
                'category' => 'Transformation and Architecture',
                'description' => 'A comprehensive framework for togaf methodologies and practices.',
                'short_description' => 'Framework for togaf implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to togaf implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Digital Transformation Models',
                'category' => 'Transformation and Architecture',
                'description' => 'A comprehensive framework for digital methodologies and practices.',
                'short_description' => 'Framework for digital implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to digital implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Lean Transformation',
                'category' => 'Transformation and Architecture',
                'description' => 'A comprehensive framework for lean methodologies and practices.',
                'short_description' => 'Framework for lean implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to lean implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Six Sigma DMAIC',
                'category' => 'Transformation and Architecture',
                'description' => 'A comprehensive framework for six methodologies and practices.',
                'short_description' => 'Framework for six implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to six implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'ITIL (Information Technology Infrastructure Library)',
                'category' => 'Transformation and Architecture',
                'description' => 'A comprehensive framework for itil methodologies and practices.',
                'short_description' => 'Framework for itil implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to itil implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'COBIT (Control Objectives for Information and Related Technologies)',
                'category' => 'Transformation and Architecture',
                'description' => 'A comprehensive framework for cobit methodologies and practices.',
                'short_description' => 'Framework for cobit implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to cobit implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            
            // Innovation and Customer Experience Frameworks
            [
                'name' => 'Design Thinking',
                'category' => 'Innovation and Customer Experience',
                'description' => 'A comprehensive framework for design methodologies and practices.',
                'short_description' => 'Framework for design implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to design implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Idea Management Framework',
                'category' => 'Innovation and Customer Experience',
                'description' => 'A comprehensive framework for idea methodologies and practices.',
                'short_description' => 'Framework for idea implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to idea implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Customer Journey Mapping',
                'category' => 'Innovation and Customer Experience',
                'description' => 'A comprehensive framework for customer methodologies and practices.',
                'short_description' => 'Framework for customer implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to customer implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Net Promoter Score (NPS) Program',
                'category' => 'Innovation and Customer Experience',
                'description' => 'A comprehensive framework for net methodologies and practices.',
                'short_description' => 'Framework for net implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to net implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Service Design Thinking',
                'category' => 'Innovation and Customer Experience',
                'description' => 'A comprehensive framework for service methodologies and practices.',
                'short_description' => 'Framework for service implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to service implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Human-Centered Design (HCD)',
                'category' => 'Innovation and Customer Experience',
                'description' => 'A comprehensive framework for human-centered methodologies and practices.',
                'short_description' => 'Framework for human-centered implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to human-centered implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            
            // Operational Excellence Frameworks
            [
                'name' => 'Total Quality Management (TQM)',
                'category' => 'Operational Excellence',
                'description' => 'A comprehensive framework for total methodologies and practices.',
                'short_description' => 'Framework for total implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to total implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Kaizen',
                'category' => 'Operational Excellence',
                'description' => 'A comprehensive framework for kaizen methodologies and practices.',
                'short_description' => 'Framework for kaizen implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to kaizen implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Lean',
                'category' => 'Operational Excellence',
                'description' => 'A comprehensive framework for lean methodologies and practices.',
                'short_description' => 'Framework for lean implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to lean implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'System Thinking',
                'category' => 'Operational Excellence',
                'description' => 'A comprehensive framework for system methodologies and practices.',
                'short_description' => 'Framework for system implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to system implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Business Process Reengineering (BPR)',
                'category' => 'Operational Excellence',
                'description' => 'A comprehensive framework for business methodologies and practices.',
                'short_description' => 'Framework for business implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to business implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
            [
                'name' => 'Continuous Improvement Process (CIP)',
                'category' => 'Operational Excellence',
                'description' => 'A comprehensive framework for continuous methodologies and practices.',
                'short_description' => 'Framework for continuous implementation.',
                'comprehensive_description' => 'This framework provides a structured approach to continuous implementation, with best practices, methodologies, and tools for successful project delivery.'
            ],
        ];

        // PASO 1: Verificar si hay proyectos en la base de datos
        $projectCount = DB::table('projects')->count();
        $this->command->info("Proyectos encontrados: {$projectCount}");
        
        // PASO 2: Insertamos un framework por cada categoría para mantener una referencia válida
        $this->command->info("Añadiendo los primeros frameworks de cada categoría...");
        
        // Lista de nombres de frameworks a insertar al inicio
        $keysToKeep = [0, 7, 14, 21, 28, 35, 42]; // Índices del primer framework de cada categoría
        $primaryFrameworks = [];
        
        foreach ($keysToKeep as $key) {
            $frameworkData = array_merge($frameworksList[$key], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            $id = DB::table('frameworks')->insertGetId($frameworkData);
            $primaryFrameworks[] = $id;
            $this->command->info("Framework inicial añadido: {$frameworksList[$key]['name']} (ID: {$id})");
        }
        
        // PASO 3: Si hay proyectos, los actualizamos para que usen el primer framework
        if ($projectCount > 0) {
            $defaultFrameworkId = $primaryFrameworks[0]; // Usamos el primer framework (PMBOK) como predeterminado
            
            $this->command->info("Actualizando proyectos para usar el framework predeterminado (ID: {$defaultFrameworkId})...");
            DB::table('projects')->update(['framework_id' => $defaultFrameworkId]);
            $this->command->info("Proyectos actualizados: {$projectCount}");
        }
        
        // PASO 4: Eliminar todos los frameworks antiguos (excepto los que acabamos de crear)
        $this->command->info("Eliminando frameworks antiguos...");
        $deleted = DB::table('frameworks')
            ->whereNotIn('id', $primaryFrameworks)
            ->delete();
        $this->command->info("Frameworks antiguos eliminados: {$deleted}");
        
        // PASO 5: Añadir el resto de frameworks nuevos
        $this->command->info("Añadiendo el resto de frameworks oficiales...");
        $added = 0;
        
        foreach ($frameworksList as $key => $framework) {
            // Saltamos los frameworks que ya añadimos
            if (in_array($key, $keysToKeep)) {
                continue;
            }
            
            DB::table('frameworks')->insert(array_merge($framework, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]));
            $added++;
        }
        
        $this->command->info("Frameworks adicionales añadidos: {$added}");
        
        // PASO 6: Verificar estadísticas finales
        $finalCount = DB::table('frameworks')->count();
        
        // Resumen final
        $this->command->info("=== Resumen de reemplazo de frameworks ===");
        $this->command->info("Frameworks anteriores eliminados: {$deleted}");
        $this->command->info("Frameworks iniciales añadidos: " . count($primaryFrameworks));
        $this->command->info("Frameworks adicionales añadidos: {$added}");
        $this->command->info("Total de frameworks actuales: {$finalCount}");
        
        // Verificación final
        $actualFrameworksNames = DB::table('frameworks')->pluck('name')->toArray();
        $expectedNames = array_column($frameworksList, 'name');
        $missing = array_diff($expectedNames, $actualFrameworksNames);
        
        if (count($missing) > 0) {
            $this->command->error("ALERTA: Faltan " . count($missing) . " frameworks en la base de datos");
        } else {
            $this->command->info("Verificación exitosa: Todos los frameworks están presentes en la base de datos");
        }
    }
}
