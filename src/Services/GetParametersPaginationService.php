<?php

namespace CirelRamos\CacheQueryBuilder\Services;

use CirelRamos\CacheQueryBuilder\Classes\ModelConst;

/**
 * Class GetParametersPaginationService
 * @package CirelRamos\CacheQueryBuilder\Services
 */
class GetParametersPaginationService
{

    /**
     * @param int $perPage
     * @param     $page
     * @return array
     */
    public static function execute($page = ModelConst::PAGE, $perPage = ModelConst::PER_PAGE): array
    {
        $sizeRequest = request()->size_pagination;
        $perPage     = $sizeRequest === null ? $perPage : $sizeRequest;

        $pageRequest = request()->page_pagination;
        $page        = $pageRequest === null ? $page : $pageRequest;

        return [ $perPage, $page ];
    }

}
