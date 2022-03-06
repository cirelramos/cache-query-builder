<?php

namespace Cirelramos\Cache\Traits;

use Cirelramos\Cache\Services\GetTagCacheService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
trait PurgeCacheBeforeActiveRecord
{
    /**
     * @param array $options
     * @param       $tag
     * @return bool
     * @throws Exception
     */
    public function saveWithCache(array $options = [], $tag = [])
    {
        /** @var Model $this */
        $query = $this->newModelQuery();
        $tag   = GetTagCacheService::execute($query, $tag);
        Cache::tags($tag)->flush();

        return $this->save();
    }

    /**
     * @param array $values
     * @param       $tag
     * @return mixed
     * @throws Exception
     */
    public function insertWithCache(array $values = [], $tag = [])
    {
        /** @var Model $this */
        $query = $this->newModelQuery();
        $tag   = GetTagCacheService::execute($this, $tag);
        Cache::tags($tag)->flush();

       return $query->insert($values);
    }

    /**
     * @param array $options
     * @param       $tag
     * @return bool
     * @throws Exception
     */
    public function deleteWithCache(array $options = [], $tag = [])
    {
        /** @var Model $this */
        $query = $this->newModelQuery();
        $tag   = GetTagCacheService::execute($query, $tag);
        Cache::tags($tag)->flush();

        return $this->save();
    }
}
