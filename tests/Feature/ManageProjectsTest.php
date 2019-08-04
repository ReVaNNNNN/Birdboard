<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();

        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path() . '/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }

    public function test_user_can_create_a_project()
    {
        $this->sigIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    public function test_user_can_delete_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    public function test_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = [
                'title' => 'Title changed.',
                'description' => 'Description changed.',
                'notes' => 'Notes has been changed.'
            ])
            ->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }

    public function test_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();

        $this->get($project->path() . '/edit')
            ->assertRedirect('login');
    }

    public function test_user_can_view_their_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->be(factory('App\User')->create());

        $project = factory('App\Project')->create();

        $this->get($project->path())
            ->assertStatus(403);
    }

    public function test_an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->sigIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path())
            ->assertStatus(403);
    }

    public function test_project_requires_a_title()
    {
        $this->sigIn();

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    public function test_project_requires_a_description()
    {
        $this->sigIn();

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
