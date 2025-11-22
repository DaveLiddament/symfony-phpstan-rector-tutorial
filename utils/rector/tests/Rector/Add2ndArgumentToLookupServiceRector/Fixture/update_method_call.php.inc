<?php

namespace Rector\Tests\TypeDeclaration\Rector\Add2ndParameterToLookupServiceRector\Fixture;

use App\Rector\Exercise05\LookupService;

function lookup(LookupService $lookupService, AnotherService $anotherService): void
{
    $lookupService->lookup('name');
    $lookupService->foo('name');
    $anotherService->lookup('name');
    $lookupService->lookup( 'name', 'bar');
    $lookupService->lookup();
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\Add2ndParameterToLookupServiceRector\Fixture;

use App\Rector\Exercise05\LookupService;

function lookup(LookupService $lookupService, AnotherService $anotherService): void
{
    $lookupService->lookup('name', null);
    $lookupService->foo('name');
    $anotherService->lookup('name');
    $lookupService->lookup( 'name', 'bar');
    $lookupService->lookup();
}

?>
