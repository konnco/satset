<?php

namespace Konnco\SatSet\Http\Controllers\Concerns\Login;

use Illuminate\Database\Eloquent\Model;

trait HasLifecycleEvent
{
    protected function didLoggedIn(Model $user)
    {
    }
}
