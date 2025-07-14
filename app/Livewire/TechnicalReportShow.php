<?php

namespace App\Livewire;

use App\Models\TechnicalReport;
use Livewire\Component;

class TechnicalReportShow extends Component
{
    public TechnicalReport $report;

    public function mount(TechnicalReport $report)
    {
        $this->report = $report->load(['customer', 'invoice']);
    }

    public function approve()
    {
        $this->report->approve(auth()->user()->name, 'Aprovado via sistema');
        
        $this->dispatch('report-approved', [
            'message' => 'Laudo técnico aprovado com sucesso!'
        ]);
    }

    public function reject()
    {
        $this->report->reject(auth()->user()->name, 'Rejeitado via sistema');
        
        $this->dispatch('report-rejected', [
            'message' => 'Laudo técnico rejeitado!'
        ]);
    }

    public function duplicate()
    {
        $newReport = $this->report->replicate();
        $newReport->report_number = null;
        $newReport->status = TechnicalReport::STATUS_DRAFT;
        $newReport->approved_at = null;
        $newReport->approved_by = null;
        $newReport->approval_notes = null;
        $newReport->report_date = now();
        $newReport->is_template = false;
        $newReport->template_name = null;
        $newReport->save();
        
        $newReport->update(['report_number' => $newReport->generateReportNumber()]);
        
        $this->dispatch('report-duplicated', [
            'message' => 'Laudo técnico duplicado com sucesso!'
        ]);
        
        $this->redirectRoute('technical-reports.edit', $newReport);
    }

    public function render()
    {
        return view('livewire.technical-report-show');
    }
}
