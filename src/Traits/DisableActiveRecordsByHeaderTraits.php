<?php

namespace Cirelramos\Cache\Traits;

/**
 *
 */
trait DisableActiveRecordsByHeaderTraits
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
        });

        static::saving(function ($model) {
        });

        static::updating(function ($model) {
        });

        static::deleting(function ($model) {
        });

    }
}
