<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'description',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'status',
        'items',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'items' => 'array',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_SENT = 'sent';
    const STATUS_PAID = 'paid';
    const STATUS_OVERDUE = 'overdue';
    const STATUS_CANCELLED = 'cancelled';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Rascunho',
            self::STATUS_SENT => 'Enviada',
            self::STATUS_PAID => 'Paga',
            self::STATUS_OVERDUE => 'Vencida',
            self::STATUS_CANCELLED => 'Cancelada',
        ];
    }

    public function getStatusNameAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? '';
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status !== self::STATUS_PAID && 
               $this->status !== self::STATUS_CANCELLED && 
               $this->due_date->isPast();
    }

    public function generateInvoiceNumber(): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $prefix = "INV-{$year}{$month}";
        
        $lastInvoice = self::where('invoice_number', 'like', "{$prefix}%")
            ->orderBy('invoice_number', 'desc')
            ->first();
        
        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "{$prefix}-{$newNumber}";
    }

    public function calculateTotals(): array
    {
        $subtotal = 0;
        
        foreach ($this->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }
        
        $discountAmount = $this->discount_amount ?? 0;
        $taxAmount = $this->tax_amount ?? 0;
        $total = $subtotal - $discountAmount + $taxAmount;
        
        return [
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total_amount' => $total,
        ];
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'Rascunho',
            self::STATUS_SENT => 'Enviada',
            self::STATUS_PAID => 'Paga',
            self::STATUS_OVERDUE => 'Vencida',
            self::STATUS_CANCELLED => 'Cancelada',
            default => 'Desconhecido',
        };
    }
}
