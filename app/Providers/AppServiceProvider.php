<?php

namespace App\Providers;

use App\Repositories\ContractRepository;
use App\Repositories\ContractRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Tenancy\TenantContext;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->singleton(TenantContext::class, function (): TenantContext {
            return new TenantContext;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
