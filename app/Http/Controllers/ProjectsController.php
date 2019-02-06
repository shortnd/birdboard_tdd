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

    public function show(Project $project)
    {
        return view('projects.show')->withProject($project);
    }

    public function store()
    {
        Project::create($this->validate(request(), [
            'title' => 'required|min:3',
            'description' => 'required'
        ]));
        return redirect('/projects');
    }
}
