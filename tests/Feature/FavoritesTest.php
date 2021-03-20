<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class FavoritesTest extends DatabaseTestCase
{
    /** @test */
    function guests_can_not_favorite_anything()
    {
        $reply = create('App\Models\Reply');

        $this->post(route('replies.favorites', $reply))
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create('App\Models\Reply');

        $this->post(route('replies.favorites', $reply));

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = create('App\Models\Reply');

        $this->post(route('replies.favorites', $reply));
        $this->post(route('replies.favorites', $reply));

        $this->assertCount(1, $reply->favorites);
    }
}
