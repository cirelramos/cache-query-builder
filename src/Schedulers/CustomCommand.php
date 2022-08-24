<?php

namespace Cirelramos\Cache\Schedulers;

use Cirelramos\Cache\Models\ModelCacheConst;
use Illuminate\Console\Command;

/**
 *
 */
class CustomCommand extends Command
{

    /**
     * @param $job
     * @return void
     */
    public function dispatchJob($job, $queue): void
    {
        $typeJob = $this->argument('type_job');

        $this->disableActiveRecord();
        switch ($typeJob) {
            case 'sync':
                dispatch_sync($job);
                request()->headers->set(ModelCacheConst::HEADER_MODE_JOB, 'sync');
                break;
            default:
                dispatch($job)->onQueue($queue);
        }


    }

    public function disableActiveRecord(): void
    {
        $enableActiveRecord = $this->argument('active_record');
        if (empty($enableActiveRecord) === false && $enableActiveRecord !== ModelCacheConst::ENABLE_ACTIVE_RECORD) {
            request()->headers->set(ModelCacheConst::HEADER_ACTIVE_RECORD, ModelCacheConst::DISABLE_ACTIVE_RECORD);
        }
    }
}
