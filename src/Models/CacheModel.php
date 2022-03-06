<?php

namespace Cirelramos\Cache\Models;

use Cirelramos\Cache\Repositories\JoinBuilder\CacheBuilder;
use Cirelramos\Cache\Traits\PurgeCacheBeforeActiveRecord;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

/**
 *
 */
class CacheModel extends Model
{
    use PurgeCacheBeforeActiveRecord;
    use PowerJoins;

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new CacheBuilder($query);
    }

}
