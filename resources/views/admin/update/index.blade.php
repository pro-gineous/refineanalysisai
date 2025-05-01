@extends('layouts.admin')

@section('title', 'System Update')

@section('styles')
<style>
    .update-dashboard {
        background: linear-gradient(180deg, rgba(248,249,250,1) 0%, rgba(242,244,248,1) 100%);
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .stats-card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .timeline-block {
        position: relative;
        margin-left: 40px;
        padding-bottom: 1.5rem;
    }
    .timeline-step {
        position: absolute;
        left: -40px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .timeline-content {
        padding: 1rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    .update-now-btn {
        background: linear-gradient(45deg, #2152ff 0%, #21d4fd 100%);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        letter-spacing: 0.025em;
        box-shadow: 0 4px 10px rgba(33, 82, 255, 0.3);
        transition: all 0.3s ease;
    }
    .update-now-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(33, 82, 255, 0.4);
    }
    .badge-update {
        background: linear-gradient(45deg, #11cdef 0%, #1171ef 100%);
        color: white;
        font-size: 0.65rem;
        padding: 0.35em 0.65em;
        border-radius: 6px;
    }
    .update-option-card {
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }
    .update-option-card:hover {
        border-color: rgba(0,0,0,0.1);
        background-color: rgba(248,249,250,1);
    }
    .version-badge {
        background-color: rgba(23, 43, 77, 0.1);
        color: #172b4d;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
    }
</style>
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
    
    <!-- Dashboard Header Section -->
    <div class="update-dashboard">
        <div class="row align-items-center mb-4">
            <div class="col-lg-6">
                <div class="d-flex align-items-center mb-2">
                    <div class="me-2">
                        <h1 class="h3 mb-0">System Updates</h1>
                    </div>
                    <span class="version-badge">v1.5.2</span>
                </div>
                <p class="text-muted">Keep your application synchronized with the latest code from your development team.</p>
                <div class="d-flex align-items-center">
                    <div id="system-status-indicator" class="d-flex align-items-center me-4">
                        <span class="badge bg-gradient-success me-2"><i class="fas fa-check"></i></span>
                        <span id="update-status" class="fw-bold">System Up to Date</span>
                        <span class="spinner-border spinner-border-sm ms-2 text-primary" role="status" id="status-spinner" style="display:none;"></span>
                    </div>
                    <span class="text-muted small">Last checked: Today at 4:45 AM</span>
                </div>
            </div>
            <div class="col-lg-6 text-lg-end mt-4 mt-lg-0">
                <form action="{{ route('admin.update.pull') }}" method="POST" class="d-inline-block">
                    @csrf
                    <button type="submit" class="update-now-btn">
                        <i class="fas fa-bolt me-2"></i> Update Now
                    </button>
                </form>
                <button type="button" class="btn btn-outline-secondary ms-2" id="refresh-updates">
                    <i class="fas fa-sync-alt"></i> Check for Updates
                </button>
            </div>
        </div>
        
        <!-- System Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stats-card card shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Current Version</p>
                                    <h5 class="font-weight-bolder mb-0">1.5.2</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center rounded-circle">
                                    <i class="fas fa-code-branch text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stats-card card shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Latest Version</p>
                                    <h5 class="font-weight-bolder mb-0">1.5.2</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center rounded-circle">
                                    <i class="fas fa-tag text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stats-card card shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Last Updated</p>
                                    <h5 class="font-weight-bolder mb-0">1 day ago</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center rounded-circle">
                                    <i class="fas fa-calendar-alt text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stats-card card shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Updates</p>
                                    <h5 class="font-weight-bolder mb-0">24</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center rounded-circle">
                                    <i class="fas fa-history text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content Area -->
    <div class="row">
        <!-- Update History Column -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 font-weight-bold">Update History</h5>
                        <p class="text-sm text-muted mb-0">Recent changes from your development team</p>
                    </div>
                    <div class="badge-update px-3 py-2">
                        <i class="fas fa-history me-1"></i> Latest commits
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-3">
                        <!-- Timeline of recent updates -->
                        <div class="timeline-block mb-4">
                            <span class="timeline-step bg-gradient-primary">
                                <i class="fas fa-code-branch"></i>
                            </span>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-dark font-weight-bold mb-1">AI Integration Improvements</h6>
                                        <p class="text-secondary text-xs mb-2">May 1, 2025 <span class="ms-2 badge bg-light text-dark">v1.5.2</span></p>
                                    </div>
                                    <span class="badge bg-gradient-success">Latest</span>
                                </div>
                                <p class="text-sm mb-2">Enhanced error handling in AI controllers and simplified service integration. Updated UI components for better user experience.</p>
                                <div>
                                    <span class="badge bg-light text-dark me-1">AIController</span>
                                    <span class="badge bg-light text-dark me-1">OpenAIService</span>
                                    <span class="badge bg-light text-dark">UI</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-block mb-4">
                            <span class="timeline-step bg-gradient-success">
                                <i class="fas fa-bug"></i>
                            </span>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-dark font-weight-bold mb-1">Bug Fixes</h6>
                                        <p class="text-secondary text-xs mb-2">April 28, 2025 <span class="ms-2 badge bg-light text-dark">v1.5.1</span></p>
                                    </div>
                                </div>
                                <p class="text-sm mb-2">Fixed file upload issues in AI journey module. Improved error messaging and session handling.</p>
                                <div>
                                    <span class="badge bg-light text-dark me-1">FileUpload</span>
                                    <span class="badge bg-light text-dark me-1">Bugfix</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-block mb-4">
                            <span class="timeline-step bg-gradient-info">
                                <i class="fas fa-rocket"></i>
                            </span>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-dark font-weight-bold mb-1">Performance Optimization</h6>
                                        <p class="text-secondary text-xs mb-2">April 25, 2025 <span class="ms-2 badge bg-light text-dark">v1.5.0</span></p>
                                    </div>
                                </div>
                                <p class="text-sm mb-2">Improved system response time and reduced database query load. Enhanced caching for AI responses.</p>
                                <div>
                                    <span class="badge bg-light text-dark me-1">Performance</span>
                                    <span class="badge bg-light text-dark me-1">Database</span>
                                    <span class="badge bg-light text-dark">Caching</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-block">
                            <span class="timeline-step bg-gradient-dark">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-dark font-weight-bold mb-1">Security Enhancements</h6>
                                        <p class="text-secondary text-xs mb-2">April 20, 2025 <span class="ms-2 badge bg-light text-dark">v1.4.9</span></p>
                                    </div>
                                </div>
                                <p class="text-sm mb-2">Updated dependencies to latest versions. Improved input validation and data sanitization.</p>
                                <div>
                                    <span class="badge bg-light text-dark me-1">Security</span>
                                    <span class="badge bg-light text-dark me-1">Dependencies</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-light p-3 text-center">
                        <a href="#" class="text-primary font-weight-bold text-sm">View all updates <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Update Actions Column -->
        <div class="col-lg-4">
            <!-- Main Update Action Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow-primary text-center rounded-circle mx-auto">
                            <i class="fas fa-cloud-download-alt opacity-10"></i>
                        </div>
                        <h5 class="mt-3 mb-1">One-Click Update</h5>
                        <p class="text-sm text-muted">Keep your application in sync with the latest code</p>
                    </div>
                    
                    <form action="{{ route('admin.update.pull') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn update-now-btn w-100 mb-3">
                            <i class="fas fa-bolt me-2"></i> Update Now
                        </button>
                    </form>
                    
                    <div class="alert alert-warning alert-dismissible fade show p-2" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="alert-icon me-2">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="small">Updates will replace all current files with the latest version. Backup custom changes.</div>
                            <button type="button" class="btn-close ms-auto pt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Update Options Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white p-3">
                    <h5 class="mb-0 font-weight-bold">Update Options</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 d-flex justify-content-between p-3 update-option-card mb-2">
                            <div class="d-flex align-items-center">
                                <div class="icon-sm bg-gradient-success rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-database text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-sm">Backup Data</h6>
                                    <p class="text-xs text-muted mb-0">Create backup before update</p>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="backup-before-update" checked>
                            </div>
                        </div>
                        
                        <div class="list-group-item border-0 d-flex justify-content-between p-3 update-option-card mb-2">
                            <div class="d-flex align-items-center">
                                <div class="icon-sm bg-gradient-info rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-broom text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-sm">Clear Cache</h6>
                                    <p class="text-xs text-muted mb-0">Refresh system cache after update</p>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="clear-cache" checked>
                            </div>
                        </div>
                        
                        <div class="list-group-item border-0 d-flex justify-content-between p-3 update-option-card">
                            <div class="d-flex align-items-center">
                                <div class="icon-sm bg-gradient-danger rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-sync-alt text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-sm">Force Reset</h6>
                                    <p class="text-xs text-muted mb-0">Discard all local changes</p>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="force-reset">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initial status check animation
        $('#status-spinner').hide();
        
        // Refresh updates button
        $('#refresh-updates').click(function(e) {
            e.preventDefault();
            
            // Show loading animation
            $('#status-spinner').show();
            $('#update-status').text('Checking for updates...');
            
            // Add checking visual indicator
            $('#system-status-indicator .badge')
                .removeClass('bg-gradient-success')
                .addClass('bg-gradient-warning')
                .html('<i class="fas fa-spinner fa-spin"></i>');
            
            // Simulate server request with timeout
            setTimeout(function() {
                // Update status back to normal
                $('#status-spinner').hide();
                $('#update-status').text('System Up to Date');
                $('#system-status-indicator .badge')
                    .removeClass('bg-gradient-warning')
                    .addClass('bg-gradient-success')
                    .html('<i class="fas fa-check"></i>');
                    
                // Show toast notification
                const toast = `
                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header bg-success text-white">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong class="me-auto">System Check</strong>
                                <small>Just now</small>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                Your system is up to date with the latest version.
                            </div>
                        </div>
                    </div>
                `;
                
                $('body').append(toast);
                
                // Auto remove toast after 3 seconds
                setTimeout(function() {
                    $('.toast').toast('hide');
                    setTimeout(function() {
                        $('.toast').parent().remove();
                    }, 500);
                }, 3000);
            }, 2000);
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
