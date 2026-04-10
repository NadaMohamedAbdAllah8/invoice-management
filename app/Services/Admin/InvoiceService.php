<?php

namespace App\Services\Admin;

use App\Models\Invoice;
use App\Repositories\Admin\InvoiceRepositoryInterface as AdminRepositoryInterface;
use App\Repositories\Contract\ContractRepositoryInterface;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Services\InvoiceService as UserInvoiceService;
use App\Services\TaxService;

class InvoiceService extends UserInvoiceService
{
    public function __construct(
        protected PaymentRepositoryInterface $paymentRepository,
        protected ContractRepositoryInterface $contractRepository,
        protected TaxService $taxService,
        private AdminRepositoryInterface $adminInvoiceRepository,
    ) {
        parent::__construct(
            invoiceRepository: $adminInvoiceRepository,
            paymentRepository: $paymentRepository,
            contractRepository: $contractRepository,
            taxService: $taxService,
        );
    }

    public function getOneById(int $id): Invoice
    {
        return $this->adminInvoiceRepository->getOneById(id: $id);
    }
}
