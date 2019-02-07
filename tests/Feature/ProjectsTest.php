<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_create_projects()
    {
        $attributes = factory('App\Project')->raw();

        $this->post('/projects', $attributes)->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $attributes = factory('App\Project')->raw(['owner_id' => $user->id]);

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_sees_message_if_no_projects()
    {
        $this->withoutExceptionHandling();

        $this->get('/projects')->assertSeeText('No projects');
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_title_must_be_longer_than_three_characters()
    {
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['title' => 'aa']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_project_description_must_be_longer_than_five_character()
    {
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['description' => 'some']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
