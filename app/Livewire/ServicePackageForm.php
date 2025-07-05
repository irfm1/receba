<?php

namespace App\Livewire;

use App\Models\ServicePackage;
use App\Models\ServiceTemplate;
use Livewire\Component;

class ServicePackageForm extends Component
{
    public $packageId;
    public $name = '';
    public $description = '';
    public $category = '';
    public $fixed_price = '';
    public $estimated_duration_days = '';
    public $is_active = true;
    public $features = [];
    public $requirements = [];
    public $deliverables = [];
    public $terms_conditions = [];
    public $discount_percentage = 0;
    public $valid_from = '';
    public $valid_until = '';
    public $selectedServices = [];
    
    public $newFeature = '';
    public $newRequirement = '';
    public $newDeliverable = '';
    public $newTerm = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|string',
        'fixed_price' => 'required|numeric|min:0',
        'estimated_duration_days' => 'nullable|integer|min:1',
        'is_active' => 'boolean',
        'discount_percentage' => 'nullable|numeric|min:0|max:100',
        'valid_from' => 'nullable|date',
        'valid_until' => 'nullable|date|after_or_equal:valid_from',
        'features' => 'array',
        'requirements' => 'array',
        'deliverables' => 'array',
        'terms_conditions' => 'array',
        'selectedServices' => 'array',
    ];

    protected $messages = [
        'name.required' => 'O nome é obrigatório.',
        'description.required' => 'A descrição é obrigatória.',
        'category.required' => 'A categoria é obrigatória.',
        'fixed_price.required' => 'O preço fixo é obrigatório.',
        'fixed_price.numeric' => 'O preço fixo deve ser um número.',
        'valid_until.after_or_equal' => 'A data final deve ser posterior à data inicial.',
    ];

    public function mount($packageId = null)
    {
        if ($packageId) {
            $this->packageId = $packageId;
            $this->loadPackage();
        }
    }

    public function loadPackage()
    {
        $package = ServicePackage::with('serviceTemplates')->findOrFail($this->packageId);
        
        $this->name = $package->name;
        $this->description = $package->description;
        $this->category = $package->category;
        $this->fixed_price = $package->fixed_price;
        $this->estimated_duration_days = $package->estimated_duration_days;
        $this->is_active = $package->is_active;
        $this->features = $package->features ?? [];
        $this->requirements = $package->requirements ?? [];
        $this->deliverables = $package->deliverables ?? [];
        $this->terms_conditions = $package->terms_conditions ?? [];
        $this->discount_percentage = $package->discount_percentage;
        $this->valid_from = $package->valid_from?->format('Y-m-d');
        $this->valid_until = $package->valid_until?->format('Y-m-d');
        
        // Load selected services
        foreach ($package->serviceTemplates as $service) {
            $this->selectedServices[$service->id] = [
                'id' => $service->id,
                'name' => $service->name,
                'quantity' => $service->pivot->quantity,
                'estimated_hours' => $service->pivot->estimated_hours,
                'custom_rate' => $service->pivot->custom_rate,
            ];
        }
    }

    public function addFeature()
    {
        if (trim($this->newFeature) && !in_array(trim($this->newFeature), $this->features)) {
            $this->features[] = trim($this->newFeature);
            $this->newFeature = '';
        }
    }

    public function removeFeature($index)
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function addRequirement()
    {
        if (trim($this->newRequirement) && !in_array(trim($this->newRequirement), $this->requirements)) {
            $this->requirements[] = trim($this->newRequirement);
            $this->newRequirement = '';
        }
    }

    public function removeRequirement($index)
    {
        unset($this->requirements[$index]);
        $this->requirements = array_values($this->requirements);
    }

    public function addDeliverable()
    {
        if (trim($this->newDeliverable) && !in_array(trim($this->newDeliverable), $this->deliverables)) {
            $this->deliverables[] = trim($this->newDeliverable);
            $this->newDeliverable = '';
        }
    }

    public function removeDeliverable($index)
    {
        unset($this->deliverables[$index]);
        $this->deliverables = array_values($this->deliverables);
    }

    public function addTerm()
    {
        if (trim($this->newTerm) && !in_array(trim($this->newTerm), $this->terms_conditions)) {
            $this->terms_conditions[] = trim($this->newTerm);
            $this->newTerm = '';
        }
    }

    public function removeTerm($index)
    {
        unset($this->terms_conditions[$index]);
        $this->terms_conditions = array_values($this->terms_conditions);
    }

    public function addService($serviceId)
    {
        $service = ServiceTemplate::find($serviceId);
        if ($service && !isset($this->selectedServices[$serviceId])) {
            $this->selectedServices[$serviceId] = [
                'id' => $service->id,
                'name' => $service->name,
                'quantity' => 1,
                'estimated_hours' => $service->estimated_hours,
                'custom_rate' => $service->base_rate_per_hour,
            ];
        }
    }

    public function removeService($serviceId)
    {
        unset($this->selectedServices[$serviceId]);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'fixed_price' => $this->fixed_price,
            'estimated_duration_days' => $this->estimated_duration_days,
            'is_active' => $this->is_active,
            'features' => $this->features,
            'requirements' => $this->requirements,
            'deliverables' => $this->deliverables,
            'terms_conditions' => $this->terms_conditions,
            'discount_percentage' => $this->discount_percentage,
            'valid_from' => $this->valid_from ?: null,
            'valid_until' => $this->valid_until ?: null,
        ];

        if ($this->packageId) {
            $package = ServicePackage::find($this->packageId);
            $package->update($data);
            session()->flash('message', 'Pacote de serviços atualizado com sucesso!');
        } else {
            $package = ServicePackage::create($data);
            session()->flash('message', 'Pacote de serviços criado com sucesso!');
        }

        // Sync services
        $syncData = [];
        foreach ($this->selectedServices as $serviceData) {
            $syncData[$serviceData['id']] = [
                'quantity' => $serviceData['quantity'],
                'estimated_hours' => $serviceData['estimated_hours'],
                'custom_rate' => $serviceData['custom_rate'],
            ];
        }
        $package->serviceTemplates()->sync($syncData);

        return redirect()->route('service-packages.index');
    }

    public function render()
    {
        $categories = ServicePackage::getCategories();
        $availableServices = ServiceTemplate::active()->get();

        return view('livewire.service-package-form', [
            'categories' => $categories,
            'availableServices' => $availableServices,
        ]);
    }
}
