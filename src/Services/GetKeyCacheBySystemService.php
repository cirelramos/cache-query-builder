<?php

namespace Cirelramos\Cache\Services;

/**
 *
 */
class GetKeyCacheBySystemService
{
    /**
     * @param $customKey
     * @return string
     */
    public static function execute($customKey): string
    {
        $request = request();
        $key     = self::getValuesFromRequest($request);
        $key     .= self::getValuesFromRequest($request);

        $customKey .= "_" . $key;

        return strtoupper($customKey);
    }

    /**
     * @param $request
     * @return string
     */
    private static function getValuesFromRequest($request): string
    {
        $elements = config('cache-query.elements_from_request');
        $values   = "";
        if (is_array($elements) === false) {
            return $values;
        }

        foreach ($elements as $element) {
            $value = $request->$element;

            if (is_array($value)) {
                $value = json_encode($value);
            }
                $values .= "_" . $value;
        }

        return $values;
    }

    /**
     * @param $request
     * @return string
     */
    private static function getValuesFromHeaderRequest($request): string
    {
        $elements = config('cache-query.elements_from_header_request');
        $values   = "";
        if (is_array($elements) === false) {
            return $values;
        }

        foreach ($elements as $element) {
            $value = $request->header($element);

            if (is_array($value)) {
                $value = json_encode($value);
            }
            $values .= "_" . $value;
        }

        return $values;
    }
}
