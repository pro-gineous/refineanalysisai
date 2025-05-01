@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')
<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Reports & Analytics</h2>
    </div>

    <!-- Report Form -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Generate Report</h3>
            
            <form action="{{ url('/admin/reports/generate') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Report Type -->
                    <div>
                        <label for="report_type" class="block text-sm font-medium text-gray-700 mb-1">Report Type <span class="text-red-500">*</span></label>
                        <select name="report_type" id="report_type" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Select Report Type</option>
                            @foreach($reportTypes as $value => $label)
                                <option value="{{ $value }}" {{ old('report_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('report_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Date Range -->
                    <div>
                        <label for="date_range" class="block text-sm font-medium text-gray-700 mb-1">Date Range <span class="text-red-500">*</span></label>
                        <select name="date_range" id="date_range" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Select Date Range</option>
                            @foreach($dateRanges as $value => $label)
                                <option value="{{ $value }}" {{ old('date_range') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('date_range')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Custom Date Range (conditionally displayed) -->
                <div id="custom-date-range" class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: none;">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Additional Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- User Filter -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by User</label>
                        <select name="user_id" id="user_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Framework Filter -->
                    <div id="framework-filter">
                        <label for="framework_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Framework</label>
                        <select name="framework_id" id="framework_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">All Frameworks</option>
                            @foreach($frameworks as $framework)
                                <option value="{{ $framework->id }}" {{ old('framework_id') == $framework->id ? 'selected' : '' }}>{{ $framework->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Output Format -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Output Format</label>
                    <div class="flex space-x-4">
                        <div class="flex items-center">
                            <input id="format_html" name="format" type="radio" value="html" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ old('format', 'html') == 'html' ? 'checked' : '' }}>
                            <label for="format_html" class="ml-2 block text-sm text-gray-700">View in Browser</label>
                        </div>
                        <div class="flex items-center">
                            <input id="format_pdf" name="format" type="radio" value="pdf" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ old('format') == 'pdf' ? 'checked' : '' }}>
                            <label for="format_pdf" class="ml-2 block text-sm text-gray-700">PDF Download</label>
                        </div>
                        <div class="flex items-center">
                            <input id="format_csv" name="format" type="radio" value="csv" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ old('format') == 'csv' ? 'checked' : '' }}>
                            <label for="format_csv" class="ml-2 block text-sm text-gray-700">CSV Download</label>
                        </div>
                        <div class="flex items-center">
                            <input id="format_excel" name="format" type="radio" value="excel" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ old('format') == 'excel' ? 'checked' : '' }}>
                            <label for="format_excel" class="ml-2 block text-sm text-gray-700">Excel Download</label>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Recent Reports -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Reports</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Range</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated By</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No reports generated yet. Use the form above to create your first report.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Show/hide custom date range when "custom" is selected
    document.addEventListener('DOMContentLoaded', function() {
        const dateRangeSelect = document.getElementById('date_range');
        const customDateRange = document.getElementById('custom-date-range');
        
        function toggleCustomDateRange() {
            if (dateRangeSelect.value === 'custom') {
                customDateRange.style.display = 'grid';
            } else {
                customDateRange.style.display = 'none';
            }
        }
        
        // Initial state
        toggleCustomDateRange();
        
        // On change
        dateRangeSelect.addEventListener('change', toggleCustomDateRange);
        
        // Toggle framework filter based on report type
        const reportTypeSelect = document.getElementById('report_type');
        const frameworkFilter = document.getElementById('framework-filter');
        
        reportTypeSelect.addEventListener('change', function() {
            if (this.value === 'project_usage' || this.value === 'framework_popularity') {
                frameworkFilter.style.display = 'block';
            } else {
                frameworkFilter.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection
