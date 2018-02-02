<?php
/**
 * Created by PhpStorm.
 * User: hafiq
 * Date: 01/02/2018
 * Time: 8:34 PM
 */

namespace App\Macros\Feature;

use App\Macros\MacroContract;
use Illuminate\Support\Carbon;

class FeaturePrint implements MacroContract
{
    public static function registerMacros()
    {
        (new FeaturePrint)->createMacros();
    }

    public function createMacros()
    {
        $this->newCarbon();
    }

    private function newCarbon()
    {
        Carbon::macro('dmy_to_ymd', function ($date) {
            return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        });

        Carbon::macro('ymd_to_dmy', function ($date) {
            return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        });
    }
}
