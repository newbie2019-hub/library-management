<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Laravel\Reverb\Protocols\Pusher\Server;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Server::class, \App\Services\ReverbServer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Response::macro('data', function (mixed $data) {
            return Response::json($data);
        });

        Response::macro('success', function (mixed $data, ?string $msg = null) {
            return Response::json([
                'data' => $data,
                'message' => $msg
            ]);
        });

        Response::macro('error', function (string $msg) {
            return response()->json($msg, 500);
        });
    }
}
