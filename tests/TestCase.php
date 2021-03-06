<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn(\App\Models\User $user = null)
    {
        $user = $user ?: create('App\Models\User');

        $this->actingAs($user);

        return $this;
    }
}
