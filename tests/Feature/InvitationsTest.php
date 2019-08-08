<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_can_invite_a_user()
    {
        $project = ProjectFactory::create();

        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
        ]);

        $this->assertTrue($project->members->contains($userToInvite));
    }

    public function test_invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        $this->sigIn($newUser);
        $this->post(action('ProjectTasksController@store', $project),
            $task = ['body' => 'Body of the task.']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
