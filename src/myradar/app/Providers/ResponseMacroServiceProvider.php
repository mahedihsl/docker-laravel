<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('ok', function($data = []) {
            if (sizeof($data) == 1 && isset($data['data'])) {
                $data = $data['data'];
            }

            /**
             * If $data is an array, doesn't have 'data' key set
             * and not an associative array then it will be mapped to 'items', 'size'
             */
            if (is_array($data) && ! isset($data['data']) && array_keys($data) === range(0, count($data) - 1)) {
                $data = [
                    'items' => $data,
                    'size' => sizeof($data),
                ];
            }

            if (is_string($data) || is_bool($data) || is_int($data)) {
                $data = [
                    'message' => $data,
                ];
            }

            return response()->json([
                'status' => 1,
                'data' => $data,
            ]);
        });

        Response::macro('error', function($message = '') {
            return response()->json([
                'status' => 0,
                'data' => [
                    'message' => $message,
                ],
            ]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
