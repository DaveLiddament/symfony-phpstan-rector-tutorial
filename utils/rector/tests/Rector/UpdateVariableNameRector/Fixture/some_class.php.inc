<?php

namespace Rector\Tests\TypeDeclaration\Rector\UpdateVariableNameRector\Fixture;

$a = 123;
$name = 'dave';

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\UpdateVariableNameRector\Fixture;

$age = 123;
$name = 'dave';

?>
