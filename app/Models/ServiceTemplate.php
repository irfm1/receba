<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category',
        'base_rate_per_hour',
        'unit',
        'estimated_hours',
        'is_active',
        'tags',
        'requirements',
        'deliverables',
    ];

    protected $casts = [
        'base_rate_per_hour' => 'decimal:2',
        'estimated_hours' => 'decimal:2',
        'is_active' => 'boolean',
        'tags' => 'array',
        'requirements' => 'array',
        'deliverables' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Service categories constants
    const CATEGORY_CONSULTORIA = 'consultoria';
    const CATEGORY_DESENVOLVIMENTO = 'desenvolvimento';
    const CATEGORY_SUPORTE = 'suporte';
    const CATEGORY_MANUTENCAO = 'manutencao';
    const CATEGORY_INFRAESTRUTURA = 'infraestrutura';
    const CATEGORY_SEGURANCA = 'seguranca';
    const CATEGORY_DESIGN = 'design';
    const CATEGORY_TREINAMENTO = 'treinamento';

    // Unit types constants
    const UNIT_HOUR = 'hour';
    const UNIT_DAY = 'day';
    const UNIT_PROJECT = 'project';
    const UNIT_MONTHLY = 'monthly';

    public static function getCategories(): array
    {
        return [
            self::CATEGORY_CONSULTORIA => 'Consultoria',
            self::CATEGORY_DESENVOLVIMENTO => 'Desenvolvimento',
            self::CATEGORY_SUPORTE => 'Suporte Técnico',
            self::CATEGORY_MANUTENCAO => 'Manutenção',
            self::CATEGORY_INFRAESTRUTURA => 'Infraestrutura',
            self::CATEGORY_SEGURANCA => 'Segurança',
            self::CATEGORY_DESIGN => 'Design/UX',
            self::CATEGORY_TREINAMENTO => 'Treinamento',
        ];
    }

    public static function getUnits(): array
    {
        return [
            self::UNIT_HOUR => 'Por Hora',
            self::UNIT_DAY => 'Por Dia',
            self::UNIT_PROJECT => 'Por Projeto',
            self::UNIT_MONTHLY => 'Mensal',
        ];
    }

    public function serviceRates(): HasMany
    {
        return $this->hasMany(ServiceRate::class);
    }

    public function getFormattedRateAttribute(): string
    {
        return 'R$ ' . number_format($this->base_rate_per_hour, 2, ',', '.');
    }

    public function getEstimatedCostAttribute(): float
    {
        return $this->base_rate_per_hour * $this->estimated_hours;
    }

    public function getFormattedEstimatedCostAttribute(): string
    {
        return 'R$ ' . number_format($this->estimated_cost, 2, ',', '.');
    }

    public function getCategoryNameAttribute(): string
    {
        return self::getCategories()[$this->category] ?? $this->category;
    }

    public function getUnitNameAttribute(): string
    {
        return self::getUnits()[$this->unit] ?? $this->unit;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
