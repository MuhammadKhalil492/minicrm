<?php
namespace App\Models\Traits;
use App\Observers\UUIDObserver;

trait HasUuidTrait
{
    /**
     * Boot function from Laravel to attach model events.
     */
    protected static function bootHasUuidTrait()
    {
        static::observe(new UuidObserver);
    }
}
