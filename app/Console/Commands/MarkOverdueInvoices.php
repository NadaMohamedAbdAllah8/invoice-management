<?php

namespace App\Console\Commands;

use App\Data\Invoice\FilterInvoiceDto;
use App\Data\UpdateManyInvoicesDTO;
use App\Enums\InvoiceStatus;
use App\Services\InvoiceService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class MarkOverdueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-overdue-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set pending invoices with past due date to overdue';

    public function __construct(private InvoiceService $invoiceService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filters = new FilterInvoiceDto(
            status: InvoiceStatus::PENDING->value,
            is_past_due_date: true,
        );

        $invoices = $this->invoiceService->findMany(
            dto: $filters,
            shouldPaginate: false,
        );

        $updated = $this->invoiceService->updateMany(
            dto: new UpdateManyInvoicesDTO(status: InvoiceStatus::OVERDUE->value),
            invoices: $invoices,
        );

        $this->info("Marked {$updated} invoice(s) as overdue.");

        return self::SUCCESS;
    }
}
