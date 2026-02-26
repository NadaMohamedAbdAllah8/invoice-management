<?php

namespace App\Providers;

use App\Repositories\Contract\ContractRepository;
use App\Repositories\Contract\ContractRepositoryInterface;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindInterfaces([
            ContractRepositoryInterface::class => ContractRepository::class,
            InvoiceRepositoryInterface::class => InvoiceRepository::class,
            PaymentRepositoryInterface::class => PaymentRepository::class,
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
