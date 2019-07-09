<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Redirector;
use App\Project;
use App\Task;

class ProjectTasksController extends Controller
{
    /**
     * @param Project $project
     * @return Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Project $project) : Redirector
    {
        $this->authorize('update', $project);

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    /**
     * @param Project $project
     * @param Task $task
     * @return Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Project $project, Task $task) : Redirector
    {
        $this->authorize('update', $task->project);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);

        return redirect($project->path());
    }
}
