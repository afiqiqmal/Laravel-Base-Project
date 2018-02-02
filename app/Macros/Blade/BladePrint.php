<?php
/**
 * Created by PhpStorm.
 * User: hafiq
 * Date: 02/02/2018
 * Time: 12:34 AM
 */

namespace App\Macros\Blade;

use App\Macros\MacroContract;
use Illuminate\Support\Facades\Blade;

class BladePrint implements MacroContract
{

    public static function registerMacros()
    {
        (new BladePrint)->createMacros();
    }

    public function createMacros()
    {
        //@sidebar
        Blade::directive('sidebar', function () {
            return null;
        });

        //@header
        Blade::directive('header', function () {
            return null;
        });

        //@footer
        Blade::directive('footer', function () {
            return null;
        });
    }
}