<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    public function index()
    {
        return view('admin.update.index');
    }

    public function update(Request $request)
    {
        // Log who requested the update
        $user = Auth::user();
        Log::info('Update requested by: ' . $user->name . ' (ID: ' . $user->id . ')');
        
        try {
            // Check if Git is installed
            $gitExists = $this->checkGitExists();
            
            if (!$gitExists) {
                return redirect()->back()->with('error', 'Git is not available on the server. Please make sure Git is installed.');
            }
            
            // Project path
            $projectPath = base_path();
            
            // Run update command
            $output = [];
            $returnCode = 0;
            
            // Attempt to pull updates
            exec('cd ' . escapeshellarg($projectPath) . ' && git reset --hard 2>&1', $output, $returnCode);
            exec('cd ' . escapeshellarg($projectPath) . ' && git pull 2>&1', $output, $returnCode);
            
            // Log update result
            Log::info('Update output: ' . implode("\n", $output));
            
            if ($returnCode !== 0) {
                return redirect()->back()->with('error', 'An error occurred during the update process: ' . implode("\n", $output));
            }
            
            // Restart the application to refresh cache
            $this->clearApplicationCache();
            
            return redirect()->back()->with('success', 'Application updated successfully! ' . implode("\n", $output));
        } catch (\Exception $e) {
            Log::error('Update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during the update process: ' . $e->getMessage());
        }
    }
    
    private function checkGitExists()
    {
        exec('git --version 2>&1', $output, $returnCode);
        return $returnCode === 0;
    }
    
    private function clearApplicationCache()
    {
        try {
            // Clear application cache
            \Artisan::call('cache:clear');
            \Artisan::call('view:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            
            Log::info('Application cache cleared successfully');
            return true;
        } catch (\Exception $e) {
            Log::error('Error clearing cache: ' . $e->getMessage());
            return false;
        }
    }
    
    public function checkForUpdates()
    {
        try {
            // Check if Git is installed
            $gitExists = $this->checkGitExists();
            
            if (!$gitExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Git is not available on the server. Please make sure Git is installed.'
                ]);
            }
            
            // Project path
            $projectPath = base_path();
            
            // Fetch the latest changes without applying them
            exec('cd ' . escapeshellarg($projectPath) . ' && git remote update 2>&1', $remoteOutput, $remoteCode);
            
            if ($remoteCode !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error connecting to the repository.'
                ]);
            }
            
            // Check if local is behind remote
            exec('cd ' . escapeshellarg($projectPath) . ' && git status -uno 2>&1', $statusOutput, $statusCode);
            
            $behindRemote = false;
            $currentVersion = '';
            $latestVersion = '';
            
            // Get current version (latest commit hash)
            exec('cd ' . escapeshellarg($projectPath) . ' && git rev-parse --short HEAD 2>&1', $currentVersionOutput, $versionCode);
            if ($versionCode === 0 && !empty($currentVersionOutput)) {
                $currentVersion = 'v1.0-' . $currentVersionOutput[0];
            }
            
            // Check output for behind status
            foreach ($statusOutput as $line) {
                if (strpos($line, 'behind') !== false) {
                    $behindRemote = true;
                    break;
                }
            }
            
            // If behind, get the latest version
            if ($behindRemote) {
                exec('cd ' . escapeshellarg($projectPath) . ' && git rev-parse --short origin/main 2>&1', $latestVersionOutput, $latestVersionCode);
                if ($latestVersionCode === 0 && !empty($latestVersionOutput)) {
                    $latestVersion = 'v1.0-' . $latestVersionOutput[0];
                }
            }
            
            return response()->json([
                'success' => true,
                'hasUpdates' => $behindRemote,
                'currentVersion' => $currentVersion,
                'latestVersion' => $behindRemote ? $latestVersion : $currentVersion,
                'lastChecked' => now()->format('F j, Y \\a\\t g:i A')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Update check error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while checking for updates: ' . $e->getMessage()
            ]);
        }
    }
}
