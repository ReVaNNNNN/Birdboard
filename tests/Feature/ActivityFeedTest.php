<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_project_generates_activity()
    {
        $project = ProjectFactory::create(); // 5:30

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    public function test_updating_a_project_generates_activity()
    {
        $project = ProjectFactory::create(); // 5:30

        $project->update([
            'title' => 'Changed'
        ]);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity[1]->description);
    }
}
