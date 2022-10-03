<?php

namespace Konnco\SatSet;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Konnco\SatSet\Commands\SatSetCommand;
use Illuminate\Support\Facades\Response;

class SatSetServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('satset')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_satset_table')
            ->hasCommand(SatSetCommand::class);
    }
}
