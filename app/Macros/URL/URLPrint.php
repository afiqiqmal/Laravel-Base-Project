<?php
/**
 * Created by PhpStorm.
 * User: hafiq
 * Date: 01/02/2018
 * Time: 5:04 PM
 */

namespace App\Macros\URL;

use App\Macros\MacroContract;
use Illuminate\Routing\UrlGenerator;

class URLPrint implements MacroContract
{
    public static function registerMacros()
    {
        (new URLPrint)->createMacros();
    }

    public function createMacros()
    {
        //return redirect()->home()
        UrlGenerator::macro('home', function () {
            return route('home');
        });

        //return redirect()->dashboard()
        UrlGenerator::macro('dashboard', function () {
            return route('dashboard');
        });
    }
}
