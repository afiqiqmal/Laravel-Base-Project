<?php

namespace App\Http\Middleware\Api;

use App\Library\Message;
use Closure;

class ApiHeaderChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $services = $request->header('Client-services');
        $powered_by = $request->header('X-powered-by');
        $api_channel = $request->header('Api-channel');

        if ($services && $powered_by && $api_channel) {
            if ($powered_by == __('api.powered_by') && $services == __('api.client_service') && $api_channel == __('api.api_channel')) {
                return $next($request);
            }
        }

        return response()->error(__('api.api_block'), 401, 'Authorization header failed');
    }
}