<?php

namespace Konnco\SatSet;

use Illuminate\Support\Facades\Route;
use Konnco\SatSet\Http\Controllers\Auth\Login\LoginController;

class SatSet
{
    public static function route(): void
    {
        Route::get('login', LoginController::class);
    }
}
