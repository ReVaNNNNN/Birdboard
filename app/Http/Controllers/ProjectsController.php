<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;

class ProjectsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function index()
    {
        $projects = auth()->user()->accessibleProjects();

        return view('projects.index', compact('projects'));
    }

    /**
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|View
     * @throws AuthorizationException
     */
    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        if ($tasks = request('tasks')) {
            /** @var Project $project */
            $project->addTasks($tasks);
        }

        return redirect($project->path());
    }

    /**
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }


    /**
     * @param UpdateProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateProjectRequest $request)
    {
        return redirect($request->save()->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
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
