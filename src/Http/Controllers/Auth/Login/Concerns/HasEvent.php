<?php

namespace Konnco\SatSet\Http\Controllers\Auth\Login\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasEvent
{
    protected function didLoggedIn(Model $user)
    {
    }
}
