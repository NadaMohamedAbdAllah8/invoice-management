<?php

namespace App\Models;

use App\Enums\ContractStatus;
use App\Tenancy\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Contract extends Model
{
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'unit_name',
        'customer_name',
        'rent_amount',
        'start_date',
        'end_date',
        'status',
    ];

    protected $guarded = ['tenant_id'];

    protected function casts(): array
    {
        return [
            'status' => ContractStatus::class,
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(
            Payment::class,
            Invoice::class,
            'contract_id',
            'invoice_id',
            'id',
            'id'
        );
    }

    public function getInvoicesCountAttribute(): int
    {
        return $this->invoices()->count();
    }

    public function getTotalInvoicedAttribute(): float
    {
        return $this->invoices()->sum('total');
    }

    public function getTotalPaidAttribute(): float
    {
        return $this->payments()->sum('amount');
    }

    public function getOutstandingBalanceAttribute(): float
    {
        return $this->total_invoiced - $this->total_paid;
    }

    public function getLatestInvoiceDateAttribute(): ?string
    {
        return $this->invoices()
            ->latest('id')
            ->value('due_date');
    }
}
