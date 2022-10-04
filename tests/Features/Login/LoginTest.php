<?php

use Illuminate\Support\Facades\Route;
use Konnco\SatSet\Tests\Features\Login\Controllers\CanLoginController;
use function Pest\Laravel\postJson;

it('can login', function () {
    \Konnco\SatSet\Tests\Models\User::create(
        [
            'email' => 'frankyso.mail@gmail.com',
            'password' => bcrypt('password'),
        ]
    );

    Route::post('/example-route', CanLoginController::class);

    postJson(
        action(CanLoginController::class),
        [
            'email' => 'frankyso.mail@gmail.com',
            'password' => 'password',
        ])
        ->assertOk();
});

it('can validate request login', function () {
});

it('can login with multiple identifier', function () {
});

it('can register push token notification', function () {
});
