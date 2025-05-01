<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    /**
     * Display a listing of the ideas.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Idea::query()->with(['owner']);
        
        // Apply filters
        if ($request->has('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('status', 'like', $searchTerm);
            });
        }
        
        if ($request->has('status') && $request->input('status') != '') {
            $query->where('status', $request->input('status'));
        }
        
        if ($request->has('owner_id') && $request->input('owner_id') != '') {
            $query->where('user_id', $request->input('owner_id'));
        }
        
        // Sort results
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        // Paginate results
        $ideas = $query->paginate(15)->withQueryString();
        
        // Get users for filter dropdown
        $users = User::orderBy('name')->get();
        
        // Get status options
        $statuses = Idea::distinct('status')->pluck('status');
        
        return view('admin.ideas.index', compact('ideas', 'users', 'statuses'));
    }

    /**
     * Show the form for creating a new idea.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        
        return view('admin.ideas.create', compact('users'));
    }

    /**
     * Store a newly created idea in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|max:50',
            'tags' => 'nullable|string',
            'submission_date' => 'nullable|date',
            'target_audience' => 'nullable|string',
            'potential_impact' => 'nullable|string',
            'implementation_difficulty' => 'nullable|string',
        ]);
        
        // Process tags if provided
        if (isset($validated['tags'])) {
            $validated['tags'] = explode(',', $validated['tags']);
        }
        
        // Create the idea
        Idea::create($validated);
        
        return redirect()->route('admin.ideas.index')
            ->with('success', 'Idea created successfully.');
    }

    /**
     * Display the specified idea.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\View\View
     */
    public function show(Idea $idea)
    {
        $idea->load('owner');
        
        return view('admin.ideas.show', compact('idea'));
    }

    /**
     * Show the form for editing the specified idea.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\View\View
     */
    public function edit(Idea $idea)
    {
        $users = User::orderBy('name')->get();
        
        return view('admin.ideas.edit', compact('idea', 'users'));
    }

    /**
     * Update the specified idea in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Idea $idea)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|max:50',
            'tags' => 'nullable|string',
            'submission_date' => 'nullable|date',
            'target_audience' => 'nullable|string',
            'potential_impact' => 'nullable|string',
            'implementation_difficulty' => 'nullable|string',
        ]);
        
        // Process tags if provided
        if (isset($validated['tags'])) {
            $validated['tags'] = explode(',', $validated['tags']);
        }
        
        // Update the idea
        $idea->update($validated);
        
        return redirect()->route('admin.ideas.index')
            ->with('success', 'Idea updated successfully.');
    }

    /**
     * Remove the specified idea from storage.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Idea $idea)
    {
        // Delete the idea
        $idea->delete();
        
        return redirect()->route('admin.ideas.index')
            ->with('success', 'Idea deleted successfully.');
    }
}
