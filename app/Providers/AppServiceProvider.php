<?php

namespace App\Providers;

use App\Contracts\PaymentServiceInterface;
use App\Models\Setting;
use App\Services\NullPaymentService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentServiceInterface::class, NullPaymentService::class);
    }

    public function boot(): void
    {
        View::share('siteName', Setting::get('site_name', config('app.name')));
    }
}
