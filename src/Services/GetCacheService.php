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
        $headerName = config('cache-query.header_force_not_cache_name');
        $headerName = empty($headerName) ?  'force-not-cache' : $headerName;
        if (request()->header($headerName) != null) {
            return null;
        }
        return Cache::tags($tag)
            ->get($customKey);
    }
}
