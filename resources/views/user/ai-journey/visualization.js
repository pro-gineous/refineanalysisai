// Global variable for current framework
let currentFramework = '';

// Helper function to create a PRINCE2 process map
function createPRINCE2ProcessMap() {
    return `
    <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
        <style>
            .box { fill: #E5E7EB; stroke: #4F46E5; stroke-width: 2; }
            .arrow { stroke: #4B5563; stroke-width: 2; fill: none; }
            .text { font-family: Arial; font-size: 12px; fill: #1F2937; text-anchor: middle; }
            .phase { font-family: Arial; font-size: 14px; fill: #4F46E5; font-weight: bold; text-anchor: middle; }
        </style>
        
        <!-- Boxes -->
        <rect class="box" x="50" y="100" width="140" height="60" rx="5" />
        <rect class="box" x="250" y="100" width="140" height="60" rx="5" />
        <rect class="box" x="450" y="100" width="140" height="60" rx="5" />
        <rect class="box" x="650" y="100" width="140" height="60" rx="5" />
        
        <!-- Phase labels -->
        <text class="phase" x="120" y="130">Starting Up</text>
        <text class="text" x="120" y="150">SU</text>
        
        <text class="phase" x="320" y="130">Initiating</text>
        <text class="text" x="320" y="150">IP</text>
        
        <text class="phase" x="520" y="130">Controlling</text>
        <text class="text" x="520" y="150">CS</text>
        
        <text class="phase" x="720" y="130">Closing</text>
        <text class="text" x="720" y="150">CP</text>
        
        <!-- Arrows -->
        <path class="arrow" d="M190 130 H 250" marker-end="url(#arrowhead)" />
        <path class="arrow" d="M390 130 H 450" marker-end="url(#arrowhead)" />
        <path class="arrow" d="M590 130 H 650" marker-end="url(#arrowhead)" />
        
        <!-- Arrowhead marker -->
        <defs>
            <marker id="arrowhead" markerWidth="10" markerHeight="7" 
            refX="9" refY="3.5" orient="auto">
            <polygon points="0 0, 10 3.5, 0 7" fill="#4B5563" />
            </marker>
        </defs>
    </svg>
    `;
}

// Helper function to create an Idea Management process map
function createIdeaManagementProcessMap() {
    return `
    <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
        <style>
            .box { fill: #E0F2FE; stroke: #0284C7; stroke-width: 2; }
            .arrow { stroke: #4B5563; stroke-width: 2; fill: none; }
            .text { font-family: Arial; font-size: 12px; fill: #1F2937; text-anchor: middle; }
            .phase { font-family: Arial; font-size: 14px; fill: #0284C7; font-weight: bold; text-anchor: middle; }
        </style>
        
        <!-- Boxes in a circular flow -->
        <rect class="box" x="100" y="60" width="120" height="50" rx="5" />
        <rect class="box" x="340" y="60" width="120" height="50" rx="5" />
        <rect class="box" x="580" y="60" width="120" height="50" rx="5" />
        <rect class="box" x="580" y="180" width="120" height="50" rx="5" />
        <rect class="box" x="340" y="180" width="120" height="50" rx="5" />
        <rect class="box" x="100" y="180" width="120" height="50" rx="5" />
        
        <!-- Phase labels -->
        <text class="phase" x="160" y="85">Idea Generation</text>
        <text class="phase" x="400" y="85">Idea Screening</text>
        <text class="phase" x="640" y="85">Evaluation</text>
        <text class="phase" x="640" y="205">Implementation</text>
        <text class="phase" x="400" y="205">Prototyping</text>
        <text class="phase" x="160" y="205">Concept Dev</text>
        
        <!-- Arrows -->
        <path class="arrow" d="M220 85 H 340" marker-end="url(#arrowhead-blue)" />
        <path class="arrow" d="M460 85 H 580" marker-end="url(#arrowhead-blue)" />
        <path class="arrow" d="M640 110 V 180" marker-end="url(#arrowhead-blue)" />
        <path class="arrow" d="M580 205 H 460" marker-end="url(#arrowhead-blue)" />
        <path class="arrow" d="M340 205 H 220" marker-end="url(#arrowhead-blue)" />
        <path class="arrow" d="M160 180 V 110" marker-end="url(#arrowhead-blue)" />
        
        <!-- Arrowhead marker -->
        <defs>
            <marker id="arrowhead-blue" markerWidth="10" markerHeight="7" 
            refX="9" refY="3.5" orient="auto">
            <polygon points="0 0, 10 3.5, 0 7" fill="#0284C7" />
            </marker>
        </defs>
    </svg>
    `;
}

// Helper function to create a generic process map
function createGenericProcessMap(framework) {
    return `
    <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
        <style>
            .box { fill: #F3F4F6; stroke: #6B7280; stroke-width: 2; }
            .arrow { stroke: #6B7280; stroke-width: 2; fill: none; }
            .text { font-family: Arial; font-size: 12px; fill: #1F2937; text-anchor: middle; }
            .phase { font-family: Arial; font-size: 14px; fill: #4B5563; font-weight: bold; text-anchor: middle; }
            .title { font-family: Arial; font-size: 16px; fill: #111827; font-weight: bold; text-anchor: middle; }
        </style>
        
        <!-- Title -->
        <text class="title" x="400" y="30">${framework.toUpperCase().replace(/-/g, ' ')} Process</text>
        
        <!-- Boxes -->
        <rect class="box" x="100" y="100" width="140" height="60" rx="5" />
        <rect class="box" x="330" y="100" width="140" height="60" rx="5" />
        <rect class="box" x="560" y="100" width="140" height="60" rx="5" />
        
        <!-- Phase labels -->
        <text class="phase" x="170" y="130">Planning</text>
        <text class="phase" x="400" y="130">Execution</text>
        <text class="phase" x="630" y="130">Review</text>
        
        <!-- Arrows -->
        <path class="arrow" d="M240 130 H 330" marker-end="url(#arrowhead-gray)" />
        <path class="arrow" d="M470 130 H 560" marker-end="url(#arrowhead-gray)" />
        
        <!-- Arrowhead marker -->
        <defs>
            <marker id="arrowhead-gray" markerWidth="10" markerHeight="7" 
            refX="9" refY="3.5" orient="auto">
            <polygon points="0 0, 10 3.5, 0 7" fill="#6B7280" />
            </marker>
        </defs>
    </svg>
    `;
}

// Helper function to create a data model
function createDataModel(framework) {
    return `
    <svg width="100%" height="100%" viewBox="0 0 800 300" xmlns="http://www.w3.org/2000/svg">
        <style>
            .entity { fill: #EFF6FF; stroke: #2563EB; stroke-width: 2; }
            .relation { stroke: #2563EB; stroke-width: 2; fill: none; }
            .text { font-family: Arial; font-size: 14px; fill: #1F2937; }
            .entity-title { font-family: Arial; font-size: 14px; fill: #2563EB; font-weight: bold; }
            .entity-field { font-family: Arial; font-size: 12px; fill: #4B5563; }
        </style>
        
        <!-- Main Entity -->
        <rect class="entity" x="300" y="50" width="200" height="120" rx="5" />
        <text class="entity-title" x="400" y="75" text-anchor="middle">${framework.toUpperCase().replace(/-/g, ' ')}</text>
        <line x1="310" y1="85" x2="490" y2="85" stroke="#2563EB" stroke-width="1" />
        <text class="entity-field" x="320" y="105">id (PK)</text>
        <text class="entity-field" x="320" y="125">name</text>
        <text class="entity-field" x="320" y="145">description</text>
        
        <!-- Related Entity 1 -->
        <rect class="entity" x="100" y="180" width="180" height="100" rx="5" />
        <text class="entity-title" x="190" y="205" text-anchor="middle">Documentation</text>
        <line x1="110" y1="215" x2="270" y2="215" stroke="#2563EB" stroke-width="1" />
        <text class="entity-field" x="120" y="235">id (PK)</text>
        <text class="entity-field" x="120" y="255">${framework}_id (FK)</text>
        
        <!-- Related Entity 2 -->
        <rect class="entity" x="520" y="180" width="180" height="100" rx="5" />
        <text class="entity-title" x="610" y="205" text-anchor="middle">Deliverables</text>
        <line x1="530" y1="215" x2="690" y2="215" stroke="#2563EB" stroke-width="1" />
        <text class="entity-field" x="540" y="235">id (PK)</text>
        <text class="entity-field" x="540" y="255">${framework}_id (FK)</text>
        
        <!-- Relationship Lines -->
        <path class="relation" d="M300 110 H 200 V 180" marker-end="url(#relation-end)" />
        <path class="relation" d="M500 110 H 600 V 180" marker-end="url(#relation-end)" />
        
        <!-- Relationship markers -->
        <defs>
            <marker id="relation-end" markerWidth="10" markerHeight="7" 
            refX="9" refY="3.5" orient="auto">
            <polygon points="0 0, 10 3.5, 0 7" fill="#2563EB" />
            </marker>
        </defs>
    </svg>
    `;
}

// Function to initialize process visualization
function initializeProcessVisualization() {
    const generateProcessMapBtn = document.getElementById('generate-process-map');
    const generateDataModelBtn = document.getElementById('generate-data-model');
    const visualizationArea = document.getElementById('visualization-area');
    const visualizationPlaceholder = document.getElementById('visualization-placeholder');
    
    if (!generateProcessMapBtn || !generateDataModelBtn || !visualizationArea) return;
    
    // Set framework when selected
    const frameworkSelector = document.getElementById('framework-selector');
    if (frameworkSelector) {
        frameworkSelector.addEventListener('change', function() {
            currentFramework = this.value;
        });
    }
    
    // Generate Process Map button
    generateProcessMapBtn.addEventListener('click', function() {
        if (!currentFramework) {
            alert('Please select a framework first');
            return;
        }
        
        if (visualizationPlaceholder) {
            visualizationPlaceholder.classList.add('hidden');
        }
        
        visualizationArea.innerHTML = '<div class="flex justify-center items-center h-full"><div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-green-500"></div></div>';
        
        // Simulate API call with timeout
        setTimeout(() => {
            // Show process map based on framework
            let processMap = '';
            
            switch(currentFramework) {
                case 'prince2':
                    processMap = createPRINCE2ProcessMap();
                    break;
                case 'idea-management':
                    processMap = createIdeaManagementProcessMap();
                    break;
                default:
                    processMap = createGenericProcessMap(currentFramework);
            }
            
            visualizationArea.innerHTML = processMap;
            visualizationArea.classList.remove('hidden');
            
            // Add success message if addMessage function exists
            if (typeof addMessage === 'function') {
                addMessage('ai', '<div class="bg-green-50 border-l-4 border-green-500 p-4"><p class="text-green-700">Process map generated successfully.</p></div>', true);
            }
        }, 1000);
    });
    
    // Generate Data Model button
    generateDataModelBtn.addEventListener('click', function() {
        if (!currentFramework) {
            alert('Please select a framework first');
            return;
        }
        
        if (visualizationPlaceholder) {
            visualizationPlaceholder.classList.add('hidden');
        }
        
        visualizationArea.innerHTML = '<div class="flex justify-center items-center h-full"><div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-green-500"></div></div>';
        
        // Simulate API call with timeout
        setTimeout(() => {
            // Create data model
            const dataModel = createDataModel(currentFramework);
            visualizationArea.innerHTML = dataModel;
            visualizationArea.classList.remove('hidden');
            
            // Add success message if addMessage function exists
            if (typeof addMessage === 'function') {
                addMessage('ai', '<div class="bg-green-50 border-l-4 border-green-500 p-4"><p class="text-green-700">Data model generated successfully.</p></div>', true);
            }
        }, 1000);
    });
}

// Initialize when document is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeProcessVisualization();
});
