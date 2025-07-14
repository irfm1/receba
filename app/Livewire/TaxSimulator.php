<?php

namespace App\Livewire;

use App\Services\BrazilianTaxService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Simulador de Impostos')]
class TaxSimulator extends Component
{
    public $amount = 5000;
    public $annualRevenue = 180000;
    public $city = 'sao_paulo';
    public $regime = 'simples';
    public $annex = 'III';
    public $withINSS = true;
    
    public $results = [];
    public $comparison = [];
    
    protected $rules = [
        'amount' => 'required|numeric|min:0',
        'annualRevenue' => 'nullable|numeric|min:0',
        'city' => 'required|string',
        'regime' => 'required|in:simples,presumido,real,pessoa_fisica',
        'annex' => 'required|in:III,V',
        'withINSS' => 'boolean',
    ];

    public function mount()
    {
        $this->calculate();
    }

    public function updated($property)
    {
        $this->validateOnly($property);
        $this->calculate();
    }

    public function calculate()
    {
        $taxService = new BrazilianTaxService();
        
        if ($this->regime === 'pessoa_fisica') {
            $this->results = $taxService->calculateIndividualTaxes($this->amount, [
                'city' => $this->city,
                'with_inss' => $this->withINSS,
            ]);
        } else {
            $this->results = $taxService->calculateCorporateTaxes($this->amount, [
                'city' => $this->city,
                'annual_revenue' => $this->annualRevenue,
                'regime' => $this->regime,
                'annex' => $this->annex,
            ]);
        }
        
        // Comparação entre cenários
        $this->comparison = $taxService->compareScenarios($this->amount, $this->annualRevenue);
    }

    public function getCitiesProperty()
    {
        return [
            'sao_paulo' => 'São Paulo',
            'rio_janeiro' => 'Rio de Janeiro',
            'belo_horizonte' => 'Belo Horizonte',
            'salvador' => 'Salvador',
            'brasilia' => 'Brasília',
            'fortaleza' => 'Fortaleza',
            'manaus' => 'Manaus',
            'curitiba' => 'Curitiba',
            'recife' => 'Recife',
            'porto_alegre' => 'Porto Alegre',
            'default' => 'Outro município',
        ];
    }

    public function render()
    {
        return view('livewire.tax-simulator', [
            'cities' => $this->cities,
        ]);
    }
}
