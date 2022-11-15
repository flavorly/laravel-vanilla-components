<?php

namespace Flavorly\VanillaComponents;

use Flavorly\VanillaComponents\Commands\VanillaComponentsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class VanillaComponentsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-vanilla-components')
            ->hasConfigFile()
            ->hasTranslations()
            //->hasMigration('create_laravel-vanilla-components_table')
            ->hasCommand(VanillaComponentsCommand::class);
    }
}
