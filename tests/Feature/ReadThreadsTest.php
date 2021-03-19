<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ReadThreadsTest extends DatabaseTestCase
{
    protected $thread;

    protected function setUp() : void
    {
        parent::setUp();

        $this->thread = create('App\Models\Thread');
    }

    /** @test */
    function an_user_can_view_all_threads()
    {
        $this->get(route('threads.index'))
            ->assertSee($this->thread->title);
    }

    /** @test */
    function an_user_can_view_a_single_thread()
    {
        $this->get(route('threads.show', [$this->thread->channel, $this->thread]))
            ->assertSee($this->thread->title);
    }

    /** @test */
    function an_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = create('App\Models\Reply', ['thread_id' => $this->thread->id]);

        $this->get(route('threads.show', [$this->thread->channel, $this->thread]))
            ->assertSee($reply->body);
    }

    /** @test */
    function an_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Models\Channel');

        $threadInChannel = create('App\Models\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Models\Thread');

        $this->get(route('channels.index', [$channel]))
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    function an_user_can_filter_threads_by_any_username(){
        $userName = 'JohnDoe';

        $this->signIn(create('App\Models\User', ['name' => $userName]));

        $threadByJohn = create('App\Models\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Models\Thread');

        $this->get('threads/?by=' . $userName)
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }
}
