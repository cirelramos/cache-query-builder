<?php /** @noinspection PhpConstantNamingConventionInspection */

/** @noinspection PhpMissingDocCommentInspection */

namespace Cirelramos\Cache\Classes;

class CacheConst
{
    public const CACHE_TAG_NAME            = "cache_query_builder_";
    public const CACHE_TIME_DAY            = 186400;  //TTL
    public const CACHE_TIME_FIVE_MINUTES   = 300;     //TTL
    public const CACHE_TIME_TEN_MINUTES    = 600;     //TTL
    public const CACHE_TIME_THIRTY_MINUTES = 1800;    //TTL
    public const DISABLED                  = 0;
    public const ENABLED                   = 1;
    public const PER_PAGE = 15;
    public const PAGE     = 1;
}
