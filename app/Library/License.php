<?php

namespace App\Library;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Exception\InvalidPathException;
use Endroid\QrCode\QrCode;
use ErrorException;

class License
{
    public static function generate($suffix = null, $segment = 5, $length = 6)
    {
        if (isset($suffix)) {
            $suffix = preg_replace('/[^A-Za-z0-9\-]/', '', $suffix);
            $num_segments = $segment;
            $segment_chars = $length;
        } else {
            $num_segments = $segment;
            $segment_chars = $length;
        }
        $tokens = 'ABCDEFGHJKLMNPQRSTUVWXYZ1234567890';
        $license_string = '';
        for ($i = 0; $i < $num_segments; $i++) {
            $segment = '';
            for ($j = 0; $j < $segment_chars; $j++) {
                $segment .= $tokens[rand(0, strlen($tokens)-1)];
            }
            $license_string .= $segment;
            if ($i < ($num_segments - 1)) {
                $license_string .= '-';
            }
        }
        try {
            if (isset($suffix)) {
                if (is_numeric($suffix)) {
                    $license_string .= '-' . strtoupper(base_convert($suffix, 10, 36));
                } else {
                    $long = sprintf("%u\n", ip2long($suffix), true);
                    if ($suffix === long2ip($long)) {
                        $license_string .= '-' . strtoupper(base_convert($long, 10, 36));
                    } else {
                        $license_string .= '-'.strtoupper(str_ireplace(' ', '-', $suffix));
                    }
                }
            }
        } catch (ErrorException $e) {
            $license_string .= '-'.strtoupper(str_ireplace(' ', '-', $suffix));
        }
        return $license_string;
    }

    public static function generateQrCode($data, $domain, $code)
    {
        $datEN = Utils::aesEncrypt($data);
        $qrCode = new QrCode($datEN);
        $qrCode->setMargin(0);
        $qrCode->setSize(400);
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        try {
            $qrCode->setLogoPath(public_path('img/bepunct.png'));
        } catch (InvalidPathException $e) {
        }
        $qrCode->setLogoWidth(30);
        $qrCode->setRoundBlockSize(true);
        $qrCode->setValidateResult(false);

        $filename = md5($code."".time()).".png";
        $short_folder_name = $domain->sub_domain.'.'.env('APP_DOMAIN');
        $subfolder = substr($datEN, 0, 10);
        $file = "qrcode/$short_folder_name/$subfolder";

        if (!file_exists(public_path($file))) {
            mkdir(public_path($file), 0777, true);
        }

        $qrCode->writeFile(public_path("$file/$filename"));

        $asset_url = Utils::fixHttpUrl(str_replace(
            config('bepunct.url.admin'),
            $short_folder_name,
            asset("$file/$filename")
        ));

        return $asset_url;
    }
}
