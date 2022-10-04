<?php

namespace Konnco\SatSet\Tests\Features\Login\Controllers;

use Konnco\SatSet\Http\Controllers\LoginController;
use Konnco\SatSet\Tests\Models\User;

class CanLoginWithMultipeIdentifierController extends LoginController
{
    protected string $model = User::class;

    public function rules(): array
    {
        return [];
    }

    public function columnIdentifier(): array
    {
        return [
            'email' => 'email',
            'phone' => 'phone'
        ];
    }
}
