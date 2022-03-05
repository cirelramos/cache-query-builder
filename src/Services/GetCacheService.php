<?php

namespace Cirelramos\Cache\Services;

use Exception;
use Illuminate\Support\Facades\Cache;

/**
 * Class GetCacheService
 */
class GetCacheService
{

    /**
     * @param      $customKey
     * @param null $tag
     * @return array|mixed
     * @throws Exception
     */
    public static function execute($customKey, $tag = null)
    {
        $tag       = GetTagCacheService::execute(null, $tag);
        $customKey = GetKeyCacheBySystemService::execute($customKey);
        if (request()->header('force-not-cache') != null) {
            return null;
        }
        return Cache::tags($tag)
            ->get($customKey);
    }
}
