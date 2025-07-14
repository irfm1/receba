<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicalReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'report_number',
        'customer_id',
        'invoice_id',
        'service_order_number',
        'title',
        'description',
        'inspection_date',
        'report_date',
        'technician_name',
        'technician_registration',
        'report_type',
        'equipment_analyzed',
        'findings',
        'recommendations',
        'observations',
        'attachments',
        'status',
        'approval_notes',
        'approved_at',
        'approved_by',
        'valid_until',
        'is_template',
        'template_name',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'report_date' => 'date',
        'valid_until' => 'date',
        'approved_at' => 'datetime',
        'equipment_analyzed' => 'array',
        'attachments' => 'array',
        'is_template' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Report types constants
    const TYPE_INSTALACAO = 'instalacao';
    const TYPE_MANUTENCAO = 'manutencao';
    const TYPE_DIAGNOSTICO = 'diagnostico';
    const TYPE_SEGURANCA = 'seguranca';
    const TYPE_PERFORMANCE = 'performance';
    const TYPE_INFRAESTRUTURA = 'infraestrutura';
    const TYPE_OUTROS = 'outros';

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_COMPLETED = 'completed';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public static function getReportTypes(): array
    {
        return [
            self::TYPE_INSTALACAO => 'Instalação',
            self::TYPE_MANUTENCAO => 'Manutenção',
            self::TYPE_DIAGNOSTICO => 'Diagnóstico',
            self::TYPE_SEGURANCA => 'Segurança',
            self::TYPE_PERFORMANCE => 'Performance',
            self::TYPE_INFRAESTRUTURA => 'Infraestrutura',
            self::TYPE_OUTROS => 'Outros',
        ];
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Rascunho',
            self::STATUS_COMPLETED => 'Concluído',
            self::STATUS_APPROVED => 'Aprovado',
            self::STATUS_REJECTED => 'Rejeitado',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getReportTypeNameAttribute(): string
    {
        return self::getReportTypes()[$this->report_type] ?? $this->report_type;
    }

    public function getStatusNameAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->valid_until && $this->valid_until->isPast();
    }

    public function generateReportNumber(): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $prefix = "LT-{$year}{$month}";
        
        $lastReport = self::where('report_number', 'like', "{$prefix}%")
            ->orderBy('report_number', 'desc')
            ->first();
        
        if ($lastReport) {
            $lastNumber = (int) substr($lastReport->report_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "{$prefix}-{$newNumber}";
    }

    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('report_type', $type);
    }

    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now());
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', self::STATUS_DRAFT);
    }

    public function scopeTemplates($query)
    {
        return $query->where('is_template', true);
    }

    public function scopeNotTemplates($query)
    {
        return $query->where('is_template', false);
    }

    public function approve(string $approvedBy, string $notes = null): void
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'approved_by' => $approvedBy,
            'approved_at' => now(),
            'approval_notes' => $notes,
        ]);
    }

    public function reject(string $rejectedBy, string $notes = null): void
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'approved_by' => $rejectedBy,
            'approved_at' => now(),
            'approval_notes' => $notes,
        ]);
    }

    public function addAttachment(string $filename, string $path, string $type = 'image'): void
    {
        $attachments = $this->attachments ?? [];
        $attachments[] = [
            'filename' => $filename,
            'path' => $path,
            'type' => $type,
            'uploaded_at' => now()->toISOString(),
        ];
        $this->update(['attachments' => $attachments]);
    }

    public function addEquipment(string $name, string $model = null, string $serial = null, string $status = null): void
    {
        $equipment = $this->equipment_analyzed ?? [];
        $equipment[] = [
            'name' => $name,
            'model' => $model,
            'serial' => $serial,
            'status' => $status,
            'analyzed_at' => now()->toISOString(),
        ];
        $this->update(['equipment_analyzed' => $equipment]);
    }
}
