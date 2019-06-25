<?php

namespace Tests\Feature;

use App\Project;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_add_tasks_to_projects()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    public function test_only_the_owner_of_a_project_may_add_tasks()
    {
        $this->sigIn();

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    public function test_only_the_owner_of_a_project_may_update_tasks()
    {
        $this->sigIn();

        $project = factory('App\Project')->create();

        $task = $project->addTask('Test task');

        $this->patch($task->path(), ['body' => 'Changed task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed task']);
    }

    public function test_a_project_can_have_tasks()
    {
        $this->sigIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');
    }

    public function test_a_project_can_be_updated()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->sigIn())
            ->withTasks(1)
            ->create();

        // $this->sigIn();

        // $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        // $task = $project->addTask('Test task');

        $this->patch($project->path() . '/tasks/' . $project->tasks[0]  ->id , [
            'body' => 'changed task',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed task',
            'completed' => true
            ]);
    }

    public function test_a_task_require_a_body()
    {
        $this->sigIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
