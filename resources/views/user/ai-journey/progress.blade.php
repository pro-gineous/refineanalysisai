@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-indigo-50">
    <div class="container mx-auto px-4 py-12">
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">متابعة <span class="text-blue-600">رحلة الذكاء الاصطناعي</span></h1>
            <p class="text-gray-600 max-w-2xl mx-auto">يمكنك متابعة تقدم رحلة الذكاء الاصطناعي والاطلاع على المخرجات المتاحة حتى الآن.</p>
        </div>

        <!-- Progress Overview -->
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-md overflow-hidden mb-10">
            <div class="p-8">
                <div class="flex items-center mb-8">
                    <div class="h-14 w-14 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4 rtl:mr-4 rtl:ml-0">
                        <h2 class="text-2xl font-semibold text-gray-800">تقدم المشروع: 45%</h2>
                        <p class="text-gray-600">تم إكمال مرحلة جمع البيانات وجاري تحليل البيانات</p>
                    </div>
                </div>
                
                <!-- Overall Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-4 mb-8">
                    <div class="bg-blue-500 h-4 rounded-full" style="width: 45%"></div>
                </div>
                
                <!-- Milestone Progress Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Milestone 1: Completed -->
                    <div class="bg-white rounded-lg border border-green-200 shadow-sm overflow-hidden">
                        <div class="bg-green-50 px-4 py-3 border-b border-green-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <h3 class="text-md font-medium text-gray-800">جمع المعلومات</h3>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm text-gray-600">التقدم:</span>
                                <span class="text-sm font-medium text-gray-800">100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-3">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: 100%"></div>
                            </div>
                            <div class="text-sm text-gray-600 mb-4">تم إكمال جميع الأسئلة ومعالجة المستندات.</div>
                            
                            <a href="#" class="inline-flex items-center text-sm text-green-600 hover:text-green-700">
                                <span>تنزيل المخرجات</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Milestone 2: In Progress -->
                    <div class="bg-white rounded-lg border border-blue-200 shadow-sm overflow-hidden">
                        <div class="bg-blue-50 px-4 py-3 border-b border-blue-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-md font-medium text-gray-800">التحليل</h3>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm text-gray-600">التقدم:</span>
                                <span class="text-sm font-medium text-gray-800">35%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-3">
                                <div class="bg-blue-500 h-2.5 rounded-full" style="width: 35%"></div>
                            </div>
                            <div class="text-sm text-gray-600 mb-4">جاري تحليل البيانات وتحديد الأولويات.</div>
                            
                            <a href="#" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
                                <span>تنزيل المخرجات الجزئية</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Milestone 3: Not Started -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-md font-medium text-gray-800">المعالجة</h3>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm text-gray-600">التقدم:</span>
                                <span class="text-sm font-medium text-gray-800">0%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-3">
                                <div class="bg-gray-500 h-2.5 rounded-full" style="width: 0%"></div>
                            </div>
                            <div class="text-sm text-gray-600 mb-4">تنتظر إكمال المرحلة السابقة.</div>
                            
                            <span class="inline-flex items-center text-sm text-gray-500">
                                <span>غير متاح حاليًا</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Outputs Section -->
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-md overflow-hidden mb-10">
            <div class="p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">المخرجات المتاحة</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Available Output -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 flex">
                        <div class="mr-4 h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-1">تقرير تحليل البيانات الأولي</h3>
                            <p class="text-sm text-gray-600 mb-3">يحتوي على تحليل البيانات التي تم جمعها ونتائج أولية.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>29/04/2025</span>
                                </div>
                                <a href="#" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
                                    <span>تنزيل</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Available Output -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 flex">
                        <div class="mr-4 h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-1">مستند متطلبات المشروع</h3>
                            <p class="text-sm text-gray-600 mb-3">قائمة بالمتطلبات الوظيفية وغير الوظيفية.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>29/04/2025</span>
                                </div>
                                <a href="#" class="inline-flex items-center text-sm text-purple-600 hover:text-purple-700">
                                    <span>تنزيل</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Upcoming Outputs -->
                <h3 class="text-xl font-semibold text-gray-800 mt-10 mb-6">المخرجات القادمة</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Upcoming Output -->
                    <div class="bg-gray-50 rounded-lg border border-gray-200 shadow-sm p-5 flex">
                        <div class="mr-4 h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-1">العرض التقديمي للمشروع</h3>
                            <p class="text-sm text-gray-600 mb-3">عرض تقديمي يشرح المشروع وأهدافه وخطة العمل والمخاطر.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>في انتظار إكمال تحليل البيانات</span>
                                </div>
                                <span class="inline-flex items-center text-sm text-gray-500">
                                    <span>قيد الإعداد</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Upcoming Output -->
                    <div class="bg-gray-50 rounded-lg border border-gray-200 shadow-sm p-5 flex">
                        <div class="mr-4 h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-1">خطة الحوكمة</h3>
                            <p class="text-sm text-gray-600 mb-3">وثيقة تشرح الأدوار والمسؤوليات وآليات اتخاذ القرار.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>في انتظار إكمال تحليل البيانات</span>
                                </div>
                                <span class="inline-flex items-center text-sm text-gray-500">
                                    <span>قيد الإعداد</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Journey Progress Timeline -->
        <div class="max-w-5xl mx-auto">
            <h3 class="text-xl font-semibold text-gray-800 text-center mb-6">المسار الزمني للرحلة</h3>
            <div class="relative">
                <!-- Timeline Bar -->
                <div class="absolute top-6 left-8 right-8 h-1 bg-gray-200"></div>
                
                <!-- Timeline Steps -->
                <div class="grid grid-cols-5 relative">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center relative">
                        <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center z-10 text-white font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-sm mt-2 font-medium text-gray-700 text-center">جمع المعلومات</span>
                        <span class="text-xs text-gray-500">مكتمل</span>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center relative">
                        <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center z-10 text-white font-bold">2</div>
                        <span class="text-sm mt-2 font-medium text-gray-700 text-center">التحليل</span>
                        <span class="text-xs text-blue-500">قيد التنفيذ</span>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center relative">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center z-10 text-white font-bold">3</div>
                        <span class="text-sm mt-2 font-medium text-gray-500 text-center">المعالجة</span>
                        <span class="text-xs text-gray-500">قريبًا</span>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="flex flex-col items-center relative">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center z-10 text-white font-bold">4</div>
                        <span class="text-sm mt-2 font-medium text-gray-500 text-center">توليد المخرجات</span>
                        <span class="text-xs text-gray-500">قريبًا</span>
                    </div>
                    
                    <!-- Step 5 -->
                    <div class="flex flex-col items-center relative">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center z-10 text-white font-bold">5</div>
                        <span class="text-sm mt-2 font-medium text-gray-500 text-center">التقرير النهائي</span>
                        <span class="text-xs text-gray-500">قريبًا</span>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('user.ideas-projects') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    <span>العودة إلى لوحة التحكم</span>
                </a>
                <a href="#" class="inline-flex items-center px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                    <span>تنزيل حزمة المخرجات المتاحة</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
