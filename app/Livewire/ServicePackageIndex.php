<?php

namespace App\Livewire;

use App\Models\ServicePackage;
use Livewire\Component;
use Livewire\WithPagination;

class ServicePackageIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $activeFilter = 'all';
    public $showDeleteModal = false;
    public $packageToDelete = null;

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

    public function confirmDelete($packageId)
    {
        $this->packageToDelete = $packageId;
        $this->showDeleteModal = true;
    }

    public function deletePackage()
    {
        if ($this->packageToDelete) {
            ServicePackage::find($this->packageToDelete)->delete();
            $this->showDeleteModal = false;
            $this->packageToDelete = null;
            
            session()->flash('message', 'Pacote de serviços excluído com sucesso!');
        }
    }

    public function toggleActive($packageId)
    {
        $package = ServicePackage::find($packageId);
        $package->update(['is_active' => !$package->is_active]);
        
        $status = $package->is_active ? 'ativado' : 'desativado';
        session()->flash('message', "Pacote {$status} com sucesso!");
    }

    public function render()
    {
        $query = ServicePackage::query()->with('serviceTemplates');

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

        $packages = $query->orderBy('name')->paginate(10);
        $categories = ServicePackage::getCategories();

        return view('livewire.service-package-index', [
            'packages' => $packages,
            'categories' => $categories,
        ]);
    }
}
