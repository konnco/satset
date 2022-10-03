<?php

namespace Konnco\SatSet\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Konnco\SatSet\SatSet
 */
class SatSet extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Konnco\SatSet\SatSet::class;
    }
}
