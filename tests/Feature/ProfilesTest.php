<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ProfilesTest extends DatabaseTestCase
{
    /** @test */
    function an_user_has_a_profile()
    {
        $user = create('App\Models\User');

        $this->get(route('profiles.show', $user->name))
            ->assertSee($user->name);
    }

    /** @test */
    function profiles_displays_all_threads_created_by_associated_user()
    {
        $user = create('App\Models\User');

        $thread = create('App\Models\Thread', ['user_id' => $user->id]);

        $this->get(route('profiles.show', $user->name))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
