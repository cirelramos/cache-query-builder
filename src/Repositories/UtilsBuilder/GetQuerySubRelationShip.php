<?php

namespace Cirelramos\Cache\Repositories\UtilsBuilder;

/**
 * Class GetQuerySubRelationShip
 * @package Cirelramos\Cache\Repositories\UtilsBuilder
 */
class GetQuerySubRelationShip
{
    /**
     * @param       $query
     * @param array $relationsShip
     * @return string
     */
    public static function execute($query, array $relationsShip): string
    {
        $collectionRelationsShip = collect($relationsShip);
        $actuallyRelationShip    = [];
        $collectionRelationsShip = $collectionRelationsShip->map(
            self::mapReplaceGetRelationQueryAndParameter(
                $query, $actuallyRelationShip
            )
        );

        return $collectionRelationsShip->toJson();
    }

    /**
     * @param $query
     * @param $actuallyRelationShip
     * @return callable
     */
    private static function mapReplaceGetRelationQueryAndParameter($query, &$actuallyRelationShip): callable
    {
        return static function ($relationShip, $key) use (&$actuallyRelationShip, $query) {
            // set variable persistent query from relation
            if ($actuallyRelationShip !== []) {
                $query = $actuallyRelationShip->getQuery();
            }

            $queryRelationsShip = $query->getRelation($relationShip);
            $querySql           = $queryRelationsShip->toSql();
            $parameters         = json_encode($queryRelationsShip->getBindings());
            $actuallyRelationShip = $queryRelationsShip;
            return "{$querySql}{$parameters}";
        };
    }

}
