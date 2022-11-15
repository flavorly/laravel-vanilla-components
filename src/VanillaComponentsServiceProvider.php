<?php

namespace Flavorly\VanillaComponents;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Flavorly\VanillaComponents\Commands\VanillaComponentsCommand;

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
            ->name('vanilla-components-laravel')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasMigration('create_vanilla-components-laravel_table')
            ->hasCommand(VanillaComponentsCommand::class);
    }
}
