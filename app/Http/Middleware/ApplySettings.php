<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\View;

class ApplySettings
{
    /**
     * Apply system settings to all pages
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get all public settings
        $publicSettings = SettingsController::getPublicSettings();
        
        // Share all settings with views
        View::share('settings', $publicSettings);
        
        // Add commonly used settings variables individually for convenience
        if (!empty($publicSettings)) {
            // Logos with proper storage URLs
            View::share('siteLogo', asset('storage/' . ($publicSettings['site_logo'] ?? 'logos/default-logo.png')));
            View::share('adminLogo', asset('storage/' . ($publicSettings['admin_logo'] ?? 'logos/default-admin-logo.png')));
            View::share('userDashboardLogo', asset('storage/' . ($publicSettings['user_dashboard_logo'] ?? 'logos/default-user-logo.png')));
            View::share('favicon', asset('storage/' . ($publicSettings['favicon'] ?? 'logos/favicon.ico')));
            
            // Site information
            View::share('siteName', $publicSettings['site_name'] ?? 'Refine Analysis');
            View::share('siteDescription', $publicSettings['site_description'] ?? 'Advanced analytics and project management platform');
            View::share('contactEmail', $publicSettings['contact_email'] ?? 'admin@example.com');
            
            // Footer settings - with proper JSON decoding for array values
            View::share('footerText', $publicSettings['footer_text'] ?? '© ' . date('Y') . ' Refine Analysis');
            View::share('footerLinks', json_decode($publicSettings['footer_links'] ?? '[]', true));
            View::share('socialLinks', json_decode($publicSettings['social_links'] ?? '[]', true));
        }
        
        return $next($request);
    }
}
