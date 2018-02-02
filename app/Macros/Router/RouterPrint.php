<?php
/**
 * Created by PhpStorm.
 * User: hafiq
 * Date: 01/02/2018
 * Time: 5:04 PM
 */

namespace App\Macros\Router;

use App\Macros\MacroContract;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouterPrint implements MacroContract
{
    public static function registerMacros()
    {
        (new RouterPrint)->createMacros();
        (new RouterPrint)->makeNewRoute();
    }

    public function createMacros()
    {
        Route::macro('home', function () {
            return url()->home();
        });

        Route::macro('dashboard', function () {
            return url()->dashboard();
        });
    }

    public function makeNewRoute()
    {
        if (!Route::hasMacro('source')) {
            Route::macro('source', function ($module, $prefix = null, $namespace = null, array $middleware = ['auth']) {

                $url        = str_replace('.', '/', Str::singular($module));
                $name       = Str::singular($module);
                $controller = Str::studly(str_replace('.', ' ', $module)) . 'Controller';

                //generate controller by running route:list
                Artisan::call('resource:controller', [
                    'name' => ($namespace ? ucwords($namespace)."/" : null).$controller,
                ]);

                Route::group([

                    'prefix'     => $prefix, //route prefix
                    'namespace'  => $namespace ? ucwords($namespace) : null, //path
                    'middleware' => $middleware, //middleware

                ], function () use ($url, $name, $controller) {

                    Route::get($url . '/', $controller . '@index')->name($name . '.index');
                    Route::get($url . '/{id}/edit', $controller . '@edit')->name($name . '.edit');
                    Route::get($url . '/{id}/show', $controller . '@show')->name($name . '.show');
                    Route::get($url . '/create', $controller . '@create')->name($name . '.edit');
                    Route::patch($url . '/{id}/update', $controller . '@update')->name($name . '.update');
                    Route::post($url . '/store', $controller . '@store')->name($name . '.store');
                    Route::delete($url . '/{id}/delete', $controller . '@destroy')->name($name . '.destroy');
                });
            });
        }
    }
}
