<?php

namespace Cirelramos\Cache\Traits;

use Cirelramos\Cache\Services\GetTagCacheService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
trait PurgeCacheBeforeActiveRecordTrait
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

        try {
            return $this->save();
        } catch (Exception $exception) {
            if ($exception->getMessage() !== "disable query") {
                throw new Exception($exception->getMessage(), previous: $exception);
            }
        }
    }

    /**
     * @param array $attributes
     * @param array $options
     * @param array $tag
     * @return bool
     * @throws Exception
     */
    public function updateWithCache(array $attributes = [], array $options = [], $tag = [])
    {
        /** @var Model $this */
        $query = $this->getModel();
        $tag   = GetTagCacheService::execute($query, $tag);
        Cache::tags($tag)->flush();

        try {
            return $this->update($attributes, $options);
        } catch (Exception $exception) {
            if ($exception->getMessage() !== "disable query") {
                throw new Exception($exception->getMessage(), previous: $exception);
            }
        }
    }

    /**
     * @param array $options
     * @param       $tag
     * @return bool
     * @throws Exception
     */
    public function deleteWithCache($tag = [])
    {
        /** @var Model $this */
        $query = $this->getModel();
        $tag   = GetTagCacheService::execute($query, $tag);
        Cache::tags($tag)->flush();

        try {
            return $this->delete();
        } catch (Exception $exception) {
            if ($exception->getMessage() !== "disable query") {
                throw new Exception($exception->getMessage(), previous: $exception);
            }
        }
    }

    public function forceDeleteWithCache($tag = [])
    {
        /** @var Model $this */
        $query = $this->getModel();
        $tag   = GetTagCacheService::execute($query, $tag);
        Cache::tags($tag)->flush();

        try {
            return $this->forceDelete();
        } catch (Exception $exception) {
            if ($exception->getMessage() !== "disable query") {
                throw new Exception($exception->getMessage(), previous: $exception);
            }
        }
    }

    /**
     * @param array $values
     * @param       $tag
     * @return mixed
     * @throws Exception
     */
    public static function insertWithCache(array $values = [], $tag = [])
    {
        /** @var Model $this */
        $model = self::query()->getModel();
        $tag   = GetTagCacheService::execute($model, $tag);
        Cache::tags($tag)->flush();

        try {
            return self::insert($values);
        } catch (Exception $exception) {
            if ($exception->getMessage() !== "disable query") {
                throw new Exception($exception->getMessage(), previous: $exception);
            }
        }
    }

}
