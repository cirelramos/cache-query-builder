<?php

namespace Cirelramos\Cache\Services;

/**
 *
 */
class GetTimeFromModelService
{
    public static function execute($itemThis)
    {

        $model = $itemThis->getModel();
        $time = config('cache-query.cache_default_time_seconds');

        if (defined($model->getMorphClass()."::TIME_CACHE_MODEL")) {
            $time = $model::TIME_CACHE_MODEL;
        }

        return $time;
    }
}
