<?php

namespace Konnco\SatSet\Http\Controllers\Concerns\Login\Concerns\Login;

use Illuminate\Database\Eloquent\Model;

trait HasEvent
{
    protected function didLoggedIn(Model $user)
    {
    }
}
