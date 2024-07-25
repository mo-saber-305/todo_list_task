<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

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
        Response::macro('api', function ($status, $message, $data = null, $hasMorePages = null) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
                'hasMorePages' => $hasMorePages
            ]);
        });
    }
}
