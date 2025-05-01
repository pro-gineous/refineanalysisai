<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Framework;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrameworkController extends Controller
{
    /**
     * Display a listing of the frameworks.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Framework::query();
        
        // Apply filters
        if ($request->has('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('category', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            });
        }
        
        if ($request->has('category') && $request->input('category') != '') {
            $query->where('category', $request->input('category'));
        }
        
        // Sort results
        $sortField = $request->input('sort', 'name');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);
        
        // Paginate results
        $frameworks = $query->paginate(15)->withQueryString();
        
        // Get unique categories for filter dropdown
        $categories = Framework::distinct('category')->pluck('category');
        
        return view('admin.frameworks.index', compact('frameworks', 'categories'));
    }

    /**
     * Show the form for creating a new framework.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get unique categories to help with selection
        $categories = Framework::distinct('category')->pluck('category');
        
        return view('admin.frameworks.create', compact('categories'));
    }

    /**
     * Store a newly created framework in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:frameworks',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string|max:255',
            'comprehensive_description' => 'required|string',
            'icon' => 'nullable|image|max:2048',
        ]);
        
        // Handle icon upload if provided
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('framework-icons', 'public');
            $validated['icon'] = $path;
        }
        
        // Create the framework
        Framework::create($validated);
        
        return redirect()->route('admin.frameworks.index')
            ->with('success', 'Framework created successfully.');
    }

    /**
     * Display the specified framework.
     *
     * @param  \App\Models\Framework  $framework
     * @return \Illuminate\View\View
     */
    public function show(Framework $framework)
    {
        // Get projects using this framework
        $projects = $framework->projects()->with('owner')->latest()->take(5)->get();
        
        return view('admin.frameworks.show', compact('framework', 'projects'));
    }

    /**
     * Show the form for editing the specified framework.
     *
     * @param  \App\Models\Framework  $framework
     * @return \Illuminate\View\View
     */
    public function edit(Framework $framework)
    {
        // Get unique categories to help with selection
        $categories = Framework::distinct('category')->pluck('category');
        
        return view('admin.frameworks.edit', compact('framework', 'categories'));
    }

    /**
     * Update the specified framework in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Framework  $framework
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Framework $framework)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:frameworks,name,' . $framework->id,
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string|max:255',
            'comprehensive_description' => 'required|string',
            'icon' => 'nullable|image|max:2048',
        ]);
        
        // Handle icon upload if provided
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($framework->icon) {
                \Storage::disk('public')->delete($framework->icon);
            }
            
            $path = $request->file('icon')->store('framework-icons', 'public');
            $validated['icon'] = $path;
        }
        
        // Update the framework
        $framework->update($validated);
        
        return redirect()->route('admin.frameworks.index')
            ->with('success', 'Framework updated successfully.');
    }

    /**
     * Remove the specified framework from storage.
     *
     * @param  \App\Models\Framework  $framework
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Framework $framework)
    {
        // Check if framework is used in any projects
        $projectCount = $framework->projects()->count();
        
        if ($projectCount > 0) {
            return redirect()->route('admin.frameworks.index')
                ->with('error', "Cannot delete framework. It is being used by {$projectCount} projects.");
        }
        
        // Delete icon if exists
        if ($framework->icon) {
            \Storage::disk('public')->delete($framework->icon);
        }
        
        // Delete the framework
        $framework->delete();
        
        return redirect()->route('admin.frameworks.index')
            ->with('success', 'Framework deleted successfully.');
    }
}
