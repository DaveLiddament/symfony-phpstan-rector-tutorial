<?php

namespace Rector\Tests\TypeDeclaration\Rector\UpdateDogMakeNoiseToBarkRector\Fixture;

use App\Rector\Exercise05\Dog;

function feed(Dog $dog): void
{
    $dog->feed();
}

?>