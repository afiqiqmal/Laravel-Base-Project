<?php

namespace App\Library;

use App\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class Utils
{
    public static function getFile($file, $add_time = true, $replace_space = false, $prefix = null)
    {
        $extension = $file->getClientOriginalExtension();
        $filePath = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        if ($add_time) {
            $timestamp = Carbon::now()->format('YmdHsiu');
            $filePath .='_'.$timestamp;
        }
        $filePath .=  '.' . $extension;
        if ($replace_space) {
            $filePath = preg_replace('/\s+/', '_', $filePath);
        }

        if ($prefix) {
            $filePath = $prefix.'_'.$filePath;
        }

        return $filePath;
    }

    public static function encrypt($str)
    {
        $temp = $str;
        for ($i=0; $i<4; $i++) {
            $temp = base64_encode($temp);
        }

        return $temp;
    }

    public static function decrypt($str)
    {
        $temp = $str;
        for ($i=0; $i<4; $i++) {
            $temp = base64_decode($temp);
        }

        return $temp;
    }

    public static function getBoolean($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public static function limitStr($value, $limit = 200)
    {
        if ($value== null) {
            return null;
        }

        return strlen($value) > $limit ? substr($value, 0, $limit)."..." : $value;
    }

    public static function date($format, $date)
    {
        return Carbon::createFromFormat($format, $date);
    }

    public static function dateFormat($date, $inputFormat, $outputFormat)
    {
        return Carbon::createfromFormat($inputFormat, $date)->format($outputFormat);
    }

    public static function inArray($needle, $haystack)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }

    public static function aesEncrypt($data)
    {
        $key = env('SECRET_KEY');
        if (strlen($key) < 16) {
            $key = str_pad("$key", 16, "0");
        } elseif (strlen($key) > 16) {
            $key = substr($key, 0, 16);
        }

        $iv = random_bytes(16);

        $encodedEncryptedData = base64_encode(
            openssl_encrypt(
                $data,
                "aes-128-cbc",
                $key,
                OPENSSL_RAW_DATA,
                $iv
            )
        );
        $encodedIV = base64_encode($iv);
        $encryptedPayload = $encodedEncryptedData.":".$encodedIV;

        return base64_encode($encryptedPayload);
    }

    public static function aesDecrypt($data)
    {
        $key = env('SECRET_KEY');

        if (strlen($key) < 16) {
            $key = str_pad("$key", 16, "0");
        } elseif (strlen($key) > 16) {
            $key = substr($key, 0, 16);
        }

        $parts = explode(':', base64_decode($data));
        $decryptedData = openssl_decrypt(
            base64_decode($parts[0]),
            "aes-128-cbc",
            $key,
            OPENSSL_RAW_DATA,
            base64_decode($parts[1])
        );

        return $decryptedData;
    }

    public static function random($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }
}
