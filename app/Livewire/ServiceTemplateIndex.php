<?php

namespace App\Livewire;

use App\Models\ServiceTemplate;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceTemplateIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $activeFilter = 'all';
    public $showDeleteModal = false;
    public $templateToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'activeFilter' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingActiveFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($templateId)
    {
        $this->templateToDelete = $templateId;
        $this->showDeleteModal = true;
    }

    public function deleteTemplate()
    {
        if ($this->templateToDelete) {
            ServiceTemplate::find($this->templateToDelete)->delete();
            $this->showDeleteModal = false;
            $this->templateToDelete = null;
            
            session()->flash('message', 'Template de serviço excluído com sucesso!');
        }
    }

    public function toggleActive($templateId)
    {
        $template = ServiceTemplate::find($templateId);
        $template->update(['is_active' => !$template->is_active]);
        
        $status = $template->is_active ? 'ativado' : 'desativado';
        session()->flash('message', "Template {$status} com sucesso!");
    }

    public function render()
    {
        $query = ServiceTemplate::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        if ($this->activeFilter !== 'all') {
            $query->where('is_active', $this->activeFilter === 'active');
        }

        $templates = $query->orderBy('name')->paginate(10);
        $categories = ServiceTemplate::getCategories();

        return view('livewire.service-template-index', [
            'templates' => $templates,
            'categories' => $categories,
        ]);
    }
}
