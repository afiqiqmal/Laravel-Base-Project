<?php
/**
 * Created by PhpStorm.
 * User: hafiq
 * Date: 01/02/2018
 * Time: 8:34 PM
 */

namespace App\Macros\Response;

use App\Macros\MacroContract;
use Illuminate\Support\Facades\Response as HttpResponse;

class ResponsePrint implements MacroContract
{

    public static function registerMacros()
    {
        (new ResponsePrint)->createMacros();
    }

    public function createMacros()
    {
        //response()->success()
        HttpResponse::macro('success', function ($msg = 'Request Success', $code = 200, $obj = null) {
            return $this->json(
                [
                    'error' => false,
                    'message' => $msg,
                    'data' => $obj,
                ],
                $code
            );
        });

        //response()->error()
        HttpResponse::macro('error', function ($msg = 'Something went wrong', $code = 400, $reference = null, $should_login = false, $should_quit = false) {
            if ($msg instanceof \Exception) {
                $reference = $msg->getMessage();
                $msg = "Something went wrong";
            }

            return $this->json(
                [
                    'error' => true,
                    'message' => $msg,
                    'reference' => $reference,
                    'should_quit' => $should_quit,
                    'should_login' => $should_login
                ],
                $code
            );
        });
    }
}
