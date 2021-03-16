<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ParticipateInForumTest extends DatabaseTestCase
{
    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->post(route('replies.store', ['channel', 'thread']), [])
            ->assertRedirect(route('login'));
    }

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = create('App\Models\User'));

        $thread = create('App\Models\Thread');
        $reply = make('App\Models\Reply');

        $this->post(route('replies.store', [$thread->channel, $thread]), $reply->toArray());

        $this->get(route('threads.show', [$thread->channel, $thread]))
            ->assertSee($reply->body);
    }

    /** @test */
    function a_reply_requires_a_body()
    {
        $this->signIn();

        $thread = create('App\Models\Thread');
        $reply = make('App\Models\Reply', ['body' => null]);

        $this->post(route('replies.store', [$thread->channel, $thread]), $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
