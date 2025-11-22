<?php

namespace Rector\Tests\TypeDeclaration\Rector\UpdateDogMakeNoiseToBarkRector\Fixture;

use App\Rector\Exercise05\Cat;

function play(Cat $cat): void
{
    $cat->makeNoise();
}

?>