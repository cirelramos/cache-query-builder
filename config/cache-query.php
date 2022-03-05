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
    'cache_default_time_minutes' => "300",
];
