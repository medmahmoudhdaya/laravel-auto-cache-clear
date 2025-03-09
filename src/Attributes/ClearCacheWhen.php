<?php

namespace Zidbih\LaravelAutoCacheClear\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ClearCacheWhen
{
    public function __construct(
        public array $events,
        public string $cacheKey = '{model}:{id}',
        public array $staticKeys=[],
    ) {}
}