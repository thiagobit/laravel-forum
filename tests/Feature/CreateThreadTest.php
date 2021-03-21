<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\DatabaseTestCase;

class CreateThreadTest extends DatabaseTestCase
{
    /** @test */
    function guest_may_not_create_threads()
    {
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));

        $this->post(route('threads.store'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = make('App\Models\Thread');

        $response = $this->post(route('threads.store'), $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        create('App\Models\Channel');

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    function guests_cannot_delete_threads()
    {
        $thread = create('App\Models\Thread');

        $this->delete(route('threads.destroy', [$thread->channel, $thread]))
            ->assertRedirect('/login');
    }

    /** @test */
    function a_thread_can_be_deleted()
    {
        $user = create('App\Models\User');

        $this->signIn($user);

        $thread = create('App\Models\Thread', ['user_id' => $user->id]);

        //$this->delete(route('threads.destroy', [$thread->channel, $thread]))
        $this->json('DELETE', route('threads.destroy', [$thread->channel, $thread]))
            ->assertSuccessful();

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);

        $this->get(route('threads.show', [$thread->channel, $thread]))
            ->assertNotFound();

        $this->get(route('threads.index', $thread))
            ->assertDontSee($thread->title);

        $this->get(route('profiles.show', $user))
            ->assertDontSee($thread->title);
    }

//    /** @test */
//    function thread_con_only_be_deleted_by_those_who_have_permission()
//    {
//
//    }

    private function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Models\Thread', $overrides);

        return $this->post(route('threads.store'), $thread->toArray());
    }
}
