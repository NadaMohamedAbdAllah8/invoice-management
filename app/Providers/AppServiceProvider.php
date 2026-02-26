<?php

namespace App\Providers;

use App\Events\PaidInvoice as PaidInvoiceEvent;
use App\Listeners\PaidInvoice as PaidInvoiceListener;
use App\Models\Invoice;
use App\Observers\InvoiceObserver;
use App\Services\TaxService;
use App\Taxes\MunicipalFeeCalculator;
use App\Taxes\TourismTaxCalculator;
use App\Taxes\VatTaxCalculator;
use App\Tenancy\TenantContext;
use Illuminate\Support\Facades\Event;
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
        Invoice::observe(InvoiceObserver::class);

        Event::listen(PaidInvoiceEvent::class, PaidInvoiceListener::class);
    }
}
