<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;

class ProjectsInvitationsController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);

        request()->validate([
            'email' => 'required', 'exists:users,email'
        ], [
            'email.exists' => 'The user you are inviting must have a Birdboard account.'
        ]);

        $user = User::where('email', request('email'))->first();

        $project->invite($user);
    }
}
