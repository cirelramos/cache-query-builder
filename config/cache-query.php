<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel cache query builder
    |--------------------------------------------------------------------------
    |
    | The values default time and tags for cache.
    |
    */

    /*
     * name to tag default when model you don't set the name tag.
     * Example: "cache_query_builder_my_project"
     */
    'cache_tag_name' => "cache_query_builder_",

    /*
     * default time when you don't set time in model class
     * 300 seconds are 5 minutes
     */
    'cache_default_time_seconds' => "300",

    /*
     * default time to SetCache class utility
     * 300 seconds are 5 minutes
     */
    'cache_time_seconds' => "186400",

    /*
     * elements to load from request
     * example:
     * ["system_id", "credential_id", "user_id"]
     */
    'elements_from_request' => [],


    /*
     * elements to load from header request
     * example:
     * ["origin", "Authorization"]
     */
    'elements_from_header_request' => [],
];
