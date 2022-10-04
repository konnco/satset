<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Konnco\SatSet\Tests\Features\Login\Controllers\CanLoginController;
use Konnco\SatSet\Tests\Features\Login\Controllers\CanLoginWithMultipeIdentifierController;
use Konnco\SatSet\Tests\Models\User;
use function Pest\Laravel\postJson;

function createUser($email = 'frankyso.mail@gmail.com', $password = 'password', ...$data): User
{
    return User::create(
        array_merge([
            'email' => $email,
            'password' => bcrypt($password),
        ], $data)
    );
}

function registerRoute(?string $controller = null): void
{
    Route::post('/example-route', $controller ?? CanLoginController::class);
}

it('can login', function () {
    Schema::create('users', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('email');
        $table->text('password');
        $table->timestamps();
    });

    registerRoute();

    createUser();

    postJson(
        action(CanLoginController::class),
        [
            'email' => 'frankyso.mail@gmail.com',
            'password' => 'password',
        ])
        ->assertOk();
});

it('can validate request login', function () {
    Schema::create('users', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('email');
        $table->text('password');
        $table->timestamps();
    });

    registerRoute();

    createUser();

    postJson(
        action(CanLoginController::class),
        [
            'email' => 'frankyso.mail@gmail.com',
            'password' => '',
        ])
        ->assertUnprocessable();
});

it('can login with multiple identifier', function () {
    Schema::create('users', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('phone');
        $table->string('email');
        $table->text('password');
        $table->timestamps();
    });

    registerRoute(CanLoginWithMultipeIdentifierController::class);

    createUser(phone: 6282195395779);

    postJson(
        action(CanLoginWithMultipeIdentifierController::class),
        [
            'phone' => '6282195395779',
            'password' => 'password',
        ])
        ->assertOk();

    postJson(
        action(CanLoginWithMultipeIdentifierController::class),
        [
            'email' => 'frankyso.mail@gmail.com',
            'password' => 'password',
        ])
        ->assertOk();
});

it('can register push token notification', function () {
});
