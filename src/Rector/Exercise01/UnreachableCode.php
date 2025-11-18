<?php

namespace App\Rector\Exercise01;

class UnreachableCode
{
    public function getAge(): int
    {
        return 21;

        echo "We can not reach this code";
    }
}