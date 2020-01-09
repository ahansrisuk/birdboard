<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index() 
    {
        $projects = auth()->user()->projects()->orderBy('updated_at', 'desc')->get(); 

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        // using the policy
        $this->authorize('update', $project);

        // if (auth()->user()->isNot($project->owner)) {
        //     abort(403);
        // }

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store() 
    {
       $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);

        // $attributes['owner_id'] = auth()->id();
        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function update(Project $project)
    {   
        $this->authorize('update', $project);

        $project->update([
            'notes' => request('notes')
        ]);
        // Equivalent: ->update(request(['notes'])

        return redirect($project->path());
    }
}
