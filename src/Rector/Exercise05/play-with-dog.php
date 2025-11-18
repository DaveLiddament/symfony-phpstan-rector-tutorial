<?php

use App\Rector\Exercise05\Dog;

function play(Dog $dog): void
{
    $dog->makeNoise();
}