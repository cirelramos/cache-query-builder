<?php

namespace CirelRamos\CacheQueryBuilder\Repositories\JoinBuilder;

use CirelRamos\CacheQueryBuilder\Classes\ModelConst;
use CirelRamos\CacheQueryBuilder\Repositories\UtilsBuilder\CacheQueryTrait;
use CirelRamos\CacheQueryBuilder\Services\GetParametersOrderService;
use CirelRamos\CacheQueryBuilder\Services\GetParametersPaginationService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class CoreBuilder extends Builder
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
    ): CoreBuilder {
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
        $perPage = ModelConst::PER_PAGE,
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
        $perPage = ModelConst::PER_PAGE,
        $pageName = 'page',
        $page = null
    ): LengthAwarePaginator {
        $query     = $this;
        [$perPage, $page] = GetParametersPaginationService::execute( $page, $perPage);
        $extras=$perPage.'-'.$page;
        $nameCache = $this->generateNameCache($query, $columns,$extras);
        if ($time === null) {
            $time = ModelConst::CACHE_TIME_FIVE_MINUTES;
        }

        if (request()->force_not_cache != null || request()->header('force-not-cache') !=
            null) {
            return $this->paginateByRequest($columns, $perPage, $pageName, $page);
        }

        return Cache::tags($tag)->remember(
            $nameCache, $time, function () use ($page, $pageName, $columns, $perPage) {
            return $this->paginateByRequest($columns,$perPage,  $pageName, $page);
        }
        );
    }
}
