<?php

namespace App\Http\Controllers;

use App\Models\Framework;
use App\Models\Idea;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Check if tables exist before counting to prevent errors
        $frameworks = Schema::hasTable('frameworks') ? Framework::count() : 0;
        $ideas = Schema::hasTable('ideas') ? Idea::count() : 0;
        $projects = Schema::hasTable('projects') ? Project::count() : 0;
        
        return view('pages.home', compact('frameworks', 'ideas', 'projects'));
    }
}