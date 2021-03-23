<?php

namespace Tests\Unit;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Models\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Models\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('App\Models\Reply');

        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        // given we have a thread
        create('App\Models\Thread', ['user_id' => auth()->id()], 2);

        // and another thread from a week ago
        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        // when we fetch their feed
        $feed = Activity::feed(auth()->user());

        // then, it should be returned in the proper format
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
    }
}
