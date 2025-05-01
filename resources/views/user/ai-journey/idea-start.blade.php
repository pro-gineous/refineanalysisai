@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container mx-auto px-4 py-12">
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Start Your <span class="text-purple-600">Idea Journey</span> with AI</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">The AI assistant will guide you through the process of developing and analyzing your idea using the Idea Management Framework.</p>
        </div>

        <!-- AI Journey Intro Card -->
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden mb-10">
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="h-14 w-14 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-semibold text-gray-800">مرحبًا! سأساعدك في تطوير فكرتك</h2>
                        <p class="text-gray-600">دعنا نبدأ رحلة تطوير وتحليل فكرتك باستخدام الذكاء الاصطناعي</p>
                    </div>
                </div>

                <div class="prose max-w-none mb-8">
                    <p>سأقوم بمساعدتك في جمع المعلومات اللازمة، وتحليل الفكرة، وتقديم توصيات ومخرجات مهنية تتضمن:</p>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4 list-none">
                        <li class="flex items-start space-x-2 rtl:space-x-reverse">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>توثيق عملية التحليل</span>
                        </li>
                        <li class="flex items-start space-x-2 rtl:space-x-reverse">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>عروض تقديمية للمعنيين</span>
                        </li>
                        <li class="flex items-start space-x-2 rtl:space-x-reverse">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>خطة الحوكمة</span>
                        </li>
                        <li class="flex items-start space-x-2 rtl:space-x-reverse">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>خيارات الحلول</span>
                        </li>
                        <li class="flex items-start space-x-2 rtl:space-x-reverse">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>مواد تدريبية</span>
                        </li>
                        <li class="flex items-start space-x-2 rtl:space-x-reverse">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>قصص المستخدمين ومتطلبات الفكرة</span>
                        </li>
                    </ul>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 mb-4">هل لديك وثائق جاهزة لفكرتك؟</h3>
                
                <form action="{{ route('user.ai-journey.data-gathering') }}" method="post" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="journey_type" value="idea">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Upload Option -->
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 hover:shadow-md transition duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-800 mb-2">Yes, I have documents</h4>
                                <p class="text-gray-600 text-sm mb-4">Upload idea-related documents (PDF, Word, Excel, PNG, JPG, maximum 50MB)</p>
                                
                                <label for="ideaDocumentUpload" class="w-full max-w-xs px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 cursor-pointer text-center">
                                    Upload Files
                                </label>
                                <input type="file" name="documents[]" multiple class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" id="ideaDocumentUpload">
                                
                                <!-- File Preview Container -->
                                <div id="ideaPreviewContainer" class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-60 overflow-y-auto hidden"></div>
                            </div>
                        </div>
                        
                        <!-- Q&A Option -->
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 hover:shadow-md transition duration-200">
                            <div class="flex flex-col items-center text-center">
                                <div class="mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-800 mb-2">No, start with questions</h4>
                                <p class="text-gray-600 text-sm mb-4">I will ask structured questions to gather the necessary information about your idea</p>
                                
                                <button type="submit" name="start_qa" value="true" class="w-full max-w-xs px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 transition duration-200">
                                    Start Questions
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Journey Flow -->
        <div class="max-w-4xl mx-auto">
            <h3 class="text-xl font-semibold text-gray-800 text-center mb-6">AI Journey Stages</h3>
            <div class="relative">
                <!-- Timeline Bar -->
                <div class="absolute top-6 left-8 right-8 h-1 bg-gray-200"></div>
                
                <!-- Timeline Steps -->
                <div class="grid grid-cols-5 relative">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center relative">
                        <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center z-10 text-white font-bold">1</div>
                        <span class="text-sm mt-2 font-medium text-gray-700 text-center">Information Gathering</span>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center relative">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center z-10 text-white font-bold">2</div>
                        <span class="text-sm mt-2 font-medium text-gray-500 text-center">Analysis</span>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center relative">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center z-10 text-white font-bold">3</div>
                        <span class="text-sm mt-2 font-medium text-gray-500 text-center">Processing</span>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="flex flex-col items-center relative">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center z-10 text-white font-bold">4</div>
                        <span class="text-sm mt-2 font-medium text-gray-500 text-center">Output Generation</span>
                    </div>
                    
                    <!-- Step 5 -->
                    <div class="flex flex-col items-center relative">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center z-10 text-white font-bold">5</div>
                        <span class="text-sm mt-2 font-medium text-gray-500 text-center">Final Report</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadBtn = document.querySelector('label[for="ideaDocumentUpload"]');
        const fileInput = document.getElementById('ideaDocumentUpload');
        
        // Initialize upload button click handler
        uploadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            fileInput.click();
        });
        
        // Show file name when files are selected and create previews
        fileInput.addEventListener('change', function() {
            const previewContainer = document.getElementById('ideaPreviewContainer');
            previewContainer.innerHTML = ''; // Clear previous previews
            
            if (this.files.length > 0) {
                let fileNames = Array.from(this.files).map(file => file.name);
                let fileLabel = fileNames.length > 1 ? `${fileNames.length} files selected` : fileNames[0];
                uploadBtn.innerHTML = fileLabel;
                
                // Show the preview container
                previewContainer.classList.remove('hidden');
                
                // Create previews for each file
                Array.from(this.files).forEach(file => {
                    const filePreview = document.createElement('div');
                    filePreview.className = 'relative bg-gray-100 p-2 rounded-md border border-gray-200';
                    
                    // Create preview content based on file type
                    const fileName = file.name.length > 15 ? file.name.substring(0, 12) + '...' : file.name;
                    
                    if (file.type.match('image.*')) {
                        // Preview for images
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            filePreview.innerHTML = `
                                <div class="relative pb-[100%] overflow-hidden rounded">
                                    <img src="${e.target.result}" class="absolute inset-0 w-full h-full object-cover" alt="${fileName}">
                                </div>
                                <p class="text-xs mt-1 text-center text-gray-600 truncate">${fileName}</p>
                                <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs remove-idea-file" title="Remove">&times;</button>
                            `;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        // Icons for other file types
                        let bgColor = '';
                        
                        if (file.name.match(/\.pdf$/i)) {
                            bgColor = 'bg-red-100';
                        } else if (file.name.match(/\.docx?$/i)) {
                            bgColor = 'bg-blue-100';
                        } else if (file.name.match(/\.xlsx?$/i)) {
                            bgColor = 'bg-green-100';
                        } else {
                            bgColor = 'bg-gray-100';
                        }
                        
                        filePreview.innerHTML = `
                            <div class="${bgColor} rounded-md flex items-center justify-center h-24">
                                <svg class="w-12 h-12 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <p class="text-xs mt-1 text-center text-gray-600 truncate">${fileName}</p>
                            <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs remove-idea-file" title="Remove">&times;</button>
                        `;
                    }
                    
                    previewContainer.appendChild(filePreview);
                });
                
                // Add event listeners to remove buttons
                document.querySelectorAll('.remove-idea-file').forEach(button => {
                    button.addEventListener('click', function() {
                        const previewItem = this.closest('div');
                        const index = Array.from(previewContainer.children).indexOf(previewItem);
                        
                        // Create a new FileList without the removed file
                        const dt = new DataTransfer();
                        const { files } = fileInput;
                        
                        for (let i = 0; i < files.length; i++) {
                            if (i !== index) {
                                dt.items.add(files[i]);
                            }
                        }
                        
                        fileInput.files = dt.files;
                        
                        // Update the label
                        if (dt.files.length > 0) {
                            let fileLabel = dt.files.length > 1 ? `${dt.files.length} files selected` : dt.files[0].name;
                            uploadBtn.innerHTML = fileLabel;
                        } else {
                            uploadBtn.innerHTML = 'Upload Files';
                            previewContainer.classList.add('hidden');
                        }
                        
                        // Remove the preview item
                        previewItem.remove();
                    });
                });
            } else {
                uploadBtn.innerHTML = 'Upload Files';
                previewContainer.classList.add('hidden');
            }
        });
    });
</script>

@endsection
