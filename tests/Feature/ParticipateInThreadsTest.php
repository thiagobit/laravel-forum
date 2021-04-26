<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ParticipateInThreadsTest extends DatabaseTestCase
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

    /** @test */
    public function unauthorized_users_cannot_delete_replies()
    {
        $reply = create('App\Models\Reply');

        $this->delete(route('replies.destroy', $reply))
            ->assertRedirect('login');

        $this->signIn()
            ->delete(route('replies.destroy', $reply))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Models\Reply', ['user_id' => auth()->id()]);

        $this->delete(route('replies.destroy', $reply));

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function unauthorized_users_cannot_update_replies()
    {
        $reply = create('App\Models\Reply');

        $this->patch(route('replies.update', $reply))
            ->assertRedirect('login');

        $this->signIn()
            ->patch(route('replies.update', $reply))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create('App\Models\Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'You benn changed, fool.';
        $response = $this->patch(route('replies.update', $reply), ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }
}
