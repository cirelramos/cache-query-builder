<?php

namespace Cirelramos\Cache\Repositories\JoinBuilder;

use Cirelramos\Cache\Traits\CachePaginateQueryTrait;
use Cirelramos\Cache\Traits\CacheQueryTrait;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
class CacheBuilder extends Builder
{
    use CacheQueryTrait;
    use CachePaginateQueryTrait;

}
