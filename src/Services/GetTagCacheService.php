<?php

namespace Cirelramos\Cache\Services;

use Cirelramos\Cache\Repositories\JoinBuilder\CacheBuilder;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GetTagCacheService
 * @package Cirelramos\Cache\Services
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
        $model      = ( $query instanceof Builder ) ? $query->getModel() :
            null;
        $tag        = $tag ?? [];
        $tagDefault = config('cache-query.cache_tag_name');
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
