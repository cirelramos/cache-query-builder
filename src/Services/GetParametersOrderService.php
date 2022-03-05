<?php

namespace Cirelramos\Cache\Services;

use Cirelramos\Cache\Repositories\JoinBuilder\CacheBuilder;

/**
 *
 */
class GetParametersOrderService
{

    /**
     * @param null $directionParameter
     * @param null $columnParameter
     * @return array
     */
    public static function execute(
        $query,
                     $directionParameter = null,
                     $columnParameter = null,
                     $customAcceptColumns = [],
    ): array {
        $orderByRequest = request()->direction_order_by;
        $direction      = $orderByRequest ?? $directionParameter;

        $columnOrderRequest = request()->column_order_by;
        $column             = $columnOrderRequest ?? $columnParameter;

        $validColumns   = $query->getModel()
            ->getFillable();
        $validColumns[] = $query->getModel()
            ->getKeyName();
        $validColumns[] = $query->getModel()
            ->getCreatedAtColumn();
        $validColumns   = array_merge($validColumns, $customAcceptColumns);

        if (array_search($column, $validColumns) === false) {
            if (array_search($columnParameter, $validColumns) === false) {
                return [ null, null ];
            }
        }

        $validDirections = [ 'asc', 'desc' ];
        if (array_search($direction, $validDirections) === false) {
            return [ null, null ];
        }

        return [ $direction, $column ];
    }

}
