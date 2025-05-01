@extends('layouts.dashboard')

@section('title', 'AI Assistant')

@section('content')
<div class="px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">AI Assistant</h1>
            <p class="text-gray-600">Get help with projects, generate ideas, or ask questions about your work.</p>
        </div>
        
        <!-- Chat Interface -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-white font-medium">Chat with AI</h2>
            </div>
            
            <div class="p-6">
                <!-- Chat Messages -->
                <div id="chat-messages" class="space-y-4 mb-4 max-h-96 overflow-y-auto">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-blue-800">Hello! I'm your AI assistant. How can I help you with your projects today?</p>
                    </div>
                </div>
                
                <!-- Chat Input -->
                <form id="chat-form" class="flex items-center space-x-2">
                    <input type="text" id="user-message" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message...">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Tools Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Generate Ideas Tool -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-white font-medium">Generate Project Ideas</h2>
                </div>
                
                <div class="p-6">
                    <form id="ideas-form">
                        <div class="mb-4">
                            <label for="idea-description" class="block text-sm font-medium text-gray-700 mb-1">What would you like ideas about?</label>
                            <textarea id="idea-description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., A mobile app for tracking fitness goals"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-2 rounded-lg hover:from-blue-600 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500">Generate Ideas</button>
                    </form>
                    
                    <div id="ideas-results" class="mt-4 space-y-3 hidden">
                        <div class="border-t pt-4">
                            <h3 class="font-medium text-gray-900 mb-2">Generated Ideas</h3>
                            <div id="ideas-list" class="space-y-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project Analysis Tool -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-white font-medium">Analyze Project</h2>
                </div>
                
                <div class="p-6">
                    <form id="analysis-form">
                        <div class="mb-4">
                            <label for="project-select" class="block text-sm font-medium text-gray-700 mb-1">Select a project to analyze</label>
                            <select id="project-select" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select a project</option>
                                <!-- Projects will be loaded here -->
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-2 rounded-lg hover:from-blue-600 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500">Analyze Project</button>
                    </form>
                    
                    <div id="analysis-results" class="mt-4 space-y-3 hidden">
                        <div class="border-t pt-4">
                            <h3 class="font-medium text-gray-900 mb-2">Analysis Results</h3>
                            <div id="analysis-content" class="text-sm text-gray-700"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load user projects
        loadUserProjects();
        
        // Chat functionality
        const chatForm = document.getElementById('chat-form');
        const userMessageInput = document.getElementById('user-message');
        const chatMessages = document.getElementById('chat-messages');
        
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = userMessageInput.value.trim();
            if (!message) return;
            
            // Add user message to chat
            appendMessage('user', message);
            userMessageInput.value = '';
            
            // Show loading indicator
            const loadingId = appendLoadingMessage();
            
            // Send to API
            fetch('{{ route("ai-assistant.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                // Remove loading message
                removeLoadingMessage(loadingId);
                
                if (data.success) {
                    // Add AI response to chat
                    appendMessage('ai', data.response);
                } else {
                    // Show error
                    appendMessage('error', data.message || 'An error occurred');
                }
            })
            .catch(error => {
                // Remove loading message
                removeLoadingMessage(loadingId);
                // Show error
                appendMessage('error', 'Failed to connect to the server');
                console.error('Error:', error);
            });
        });
        
        // Generate Ideas functionality
        const ideasForm = document.getElementById('ideas-form');
        const ideasResults = document.getElementById('ideas-results');
        const ideasList = document.getElementById('ideas-list');
        
        ideasForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const description = document.getElementById('idea-description').value.trim();
            if (!description) return;
            
            // Show loading
            ideasList.innerHTML = '<div class="text-center py-4"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500 mx-auto"></div><p class="mt-2 text-sm text-gray-500">Generating ideas...</p></div>';
            ideasResults.classList.remove('hidden');
            
            // Send to API
            fetch('{{ route("ai-assistant.generate-ideas") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ description: description })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Display ideas
                    displayIdeas(data.ideas);
                } else {
                    // Show error
                    ideasList.innerHTML = `<div class="text-red-500">${data.message || 'Failed to generate ideas'}</div>`;
                }
            })
            .catch(error => {
                // Show error
                ideasList.innerHTML = '<div class="text-red-500">Failed to connect to the server</div>';
                console.error('Error:', error);
            });
        });
        
        // Project Analysis functionality
        const analysisForm = document.getElementById('analysis-form');
        const analysisResults = document.getElementById('analysis-results');
        const analysisContent = document.getElementById('analysis-content');
        
        analysisForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const projectId = document.getElementById('project-select').value;
            if (!projectId) return;
            
            // Show loading
            analysisContent.innerHTML = '<div class="text-center py-4"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500 mx-auto"></div><p class="mt-2 text-sm text-gray-500">Analyzing project...</p></div>';
            analysisResults.classList.remove('hidden');
            
            // Send to API
            fetch('{{ route("ai-assistant.analyze-project") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ project_id: projectId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Display analysis
                    displayAnalysis(data.analysis);
                } else {
                    // Show error
                    analysisContent.innerHTML = `<div class="text-red-500">${data.message || 'Failed to analyze project'}</div>`;
                }
            })
            .catch(error => {
                // Show error
                analysisContent.innerHTML = '<div class="text-red-500">Failed to connect to the server</div>';
                console.error('Error:', error);
            });
        });
        
        // Helper functions
        function appendMessage(type, content) {
            const messageDiv = document.createElement('div');
            messageDiv.className = type === 'user' ? 'bg-gray-100 p-4 rounded-lg ml-12' : 'bg-blue-50 p-4 rounded-lg mr-12';
            
            if (type === 'error') {
                messageDiv.className = 'bg-red-50 p-4 rounded-lg mr-12';
                messageDiv.innerHTML = `<p class="text-sm text-red-800">${content}</p>`;
            } else {
                messageDiv.innerHTML = `<p class="text-sm ${type === 'user' ? 'text-gray-800' : 'text-blue-800'}">${content}</p>`;
            }
            
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        function appendLoadingMessage() {
            const id = 'loading-' + Date.now();
            const loadingDiv = document.createElement('div');
            loadingDiv.id = id;
            loadingDiv.className = 'bg-blue-50 p-4 rounded-lg mr-12 flex items-center space-x-2';
            loadingDiv.innerHTML = `
                <div class="animate-pulse flex space-x-2">
                    <div class="h-2 w-2 bg-blue-400 rounded-full"></div>
                    <div class="h-2 w-2 bg-blue-400 rounded-full"></div>
                    <div class="h-2 w-2 bg-blue-400 rounded-full"></div>
                </div>
                <p class="text-sm text-blue-800">Thinking...</p>
            `;
            
            chatMessages.appendChild(loadingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return id;
        }
        
        function removeLoadingMessage(id) {
            const loadingDiv = document.getElementById(id);
            if (loadingDiv) {
                loadingDiv.remove();
            }
        }
        
        function displayIdeas(ideas) {
            ideasList.innerHTML = '';
            
            ideas.forEach((idea, index) => {
                const ideaDiv = document.createElement('div');
                ideaDiv.className = 'bg-gray-50 p-4 rounded-lg';
                
                ideaDiv.innerHTML = `
                    <h4 class="font-medium text-gray-900">${index + 1}. ${idea.title}</h4>
                    <p class="text-sm text-gray-700 mt-1">${idea.description}</p>
                    <button class="save-idea-btn mt-2 text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200" 
                        data-title="${encodeURIComponent(idea.title)}" 
                        data-description="${encodeURIComponent(idea.description)}">
                        Save to My Ideas
                    </button>
                `;
                
                ideasList.appendChild(ideaDiv);
            });
            
            // Add event listeners to save buttons
            document.querySelectorAll('.save-idea-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const title = decodeURIComponent(this.dataset.title);
                    const description = decodeURIComponent(this.dataset.description);
                    saveIdea(title, description, this);
                });
            });
        }
        
        function saveIdea(title, description, buttonElement) {
            // Change button to loading state
            const originalText = buttonElement.innerHTML;
            buttonElement.innerHTML = 'Saving...';
            buttonElement.disabled = true;
            
            fetch('{{ route("ai-assistant.save-idea") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ title, description })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Change button to success state
                    buttonElement.innerHTML = 'Saved!';
                    buttonElement.className = 'mt-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded';
                } else {
                    // Revert button to original state with error
                    buttonElement.innerHTML = originalText;
                    buttonElement.disabled = false;
                    alert(data.message || 'Failed to save idea');
                }
            })
            .catch(error => {
                // Revert button to original state
                buttonElement.innerHTML = originalText;
                buttonElement.disabled = false;
                alert('Failed to connect to the server');
                console.error('Error:', error);
            });
        }
        
        function displayAnalysis(analysis) {
            analysisContent.innerHTML = `<div class="whitespace-pre-line">${analysis.analysis}</div>`;
        }
        
        function loadUserProjects() {
            const projectSelect = document.getElementById('project-select');
            
            fetch('/api/user/projects')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.projects.length > 0) {
                        data.projects.forEach(project => {
                            const option = document.createElement('option');
                            option.value = project.id;
                            option.textContent = project.title;
                            projectSelect.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.disabled = true;
                        option.textContent = 'No projects found';
                        projectSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error loading projects:', error);
                    const option = document.createElement('option');
                    option.disabled = true;
                    option.textContent = 'Failed to load projects';
                    projectSelect.appendChild(option);
                });
        }
    });
</script>
@endsection
