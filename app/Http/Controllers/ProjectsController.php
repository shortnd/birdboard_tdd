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
        // $attibutes = ;

        auth()->user()->projects()->create(request()->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:5'
        ]));

        return redirect('/projects');
    }
}
