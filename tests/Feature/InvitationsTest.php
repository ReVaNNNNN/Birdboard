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

        $project->invite($newUser = factory(User::class)->create());

        $this->sigIn($newUser);
        $this->post(action('ProjectTasksController@store', $project),
            $task = ['body' => 'Body of the task.']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
