<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\ServiceTemplate;
use App\Models\ServicePackage;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InvoiceForm extends Component
{
    public ?Invoice $invoice = null;

    #[Validate('required|exists:customers,id')]
    public $customer_id = '';

    #[Validate('required|date')]
    public $issue_date = '';

    #[Validate('required|date|after_or_equal:issue_date')]
    public $due_date = '';

    #[Validate('required|string|max:500')]
    public $description = '';

    #[Validate('nullable|numeric|min:0')]
    public $discount_amount = 0;

    #[Validate('nullable|numeric|min:0')]
    public $tax_amount = 0;

    #[Validate('required|in:draft,sent,paid,overdue,cancelled')]
    public $status = 'draft';

    #[Validate('nullable|string|max:1000')]
    public $notes = '';

    public array $items = [];
    public bool $isEditing = false;
    
    // Service integration
    public bool $use_services = false;
    public array $selectedServiceTemplates = [];
    public array $selectedServicePackages = [];
    public string $serviceTab = 'templates'; // 'templates' or 'packages'

    public function mount(?Invoice $invoice = null): void
    {
        if ($invoice && $invoice->exists) {
            $this->invoice = $invoice;
            $this->isEditing = true;
            $this->fill($invoice->toArray());
            $this->items = $invoice->items ?? [];
            $this->use_services = (bool) ($invoice->use_services ?? false);
            $this->selectedServiceTemplates = $invoice->service_templates ?? [];
            $this->selectedServicePackages = $invoice->service_packages ?? [];
        } else {
            // Pre-select customer if provided in query string
            $this->customer_id = request('customer_id', '');
            
            $this->issue_date = now()->format('Y-m-d');
            $this->due_date = now()->addDays(30)->format('Y-m-d');
            $this->use_services = false; // Explicitly set to false for new invoices
            
            if (!$this->use_services) {
                $this->addItem();
            }
        }
    }

    public function addItem(): void
    {
        $this->items[] = [
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'total' => 0,
        ];
    }

    public function removeItem(int $index): void
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems(): void
    {
        foreach ($this->items as $index => $item) {
            $this->items[$index]['total'] = $item['quantity'] * $item['unit_price'];
        }
    }

    public function updatedUseServices(): void
    {
        // Convert string to boolean
        $this->use_services = (bool) $this->use_services;
        
        if ($this->use_services) {
            // Clear manual items when switching to services
            $this->items = [];
        } else {
            // Clear services and add a default item
            $this->selectedServiceTemplates = [];
            $this->selectedServicePackages = [];
            if (empty($this->items)) {
                $this->addItem();
            }
        }
    }

    public function toggleServiceTemplate($templateId): void
    {
        $existingIndex = collect($this->selectedServiceTemplates)->search(function ($item) use ($templateId) {
            return $item['id'] == $templateId;
        });

        if ($existingIndex !== false) {
            unset($this->selectedServiceTemplates[$existingIndex]);
            $this->selectedServiceTemplates = array_values($this->selectedServiceTemplates);
        } else {
            $template = ServiceTemplate::find($templateId);
            if ($template) {
                $this->selectedServiceTemplates[] = [
                    'id' => $template->id,
                    'quantity' => 1,
                    'hours' => $template->estimated_hours ?? 1,
                    'rate' => $template->base_rate_per_hour,
                ];
            }
        }
    }

    public function toggleServicePackage($packageId): void
    {
        $existingIndex = collect($this->selectedServicePackages)->search(function ($item) use ($packageId) {
            return $item['id'] == $packageId;
        });

        if ($existingIndex !== false) {
            unset($this->selectedServicePackages[$existingIndex]);
            $this->selectedServicePackages = array_values($this->selectedServicePackages);
        } else {
            $package = ServicePackage::find($packageId);
            if ($package) {
                $this->selectedServicePackages[] = [
                    'id' => $package->id,
                    'quantity' => 1,
                    'price' => $package->discounted_price,
                ];
            }
        }
    }

    public function updateServiceTemplate($index, $field, $value): void
    {
        if (isset($this->selectedServiceTemplates[$index])) {
            $this->selectedServiceTemplates[$index][$field] = $value;
        }
    }

    public function updateServicePackage($index, $field, $value): void
    {
        if (isset($this->selectedServicePackages[$index])) {
            $this->selectedServicePackages[$index][$field] = $value;
        }
    }

    public function calculateServiceSubtotal(): float
    {
        $templateTotal = collect($this->selectedServiceTemplates)->sum(function ($item) {
            return ($item['quantity'] ?? 1) * ($item['hours'] ?? 1) * ($item['rate'] ?? 0);
        });

        $packageTotal = collect($this->selectedServicePackages)->sum(function ($item) {
            return ($item['quantity'] ?? 1) * ($item['price'] ?? 0);
        });

        return $templateTotal + $packageTotal;
    }

    public function getSubtotalProperty(): float
    {
        if ($this->use_services) {
            return $this->calculateServiceSubtotal();
        }
        return collect($this->items)->sum('total');
    }

    public function getTotalProperty(): float
    {
        return $this->subtotal - $this->discount_amount + $this->tax_amount;
    }

    public function generateItemsFromServices(): void
    {
        $this->items = [];
        
        // Add service templates as items
        foreach ($this->selectedServiceTemplates as $serviceData) {
            $template = ServiceTemplate::find($serviceData['id']);
            if ($template) {
                $this->items[] = [
                    'description' => $template->name . ($template->description ? ' - ' . $template->description : ''),
                    'quantity' => $serviceData['hours'] ?? $template->estimated_hours ?? 1,
                    'unit_price' => $serviceData['rate'] ?? $template->base_rate_per_hour,
                    'total' => ($serviceData['quantity'] ?? 1) * ($serviceData['hours'] ?? $template->estimated_hours ?? 1) * ($serviceData['rate'] ?? $template->base_rate_per_hour),
                ];
            }
        }
        
        // Add service packages as items
        foreach ($this->selectedServicePackages as $packageData) {
            $package = ServicePackage::find($packageData['id']);
            if ($package) {
                $this->items[] = [
                    'description' => $package->name . ($package->description ? ' - ' . $package->description : ''),
                    'quantity' => $packageData['quantity'] ?? 1,
                    'unit_price' => $packageData['price'] ?? $package->discounted_price,
                    'total' => ($packageData['quantity'] ?? 1) * ($packageData['price'] ?? $package->discounted_price),
                ];
            }
        }
    }

    public function save(): void
    {
        $this->validate();

        // Generate items from services if using services
        if ($this->use_services) {
            $this->generateItemsFromServices();
        }

        // Validate items
        if (empty($this->items)) {
            $this->addError('items', 'Pelo menos um item é obrigatório');
            return;
        }

        foreach ($this->items as $index => $item) {
            if (empty($item['description'])) {
                $this->addError("items.{$index}.description", 'Descrição é obrigatória');
            }
            if (($item['quantity'] ?? 0) <= 0) {
                $this->addError("items.{$index}.quantity", 'Quantidade deve ser maior que zero');
            }
            if (($item['unit_price'] ?? 0) <= 0) {
                $this->addError("items.{$index}.unit_price", 'Preço unitário deve ser maior que zero');
            }
        }

        if ($this->getErrorBag()->isNotEmpty()) {
            return;
        }

        $data = [
            'customer_id' => $this->customer_id,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'description' => $this->description,
            'subtotal' => $this->subtotal,
            'discount_amount' => $this->discount_amount,
            'tax_amount' => $this->tax_amount,
            'total_amount' => $this->total,
            'status' => $this->status,
            'items' => $this->items,
            'notes' => $this->notes,
            'use_services' => $this->use_services,
            'service_templates' => $this->use_services ? $this->selectedServiceTemplates : null,
            'service_packages' => $this->use_services ? $this->selectedServicePackages : null,
        ];

        if ($this->isEditing) {
            $this->invoice->update($data);
            $message = 'Fatura atualizada com sucesso!';
        } else {
            $invoice = Invoice::create($data);
            // Generate invoice number if not editing
            $invoice->update(['invoice_number' => $invoice->generateInvoiceNumber()]);
            $message = 'Fatura criada com sucesso!';
        }

        $this->dispatch('invoice-saved', [
            'message' => $message
        ]);

        $this->redirectRoute('invoices.index');
    }

    public function render()
    {
        return view('livewire.invoice-form', [
            'customers' => Customer::orderBy('name')->get(),
            'statuses' => Invoice::getStatuses(),
            'serviceTemplates' => ServiceTemplate::active()->orderBy('name')->get(),
            'servicePackages' => ServicePackage::active()->validNow()->orderBy('name')->get(),
        ]);
    }
}
