<?php

namespace App\Providers;

use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Admin\InvoiceRepository as AdminInvoiceRepository;
use App\Repositories\Admin\InvoiceRepositoryInterface as AdminInvoiceRepositoryInterface;
use App\Repositories\Contract\ContractRepository;
use App\Repositories\Contract\ContractRepositoryInterface;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Tenant\TenantRepository;
use App\Repositories\Tenant\TenantRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindInterfaces([
            AdminRepositoryInterface::class => AdminRepository::class,
            ContractRepositoryInterface::class => ContractRepository::class,
            AdminInvoiceRepositoryInterface::class => AdminInvoiceRepository::class,
            InvoiceRepositoryInterface::class => InvoiceRepository::class,
            PaymentRepositoryInterface::class => PaymentRepository::class,
            TenantRepositoryInterface::class => TenantRepository::class,
            UserRepositoryInterface::class => UserRepository::class,
        ]);
    }

    private function bindInterfaces(array $bindings): void
    {
        foreach ($bindings as $interface => $concrete) {
            $this->app->bind($interface, $concrete);
        }
    }
}
