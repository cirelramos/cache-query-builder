<?php

namespace CirelRamos\CacheQueryBuilder\Traits;


//TODO disable for this version
//
//
//use CirelRamos\CacheQueryBuilder\Classes\ModelConst;
//use CirelRamos\CacheQueryBuilder\Services\GetCacheService;
//use CirelRamos\CacheQueryBuilder\Services\GetKeyCacheBySystemService;
//use CirelRamos\CacheQueryBuilder\Services\GetTagCacheService;
//use CirelRamos\CacheQueryBuilder\Services\SetCacheService;
//use Exception;
//use Illuminate\Support\Facades\Cache;
//
///**
// * Trait CacheRedisTraits
// * @package CirelRamos\CacheQueryBuilder\Traits
// */
//trait CacheUtilsCollectionTraits
//{
//    /**
//     * @param string $tag
//     * @param string $model
//     * @param array  $keys
//     * @param int    $time
//     * @return callable
//     */
//    public function mapKeyCache(string $model, array $keys = [], $tag = null, $time = 0): callable
//    {
//        return function ($item) use ($tag, $model, $keys, $time) {
//            $this->setItemInCache($model, $keys, $item, $tag, $time);
//            return $item;
//        };
//    }
//
//    /**
//     * @param string      $model
//     * @param array       $keys
//     * @param array       $item
//     * @param string|null $tag
//     * @param int         $time
//     * @throws Exception
//     */
//    protected function setItemInCache(
//        string $model,
//        array $keys = [],
//        $item = [],
//        $tag = null,
//        $time = 0
//    ): void {
//        $customKey = $this->setKeysToCustomKey($model, $keys, $item);
//        $this->setCache($customKey, $item, $tag, $time);
//    }
//
//    /**
//     * @param      $model
//     * @param      $keys
//     * @param null $item
//     * @return string
//     */
//    public function setKeysToCustomKey($model, $keys, $item = null)
//    {
//        $customKey = $model;
//        if (is_string($keys)) {
//            return $customKey . "_" . $keys;
//        }
//        foreach ($keys as $key) {
//            if (empty($key) === false && $item !== null) {
//                $customKey .= "_" . $item[ $key ];
//            }
//        }
//        return $customKey;
//    }
//
//    /**
//     * @param        $customKey
//     * @param        $data
//     * @param string $tag
//     * @param int    $time
//     * @throws Exception
//     */
//    protected function setCache($customKey, $data = [], $tag = null, $time = 0): void
//    {
//        SetCacheService::execute($customKey, $data, $tag, $time);
//    }
//
//    /**
//     * @param $model
//     * @param $keys
//     * @return array|mixed
//     * @throws Exception
//     */
//    public function getCacheByModel($model, $keys)
//    {
//        $customKey = $this->setKeysToCustomKey($model, $keys);
//        return $this->getCache($customKey);
//    }
//
//    /**
//     * @param      $customKey
//     * @param null $tag
//     * @return array|mixed
//     * @throws Exception
//     */
//    protected function getCache($customKey, $tag = null)
//    {
//        return GetCacheService::execute($customKey, $tag);
//    }
//}
