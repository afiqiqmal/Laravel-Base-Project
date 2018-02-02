<?php

namespace App\Providers;

use App\Macros\Blade\BladePrint;
use App\Macros\Feature\FeaturePrint;
use App\Macros\Response\ResponsePrint;
use App\Macros\Router\RouterPrint;
use App\Macros\Schema\MigrationBlueprint;
use App\Macros\URL\URLPrint;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class BlueprintMacroProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        MigrationBlueprint::registerMacros();
        ResponsePrint::registerMacros();
        URLPrint::registerMacros();
        RouterPrint::registerMacros();
        FeaturePrint::registerMacros();
        BladePrint::registerMacros();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
