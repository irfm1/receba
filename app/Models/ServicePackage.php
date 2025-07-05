<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category',
        'fixed_price',
        'estimated_duration_days',
        'is_active',
        'features',
        'requirements',
        'deliverables',
        'terms_conditions',
        'discount_percentage',
        'valid_from',
        'valid_until',
    ];

    protected $casts = [
        'fixed_price' => 'decimal:2',
        'estimated_duration_days' => 'integer',
        'is_active' => 'boolean',
        'features' => 'array',
        'requirements' => 'array',
        'deliverables' => 'array',
        'terms_conditions' => 'array',
        'discount_percentage' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Package categories constants
    const CATEGORY_WEBSITE_BASICO = 'website_basico';
    const CATEGORY_ECOMMERCE = 'ecommerce';
    const CATEGORY_SISTEMA_GESTAO = 'sistema_gestao';
    const CATEGORY_APP_MOBILE = 'app_mobile';
    const CATEGORY_CONSULTORIA_TI = 'consultoria_ti';
    const CATEGORY_INFRAESTRUTURA = 'infraestrutura';
    const CATEGORY_SEGURANCA = 'seguranca';
    const CATEGORY_MANUTENCAO = 'manutencao';

    public static function getCategories(): array
    {
        return [
            self::CATEGORY_WEBSITE_BASICO => 'Website Básico',
            self::CATEGORY_ECOMMERCE => 'E-commerce',
            self::CATEGORY_SISTEMA_GESTAO => 'Sistema de Gestão',
            self::CATEGORY_APP_MOBILE => 'Aplicativo Mobile',
            self::CATEGORY_CONSULTORIA_TI => 'Consultoria em TI',
            self::CATEGORY_INFRAESTRUTURA => 'Infraestrutura',
            self::CATEGORY_SEGURANCA => 'Segurança',
            self::CATEGORY_MANUTENCAO => 'Manutenção',
        ];
    }

    public function serviceTemplates(): BelongsToMany
    {
        return $this->belongsToMany(ServiceTemplate::class, 'package_services')
                    ->withPivot('quantity', 'estimated_hours', 'custom_rate')
                    ->withTimestamps();
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'R$ ' . number_format($this->fixed_price, 2, ',', '.');
    }

    public function getCategoryNameAttribute(): string
    {
        return self::getCategories()[$this->category] ?? $this->category;
    }

    public function getEstimatedDurationAttribute(): string
    {
        if ($this->estimated_duration_days < 7) {
            return $this->estimated_duration_days . ' dias';
        } elseif ($this->estimated_duration_days < 30) {
            $weeks = round($this->estimated_duration_days / 7);
            return $weeks . ' semana' . ($weeks > 1 ? 's' : '');
        } else {
            $months = round($this->estimated_duration_days / 30);
            return $months . ' mês' . ($months > 1 ? 'es' : '');
        }
    }

    public function getDiscountedPriceAttribute(): float
    {
        if ($this->discount_percentage > 0) {
            return $this->fixed_price * (1 - $this->discount_percentage / 100);
        }
        return $this->fixed_price;
    }

    public function getFormattedDiscountedPriceAttribute(): string
    {
        return 'R$ ' . number_format($this->discounted_price, 2, ',', '.');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValidNow($query)
    {
        $now = now()->toDateString();
        return $query->where(function ($q) use ($now) {
            $q->where(function ($subQ) use ($now) {
                $subQ->whereNull('valid_from')
                     ->orWhere('valid_from', '<=', $now);
            })->where(function ($subQ) use ($now) {
                $subQ->whereNull('valid_until')
                     ->orWhere('valid_until', '>=', $now);
            });
        });
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
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

    public function calculateTotalServiceCost(): float
    {
        $total = 0;
        
        foreach ($this->serviceTemplates as $service) {
            $rate = $service->pivot->custom_rate ?: $service->base_rate_per_hour;
            $hours = $service->pivot->estimated_hours ?: $service->estimated_hours;
            $quantity = $service->pivot->quantity ?: 1;
            
            $total += $rate * $hours * $quantity;
        }
        
        return $total;
    }

    public function getSavingsAttribute(): float
    {
        $serviceCost = $this->calculateTotalServiceCost();
        return max(0, $serviceCost - $this->discounted_price);
    }

    public function getFormattedSavingsAttribute(): string
    {
        return 'R$ ' . number_format($this->savings, 2, ',', '.');
    }
}
