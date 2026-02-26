<?php

namespace App\Data\Invoice;

use App\Constants\Pagination;

class FilterInvoiceDto extends InvoiceDTO
{
    public function __construct(
        public ?int $contract_id = null,
        public ?string $status = null,
        public ?string $from_due_date = null,
        public ?string $to_due_date = null,
        public ?bool $is_past_due_date = null,
        public ?int $page = null,
        public ?int $per_page = null,
    ) {
        parent::__construct(contract_id: $this->contract_id);

        $this->per_page ??= Pagination::PER_PAGE;
        $this->page ??= Pagination::PAGE;
    }
}
