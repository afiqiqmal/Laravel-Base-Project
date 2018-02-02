<?php
/**
 * Created by PhpStorm.
 * User: hafiq
 * Date: 02/02/2018
 * Time: 10:27 AM
 */

namespace App\Console\Commands\Custom;

use Illuminate\Routing\Console\ControllerMakeCommand;

class MakeControllerCommand extends ControllerMakeCommand
{
    protected $name = 'resource:controller';
    protected $description = '';

    protected function getStub()
    {
        return __DIR__.'/stubs/resource_controller.stub';
    }
}