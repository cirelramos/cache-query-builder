<?php

namespace CirelRamos\CacheQueryBuilder\Repositories\UtilsBuilder;

/**
 * Class GetQueryRelationShip
 * @package CirelRamos\CacheQueryBuilder\Repositories\UtilsBuilder
 */
class GetQueryRelationShip
{
    /**
     * @param       $query
     * @param array $relationsShip
     * @return string
     */
    public static function execute($query, array $relationsShip): string
    {
        $collectionRelationsShip = collect($relationsShip);
        $collectionRelationsShip = $collectionRelationsShip->map(
            self::mapReplaceGetRelationQueryAndParameter(
                $query
            )
        );

        return $collectionRelationsShip->toJson();

    }

    /**
     * @param $query
     * @return callable
     */
    private static function mapReplaceGetRelationQueryAndParameter($query): callable
    {
        return static function ($relationShip) use ($query) {
            $explodeItem = explode('.', $relationShip);

            if (count($explodeItem) > 1) {
                return GetQuerySubRelationShip::execute($query, $explodeItem);
            }

            $queryRelationsShip = $query->getRelation($relationShip);
            $querySql           = $queryRelationsShip->toSql();
            $parameters         = json_encode($queryRelationsShip->getBindings());
            return "{$querySql}{$parameters}";
        };
    }

}
