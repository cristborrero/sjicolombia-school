<?php

namespace App\Providers;

use App\Services\Meet\GoogleCalendarMeetService;
use App\Services\Meet\ManualMeetService;
use App\Services\Meet\MeetServiceInterface;
use App\Services\Payment\PaymentGatewayInterface;
use App\Services\Payment\PaymentManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Payment Gateway — resolved via PaymentManager (Strategy Pattern)
        $this->app->singleton(PaymentManager::class, function ($app) {
            return new PaymentManager($app);
        });

        $this->app->bind(PaymentGatewayInterface::class, function ($app) {
            return $app->make(PaymentManager::class)->driver();
        });

        // Meet Service — resolved by MEET_DRIVER config
        $this->app->bind(MeetServiceInterface::class, function ($app) {
            $driver = config('meet.driver', 'manual');

            return match ($driver) {
                'google_calendar' => new GoogleCalendarMeetService(),
                default => new ManualMeetService(),
            };
        });
    }

    public function boot(): void
    {
        //
    }
}
