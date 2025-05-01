<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the ideas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $ideas = $user->ideas()->orderBy('created_at', 'desc')->get();
        
        return view('user.ideas.index', compact('ideas'));
    }

    /**
     * Show the form for creating a new idea.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.ideas.create');
    }

    /**
     * Store a newly created idea in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|string|in:draft,active,completed,archived',
        ]);

        $user = Auth::user();
        $idea = $user->ideas()->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'draft',
        ]);

        return redirect()->route('user.ideas.show', $idea)->with('success', 'Idea created successfully!');
    }

    /**
     * Display the specified idea.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function show(Idea $idea)
    {
        // Check if the user has access to this idea
        if ($idea->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Get related projects
        $projects = $idea->projects;
        
        return view('user.ideas.show', compact('idea', 'projects'));
    }

    /**
     * Show the form for editing the specified idea.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function edit(Idea $idea)
    {
        // Check if the user has access to this idea
        if ($idea->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('user.ideas.edit', compact('idea'));
    }

    /**
     * Update the specified idea in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Idea $idea)
    {
        // Check if the user has access to this idea
        if ($idea->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|string|in:draft,active,completed,archived',
        ]);

        $idea->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? $idea->status,
        ]);

        return redirect()->route('user.ideas.show', $idea)->with('success', 'Idea updated successfully!');
    }

    /**
     * Remove the specified idea from storage.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idea $idea)
    {
        // Check if the user has access to this idea
        if ($idea->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if idea has any associated projects
        if ($idea->projects()->count() > 0) {
            return back()->with('error', 'Cannot delete this idea because it has associated projects.');
        }
        
        $idea->delete();
        
        return redirect()->route('user.ideas')->with('success', 'Idea deleted successfully!');
    }
}
