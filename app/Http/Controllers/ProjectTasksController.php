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

        request()->validate(['body' => 'required']);

        $task->update(['body' => request('body')]);

        if (request('completed')) {
            $task->complete();
        } else {
            $task->incomplete();
        }

        return redirect($project->path());
    }
}
