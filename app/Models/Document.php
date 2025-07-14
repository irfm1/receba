<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'name',
        'file_path',
        'file_size',
        'mime_type',
        'category',
        'description',
        'customer_id',
        'invoice_id',
        'technical_report_id',
        'uploaded_by',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function technicalReport(): BelongsTo
    {
        return $this->belongsTo(TechnicalReport::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFormattedFileSizeAttribute(): string
    {
        if ($this->file_size < 1024) {
            return $this->file_size . ' B';
        } elseif ($this->file_size < 1024 * 1024) {
            return round($this->file_size / 1024, 2) . ' KB';
        } elseif ($this->file_size < 1024 * 1024 * 1024) {
            return round($this->file_size / (1024 * 1024), 2) . ' MB';
        } else {
            return round($this->file_size / (1024 * 1024 * 1024), 2) . ' GB';
        }
    }

    public function getIconAttribute(): string
    {
        return match ($this->mime_type) {
            'application/pdf' => 'document-text',
            'image/jpeg', 'image/png', 'image/gif', 'image/webp' => 'photo',
            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'document-text',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'table-cells',
            'application/zip', 'application/x-rar-compressed' => 'archive-box',
            default => 'document'
        };
    }
}
