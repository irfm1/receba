<?php

namespace App\Livewire;

use App\Models\ServiceTemplate;
use Livewire\Component;

class ServiceTemplateForm extends Component
{
    public $templateId;
    public $name = '';
    public $description = '';
    public $category = '';
    public $base_rate_per_hour = '';
    public $unit = 'hour';
    public $estimated_hours = '';
    public $is_active = true;
    public $tags = [];
    public $requirements = [];
    public $deliverables = [];
    public $newTag = '';
    public $newRequirement = '';
    public $newDeliverable = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|string',
        'base_rate_per_hour' => 'required|numeric|min:0',
        'unit' => 'required|string',
        'estimated_hours' => 'nullable|numeric|min:0',
        'is_active' => 'boolean',
        'tags' => 'array',
        'requirements' => 'array',
        'deliverables' => 'array',
    ];

    protected $messages = [
        'name.required' => 'O nome é obrigatório.',
        'description.required' => 'A descrição é obrigatória.',
        'category.required' => 'A categoria é obrigatória.',
        'base_rate_per_hour.required' => 'O valor por hora é obrigatório.',
        'base_rate_per_hour.numeric' => 'O valor por hora deve ser um número.',
        'base_rate_per_hour.min' => 'O valor por hora deve ser maior que zero.',
    ];

    public function mount($templateId = null)
    {
        if ($templateId) {
            $this->templateId = $templateId;
            $this->loadTemplate();
        }
    }

    public function loadTemplate()
    {
        $template = ServiceTemplate::findOrFail($this->templateId);
        
        $this->name = $template->name;
        $this->description = $template->description;
        $this->category = $template->category;
        $this->base_rate_per_hour = $template->base_rate_per_hour;
        $this->unit = $template->unit;
        $this->estimated_hours = $template->estimated_hours;
        $this->is_active = $template->is_active;
        $this->tags = $template->tags ?? [];
        $this->requirements = $template->requirements ?? [];
        $this->deliverables = $template->deliverables ?? [];
    }

    public function addTag()
    {
        if (trim($this->newTag) && !in_array(trim($this->newTag), $this->tags)) {
            $this->tags[] = trim($this->newTag);
            $this->newTag = '';
        }
    }

    public function removeTag($index)
    {
        unset($this->tags[$index]);
        $this->tags = array_values($this->tags);
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

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'base_rate_per_hour' => $this->base_rate_per_hour,
            'unit' => $this->unit,
            'estimated_hours' => $this->estimated_hours,
            'is_active' => $this->is_active,
            'tags' => $this->tags,
            'requirements' => $this->requirements,
            'deliverables' => $this->deliverables,
        ];

        if ($this->templateId) {
            ServiceTemplate::find($this->templateId)->update($data);
            session()->flash('message', 'Template de serviço atualizado com sucesso!');
        } else {
            ServiceTemplate::create($data);
            session()->flash('message', 'Template de serviço criado com sucesso!');
        }

        return redirect()->route('service-templates.index');
    }

    public function render()
    {
        $categories = ServiceTemplate::getCategories();
        $units = ServiceTemplate::getUnits();

        return view('livewire.service-template-form', [
            'categories' => $categories,
            'units' => $units,
        ]);
    }
}
