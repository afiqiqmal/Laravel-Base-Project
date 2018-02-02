<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('store_file')) {

    /**
     * @param $file
     * @param string $disk
     * @param bool $add_time
     * @param bool $replace_space
     * @param null $prefix
     * @return bool
     */
    function store_file($file, $disk = "local", $add_time = true, $replace_space = false, $prefix = null)
    {
        $filePath = rename_file($file, $add_time, $replace_space, $prefix);
        Storage::disk($disk)->put($filePath, \File::get($file));
        return $filePath;
    }
}

if (! function_exists('get_store_file')) {

    /**
     * @param $filePath
     * @param string $disk
     * @param null $defaultFile
     * @param bool $public_path
     * @return string
     */
    function get_store_file($filePath, $disk = "local", $defaultFile = null, $public_path = false)
    {
        if ($filePath) {
            if (Storage::disk($disk)->has($filePath)) {
                if ($public_path) {
                    return get_full_storage_path($filePath, $disk);
                }
                return Storage::disk($disk)->url($filePath);
            }
        }

        if ($defaultFile == -1) {
            return null;
        }

        if ($public_path) {
            return ($defaultFile) ? $defaultFile : public_path('img/logo.jpg');
        }

        return ($defaultFile) ? $defaultFile : asset('img/logo.jpg');
    }
}

if (! function_exists('get_full_storage_path')) {

    /**
     * @param $filePath
     * @param string $disk
     * @return string
     */
    function get_full_storage_path($filePath, $disk = "local")
    {
        return Storage::disk($disk)->getDriver()->getAdapter()->getPathPrefix().$filePath;
    }
}

if (! function_exists('rename_file')) {

    /**
     * @param $file
     * @param bool $add_time
     * @param bool $replace_space
     * @param null $prefix
     * @return string
     */
    function rename_file($file, $add_time = true, $replace_space = false, $prefix = null)
    {
        return App\Library\Utils::getFile($file, $add_time, $replace_space, $prefix);
    }
}


if (! function_exists('redirect_error')) {

    /**
     * @param null $error
     * @param null $route_name
     * @param bool $with_input
     * @return string
     */
    function redirect_error($error = null, $with_input = true, $route_name = null)
    {
        $init = redirect();
        if ($route_name) {
            $init = $init->route($route_name);
        } else {
            $init = $init->back();
        }

        if ($with_input) {
            $init = $init->withInput($error);
        }

        if ($error) {
            $init = $init->withErrors($error);
        }

        return $init;
    }
}


if (! function_exists('redirect_success')) {

    /**
     * @param null $message
     * @param null $route_name
     * @return string
     */
    function redirect_success($message = null, $route_name = null)
    {
        $init = redirect();
        if ($route_name) {
            $init = $init->route($route_name);
        } else {
            $init = $init->back();
        }

        if ($message) {
            $init = $init->withMessage($message);
        }

        return $init;
    }
}
