<?php

namespace App\Services;

class BrazilianTaxService
{
    // Alíquotas ISS por município (exemplos)
    private const ISS_RATES = [
        'sao_paulo' => 0.05,      // 5%
        'rio_janeiro' => 0.05,    // 5%
        'belo_horizonte' => 0.05, // 5%
        'salvador' => 0.05,       // 5%
        'brasilia' => 0.05,       // 5%
        'fortaleza' => 0.05,      // 5%
        'manaus' => 0.05,         // 5%
        'curitiba' => 0.05,       // 5%
        'recife' => 0.05,         // 5%
        'porto_alegre' => 0.05,   // 5%
        'default' => 0.05,        // 5% padrão
    ];

    // Faixas do Simples Nacional para TI
    private const SIMPLES_NACIONAL_ANEXO_III = [
        ['min' => 0, 'max' => 180000, 'rate' => 0.06, 'deduction' => 0],
        ['min' => 180000.01, 'max' => 360000, 'rate' => 0.112, 'deduction' => 9360],
        ['min' => 360000.01, 'max' => 720000, 'rate' => 0.135, 'deduction' => 17640],
        ['min' => 720000.01, 'max' => 1800000, 'rate' => 0.16, 'deduction' => 35640],
        ['min' => 1800000.01, 'max' => 3600000, 'rate' => 0.21, 'deduction' => 125640],
        ['min' => 3600000.01, 'max' => 4800000, 'rate' => 0.33, 'deduction' => 648000],
    ];

    // Faixas do Simples Nacional para Consultoria
    private const SIMPLES_NACIONAL_ANEXO_V = [
        ['min' => 0, 'max' => 180000, 'rate' => 0.155, 'deduction' => 0],
        ['min' => 180000.01, 'max' => 360000, 'rate' => 0.18, 'deduction' => 4500],
        ['min' => 360000.01, 'max' => 720000, 'rate' => 0.195, 'deduction' => 9900],
        ['min' => 720000.01, 'max' => 1800000, 'rate' => 0.205, 'deduction' => 17100],
        ['min' => 1800000.01, 'max' => 3600000, 'rate' => 0.23, 'deduction' => 62100],
        ['min' => 3600000.01, 'max' => 4800000, 'rate' => 0.305, 'deduction' => 540000],
    ];

    /**
     * Calcula ISS baseado no município
     */
    public function calculateISS(float $amount, string $city = 'default'): array
    {
        $rate = self::ISS_RATES[$city] ?? self::ISS_RATES['default'];
        $tax = $amount * $rate;

        return [
            'rate' => $rate,
            'amount' => $tax,
            'net_amount' => $amount - $tax,
            'city' => $city,
        ];
    }

    /**
     * Calcula impostos do Simples Nacional
     */
    public function calculateSimplesNacional(float $annualRevenue, float $monthlyAmount, string $annex = 'III'): array
    {
        $tables = $annex === 'V' ? self::SIMPLES_NACIONAL_ANEXO_V : self::SIMPLES_NACIONAL_ANEXO_III;
        
        // Encontra a faixa apropriada
        $bracket = null;
        foreach ($tables as $table) {
            if ($annualRevenue >= $table['min'] && $annualRevenue <= $table['max']) {
                $bracket = $table;
                break;
            }
        }

        if (!$bracket) {
            return [
                'error' => 'Faturamento anual excede limite do Simples Nacional',
                'rate' => 0,
                'amount' => 0,
                'net_amount' => $monthlyAmount,
            ];
        }

        // Calcula alíquota efetiva
        $effectiveRate = (($annualRevenue * $bracket['rate']) - $bracket['deduction']) / $annualRevenue;
        $tax = $monthlyAmount * $effectiveRate;

        return [
            'rate' => $effectiveRate,
            'amount' => $tax,
            'net_amount' => $monthlyAmount - $tax,
            'bracket' => $bracket,
            'annex' => $annex,
        ];
    }

    /**
     * Calcula INSS para autônomos
     */
    public function calculateINSS(float $amount): array
    {
        $minimumSalary = 1412.00; // Salário mínimo 2024
        $maxContribution = 908.85; // Teto INSS 2024
        
        // Limita ao teto
        $calculationBase = min($amount, 7507.49);
        
        // Calcula contribuição (20% para autônomos)
        $inss = min($calculationBase * 0.20, $maxContribution);

        return [
            'rate' => 0.20,
            'amount' => $inss,
            'calculation_base' => $calculationBase,
            'net_amount' => $amount - $inss,
        ];
    }

    /**
     * Calcula IRRF para pessoa física
     */
    public function calculateIRRF(float $amount): array
    {
        // Tabela IRRF 2024
        $brackets = [
            ['min' => 0, 'max' => 2112.00, 'rate' => 0, 'deduction' => 0],
            ['min' => 2112.01, 'max' => 2826.65, 'rate' => 0.075, 'deduction' => 158.40],
            ['min' => 2826.66, 'max' => 3751.05, 'rate' => 0.15, 'deduction' => 370.40],
            ['min' => 3751.06, 'max' => 4664.68, 'rate' => 0.225, 'deduction' => 651.73],
            ['min' => 4664.69, 'max' => PHP_FLOAT_MAX, 'rate' => 0.275, 'deduction' => 884.96],
        ];

        $bracket = null;
        foreach ($brackets as $b) {
            if ($amount >= $b['min'] && $amount <= $b['max']) {
                $bracket = $b;
                break;
            }
        }

        if (!$bracket) {
            return [
                'rate' => 0,
                'amount' => 0,
                'net_amount' => $amount,
            ];
        }

        $irrf = ($amount * $bracket['rate']) - $bracket['deduction'];
        $irrf = max(0, $irrf);

        return [
            'rate' => $bracket['rate'],
            'amount' => $irrf,
            'deduction' => $bracket['deduction'],
            'net_amount' => $amount - $irrf,
        ];
    }

    /**
     * Calcula todos os impostos para pessoa jurídica
     */
    public function calculateCorporateTaxes(float $amount, array $options = []): array
    {
        $city = $options['city'] ?? 'default';
        $annualRevenue = $options['annual_revenue'] ?? 0;
        $regime = $options['regime'] ?? 'simples'; // simples, presumido, real
        $annex = $options['annex'] ?? 'III';

        $taxes = [];

        // ISS
        $iss = $this->calculateISS($amount, $city);
        $taxes['iss'] = $iss;

        // Simples Nacional
        if ($regime === 'simples' && $annualRevenue > 0) {
            $simples = $this->calculateSimplesNacional($annualRevenue, $amount, $annex);
            $taxes['simples_nacional'] = $simples;
        }

        // Calcula totais
        $totalTax = 0;
        $netAmount = $amount;

        if ($regime === 'simples') {
            // No Simples Nacional, ISS já está incluído no DAS
            $totalTax = $taxes['simples_nacional']['amount'] ?? 0;
        } else {
            // Outros regimes - ISS separado
            $totalTax = $taxes['iss']['amount'];
        }

        $netAmount = $amount - $totalTax;

        return [
            'gross_amount' => $amount,
            'total_tax' => $totalTax,
            'net_amount' => $netAmount,
            'effective_rate' => $amount > 0 ? ($totalTax / $amount) : 0,
            'taxes' => $taxes,
            'regime' => $regime,
        ];
    }

    /**
     * Calcula impostos para pessoa física
     */
    public function calculateIndividualTaxes(float $amount, array $options = []): array
    {
        $city = $options['city'] ?? 'default';
        $withINSS = $options['with_inss'] ?? false;

        $taxes = [];

        // ISS
        $iss = $this->calculateISS($amount, $city);
        $taxes['iss'] = $iss;

        // INSS (se aplicável)
        if ($withINSS) {
            $inss = $this->calculateINSS($amount);
            $taxes['inss'] = $inss;
        }

        // IRRF
        $irrf = $this->calculateIRRF($amount);
        $taxes['irrf'] = $irrf;

        // Calcula totais
        $totalTax = $iss['amount'] + ($taxes['inss']['amount'] ?? 0) + $irrf['amount'];
        $netAmount = $amount - $totalTax;

        return [
            'gross_amount' => $amount,
            'total_tax' => $totalTax,
            'net_amount' => $netAmount,
            'effective_rate' => $amount > 0 ? ($totalTax / $amount) : 0,
            'taxes' => $taxes,
        ];
    }

    /**
     * Obtém alíquotas disponíveis por cidade
     */
    public function getAvailableCities(): array
    {
        return array_keys(self::ISS_RATES);
    }

    /**
     * Simula diferentes cenários de tributação
     */
    public function compareScenarios(float $amount, float $annualRevenue = 0): array
    {
        $scenarios = [];

        // Pessoa Física
        $scenarios['pessoa_fisica'] = $this->calculateIndividualTaxes($amount, ['with_inss' => true]);

        // Pessoa Jurídica - Simples Nacional
        if ($annualRevenue > 0) {
            $scenarios['simples_nacional_anexo_iii'] = $this->calculateCorporateTaxes($amount, [
                'annual_revenue' => $annualRevenue,
                'regime' => 'simples',
                'annex' => 'III'
            ]);

            $scenarios['simples_nacional_anexo_v'] = $this->calculateCorporateTaxes($amount, [
                'annual_revenue' => $annualRevenue,
                'regime' => 'simples',
                'annex' => 'V'
            ]);
        }

        return $scenarios;
    }
}
