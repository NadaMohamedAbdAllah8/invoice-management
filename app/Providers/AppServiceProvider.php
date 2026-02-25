<?php

namespace App\Providers;

use App\Repositories\ContractRepository;
use App\Repositories\ContractRepositoryInterface;
use App\Repositories\InvoiceRepository;
use App\Repositories\InvoiceRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\TaxService;
use App\Taxes\MunicipalFeeCalculator;
use App\Taxes\TourismTaxCalculator;
use App\Taxes\VatTaxCalculator;
use App\Tenancy\TenantContext;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TenantContext::class, function (): TenantContext {
            return new TenantContext;
        });

        $this->bindInterfaces([
            ContractRepositoryInterface::class => ContractRepository::class,
            InvoiceRepositoryInterface::class => InvoiceRepository::class,
            UserRepositoryInterface::class => UserRepository::class,
        ]);

        $this->app->tag([
            VatTaxCalculator::class,
            MunicipalFeeCalculator::class,
            TourismTaxCalculator::class,
        ], 'tax.calculators');

        $this->app->bind(TaxService::class, function ($app): TaxService {
            return new TaxService($app->tagged('tax.calculators'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function bindInterfaces(array $bindings): void
    {
        foreach ($bindings as $interface => $concrete) {
            $this->app->bind($interface, $concrete);
        }
    }
}
