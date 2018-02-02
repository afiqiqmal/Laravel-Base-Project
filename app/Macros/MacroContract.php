<?php

namespace App\Macros;

interface MacroContract
{
    public static function registerMacros();
    public function createMacros();
}
