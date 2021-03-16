<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\DatabaseTestCase;

class ThreadTest extends DatabaseTestCase
{
    protected $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Models\Thread');
    }

    /** @test */
    function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    function a_thread_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    function a_thread_can_add_a_reply()
    {
        $reply = make('App\Models\Reply', ['thread_id' => $this->thread->id]);

        $this->thread->addReply($reply->toArray());

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    function a_thread_belongs_to_a_channel()
    {
        $this->withoutExceptionHandling();
        $thread = create('App\Models\Thread');

        $this->assertInstanceOf('App\Models\Channel', $thread->channel);
    }
}
