<?php
/**
 * Created by PhpStorm.
 * User: hafiq
 * Date: 01/02/2018
 * Time: 4:42 PM
 */

namespace App\Macros\Schema;

use Illuminate\Database\Schema\Blueprint;
use App\Macros\MacroContract;

class MigrationBlueprint implements MacroContract
{
    public static function registerMacros()
    {
        (new MigrationBlueprint)->createMacros();
    }

    public function createMacros()
    {
        //$table->name();
        Blueprint::macro('name', function () {
            return $this->string('name');
        });

        //$table->uniqueEmail();
        Blueprint::macro('uniqueEmail', function () {
            return $this->string('email')->unique();
        });

        //$table->password();
        Blueprint::macro('password', function () {
            return $this->string('password');
        });

        //$table->token();
        Blueprint::macro('token', function ($length = 256) {
            return $this->text('token', $length);
        });

        //$table->description();
        Blueprint::macro('description', function () {
            return $this->text('description');
        });

        //$table->description();
        Blueprint::macro('description', function () {
            return $this->text('description');
        });
    }
}
