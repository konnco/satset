<?php

namespace Konnco\SatSet\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Konnco\SatSet\SatSetServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Konnco\\SatSet\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

//        $this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [
            SatSetServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_push_notification_tokens.php.stub';
        $migration->up();

        /*
        $migration = include __DIR__.'/../database/migrations/create_satset_table.php.stub';
        $migration->up();
        */
    }
}
