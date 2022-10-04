<?php

namespace Konnco\SatSet;

use Konnco\SatSet\Commands\SatSetCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasRoute('api')
            ->hasCommand(SatSetCommand::class);
    }
}
