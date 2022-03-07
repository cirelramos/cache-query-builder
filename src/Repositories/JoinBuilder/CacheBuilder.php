<?php

namespace Cirelramos\Cache\Repositories\JoinBuilder;

use Cirelramos\Cache\Traits\CacheOrderQueryTrait;
use Cirelramos\Cache\Traits\CachePaginateQueryTrait;
use Cirelramos\Cache\Traits\CacheQueryTrait;
use Cirelramos\Cache\Traits\PurgeCacheBeforeActiveRecord;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
class CacheBuilder extends Builder
{
    use CacheQueryTrait;
    use CachePaginateQueryTrait;
    use CacheOrderQueryTrait;
    use PurgeCacheBeforeActiveRecord;
}
