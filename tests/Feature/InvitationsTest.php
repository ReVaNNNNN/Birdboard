<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_owners_may_not_invite_users()
    {
        $project = ProjectFactory::create();
        $notOwner = factory(User::class)->create();

        $assertInvitationForbidden = function () use ($project, $notOwner) {
            $this->actingAs($notOwner)
                ->post($project->path() . '/invitations')
                ->assertStatus(403);
        };

        $assertInvitationForbidden();

        $project->invite($notOwner);

        $assertInvitationForbidden();
    }
    
    public function test_project_owner_can_invite_a_user()
    {
        $project = ProjectFactory::create();

        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
        ]);

        $this->assertTrue($project->members->contains($userToInvite));
    }

    public function test_the_email_address_must_be_associated_with_a_valid_birdboard_account()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => 'notauser@example.com'
            ])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have a Birdboard account.'
            ], null, 'invitation');
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
