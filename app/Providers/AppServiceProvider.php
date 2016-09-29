<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Response::macro('jsend', function ($status, $data = null, $message = null, $code = null) {
            switch ($status) {
                case 'success':
                case 'fail':
                    $content = ['status' => $status, 'data' => $data];
                    break;
                default:
                    $content = ['status' => 'error', 'message' => $message];
                    if ($data) {
                        $content['data'] = $data;
                    }
                    if ($code) {
                        $content['code'] = $code;
                    }
            }
            $response = \Response::make($content);
            /**
             * @var $response Response
             */
            $response->header('Content-Type', 'application/json');
            return $response;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
