<?php

namespace Cirelramos\Cache\Repositories\UtilsBuilder;

use Cirelramos\Cache\Classes\ModelConst;
use Cirelramos\Cache\Repositories\JoinBuilder\CacheBuilder;
use Cirelramos\Cache\Services\GetTagCacheService;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Trait CacheQueryTrait
 * @package Cirelramos\Cache\Repositories\UtilsBuilder
 */
trait CacheQueryTrait
{
    /**
     * @param string[]    $columns
     * @param string|null $tag
     * @param int         $time
     * @return Collection
     * @throws \Exception
     */
    public function getFromCache(
        array $columns = [ '*' ],
        $tag = null,
        int $time = null
    ): Collection {
        /** @var CacheBuilder $this */
        $query     = $this;
        $tag       = $this->setTag($query, $tag);
        $nameCache = $this->generateNameCache($query, $columns);
        [
            $data,
            $dataIsFromCache,
        ] = $this->getDataFromCacheOrDatabase($query, $columns, $nameCache, $tag);
        $this->setCache($nameCache, $data, $time, $dataIsFromCache, $tag);

        return $data;

    }

    /**
     * @param $query
     * @param $tag
     * @return array
     * @throws \Exception
     */
    public function setTag($query, $tag = null): array
    {
        return GetTagCacheService::execute($query, $tag);
    }

    /**
     * @param string[] $columns
     * @param null     $tag
     * @param null     $time
     * @return Model|null
     * @throws \Exception
     */
    public function firstFromCache(
        array $columns = [ '*' ],
        $tag = null,
        int $time = null
    ): ?Model {
        /** @var CacheBuilder $this */
        $query     = $this;
        $tag       = $this->setTag($query, $tag);
        $nameCache = $this->generateNameCache($query, $columns);
        [
            $data,
            $dataIsFromCache,
        ] = $this->firstDataFromCacheOrDatabase($query, $columns, $nameCache, $tag);
        $this->setCache($nameCache, $data, $time, $dataIsFromCache, $tag);

        return $data === '' ? null : $data;
    }

    /**
     * @param CacheBuilder $query
     * @param             $columns
     * @param             $extras
     * @return string
     */
    public function generateNameCache(CacheBuilder $query, $columns, $extras = ''): string
    {
        $querySql = $query->toSql();
        if (is_array($columns)) {
            $columns = array_values($columns);
            $columns = json_encode($columns);
        }

        $relationShip = array_keys($query->getEagerLoads());
        $queryRelationsShip = GetQueryRelationShip::execute($query, $relationShip);
        $relationShip = json_encode($relationShip);
        $parameters   = json_encode($query->getBindings());
        $nameCache    = $querySql;
        $nameCache    .= $parameters;
        $nameCache    .= $relationShip;
        $nameCache    .= $columns;
        $nameCache    .= $queryRelationsShip;

        $charactersToRemove = [
            ' ',
            '?',
            '`',
            ',',
            '"',
            '*',
            '.',
            '[',
            ']',
            '(',
            ')',
        ];

        $nameCache .= '-' . $extras;
        $nameCache = str_replace($charactersToRemove, '', $nameCache);
        $nameCache = md5($nameCache);
        return $nameCache;

    }

    /**
     * @param CacheBuilder $query
     * @param             $columns
     * @param             $nameCache
     * @param array        $tag
     * @return array
     */
    public function firstDataFromCacheOrDatabase(
        CacheBuilder $query,
                     $columns,
                     $nameCache,
        array        $tag
    ): array {
        $dataIsFromCache = true;
        $dataFromCache   = $this->getCache($nameCache, $tag);
        if (request()->force_not_cache != null || request()->header('force-not-cache')!=
            null) {
            $dataFromCache = null;
        }

        if ($dataFromCache !== null) {
            return [ $dataFromCache, $dataIsFromCache ];
        }

        $dataIsFromCache  = false;
        $dataFromDatabase = $query->first($columns);
        $dataFromDatabase = $dataFromDatabase === null ? '' : $dataFromDatabase;
        return [ $dataFromDatabase, $dataIsFromCache ];
    }

    /**
     * @param CacheBuilder $query
     * @param             $columns
     * @param             $nameCache
     * @param array        $tag
     * @return array
     */
    public function getDataFromCacheOrDatabase(
        CacheBuilder $query,
                     $columns,
                     $nameCache,
        array        $tag
    ): array {
        $dataIsFromCache = true;
        $dataFromCache   = $this->getCache($nameCache, $tag);
        if (request()->force_not_cache != null || request()->header('force-not-cache') !=
            null) {
            $dataFromCache = null;
        }

        if ($dataFromCache !== null) {
            return [ $dataFromCache, $dataIsFromCache ];
        }

        $dataIsFromCache  = false;
        $dataFromDatabase = $query->get($columns);
        return [ $dataFromDatabase, $dataIsFromCache ];
    }

    /**
     * @param       $nameCache
     * @param array $tag
     * @return mixed
     */
    public function getCache($nameCache, array $tag): mixed
    {
        return Cache::tags($tag)->get($nameCache);
    }

    /**
     * @param       $nameCache
     * @param       $data
     * @param       $time
     * @param       $dataIsFromCache
     * @param array $tag
     * @return void
     */
    public function setCache(
        $nameCache,
        $data,
        $time,
        $dataIsFromCache,
        array $tag
    ): void {
        if ($dataIsFromCache === false) {
            if ($time === null) {
                $time = $this->getModelTimeConstant($this);
            }
            Cache::tags($tag)->put($nameCache, $data, $time);
        }
    }

    /**
     * @param $itemThis
     * @return Repository|Application|mixed
     */
    private function getModelTimeConstant($itemThis): mixed
    {
        $model = $itemThis->getModel();
        $time = ModelConst::CACHE_TIME_FIVE_MINUTES;

        if (defined($model->getMorphClass()."::TIME_CACHE_MODEL")) {
                $time = $model::TIME_CACHE_MODEL;
        }

        return $time;
    }
}
