@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Enhanced Header with Journey Information -->
    <div class="bg-white shadow-sm">
        <div class="container mx-auto p-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="flex items-center space-x-3 mb-3 md:mb-0">
                    <a href="{{ route('user.ideas-projects') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">AI {{ isset($journeyType) && $journeyType == 'idea' ? 'Idea' : 'Project' }} Journey</h1>
                        <p class="text-sm text-gray-500">Let AI guide you through developing your {{ isset($journeyType) && $journeyType == 'idea' ? 'idea' : 'project' }}</p>
                    </div>
                </div>
                
                <!-- Journey Progress --> 
                <div class="flex items-center w-full md:w-1/3">
                    <span class="text-xs text-gray-500 mr-2 whitespace-nowrap">Progress</span>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div id="journey-progress" class="bg-blue-600 h-2.5 rounded-full transition-all duration-700" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Minimalist Chat Interface -->
    <div class="max-w-3xl mx-auto mt-10 bg-white rounded-lg shadow-sm overflow-hidden flex flex-col" style="min-height: 80vh;">
        <!-- Chat Area - Will be filled with messages -->
        <div class="flex-grow p-6 overflow-y-auto" id="chatMessages">
            @if(isset($files) && count($files) > 0)
            <!-- Uploaded Files Section -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-600 mb-2">Uploaded Documents</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($files as $file)
                    <div class="bg-white p-2 rounded-md border border-gray-200 flex flex-col items-center">
                        @if(strpos($file['type'], 'image/') === 0)
                        <div class="w-12 h-12 bg-gray-100 rounded-md flex items-center justify-center mb-1 overflow-hidden">
                            <img src="{{ Storage::url($file['path']) }}" alt="{{ $file['name'] }}" class="w-full h-full object-cover">
                        </div>
                        @elseif(strpos($file['type'], 'application/pdf') === 0)
                        <div class="w-12 h-12 bg-red-100 rounded-md flex items-center justify-center mb-1">
                            <svg class="w-8 h-8 text-red-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        @elseif(strpos($file['name'], '.doc') !== false)
                        <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-1">
                            <svg class="w-8 h-8 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        @elseif(strpos($file['name'], '.xls') !== false)
                        <div class="w-12 h-12 bg-green-100 rounded-md flex items-center justify-center mb-1">
                            <svg class="w-8 h-8 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        @else
                        <div class="w-12 h-12 bg-gray-100 rounded-md flex items-center justify-center mb-1">
                            <svg class="w-8 h-8 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        @endif
                        <p class="text-xs text-gray-600 truncate w-full text-center">{{ \Illuminate\Support\Str::limit($file['name'], 15) }}</p>
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500 mt-2">These documents will be analyzed to enhance your AI journey experience.</p>
            </div>
            @endif

            <!-- Welcome Message -->
            <div class="message ai-message">
                <div class="message-content">
                    <p>Hello! I'm your AI assistant for this journey. I'll help you refine your {{ isset($journeyType) && $journeyType == 'idea' ? 'idea' : 'project' }} through a series of questions.</p>
                    <p class="text-sm text-gray-500 mt-1">Let's start with a brief description of what you have in mind.</p>
                </div>
            </div>
            
            <!-- Messages will be dynamically added here -->
        </div>
        
        <!-- Message Input Form - Minimalist Design -->
        <div class="p-4 border-t border-gray-100">
            <form id="chat-form" class="flex items-center">
                <div class="relative flex-grow">
                    <input type="text" id="user-message" name="message" placeholder="Type your message here..." class="w-full bg-blue-50 text-gray-700 rounded-full px-4 py-3 focus:outline-none" required>
                </div>
                <button type="submit" id="send-button" class="rounded-full w-10 h-10 ml-2 bg-blue-600 flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </form>
        </div>
        
        <!-- AI Typing Indicator (Hidden by default) -->
        <div id="typing-indicator" class="hidden px-6 py-2 bg-gray-50 border-t border-gray-100">
            <div class="flex items-center">
                <div class="flex space-x-1">
                    <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                </div>
                <span class="text-xs text-gray-500 ml-2">AI is typing...</span>
            </div>
        </div>
    </div>
</div>

<style>
    .message {
        margin-bottom: 16px;
        animation: fadeIn 0.3s ease-in-out;
    }
    
    .user-message {
        display: flex;
        justify-content: flex-end;
    }
    
    .message-content {
        max-width: 80%;
        padding: 12px 16px;
        border-radius: 18px;
        position: relative;
    }
    
    .user-message .message-content {
        background-color: #2563eb;
        color: white;
        border-bottom-right-radius: 4px;
    }
    
    .ai-message .message-content {
        background-color: #f3f4f6;
        color: #1f2937;
        border-bottom-left-radius: 4px;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('chatMessages');
        const chatForm = document.getElementById('chat-form');
        const userMessageInput = document.getElementById('user-message');
        const sendButton = document.getElementById('send-button');
        const typingIndicator = document.getElementById('typing-indicator');
        
        // Auto-scroll to bottom of chat
        chatContainer.scrollTop = chatContainer.scrollHeight;
        
        // Handle user message submission
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = userMessageInput.value.trim();
            if (!message) return;
            
            // Add user message to chat
            addMessage('user', message);
            
            // Clear input field
            userMessageInput.value = '';
            
            // Show typing indicator
            typingIndicator.classList.remove('hidden');
            
            // Send message to server
            fetch('{{ route("user.ai-journey.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => {
                if (!response.ok) {
                    console.error('Server error:', response.status, response.statusText);
                }
                return response.json();
            })
            .then(data => {
                // Hide typing indicator
                typingIndicator.classList.add('hidden');
                console.log('AI response data:', data); // Debug log
                
                if (data.success) {
                    // Add AI response to chat
                    addMessage('ai', data.message);
                    
                    // Update progress if provided
                    if (data.progress) {
                        updateProgress(data.progress);
                    }
                    
                    // If we have next steps, show them
                    if (data.next_steps && data.next_steps.length > 0) {
                        setTimeout(() => {
                            addMessage('ai', 'Here are some things to consider: \n• ' + data.next_steps.join('\n• '));
                        }, 1000);
                    }
                } else {
                    // Show detailed error message if available
                    const errorMsg = data.message || 'Sorry, I encountered an error. Please try again.';
                    addMessage('ai', errorMsg);
                    console.error('AI error response:', data.error);
                }
            })
            .catch(error => {
                console.error('Network Error:', error);
                typingIndicator.classList.add('hidden');
                addMessage('ai', 'Sorry, there was a network error. Please try again.');
            });
        });
        
        // Function to add a message to the chat
        function addMessage(sender, content) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            
            // Parse links and format text
            const formattedContent = formatMessageContent(content);
            messageContent.innerHTML = formattedContent;
            
            messageDiv.appendChild(messageContent);
            chatContainer.appendChild(messageDiv);
            
            // Scroll to bottom of chat
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        
        // Function to format message content (handle links, line breaks, etc.)
        function formatMessageContent(content) {
            // Replace URLs with clickable links
            const urlRegex = /(https?:\/\/[^\s]+)/g;
            content = content.replace(urlRegex, url => `<a href="${url}" target="_blank" class="text-blue-600 hover:underline">${url}</a>`);
            
            // Replace line breaks with <br>
            content = content.replace(/\n/g, '<br>');
            
            return content;
        }
        
        // Function to update progress bar if available
        function updateProgress(progress) {
            const progressBar = document.getElementById('journey-progress');
            if (progressBar) {
                progressBar.style.width = `${progress}%`;
                progressBar.setAttribute('aria-valuenow', progress);
            }
        }
    });
</script>
@endsection
