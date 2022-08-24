<?php

namespace Cirelramos\Cache\Services;


use Cirelramos\Cache\Models\ModelCacheConst;

/**
 *
 */
class DispatchJobService
{

    /**
     * @param $job
     * @param $queue
     * @param $mode
     * @return void
     */
    public static function execute($job, $queue): void
    {
        $typeJob = request()->header(ModelCacheConst::HEADER_MODE_JOB);
        switch ($typeJob) {
            case 'sync':
                dispatch_sync($job);
                break;
            default:
                dispatch($job)->onQueue($queue);
        }
    }
}
