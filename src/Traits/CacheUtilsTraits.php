<?php

namespace CirelRamos\CacheQueryBuilder\Traits;

use Illuminate\Support\Facades\Cache;

/**
 *
 */
trait CacheUtilsTraits
{
    /**
     * @param $tag
     */
    protected function forgetCacheByTag($tag): void
    {
        Cache::tags($tag)->flush();
    }
}
