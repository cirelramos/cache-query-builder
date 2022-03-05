<?php

namespace CirelRamos\CacheQueryBuilder\Services;

use CirelRamos\CacheQueryBuilder\Classes\ModelConst;
use CirelRamos\CacheQueryBuilder\Repositories\JoinBuilder\CoreBuilder;
use Exception;

/**
 * Class GetTagCacheService
 * @package CirelRamos\CacheQueryBuilder\Services
 */
class GetTagCacheService
{

    /**
     * @param $query
     * @param $tag
     * @return array
     * @throws Exception
     */
    public static function execute($query = null, $tag = null): array
    {
        $model      = ( $query instanceof CoreBuilder ) ? $query->getModel() : null;
        $tag        = $tag ?? [];
        $tagDefault = ModelConst::CACHE_TAG_NAME;
        $arrayTags = [ $tagDefault ];

        if (is_string($tag)) {
            $arrayTags[] = $tag;
        }
        if (is_array($tag)) {
            $arrayTags = array_merge($arrayTags, $tag);
        }

        if ($model !== null && defined($model->getMorphClass() . "::TAG_CACHE_MODEL")) {
            if (is_string($model::TAG_CACHE_MODEL)) {
                $arrayTags[] = $model::TAG_CACHE_MODEL;
            }
            if (is_array($model::TAG_CACHE_MODEL)) {
                $arrayTags = array_merge($arrayTags, $model::TAG_CACHE_MODEL);
            }
        }

        if (is_array($arrayTags)) {
            $arrayTags = array_unique($arrayTags);
        }

        return $arrayTags;
    }

}
