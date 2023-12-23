<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\ResponseFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResponseFactory::macro('api', function($data = null, $error = 0, $message = '',int  $statusCode = 200){
            return response()->json([
                'data' => $data,
                'error' => $error,
                'message' => $message,
            ], $statusCode);
        });
    }
}
