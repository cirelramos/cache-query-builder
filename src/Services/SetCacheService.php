<?php

namespace Cirelramos\Cache\Services;

use Cirelramos\Cache\Classes\CacheConst;
use Exception;
use Illuminate\Support\Facades\Cache;

/**
 * Class SetCacheService
 */
class SetCacheService
{

    /**
     * @param       $customKey
     * @param array $data
     * @param null  $tag
     * @param int   $time
     * @throws Exception
     */
    public static function execute($customKey, $data = [], $tag = null, $time = 0, $disabled = false): void
    {
        $time      = $time === 0 ? CacheConst::CACHE_TIME_DAY : $time;
        $tag       = GetTagCacheService::execute(null, $tag);
        $customKey = GetKeyCacheBySystemService::execute($customKey, $disabled);
        Cache::tags($tag)
            ->put($customKey, $data, $time);
    }
}
