<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use App\Project;
use App\User;
use Illuminate\Support\Str;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_create_projects()
    {
        $attributes = factory(Project::class)->raw();

        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_projects()
    {
        $this->get('/projects')->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_a_single_project()
    {
        $project = factory(Project::class)->create();

        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        $this->get('/projects/create')->assertStatus(200);
        $response = $this->post('/projects', $attributes);
        $project = Project::where($attributes)->first();

        $this->get('/projects/create')->assertStatus(200);
        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $attributes = [
            'notes' => 'Updated notes'
        ];

        $this->patch($project->path(), $attributes)
            ->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $attributes);
        $this->get($project->path())->assertSee($attributes['notes']);

    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description, 100));
    }

    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->signIn();
        $project = factory(Project::class)->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_projects_of_others()
    {
        $this->signIn();
        $project = factory(Project::class)->create();

        $this->patch($project->path(), ['notes' => 'updated notes'])->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = factory(Project::class)->raw(['title' => '']);
        
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $attributes = factory(Project::class)->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    
}