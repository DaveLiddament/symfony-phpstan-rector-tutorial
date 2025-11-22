<?php

namespace App\Phpstan;

use http\Env\Response;

/**
 * Pretend version of Symfony's Route annotation'
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(
        public string $path,
        public string|null $name = null,
    ){
    }
}