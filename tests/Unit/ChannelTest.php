<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    Use DatabaseMigrations;

    /** @test */
    function a_channel_consists_of_threads()
    {
        $channel = create('App\Models\Channel');
        $thread = create('App\Models\Thread', ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));

        //$this->assert
    }
}
