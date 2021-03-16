<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\DatabaseTestCase;

class ReplyTest extends DatabaseTestCase
{
    /** @test */
    function it_has_an_owner()
    {
        $reply = create('App\Models\Reply');

        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
