<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Project;
use App\User;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = factory(Project::class)->create();
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $user = factory(User::class)->create();
        $attributes = factory(Project::class)->raw();
        $project = $user->projects()->create($attributes);

        $this->assertEquals($user->id, $project->owner->id);
    }

    /** @ test */
    public function it_can_add_a_task()
    {
        $project = factory(Project::class)->create();
        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }
}
