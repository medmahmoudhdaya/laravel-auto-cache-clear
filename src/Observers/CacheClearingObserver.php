<?php

namespace Zidbih\LaravelAutoCacheClear\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Zidbih\LaravelAutoCacheClear\Attributes\ClearCacheWhen;

class CacheClearingObserver
{
    public function created(Model $model)
    {
        $this->clearCacheForEvent($model, 'created');
    }

    public function updated(Model $model)
    {
        $this->clearCacheForEvent($model, 'updated');
    }

    public function deleted(Model $model)
    {
        $this->clearCacheForEvent($model, 'deleted');
    }

    public function restored(Model $model)
    {
        $this->clearCacheForEvent($model, 'restored');
    }

    public function forceDeleted(Model $model)
    {
        $this->clearCacheForEvent($model, 'forceDeleted');
    }

    protected function clearCacheForEvent(Model $model, string $event)
    {
        $reflection = new \ReflectionClass($model);
        $attributes = $reflection->getAttributes(ClearCacheWhen::class);

        foreach ($attributes as $attribute) {
            $config = $attribute->newInstance();

            if (in_array($event, $config->events)) {
                $cacheKey = str_replace(
                    ['{model}', '{id}'],
                    [get_class($model), $model->getKey()],
                    $config->cacheKey
                );

                Cache::forget($cacheKey);

                // Clear static cache keys
                foreach ($config->staticKeys as $staticKey) {
                    Cache::forget($staticKey);
                }
            }
        }
    }
}