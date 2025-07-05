<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_template_id',
        'customer_category',
        'complexity_level',
        'rate_per_hour',
        'minimum_hours',
        'is_active',
        'valid_from',
        'valid_until',
        'notes',
    ];

    protected $casts = [
        'rate_per_hour' => 'decimal:2',
        'minimum_hours' => 'decimal:2',
        'is_active' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Complexity levels constants
    const COMPLEXITY_BASIC = 'basic';
    const COMPLEXITY_INTERMEDIATE = 'intermediate';
    const COMPLEXITY_ADVANCED = 'advanced';
    const COMPLEXITY_EXPERT = 'expert';

    public static function getComplexityLevels(): array
    {
        return [
            self::COMPLEXITY_BASIC => 'Básico',
            self::COMPLEXITY_INTERMEDIATE => 'Intermediário',
            self::COMPLEXITY_ADVANCED => 'Avançado',
            self::COMPLEXITY_EXPERT => 'Especialista',
        ];
    }

    public static function getCustomerCategories(): array
    {
        return [
            Customer::CATEGORY_INDIVIDUAL => 'Pessoa Física',
            Customer::CATEGORY_MEI => 'MEI',
            Customer::CATEGORY_SMALL_BUSINESS => 'Pequena Empresa',
            Customer::CATEGORY_LARGE_BUSINESS => 'Grande Empresa',
        ];
    }

    public function serviceTemplate(): BelongsTo
    {
        return $this->belongsTo(ServiceTemplate::class);
    }

    public function getFormattedRateAttribute(): string
    {
        return 'R$ ' . number_format($this->rate_per_hour, 2, ',', '.');
    }

    public function getComplexityNameAttribute(): string
    {
        return self::getComplexityLevels()[$this->complexity_level] ?? $this->complexity_level;
    }

    public function getCustomerCategoryNameAttribute(): string
    {
        return self::getCustomerCategories()[$this->customer_category] ?? $this->customer_category;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValidNow($query)
    {
        $now = now()->toDateString();
        return $query->where(function ($q) use ($now) {
            $q->where('valid_from', '<=', $now)
              ->where(function ($subQ) use ($now) {
                  $subQ->whereNull('valid_until')
                       ->orWhere('valid_until', '>=', $now);
              });
        });
    }

    public function scopeForCustomerCategory($query, $category)
    {
        return $query->where('customer_category', $category);
    }

    public function scopeForComplexity($query, $complexity)
    {
        return $query->where('complexity_level', $complexity);
    }

    public function isValid(): bool
    {
        $now = now()->toDateString();
        
        if ($this->valid_from && $this->valid_from > $now) {
            return false;
        }
        
        if ($this->valid_until && $this->valid_until < $now) {
            return false;
        }
        
        return $this->is_active;
    }
}
