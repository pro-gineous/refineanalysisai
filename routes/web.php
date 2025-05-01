<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Main website pages (pages shown in the menu)
Route::prefix('')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/services', function () {
        return view('pages.services');
    })->name('services');
    Route::get('/solutions', function () {
        return view('pages.solutions');
    })->name('solutions');
    Route::get('/features', function () {
        return view('pages.features');
    })->name('features');
    Route::get('/pricing', function () {
        return view('pages.pricing');
    })->name('pricing');
    Route::get('/blog', function () {
        return view('pages.blog');
    })->name('blog');
    Route::get('/signup', function () {
        return view('pages.signup');
    })->name('signup')->middleware('guest');
    Route::get('/signin', function () {
        return view('pages.signin');
    })->name('signin')->middleware('guest');
    Route::get('/forgotpassword', function () {
        return view('pages.Forgotpassword');
    })->name('forgotpassword');
    
    // Authentication routes
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register')->middleware('guest');
    Route::get('/login', function() { return redirect()->route('signin'); })->middleware('guest');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login')->middleware('guest');
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    
    // OpenAI Test routes (accessible without login for testing)
    Route::get('/openai-test', [\App\Http\Controllers\OpenAITestController::class, 'testConnection'])->name('openai.test');
    Route::get('/direct-test', [\App\Http\Controllers\OpenAIDirectTestController::class, 'testDirectConnection'])->name('openai.direct.test');
});

// User dashboard routes
Route::prefix('user')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('user.dashboard');
    
    // AI Assistant routes
    Route::get('/ai-assistant', [\App\Http\Controllers\AIAssistantController::class, 'index'])->name('user.ai-assistant');
    Route::post('/ai-assistant/chat', [\App\Http\Controllers\AIAssistantController::class, 'chat'])->name('ai-assistant.chat');
    Route::post('/ai-assistant/generate-ideas', [\App\Http\Controllers\AIAssistantController::class, 'generateIdeas'])->name('ai-assistant.generate-ideas');
    Route::post('/ai-assistant/save-idea', [\App\Http\Controllers\AIAssistantController::class, 'saveIdea'])->name('ai-assistant.save-idea');
    Route::post('/ai-assistant/analyze-project', [\App\Http\Controllers\AIAssistantController::class, 'analyzeProject'])->name('ai-assistant.analyze-project');
    
    // AI Journey routes
    Route::get('/ideas/create', [\App\Http\Controllers\AIJourneyController::class, 'startIdeaJourney'])->name('user.ideas.create');
    Route::get('/projects/create', [\App\Http\Controllers\AIJourneyController::class, 'startProjectJourney'])->name('user.projects.create');
    Route::get('/ai-journey/idea-start', [\App\Http\Controllers\AIJourneyController::class, 'startIdeaJourney'])->name('user.ai-journey.idea-start');
    Route::get('/ai-journey/project-start', [\App\Http\Controllers\AIJourneyController::class, 'startProjectJourney'])->name('user.ai-journey.project-start');
    Route::post('/ai-journey/data-gathering', [\App\Http\Controllers\AIJourneyController::class, 'processDataGathering'])->name('user.ai-journey.data-gathering');
    Route::get('/ai-journey/progress', [\App\Http\Controllers\AIJourneyController::class, 'showJourneyProgress'])->name('user.ai-journey.progress');
    Route::post('/ai-journey/chat', [\App\Http\Controllers\AIJourneyController::class, 'processChatMessage'])->name('user.ai-journey.chat');
    
    // User Settings routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/settings', [\App\Http\Controllers\UserSettingsController::class, 'index'])->name('user.settings');
        Route::post('/settings/update', [\App\Http\Controllers\UserSettingsController::class, 'update'])->name('user.settings.update');
        Route::post('/settings/profile', [\App\Http\Controllers\UserSettingsController::class, 'updateProfile'])->name('user.settings.profile');
        Route::post('/settings/upload-profile-image', [\App\Http\Controllers\UserSettingsController::class, 'uploadProfileImage'])->name('user.settings.upload-profile-image');
        Route::post('/settings/remove-profile-image', [\App\Http\Controllers\UserSettingsController::class, 'removeProfileImage'])->name('user.settings.remove-profile-image');
        Route::post('/settings/password', [\App\Http\Controllers\UserSettingsController::class, 'updatePassword'])->name('user.settings.password');
        Route::post('/settings/notifications', [\App\Http\Controllers\UserSettingsController::class, 'updateNotifications'])->name('user.settings.notifications');
        Route::post('/settings/appearance', [\App\Http\Controllers\UserSettingsController::class, 'updateAppearance'])->name('user.settings.appearance');
        Route::post('/settings/security', [\App\Http\Controllers\UserSettingsController::class, 'updateSecurity'])->name('user.settings.security');
        Route::post('/settings/branding', [\App\Http\Controllers\UserSettingsController::class, 'updateBranding'])->name('user.settings.branding');
        Route::post('/settings/branding/reset', [\App\Http\Controllers\UserSettingsController::class, 'resetBranding'])->name('user.settings.branding.reset');
        Route::post('/settings/advanced', [\App\Http\Controllers\UserSettingsController::class, 'updateAdvanced'])->name('user.settings.advanced');
        Route::get('/user-data/export/{format}', [\App\Http\Controllers\UserDataController::class, 'exportUserData'])->name('user.data.export');
        Route::post('/settings/team/add', [\App\Http\Controllers\UserSettingsController::class, 'addTeamMember'])->name('user.settings.team.add');
        Route::get('/settings/team/{id}/edit', [\App\Http\Controllers\UserSettingsController::class, 'getTeamMemberForEdit'])->name('user.settings.team.edit');
        Route::post('/settings/team/{id}/update', [\App\Http\Controllers\UserSettingsController::class, 'updateTeamMember'])->name('user.settings.team.update');
        Route::delete('/settings/team/{id}/remove', [\App\Http\Controllers\UserSettingsController::class, 'removeTeamMember'])->name('user.settings.team.remove');
        Route::post('/settings/team/{id}/resend-invitation', [\App\Http\Controllers\UserSettingsController::class, 'resendInvitation'])->name('user.settings.team.resend-invitation');
    });
    
    // Ideas & Projects Routes
    Route::get('/ideas-projects', [\App\Http\Controllers\ProjectController::class, 'ideasProjects'])->name('user.ideas-projects');
    Route::get('/projects', [\App\Http\Controllers\ProjectController::class, 'index'])->name('user.projects');
    Route::get('/projects/create', [\App\Http\Controllers\ProjectController::class, 'create'])->name('user.projects.create');
    Route::post('/projects', [\App\Http\Controllers\ProjectController::class, 'store'])->name('user.projects.store');
    Route::get('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'show'])->name('user.projects.show');
    Route::get('/projects/{project}/edit', [\App\Http\Controllers\ProjectController::class, 'edit'])->name('user.projects.edit');
    Route::put('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'update'])->name('user.projects.update');
    Route::delete('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'destroy'])->name('user.projects.destroy');
    
    // Ideas Routes
    Route::get('/ideas', [\App\Http\Controllers\IdeaController::class, 'index'])->name('user.ideas');
    Route::get('/ideas/create', [\App\Http\Controllers\IdeaController::class, 'create'])->name('user.ideas.create');
    Route::post('/ideas', [\App\Http\Controllers\IdeaController::class, 'store'])->name('user.ideas.store');
    Route::get('/ideas/{idea}', [\App\Http\Controllers\IdeaController::class, 'show'])->name('user.ideas.show');
    Route::get('/ideas/{idea}/edit', [\App\Http\Controllers\IdeaController::class, 'edit'])->name('user.ideas.edit');
    Route::put('/ideas/{idea}', [\App\Http\Controllers\IdeaController::class, 'update'])->name('user.ideas.update');
    Route::delete('/ideas/{idea}', [\App\Http\Controllers\IdeaController::class, 'destroy'])->name('user.ideas.destroy');
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');
    Route::get('/search', [\App\Http\Controllers\UserController::class, 'search'])->name('user.search');
    
    // Notifications
    Route::middleware(['auth'])->group(function() {
        Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('user.notifications');
        Route::get('/notifications/header', [\App\Http\Controllers\NotificationController::class, 'getHeaderNotifications'])->name('user.notifications.header');
        Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('user.notifications.read');
        Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('user.notifications.read-all');
        Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'delete'])->name('user.notifications.delete');
        Route::delete('/notifications', [\App\Http\Controllers\NotificationController::class, 'deleteAll'])->name('user.notifications.delete-all');
        Route::get('/notifications/create-test', [\App\Http\Controllers\NotificationController::class, 'createTestNotifications'])->name('user.notifications.create-test');
        
        // تفضيلات الإشعارات
        Route::get('/notification-preferences', [\App\Http\Controllers\NotificationPreferenceController::class, 'index'])->name('user.notification-preferences');
        Route::patch('/notification-preferences', [\App\Http\Controllers\NotificationPreferenceController::class, 'update'])->name('user.notification-preferences.update');
        
        // Direct notification test route (for debugging)
        Route::get('/test-notification', function() {
            $user = auth()->user();
            $sender = User::where('id', '!=', $user->id)->first() ?? $user;
            
            $user->notify(new DirectTeamInvitation($sender, 'دعوة تجريبية للتأكد من عمل نظام الإشعارات'));
            
            return back()->with('success', 'تم إرسال إشعار تجريبي بنجاح!');
        })->name('test.notification');
    });
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/refresh-stats', [\App\Http\Controllers\Admin\DashboardController::class, 'refreshStats'])->name('admin.dashboard.refresh-stats');
    Route::get('/dashboard/refresh-activity', [\App\Http\Controllers\Admin\DashboardController::class, 'refreshActivity'])->name('admin.dashboard.refresh-activity');
});

// API routes
Route::prefix('api')->group(function () {
    Route::get('/user-search', [\App\Http\Controllers\UserController::class, 'apiSearch']);
});

// Notification API route
Route::get('/user/notifications/api', [\App\Http\Controllers\NotificationController::class, 'getNotificationsApi'])->middleware('auth');

// Admin Dashboard routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Framework Routes
    Route::get('/frameworks/{framework}/preview', [\App\Http\Controllers\Admin\FrameworkController::class, 'preview'])->name('frameworks.preview');
    Route::get('/dashboard/refresh-stats', [\App\Http\Controllers\Admin\DashboardController::class, 'refreshStats'])->name('dashboard.refresh-stats');
    Route::get('/dashboard/refresh-activity', [\App\Http\Controllers\Admin\DashboardController::class, 'refreshActivity'])->name('dashboard.refresh-activity');
    
    // User Analytics & Engagement
    Route::get('/analytics/engagement', [\App\Http\Controllers\Admin\UserAnalyticsController::class, 'index'])->name('analytics.engagement');
    Route::get('/analytics/metrics', [\App\Http\Controllers\Admin\UserAnalyticsController::class, 'getMetrics'])->name('analytics.metrics');
    Route::get('/analytics/events/by-type', [\App\Http\Controllers\Admin\UserAnalyticsController::class, 'getEventsByType'])->name('analytics.events.by-type');
    Route::get('/analytics/events/hourly', [\App\Http\Controllers\Admin\UserAnalyticsController::class, 'getHourlyData'])->name('analytics.events.hourly');
    Route::post('/analytics/track-event', [\App\Http\Controllers\Admin\UserAnalyticsController::class, 'trackEvent'])->name('analytics.track-event');
    
    // User Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/activity', [\App\Http\Controllers\Admin\UserController::class, 'activity'])->name('users.activity');
    Route::get('/users/{user}/stats', [\App\Http\Controllers\Admin\UserController::class, 'stats'])->name('users.stats');
    
    // Framework Management
    Route::get('/frameworks', [\App\Http\Controllers\Admin\FrameworkController::class, 'index'])->name('frameworks.index');
    Route::get('/frameworks/create', [\App\Http\Controllers\Admin\FrameworkController::class, 'create'])->name('frameworks.create');
    Route::post('/frameworks', [\App\Http\Controllers\Admin\FrameworkController::class, 'store'])->name('frameworks.store');
    Route::get('/frameworks/{framework}', [\App\Http\Controllers\Admin\FrameworkController::class, 'show'])->name('frameworks.show');
    Route::get('/frameworks/{framework}/edit', [\App\Http\Controllers\Admin\FrameworkController::class, 'edit'])->name('frameworks.edit');
    Route::put('/frameworks/{framework}', [\App\Http\Controllers\Admin\FrameworkController::class, 'update'])->name('frameworks.update');
    Route::delete('/frameworks/{framework}', [\App\Http\Controllers\Admin\FrameworkController::class, 'destroy'])->name('frameworks.destroy');
    
    // Site Settings Management
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    
    // Projects & Ideas Management
    Route::get('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [\App\Http\Controllers\Admin\ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [\App\Http\Controllers\Admin\ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('projects.destroy');
    
    Route::get('/ideas', [\App\Http\Controllers\Admin\IdeaController::class, 'index'])->name('ideas.index');
    Route::get('/ideas/create', [\App\Http\Controllers\Admin\IdeaController::class, 'create'])->name('ideas.create');
    Route::post('/ideas', [\App\Http\Controllers\Admin\IdeaController::class, 'store'])->name('ideas.store');
    Route::get('/ideas/{idea}', [\App\Http\Controllers\Admin\IdeaController::class, 'show'])->name('ideas.show');
    Route::get('/ideas/{idea}/edit', [\App\Http\Controllers\Admin\IdeaController::class, 'edit'])->name('ideas.edit');
    Route::put('/ideas/{idea}', [\App\Http\Controllers\Admin\IdeaController::class, 'update'])->name('ideas.update');
    Route::delete('/ideas/{idea}', [\App\Http\Controllers\Admin\IdeaController::class, 'destroy'])->name('ideas.destroy');
    
    // AI Settings
    Route::get('/ai-settings', [\App\Http\Controllers\Admin\AISettingController::class, 'index'])->name('ai-settings.index');
    Route::put('/ai-settings', [\App\Http\Controllers\Admin\AISettingController::class, 'update'])->name('ai-settings.update');
    Route::post('/ai-settings/test-connection', [\App\Http\Controllers\Admin\AISettingController::class, 'testConnection'])->name('ai-settings.test-connection');
    
    // System Update from GitHub
    Route::get('/update', [\App\Http\Controllers\Admin\UpdateController::class, 'index'])->name('update.index');
    Route::post('/update/pull', [\App\Http\Controllers\Admin\UpdateController::class, 'update'])->name('update.pull');
    Route::get('/update/check', [\App\Http\Controllers\Admin\UpdateController::class, 'checkForUpdates'])->name('update.check');
    
    // Statistics & Reports
    Route::get('/statistics', [\App\Http\Controllers\Admin\StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/users', [\App\Http\Controllers\Admin\StatisticsController::class, 'users'])->name('statistics.users');
    Route::get('/statistics/projects', [\App\Http\Controllers\Admin\StatisticsController::class, 'projects'])->name('statistics.projects');
    Route::get('/statistics/ideas', [\App\Http\Controllers\Admin\StatisticsController::class, 'ideas'])->name('statistics.ideas');
    
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate', [\App\Http\Controllers\Admin\ReportController::class, 'generate'])->name('reports.generate.post');
    Route::get('/reports/generate/{type}', [\App\Http\Controllers\Admin\ReportController::class, 'generate'])->name('reports.generate');
    Route::get('/reports/download/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'download'])->name('reports.download');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('user.projects.index');
    Route::get('/projects/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('user.projects.create');
    Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'store'])->name('user.projects.store');
    Route::get('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'show'])->name('user.projects.show');
    Route::get('/projects/{project}/edit', [App\Http\Controllers\ProjectController::class, 'edit'])->name('user.projects.edit');
    Route::put('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'update'])->name('user.projects.update');
    Route::delete('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'destroy'])->name('user.projects.destroy');
    
    // Team Members Routes
    Route::get('/team-members', [App\Http\Controllers\TeamMemberController::class, 'index'])->name('user.team-members.index');
    Route::post('/team-members', [App\Http\Controllers\TeamMemberController::class, 'store'])->name('user.team-members.store');
    Route::patch('/team-members/{teamMember}', [App\Http\Controllers\TeamMemberController::class, 'update'])->name('user.team-members.update');
    Route::delete('/team-members/{teamMember}', [App\Http\Controllers\TeamMemberController::class, 'destroy'])->name('user.team-members.destroy');
});