<?php

namespace App\Http\Middleware;

use App\Models\UserEvent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackUserEvents
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Process the request first
        $response = $next($request);
        
        // Only track events for authenticated users
        if (Auth::check()) {
            $this->recordUserEvent($request);
        }
        
        return $response;
    }
    
    /**
     * Record user event based on the request
     *
     * @param Request $request
     * @return void
     */
    protected function recordUserEvent(Request $request): void
    {
        // Skip tracking for API and analytics endpoints
        if ($this->shouldSkipTracking($request)) {
            return;
        }
        
        $userId = Auth::id();
        $path = $request->path();
        $routeName = $request->route() ? $request->route()->getName() : null;
        
        // Determine event type and name based on the request
        $eventType = $this->determineEventType($request);
        $eventName = $this->determineEventName($request, $routeName, $path);
        
        // Only record events with a valid type and name
        if ($eventType && $eventName) {
            // Create event attributes
            $attributes = [
                'page' => $path,
                'section' => $this->determineSection($path),
                'action' => $request->method(),
                'metadata' => $this->collectMetadata($request)
            ];
            
            // Record the event using our UserEvent model
            UserEvent::recordEvent($userId, $eventType, $eventName, $attributes);
        }
    }
    
    /**
     * Determine if tracking should be skipped for this request
     *
     * @param Request $request
     * @return bool
     */
    protected function shouldSkipTracking(Request $request): bool
    {
        // Skip API routes
        if ($request->is('api/*')) {
            return true;
        }
        
        // Skip analytics routes to prevent recursion
        if ($request->is('admin/analytics/*')) {
            return true;
        }
        
        // Skip refresh-stats route
        if ($request->is('admin/dashboard/refresh-stats')) {
            return true;
        }
        
        // Skip assets, images, CSS, JS, etc.
        if ($request->is(
            'css/*', 'js/*', 'images/*', 'fonts/*', 'assets/*', '*.ico', '*.png', '*.jpg', 
            '*.svg', '*.gif', '*.css', '*.js', '*.json', '*.map', '*.woff', '*.woff2', '*.ttf'
        )) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine event type based on the request
     *
     * @param Request $request
     * @return string|null
     */
    protected function determineEventType(Request $request): ?string
    {
        if ($request->isMethod('GET')) {
            return 'view';
        }
        
        if ($request->isMethod('POST')) {
            return 'create';
        }
        
        if ($request->isMethod('PUT') || $request->isMethod('PATCH')) {
            return 'update';
        }
        
        if ($request->isMethod('DELETE')) {
            return 'delete';
        }
        
        return 'other';
    }
    
    /**
     * Determine event name based on the request
     *
     * @param Request $request
     * @param string|null $routeName
     * @param string $path
     * @return string|null
     */
    protected function determineEventName(Request $request, ?string $routeName, string $path): ?string
    {
        // If we have a named route, use it
        if ($routeName) {
            return $routeName;
        }
        
        // Clean the path and determine a name
        $segments = explode('/', rtrim($path, '/'));
        
        // If empty path (root), return homepage
        if (empty($segments[0])) {
            return 'homepage';
        }
        
        // Admin dashboard
        if ($segments[0] === 'admin' && count($segments) === 1) {
            return 'admin_dashboard';
        }
        
        // Create an event name from the path
        if (count($segments) >= 2) {
            $resource = end($segments);
            
            // Try to match common CRUD patterns
            if ($resource === 'create') {
                $resourceType = $segments[count($segments) - 2];
                return "create_{$resourceType}";
            }
            
            if ($resource === 'edit') {
                $resourceType = $segments[count($segments) - 3] ?? 'resource';
                return "edit_{$resourceType}";
            }
            
            if (is_numeric($resource) && isset($segments[count($segments) - 2])) {
                $resourceType = $segments[count($segments) - 2];
                return "view_{$resourceType}_details";
            }
            
            // For index pages
            if ($segments[count($segments) - 1] === $segments[0] || 
                $segments[count($segments) - 1] === 'index') {
                return "view_{$segments[count($segments) - 1]}_list";
            }
        }
        
        // Fallback: just use the last segment
        return 'view_' . end($segments);
    }
    
    /**
     * Determine section from path
     *
     * @param string $path
     * @return string|null
     */
    protected function determineSection(string $path): ?string
    {
        $segments = explode('/', rtrim($path, '/'));
        
        // Admin section
        if (isset($segments[0]) && $segments[0] === 'admin') {
            return isset($segments[1]) ? 'admin_' . $segments[1] : 'admin';
        }
        
        // Front section
        return isset($segments[0]) && !empty($segments[0]) ? $segments[0] : 'home';
    }
    
    /**
     * Collect additional metadata about the request
     *
     * @param Request $request
     * @return array
     */
    protected function collectMetadata(Request $request): array
    {
        $metadata = [
            'referer' => $request->header('referer'),
            'query_params' => $request->query(),
        ];
        
        // For non-GET requests, collect submitted parameters (except sensitive data)
        if (!$request->isMethod('GET') && $request->has('_token')) {
            $input = $request->except([
                '_token', 'password', 'password_confirmation', 'current_password',
                'credit_card', 'card_number', 'cvv', 'api_key', 'secret'
            ]);
            
            $metadata['form_data'] = array_map(function ($value) {
                // Truncate long values
                if (is_string($value) && strlen($value) > 100) {
                    return substr($value, 0, 97) . '...';
                }
                return $value;
            }, $input);
        }
        
        return $metadata;
    }
}
