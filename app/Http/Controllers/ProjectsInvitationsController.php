<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;

class ProjectsInvitationsController extends Controller
{
    public function store(Project $project)
    {
        $user = User::where('email', request('email'))->first();

        $project->invite($user);
    }
}
