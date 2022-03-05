<?php

namespace Cirelramos\Cache\Services;

use Cirelramos\Cache\Repositories\JoinBuilder\CacheBuilder;

/**
 *
 */
class GenerateNameCacheService
{
    /**
     * @param CacheBuilder $query
     * @param              $columns
     * @param              $extras
     * @return string
     */
    public static function execute($query, $columns, $extras = ''): string
    {
        $querySql = $query->toSql();
        if (is_array($columns)) {
            $columns = array_values($columns);
            $columns = json_encode($columns);
        }

        $relationShip       = array_keys($query->getEagerLoads());
        $queryRelationsShip = GetQueryRelationShipService::execute($query, $relationShip);
        $relationShip       = json_encode($relationShip);
        $parameters         = json_encode($query->getBindings());
        $nameCache          = $querySql;
        $nameCache          .= $parameters;
        $nameCache          .= $relationShip;
        $nameCache          .= $columns;
        $nameCache          .= $queryRelationsShip;

        $charactersToRemove = [
            ' ',
            '?',
            '`',
            ',',
            '"',
            '*',
            '.',
            '[',
            ']',
            '(',
            ')',
        ];

        $nameCache .= '-' . $extras;
        $nameCache = str_replace($charactersToRemove, '', $nameCache);
        $nameCache = md5($nameCache);

        return $nameCache;

    }
}
