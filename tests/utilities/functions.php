<?php

function create($class, $attributes = [])
{
    return $class::factory()->create($attributes);
}

function make($class, $attributes = [])
{
    return $class::factory()->make($attributes);
}

function raw($class, $attributes = [])
{
    return $class::factory()->raw($attributes);
}
