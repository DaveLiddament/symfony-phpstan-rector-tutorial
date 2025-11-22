<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src/Rector/Exercise03',
    ])
    ->withRules(
        [
            \Utils\Rector\Rector\UpdateSayHelloToGreetRector::class,
            \Utils\Rector\Rector\UpdateVariableNameRector::class,
        ]
    );