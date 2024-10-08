<?php

namespace App\Providers;

use App\Jobs\ProductCreatedJob;
use App\Jobs\ProductDeletedJob;
use App\Jobs\ProductUpdatedJob;
use App\Jobs\TestJob;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{


    public function boot()
    {
        App::bindMethod(ProductCreatedJob::class . '@handle', fn($job) => $job->handle());
        App::bindMethod(ProductUpdatedJob::class . '@handle', fn($job) => $job->handle());
        App::bindMethod(ProductDeletedJob::class . '@handle', fn($job) => $job->handle());
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
