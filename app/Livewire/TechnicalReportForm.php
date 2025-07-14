<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\TechnicalReport;
use Livewire\Component;
use Livewire\WithFileUploads;

class TechnicalReportForm extends Component
{
    use WithFileUploads;

    public ?TechnicalReport $report = null;
    public bool $isEditing = false;

    // Basic fields
    public string $customer_id = '';
    public string $invoice_id = '';
    public string $service_order_number = '';
    public string $title = '';
    public string $description = '';
    public string $inspection_date = '';
    public string $report_date = '';
    public string $technician_name = '';
    public string $technician_registration = '';
    public string $report_type = 'diagnostico';
    public string $findings = '';
    public string $recommendations = '';
    public string $observations = '';
    public string $status = 'draft';
    public string $valid_until = '';
    public bool $is_template = false;
    public string $template_name = '';

    // Dynamic arrays
    public array $equipment_analyzed = [];
    public array $attachments = [];
    public array $uploadedFiles = [];

    // Temp fields for adding items
    public string $newEquipmentName = '';
    public string $newEquipmentModel = '';
    public string $newEquipmentSerial = '';
    public string $newEquipmentStatus = '';

    protected $rules = [
        'customer_id' => 'required|exists:customers,id',
        'invoice_id' => 'nullable|exists:invoices,id',
        'service_order_number' => 'nullable|string|max:255',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'inspection_date' => 'required|date',
        'report_date' => 'required|date',
        'technician_name' => 'required|string|max:255',
        'technician_registration' => 'nullable|string|max:255',
        'report_type' => 'required|in:instalacao,manutencao,diagnostico,seguranca,performance,infraestrutura,outros',
        'findings' => 'required|string',
        'recommendations' => 'required|string',
        'observations' => 'nullable|string',
        'status' => 'required|in:draft,completed,approved,rejected',
        'valid_until' => 'nullable|date|after:report_date',
        'is_template' => 'boolean',
        'template_name' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'customer_id.required' => 'O cliente é obrigatório.',
        'title.required' => 'O título é obrigatório.',
        'description.required' => 'A descrição é obrigatória.',
        'inspection_date.required' => 'A data de inspeção é obrigatória.',
        'report_date.required' => 'A data do laudo é obrigatória.',
        'technician_name.required' => 'O nome do técnico é obrigatório.',
        'findings.required' => 'As constatações são obrigatórias.',
        'recommendations.required' => 'As recomendações são obrigatórias.',
        'valid_until.after' => 'A data de validade deve ser posterior à data do laudo.',
    ];

    public function mount(?TechnicalReport $report = null): void
    {
        if ($report && $report->exists) {
            $this->report = $report;
            $this->isEditing = true;
            $this->fill($report->toArray());
            $this->equipment_analyzed = $report->equipment_analyzed ?? [];
            $this->attachments = $report->attachments ?? [];
            $this->inspection_date = $report->inspection_date?->format('Y-m-d') ?? '';
            $this->report_date = $report->report_date?->format('Y-m-d') ?? '';
            $this->valid_until = $report->valid_until?->format('Y-m-d') ?? '';
        } else {
            // Pre-select customer and invoice if provided in query string
            $this->customer_id = request('customer_id', '');
            $this->invoice_id = request('invoice_id', '');
            $this->service_order_number = request('service_order_number', '');
            
            $this->inspection_date = now()->format('Y-m-d');
            $this->report_date = now()->format('Y-m-d');
            $this->technician_name = auth()->user()->name ?? '';
        }
    }

    public function addEquipment(): void
    {
        if (empty($this->newEquipmentName)) {
            return;
        }

        $this->equipment_analyzed[] = [
            'name' => $this->newEquipmentName,
            'model' => $this->newEquipmentModel,
            'serial' => $this->newEquipmentSerial,
            'status' => $this->newEquipmentStatus,
            'analyzed_at' => now()->toISOString(),
        ];

        $this->reset(['newEquipmentName', 'newEquipmentModel', 'newEquipmentSerial', 'newEquipmentStatus']);
    }

    public function removeEquipment(int $index): void
    {
        unset($this->equipment_analyzed[$index]);
        $this->equipment_analyzed = array_values($this->equipment_analyzed);
    }

    public function uploadFiles(): void
    {
        $this->validate([
            'uploadedFiles.*' => 'file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt',
        ]);

        foreach ($this->uploadedFiles as $file) {
            $filename = $file->getClientOriginalName();
            $path = $file->store('technical-reports', 'public');
            
            $this->attachments[] = [
                'filename' => $filename,
                'path' => $path,
                'type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'uploaded_at' => now()->toISOString(),
            ];
        }

        $this->uploadedFiles = [];
    }

    public function removeAttachment(int $index): void
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    public function loadTemplate(int $templateId): void
    {
        $template = TechnicalReport::templates()->findOrFail($templateId);
        
        $this->title = $template->title;
        $this->description = $template->description;
        $this->report_type = $template->report_type;
        $this->findings = $template->findings;
        $this->recommendations = $template->recommendations;
        $this->observations = $template->observations;
        $this->equipment_analyzed = $template->equipment_analyzed ?? [];
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'customer_id' => $this->customer_id,
            'invoice_id' => $this->invoice_id ?: null,
            'service_order_number' => $this->service_order_number ?: null,
            'title' => $this->title,
            'description' => $this->description,
            'inspection_date' => $this->inspection_date,
            'report_date' => $this->report_date,
            'technician_name' => $this->technician_name,
            'technician_registration' => $this->technician_registration,
            'report_type' => $this->report_type,
            'equipment_analyzed' => $this->equipment_analyzed,
            'findings' => $this->findings,
            'recommendations' => $this->recommendations,
            'observations' => $this->observations,
            'attachments' => $this->attachments,
            'status' => $this->status,
            'valid_until' => $this->valid_until ?: null,
            'is_template' => $this->is_template,
            'template_name' => $this->template_name,
        ];

        if ($this->isEditing) {
            $this->report->update($data);
            $message = 'Laudo técnico atualizado com sucesso!';
        } else {
            $report = TechnicalReport::create($data);
            $report->update(['report_number' => $report->generateReportNumber()]);
            $message = 'Laudo técnico criado com sucesso!';
        }

        $this->dispatch('report-saved', [
            'message' => $message
        ]);

        $this->redirectRoute('technical-reports.index');
    }

    public function render()
    {
        return view('livewire.technical-report-form', [
            'customers' => Customer::orderBy('name')->get(),
            'invoices' => $this->customer_id ? Invoice::where('customer_id', $this->customer_id)->orderBy('created_at', 'desc')->get() : collect(),
            'reportTypes' => TechnicalReport::getReportTypes(),
            'statuses' => TechnicalReport::getStatuses(),
            'templates' => TechnicalReport::templates()->orderBy('template_name')->get(),
        ]);
    }
}
