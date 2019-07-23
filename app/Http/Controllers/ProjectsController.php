<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ProjectsController extends Controller
{
    /**
     * @return View
     */
    public function index() : View
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }


    /**
     * @param Project $project
     * @return View
     * @throws AuthorizationException
     */
    public function show(Project $project) : View
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * @return Redirector
     */
    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        return redirect($project->path());
    }

    public function edit(Project $project) : View
    {
        return view('projects.edit', compact('project'));
    }


    /**
     * @param UpdateProjectRequest $request
     * @return Redirector
     */
    public function update(UpdateProjectRequest $request) 
    {
        return redirect($request->save()->path());
    }

    /**
     * @return array
     */
    public function validateRequest()
    {
        $attributes = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
        return $attributes;
    }
}
