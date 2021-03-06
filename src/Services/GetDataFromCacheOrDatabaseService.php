<?php

namespace Cirelramos\Cache\Services;

use Cirelramos\Cache\Repositories\JoinBuilder\CacheBuilder;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class GetDataFromCacheOrDatabaseService
{
    /**
     * @param CacheBuilder $query
     * @param              $columns
     * @param              $nameCache
     * @param array        $tag
     * @return array
     */
    public static function execute(
        $query,
        $columns,
        $nameCache,
        array $tag
    ): array {
        $dataIsFromCache = true;
        $dataFromCache   = Cache::tags($tag)
            ->get($nameCache);
        if (request()->header('force-not-cache') != null) {
            $dataFromCache = null;
        }

        if ($dataFromCache !== null) {
            return [ $dataFromCache, $dataIsFromCache ];
        }

        $dataIsFromCache  = false;
        $dataFromDatabase = $query->get($columns);

        return [ $dataFromDatabase, $dataIsFromCache ];
    }
}
