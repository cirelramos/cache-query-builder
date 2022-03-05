<?php

namespace CirelRamos\CacheQueryBuilder\Models;

use CirelRamos\CacheQueryBuilder\Repositories\JoinBuilder\CoreBuilder;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

/**
 *
 */
class CoreModel extends Model
{

    use PowerJoins;

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new CoreBuilder($query);
    }

}
