<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Path to the settings JSON file.
     */
    protected $settingsPath;
    
    /**
     * Default settings values
     */
    protected $defaultSettings;
    
    /**
     * Constructor to initialize settings
     */
    public function __construct()
    {
        $this->settingsPath = storage_path('app/settings.json');
        
        $this->defaultSettings = [
            // General settings
            'site_name' => [
                'value' => 'Refine Analysis',
                'group' => 'general',
                'type' => 'text',
                'name' => 'Site Name',
                'description' => 'The main name of your site displayed in various locations',
                'is_public' => true,
                'sort_order' => 1
            ],
            'site_description' => [
                'value' => 'Advanced analytics and project management platform',
                'group' => 'general',
                'type' => 'text',
                'name' => 'Site Description',
                'description' => 'A short description of your site used in search engines',
                'is_public' => true,
                'sort_order' => 2
            ],
            'contact_email' => [
                'value' => 'admin@example.com',
                'group' => 'general',
                'type' => 'text',
                'name' => 'Contact Email',
                'description' => 'The email address used for contact purposes',
                'is_public' => true,
                'sort_order' => 3
            ],
            
            // Branding settings
            'site_logo' => [
                'value' => 'logos/default-logo.png',
                'group' => 'branding',
                'type' => 'image',
                'name' => 'Site Logo',
                'description' => 'The main logo of your site (Recommended: 200 × 60px)',
                'is_public' => true,
                'sort_order' => 1
            ],
            'admin_logo' => [
                'value' => 'logos/default-admin-logo.png',
                'group' => 'branding',
                'type' => 'image',
                'name' => 'Admin Dashboard Logo',
                'description' => 'The logo used in the admin dashboard (Recommended: 160 × 50px)',
                'is_public' => false,
                'sort_order' => 2
            ],
            'user_dashboard_logo' => [
                'value' => 'logos/default-user-logo.png',
                'group' => 'branding',
                'type' => 'image',
                'name' => 'User Dashboard Logo',
                'description' => 'The logo used in the user dashboard (Recommended: 160 × 50px)',
                'is_public' => true,
                'sort_order' => 3
            ],
            'favicon' => [
                'value' => 'logos/favicon.ico',
                'group' => 'branding',
                'type' => 'image',
                'name' => 'Favicon',
                'description' => 'The site icon shown in browser tabs (Recommended: 32 × 32px, .ico format)',
                'is_public' => true,
                'sort_order' => 4
            ],
            
            // Footer settings
            'footer_text' => [
                'value' => '© ' . date('Y') . ' Refine Analysis. All rights reserved.',
                'group' => 'footer',
                'type' => 'text',
                'name' => 'Copyright Text',
                'description' => 'The copyright text displayed at the bottom of the page',
                'is_public' => true,
                'sort_order' => 1
            ],
            'footer_links' => [
                'value' => json_encode([
                    ['title' => 'Privacy Policy', 'url' => '/privacy-policy'],
                    ['title' => 'Terms of Service', 'url' => '/terms'],
                    ['title' => 'Contact Us', 'url' => '/contact']
                ]),
                'group' => 'footer',
                'type' => 'json',
                'name' => 'Footer Links',
                'description' => 'Links displayed in the footer',
                'is_public' => true,
                'sort_order' => 2
            ],
            'social_links' => [
                'value' => json_encode([
                    ['platform' => 'twitter', 'url' => 'https://twitter.com/example'],
                    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/company/example'],
                    ['platform' => 'github', 'url' => 'https://github.com/example']
                ]),
                'group' => 'footer',
                'type' => 'json',
                'name' => 'Social Media Links',
                'description' => 'Social media profile links displayed in the footer',
                'is_public' => true,
                'sort_order' => 3
            ],
            
            // Advanced settings
            'enable_registration' => [
                'value' => '1',
                'group' => 'advanced',
                'type' => 'boolean',
                'name' => 'Enable Registration',
                'description' => 'Allow new users to register on the site',
                'is_public' => false,
                'sort_order' => 1
            ],
            'maintenance_mode' => [
                'value' => '0',
                'group' => 'advanced',
                'type' => 'boolean',
                'name' => 'Maintenance Mode',
                'description' => 'Enable maintenance mode to prevent access to the site except for admins',
                'is_public' => false,
                'sort_order' => 2
            ],
            'google_analytics_id' => [
                'value' => '',
                'group' => 'advanced',
                'type' => 'text',
                'name' => 'Google Analytics ID',
                'description' => 'Google Analytics account ID for tracking site visits',
                'is_public' => false,
                'sort_order' => 3
            ]
        ];
        
        // Initialize settings file if it doesn't exist
        $this->initializeSettings();
    }
    
    /**
     * Initialize settings file if it doesn't exist
     */
    protected function initializeSettings()
    {
        if (!File::exists($this->settingsPath)) {
            // Create directory if it doesn't exist
            File::ensureDirectoryExists(storage_path('app'));
            
            // Create settings file with default values
            File::put($this->settingsPath, json_encode($this->defaultSettings, JSON_PRETTY_PRINT));
            
            // Create logos directory if it doesn't exist
            $logosPath = storage_path('app/public/logos');
            if (!File::exists($logosPath)) {
                File::makeDirectory($logosPath, 0755, true);
            }
            
            // Copy default logos if they exist
            $defaultImages = [
                'default-logo.png',
                'default-admin-logo.png',
                'default-user-logo.png',
                'favicon.ico'
            ];
            
            foreach ($defaultImages as $image) {
                $sourcePath = public_path('img/defaults/' . $image);
                $destinationPath = storage_path('app/public/logos/' . $image);
                
                if (File::exists($sourcePath) && !File::exists($destinationPath)) {
                    File::copy($sourcePath, $destinationPath);
                }
            }
        }
    }
    
    /**
     * Get all settings
     * 
     * @return array
     */
    protected function getSettings()
    {
        if (File::exists($this->settingsPath)) {
            return json_decode(File::get($this->settingsPath), true) ?: $this->defaultSettings;
        }
        
        return $this->defaultSettings;
    }
    
    /**
     * Save settings
     * 
     * @param array $settings
     * @return bool
     */
    protected function saveSettings($settings)
    {
        return File::put($this->settingsPath, json_encode($settings, JSON_PRETTY_PRINT));
    }
    
    /**
     * Display the settings page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get settings and group them
        $settings = $this->getSettings();
        $grouped = [];
        
        foreach ($settings as $key => $setting) {
            $group = $setting['group'] ?? 'general';
            $setting['key'] = $key;
            $grouped[$group][] = (object) $setting;
        }
        
        // Send data to the view
        return view('admin.settings.index', [
            'settings' => $grouped,
            'groups' => [
                'general' => 'General Settings',
                'branding' => 'Branding & Identity',
                'footer' => 'Footer Settings',
                'advanced' => 'Advanced Settings'
            ]
        ]);
    }
    
    /**
     * Update settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate submitted data
        $validator = Validator::make($request->all(), [
            'settings' => 'required|array',
            'settings.*' => 'nullable',
            'files.*' => 'nullable|image|max:2048' // 2MB max for images
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Get submitted settings and files
        $settingValues = $request->input('settings', []);
        $settingFiles = $request->file('files', []);
        
        // Get current settings
        $settings = $this->getSettings();
        
        // Update settings
        foreach ($settingValues as $key => $value) {
            if (!isset($settings[$key])) {
                continue;
            }
            
            // Handle file uploads
            if ($settings[$key]['type'] === 'image' && isset($settingFiles[$key])) {
                $file = $settingFiles[$key];
                
                if ($file && $file->isValid()) {
                    // Delete old file if exists
                    $oldPath = $settings[$key]['value'];
                    if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                    
                    // Store new file
                    $path = $file->store('logos', 'public');
                    $settings[$key]['value'] = $path;
                }
            } else {
                // Update regular value
                $settings[$key]['value'] = $value;
            }
        }
        
        // Save updated settings
        $this->saveSettings($settings);
        
        // Clear cache
        $this->clearSettingsCache();
        
        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
    
    /**
     * Clear settings cache
     */
    protected function clearSettingsCache()
    {
        Cache::forget('app_settings');
        Cache::forget('public_settings');
    }
    
    /**
     * Get public settings for use in frontend
     * 
     * @return array
     */
    public static function getPublicSettings()
    {
        return Cache::rememberForever('public_settings', function() {
            $controller = new self();
            $settings = $controller->getSettings();
            $publicSettings = [];
            
            foreach ($settings as $key => $setting) {
                if (isset($setting['is_public']) && $setting['is_public']) {
                    $publicSettings[$key] = $setting['value'];
                }
            }
            
            return $publicSettings;
        });
    }
}
