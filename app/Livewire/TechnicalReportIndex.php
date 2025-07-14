<?php

namespace App\Livewire;

use App\Models\TechnicalReport;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class TechnicalReportIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $typeFilter = '';
    public string $sortBy = 'report_date';
    public string $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'sortBy' => ['except' => 'report_date'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteReport($reportId)
    {
        $report = TechnicalReport::findOrFail($reportId);
        $report->delete();
        
        $this->dispatch('report-deleted', [
            'message' => 'Laudo técnico excluído com sucesso!'
        ]);
    }

    #[Computed]
    public function reports()
    {
        return TechnicalReport::with(['customer', 'invoice'])
            ->notTemplates()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('report_number', 'like', '%' . $this->search . '%')
                      ->orWhere('service_order_number', 'like', '%' . $this->search . '%')
                      ->orWhere('technician_name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('customer', function ($customer) {
                          $customer->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('report_type', $this->typeFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.technical-report-index', [
            'statuses' => TechnicalReport::getStatuses(),
            'reportTypes' => TechnicalReport::getReportTypes(),
        ]);
    }
}
