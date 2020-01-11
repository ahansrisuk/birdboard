<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use App\Project;

class ProjectTasksTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_tasks()
    {
        $this->signIn();
        $project = ProjectFactory::withTasks(1)->create();
        $task = $project->tasks[0];

        $this->patch($task->path(), ['body' => 'updated task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'updated task']);
    }

    /** @test */
    public function a_project_can_have_tasks()
    { 
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        // This functionality is made possible by Facade (see imports)
        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)
            ->create();

        $this->patch($project->tasks[0]->path(), [
            'body' => 'updated task',
            'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'updated task',
            'completed' => true
            ]);
    }

    /** @ test */
    public function a_task_requires_a_body()
    {
        $this->signIn();
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');

    }
}
