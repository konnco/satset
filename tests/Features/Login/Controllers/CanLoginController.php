<?php

namespace Konnco\SatSet\Tests\Features\Login\Controllers;

use Konnco\SatSet\Http\Controllers\Auth\Login\LoginController;
use Konnco\SatSet\Tests\Models\User;

class CanLoginController extends LoginController
{
    protected string $model = User::class;
}
