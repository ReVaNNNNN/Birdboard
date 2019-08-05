<?php

namespace Tests\Unit;


use App\User;
use Illuminate\Database\Eloquent\Collection;
use phpDocumentor\Reflection\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_projects()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    public function test_user_has_accessible_projects()
    {
        $john = $this->sigIn();

        $project = ProjectFactory::ownedBy($john)->create();

        $this->assertCount(1, $john->accessibleProjects());

        $sally = factory(User::class)->create();

        ProjectFactory::ownedBy($sally)->create()->invite($john);

        $this->assertCount(2, $john->accessibleProjects());
    }
}
