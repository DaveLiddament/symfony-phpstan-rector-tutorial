<?php

namespace App\Rector\Exercise05;


function lookupName(LookupService $lookupService): mixed
{
    return $lookupService->lookup('name');
}