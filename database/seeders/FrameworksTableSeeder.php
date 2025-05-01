<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrameworksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // استخدام نموذج Framework
        $framework = \App\Models\Framework::class;
        
        // مسح البيانات الموجودة أو تحديثها إن وجدت
        // بدلاً من استخدام truncate سنتحقق من وجود الإطار أولاً
        
        // Project Management Frameworks
        $framework::updateOrCreate(['name' => 'PMBOK'], [
            'name' => 'PMBOK',
            'category' => 'Project Management',
            'description' => 'Project Management Body of Knowledge',
            'short_description' => 'Elevate your PMBOK projects with ProcessFlow\'s AI-enhanced workflows.',
            'comprehensive_description' => 'With ProcessFlow, your PMBOK projects reach new heights through AI-driven project charters, schedules, and risk registers.'
        ]);
        
        $framework::updateOrCreate(['name' => 'PRINCE2'], [
            'name' => 'PRINCE2',
            'category' => 'Project Management',
            'description' => 'Projects IN Controlled Environments',
            'short_description' => 'Supercharge your PRINCE2 projects with ProcessFlow\'s intelligent templates.',
            'comprehensive_description' => 'ProcessFlow takes your PRINCE2 projects to the next level by automating planning, quality control, and stage management.'
        ]);
        
        $framework::updateOrCreate(['name' => 'PM²'], [
            'name' => 'PM²',
            'category' => 'Project Management',
            'description' => 'European Commission Methodology',
            'short_description' => 'Streamline your European projects with PM² and ProcessFlow integration.',
            'comprehensive_description' => 'ProcessFlow enhances the PM² methodology with automated documentation, visual progress tracking, and simplified reporting for European Commission requirements.'
        ]);
        
        $framework::updateOrCreate(['name' => 'Waterfall Model'], [
            'name' => 'Waterfall Model',
            'category' => 'Project Management',
            'description' => 'Sequential design process',
            'short_description' => 'Perfect your Waterfall projects with ProcessFlow\'s structured workflow management.',
            'comprehensive_description' => 'ProcessFlow enhances the traditional Waterfall model by providing clear phase transitions, automated documentation, and comprehensive stage-gate reviews.'
        ]);
        
        // Agile Frameworks
        $framework::updateOrCreate(['name' => 'Scrum'], [
            'name' => 'Scrum',
            'category' => 'Agile',
            'description' => 'Iterative and incremental framework',
            'short_description' => 'Boost your Scrum sprints with ProcessFlow\'s AI assistance.',
            'comprehensive_description' => 'ProcessFlow transforms your Scrum experience by streamlining backlog grooming, sprint planning, and retrospectives.'
        ]);
        
        $framework::updateOrCreate(['name' => 'SAFe'], [
            'name' => 'SAFe',
            'category' => 'Agile',
            'description' => 'Scaled Agile Framework',
            'short_description' => 'Scale your Agile practices effortlessly with ProcessFlow-enhanced SAFe implementation.',
            'comprehensive_description' => 'ProcessFlow elevates your SAFe implementation with automated program boards, multi-team coordination tools, and synchronized release planning.'
        ]);
        
        $framework::updateOrCreate(['name' => 'Agile'], [
            'name' => 'Agile',
            'category' => 'Agile',
            'description' => 'Iterative approach to project management',
            'short_description' => 'Embrace true agility with ProcessFlow\'s adaptive project tools.',
            'comprehensive_description' => 'ProcessFlow enhances Agile methodologies by providing flexible, customizable workflows that adapt to your team\'s unique approach while maintaining core Agile principles.'
        ]);
        
        // Business Analysis Frameworks
        $framework::updateOrCreate(['name' => 'BABOK'], [
            'name' => 'BABOK',
            'category' => 'Business Analysis',
            'description' => 'Business Analysis Body of Knowledge',
            'short_description' => 'Elevate your business analysis with ProcessFlow\'s BABOK-aligned tools.',
            'comprehensive_description' => 'ProcessFlow enhances your BABOK implementation with smart requirements traceability, stakeholder engagement tracking, and automated documentation generation.'
        ]);
        
        $framework::updateOrCreate(['name' => 'BPMN'], [
            'name' => 'BPMN',
            'category' => 'Business Analysis',
            'description' => 'Business Process Model and Notation',
            'short_description' => 'Visualize and optimize processes with ProcessFlow\'s BPMN integration.',
            'comprehensive_description' => 'ProcessFlow takes BPMN to new heights by providing interactive modeling tools, simulation capabilities, and direct implementation paths from models to executable workflows.'
        ]);
        
        // Risk Management Frameworks
        $framework::updateOrCreate(['name' => 'ISO 31000'], [
            'name' => 'ISO 31000',
            'category' => 'Risk Management',
            'description' => 'Risk Management Standard',
            'short_description' => 'Strengthen risk management with ProcessFlow\'s ISO 31000 implementation.',
            'comprehensive_description' => 'ProcessFlow enhances ISO 31000 practices with automated risk assessment tools, continuous monitoring dashboards, and AI-driven risk prediction capabilities.'
        ]);
        
        // Transformation Frameworks
        $framework::updateOrCreate(['name' => 'TOGAF'], [
            'name' => 'TOGAF',
            'category' => 'Transformation',
            'description' => 'The Open Group Architecture Framework',
            'short_description' => 'Accelerate enterprise architecture with ProcessFlow\'s TOGAF toolkit.',
            'comprehensive_description' => 'ProcessFlow enhances TOGAF implementation with interactive architecture repositories, automated documentation, and change impact analysis tools.'
        ]);
        
        // Innovation Frameworks
        $framework::updateOrCreate(['name' => 'Design Thinking'], [
            'name' => 'Design Thinking',
            'category' => 'Innovation',
            'description' => 'Human-centered approach to innovation',
            'short_description' => 'Unleash creativity with ProcessFlow\'s Design Thinking digital workspace.',
            'comprehensive_description' => 'ProcessFlow transforms Design Thinking practices with collaborative ideation spaces, user research tools, and prototype-to-production tracking.'
        ]);
        
        // Operational Excellence Frameworks
        $framework::updateOrCreate(['name' => 'Lean'], [
            'name' => 'Lean',
            'category' => 'Operational Excellence',
            'description' => 'Maximize value while minimizing waste',
            'short_description' => 'Eliminate waste and optimize flow with ProcessFlow\'s Lean management tools.',
            'comprehensive_description' => 'ProcessFlow enhances Lean practices with value stream mapping, waste identification analytics, and continuous improvement tracking systems.'
        ]);
        
        $framework::updateOrCreate(['name' => 'Six Sigma'], [
            'name' => 'Six Sigma',
            'category' => 'Operational Excellence',
            'description' => 'Data-driven improvement methodology',
            'short_description' => 'Achieve Six Sigma excellence with ProcessFlow\'s statistical process control.',
            'comprehensive_description' => 'ProcessFlow elevates Six Sigma implementation with integrated statistical analysis, automated measurement systems, and DMAIC project tracking tools.'
        ]);
    }
}
