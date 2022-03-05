<?php

namespace Cirelramos\Cache\Repositories\JoinBuilder;

use Cirelramos\Cache\Classes\CacheConst;
use Cirelramos\Cache\Traits\CacheQueryTrait;
use Cirelramos\Cache\Services\GetParametersOrderService;
use Cirelramos\Cache\Services\GetParametersPaginationService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class CacheBuilder extends Builder
{
    use CacheQueryTrait;

    /**
     * @param $direction
     * @param $column
     * @return $this
     */
    public function orderByRequest(
        $direction = null,
        $column = null,
        $customAcceptColumns = [],
    ): CacheBuilder {
        [ $direction, $column ] = GetParametersOrderService::execute(
            $this,
            $direction,
            $column,
            $customAcceptColumns
        );
        if ($column === null || $direction === null) {
            return $this;
        }
        return $this->orderBy($column, $direction);
    }

    /**
     * @param int $perPage
     * @param string[] $columns
     * @param string $pageName
     * @param null $page
     * @return LengthAwarePaginator
     */
    public function paginateByRequest(
        $columns = [ '*' ],
        $perPage = CacheConst::PER_PAGE,
        $pageName = 'page',
        $page = null
    ): LengthAwarePaginator {

        [$perPage, $page] = GetParametersPaginationService::execute( $page, $perPage);
        return $this->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * @param array    $columns
     * @param          $tag
     * @param int|null $time
     * @param          $perPage
     * @param          $pageName
     * @param          $page
     * @return LengthAwarePaginator
     */
    public function paginateFromCacheByRequest(
        array $columns = [ '*' ],
        $tag = null,
        int $time = null,
        $perPage = CacheConst::PER_PAGE,
        $pageName = 'page',
        $page = null
    ): LengthAwarePaginator {
        $query     = $this;
        [$perPage, $page] = GetParametersPaginationService::execute( $page, $perPage);
        $extras=$perPage.'-'.$page;
        $nameCache = $this->generateNameCache($query, $columns,$extras);
        if ($time === null) {
            $time = config('cache-query.cache_default_time_seconds');
        }

        if (request()->header('force-not-cache') != null) {
            return $this->paginateByRequest($columns, $perPage, $pageName, $page);
        }

        return Cache::tags($tag)->remember(
            $nameCache, $time, function () use ($page, $pageName, $columns, $perPage) {
            return $this->paginateByRequest($columns,$perPage,  $pageName, $page);
        }
        );
    }
}
