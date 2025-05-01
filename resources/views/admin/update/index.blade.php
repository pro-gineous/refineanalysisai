@extends('layouts.admin')

@section('title', 'System Update')

@section('styles')
<!-- استخدام ملف CSS خارجي بدلاً من الأنماط المضمنة -->
<link rel="stylesheet" href="{{ asset('css/admin/update.css') }}">

@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Status Alerts -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    <div class="update-container">
        <div class="update-header text-center">
            <h2 class="text-gray-900 font-bold mb-3">System Update</h2>
            <div id="version-badge" class="version-badge inline-block mx-auto mb-6">
                <i class="fas fa-code-branch mr-1"></i> <span id="current-version">Loading version...</span>
            </div>
        </div>
        
        <div class="update-status-container text-center mb-8">
            <!-- System Status Indicator -->
            <div class="inline-flex items-center justify-center mb-4 px-6 py-3 rounded-lg bg-gray-50">
                <span id="status-indicator" class="status-indicator updated"></span>
                <span id="status-text" class="font-medium text-gray-800">Checking system status...</span>
            </div>
            
            <div id="last-checked" class="text-sm text-gray-500 mt-2 hidden">
                Last checked: <span id="last-checked-time"></span>
            </div>
        </div>
        
        <!-- Update Actions -->
        <div class="flex flex-col items-center justify-center">
            <div id="update-actions">
                <!-- زر التحقق من التحديثات / التحديث -->
                <div id="check-updates-container">
                    <button type="button" class="check-updates-btn px-5 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="refresh-updates">
                        <i class="fas fa-sync-alt mr-2" id="update-icon"></i> <span id="update-btn-text">Check for Updates</span>
                    </button>
                </div>
                
                <!-- نموذج التحديث (يظهر فقط عند الضغط على زر Update Now) -->
                <form action="/admin/update/pull" method="POST" id="update-form" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        // Apply animation to the update container on page load
        $('.update-container').addClass('animate-fade-in-up');
        
        // قم بفحص التحديثات عند تحميل الصفحة
        checkForUpdates();
        
        // تهيئة زر التحقق من التحديثات
        $('#refresh-updates').click(function(e) {
            e.preventDefault();
            checkForUpdates();
        });
        
        // دالة التحقق من وجود تحديثات
        function checkForUpdates() {
            let $statusIndicator = $('#status-indicator');
            let $statusText = $('#status-text');
            let $button = $('#refresh-updates');
            let $updateNowContainer = $('#update-now-container');
            let $lastChecked = $('#last-checked');
            let $lastCheckedTime = $('#last-checked-time');
            let $currentVersion = $('#current-version');
            
            // تعطيل الزر وإظهار مؤشر التحميل
            $button.prop('disabled', true);
            $button.html('<i class="fas fa-spinner fa-spin mr-2"></i> Checking...');
            
            // طلب AJAX للتحقق من التحديثات
            $.ajax({
                url: '/admin/update/check',
                type: 'GET',
                dataType: 'json',
                cache: false,
                success: function(response) {
                    if (response.success) {
                        // تحديث معلومات الإصدار
                        $currentVersion.text('Current Version: ' + response.currentVersion);
                        
                        // تحديث وقت آخر فحص
                        $lastCheckedTime.text(response.lastChecked);
                        $lastChecked.removeClass('hidden');
                        
                        // تحديث حالة التحديث
                        if (response.hasUpdates) {
                            // هناك تحديثات متاحة
                            $statusIndicator.removeClass('updated').addClass('outdated');
                            $statusText.text('Updates Available');
                            $updateNowContainer.removeClass('hidden');
                            
                            // إظهار إشعار التحديثات
                            showToast('Update Available', 'A new version is available for your system.', 'warning');
                        } else {
                            // النظام محدث
                            $statusIndicator.removeClass('outdated').addClass('updated');
                            $statusText.text('System Up to Date');
                            $updateNowContainer.addClass('hidden');
                            
                            // إظهار إشعار النظام محدث
                            showToast('System Check', 'Your system is up to date with the latest version.', 'success');
                        }
                    } else {
                        // حدث خطأ أثناء التحقق
                        $statusText.text('Error checking updates');
                        showToast('Error', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    // حدث خطأ في الاتصال
                    $statusText.text('Connection error');
                    showToast('Connection Error', 'Could not connect to the server to check for updates.', 'error');
                },
                complete: function() {
                    // إعادة تفعيل الزر
                    $button.prop('disabled', false);
                    $button.html('<i class="fas fa-sync-alt mr-2"></i> Check for Updates');
                }
            });
        }
        
        // دالة عرض إشعار منبثق
        function showToast(title, message, type) {
            // تحديد لون الإشعار حسب النوع
            let headerClass = 'bg-green-500';
            let icon = 'fa-check-circle';
            
            if (type === 'warning') {
                headerClass = 'bg-yellow-500';
                icon = 'fa-exclamation-circle';
            } else if (type === 'error') {
                headerClass = 'bg-red-500';
                icon = 'fa-times-circle';
            }
            
            // إنشاء الإشعار
            const toast = `
                <div class="update-toast">
                    <div class="update-toast-header ${headerClass}">
                        <div class="flex items-center">
                            <i class="fas ${icon} mr-2"></i>
                            <span>${title}</span>
                        </div>
                        <button type="button" class="text-white hover:text-gray-200 toast-close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="update-toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            const $toast = $(toast);
            $('body').append($toast);
            
            // وظيفة زر الإغلاق
            $toast.find('.toast-close').click(function() {
                $toast.remove();
            });
            
            // إزالة الإشعار تلقائيًا بعد 4 ثوانٍ
            setTimeout(function() {
                $toast.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 4000);
        }
    });
        
        // Options toggles
        $('#force-reset').change(function() {
            if($(this).is(':checked')) {
                // Show warning if force reset is enabled
                const warningModal = `
                    <div class="modal fade" id="resetWarningModal" tabindex="-1" role="dialog" aria-labelledby="resetWarningModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title" id="resetWarningModalLabel">Warning: Force Reset Enabled</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-3">
                                        <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
                                    </div>
                                    <p>Enabling force reset will discard all local changes that have not been committed to the repository.</p>
                                    <p class="fw-bold">This action cannot be undone. Proceed with caution.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" id="disableForceReset" data-bs-dismiss="modal">Disable Force Reset</button>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">I Understand</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                if($('#resetWarningModal').length === 0) {
                    $('body').append(warningModal);
                    $('#resetWarningModal').modal('show');
                    
                    $('#disableForceReset').click(function() {
                        $('#force-reset').prop('checked', false);
                    });
                } else {
                    $('#resetWarningModal').modal('show');
                }
            }
        });
    });
</script>
@endpush
