<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'document_type',
        'document_number',
        'address_street',
        'address_number',
        'address_complement',
        'address_neighborhood',
        'address_city',
        'address_state',
        'address_postal_code',
        'company_name',
        'contact_person',
        'category',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Customer categories constants
    const CATEGORY_INDIVIDUAL = 'individual';
    const CATEGORY_MEI = 'mei';
    const CATEGORY_SMALL_BUSINESS = 'small_business';
    const CATEGORY_LARGE_BUSINESS = 'large_business';

    // Document types constants
    const DOCUMENT_CPF = 'cpf';
    const DOCUMENT_CNPJ = 'cnpj';

    public static function getCategories(): array
    {
        return [
            self::CATEGORY_INDIVIDUAL => 'Pessoa Física',
            self::CATEGORY_MEI => 'MEI',
            self::CATEGORY_SMALL_BUSINESS => 'Pequena Empresa',
            self::CATEGORY_LARGE_BUSINESS => 'Grande Empresa',
        ];
    }

    public static function getDocumentTypes(): array
    {
        return [
            self::DOCUMENT_CPF => 'CPF',
            self::DOCUMENT_CNPJ => 'CNPJ',
        ];
    }

    public function getCategoryNameAttribute(): string
    {
        return self::getCategories()[$this->category] ?? '';
    }

    public function getDocumentTypeNameAttribute(): string
    {
        return self::getDocumentTypes()[$this->document_type] ?? '';
    }

    public function getFormattedDocumentAttribute(): string
    {
        if (!$this->document_number) {
            return '';
        }

        if ($this->document_type === self::DOCUMENT_CPF) {
            return $this->formatCpf($this->document_number);
        }

        if ($this->document_type === self::DOCUMENT_CNPJ) {
            return $this->formatCnpj($this->document_number);
        }

        return $this->document_number;
    }

    public function getFullAddressAttribute(): string
    {
        $address = [];
        
        if ($this->address_street) {
            $street = $this->address_street;
            if ($this->address_number) {
                $street .= ', ' . $this->address_number;
            }
            if ($this->address_complement) {
                $street .= ' - ' . $this->address_complement;
            }
            $address[] = $street;
        }

        if ($this->address_neighborhood) {
            $address[] = $this->address_neighborhood;
        }

        if ($this->address_city) {
            $cityState = $this->address_city;
            if ($this->address_state) {
                $cityState .= ' - ' . $this->address_state;
            }
            $address[] = $cityState;
        }

        if ($this->address_postal_code) {
            $address[] = 'CEP: ' . $this->formatPostalCode($this->address_postal_code);
        }

        return implode(', ', $address);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function technicalReports(): HasMany
    {
        return $this->hasMany(TechnicalReport::class);
    }

    private function formatCpf(string $cpf): string
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }

    private function formatCnpj(string $cnpj): string
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
    }

    private function formatPostalCode(string $postalCode): string
    {
        $postalCode = preg_replace('/\D/', '', $postalCode);
        return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $postalCode);
    }
}
