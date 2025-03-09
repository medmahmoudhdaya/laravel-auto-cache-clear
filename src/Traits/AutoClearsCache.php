<?php

namespace Zidbih\LaravelAutoCacheClear\Traits;

use Zidbih\LaravelAutoCacheClear\Attributes\ClearCacheWhen;
use Zidbih\LaravelAutoCacheClear\Observers\CacheClearingObserver;
use ReflectionClass;

trait AutoClearsCache
{
    protected static function bootAutoClearsCache()
    {
        $reflection = new ReflectionClass(static::class);
        $attributes = $reflection->getAttributes(ClearCacheWhen::class);

        if (!empty($attributes)) {
            static::observe(CacheClearingObserver::class);
        }
    }
}