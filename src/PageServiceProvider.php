<?php

namespace Performing\View;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-view-helpers')
            ->hasViews('laravel-view-helpers')
            ->hasConfigFile();
    }
}
