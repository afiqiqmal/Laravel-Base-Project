<?php

namespace App\Library;

class Message
{
    public static function error(
        $msg = 'Something went wrong',
        $code = 400,
        $reference = null,
        $should_login = false,
        $should_quit = false
    ) {

        if ($msg instanceof \Exception) {
            $reference = $msg->getMessage();
            $msg = "Something went wrong";
        }

        return response()->json(
            [
                'error' => true,
                'message' => $msg,
                'reference' => $reference,
                'should_quit' => $should_quit,
                'should_login' => $should_login
            ],
            $code
        );
    }

    public static function success($msg = 'Request Success', $code = 200, $obj = null)
    {
        return response()->json(
            [
                'error' => false,
                'message' => $msg,
                'data' => $obj,
            ],
            $code
        );
    }

    public static function raw($data, $code)
    {
        return response()->json($data, $code);
    }
}
