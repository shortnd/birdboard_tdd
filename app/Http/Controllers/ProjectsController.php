<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        return view('projects.index')->withProjects($projects);
    }

    public function store()
    {
        Project::create(request(['title', 'description']));
        return redirect('/projects');
    }
}
