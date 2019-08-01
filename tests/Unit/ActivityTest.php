<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_user()
    {
        // $this->signIn();

        $project = factory(Project::class)->create();

        $this->assertInstanceOf(User::class, $project->activity->first()->user);
    }
}
