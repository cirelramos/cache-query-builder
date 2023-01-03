<?php

namespace Cirelramos\Cache\Services;


use Cirelramos\Cache\Models\ModelCacheConst;

/**
 *
 */
class SetHeaderSwitchActiveRecordAndModeJobService
{

    public static function execute($modeRecord, $typeJob): void
    {
        if (empty($modeRecord) === false && $modeRecord !== ModelCacheConst::ENABLE_ACTIVE_RECORD) {
            request()->headers->set(ModelCacheConst::HEADER_ACTIVE_RECORD, ModelCacheConst::DISABLE_ACTIVE_RECORD);
        }

        request()->headers->set(ModelCacheConst::HEADER_MODE_JOB, $typeJob);
    }
}
