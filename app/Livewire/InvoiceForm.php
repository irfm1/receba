<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
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

    public function mount(?Invoice $invoice = null): void
    {
        if ($invoice && $invoice->exists) {
            $this->invoice = $invoice;
            $this->isEditing = true;
            $this->fill($invoice->toArray());
            $this->items = $invoice->items ?? [];
        } else {
            // Pre-select customer if provided in query string
            $this->customer_id = request('customer_id', '');
            
            $this->issue_date = now()->format('Y-m-d');
            $this->due_date = now()->addDays(30)->format('Y-m-d');
            $this->addItem();
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

    public function getSubtotalProperty(): float
    {
        return collect($this->items)->sum('total');
    }

    public function getTotalProperty(): float
    {
        return $this->subtotal - $this->discount_amount + $this->tax_amount;
    }

    public function save(): void
    {
        $this->validate();

        // Validate items
        foreach ($this->items as $index => $item) {
            if (empty($item['description'])) {
                $this->addError("items.{$index}.description", 'Descrição é obrigatória');
            }
            if ($item['quantity'] <= 0) {
                $this->addError("items.{$index}.quantity", 'Quantidade deve ser maior que zero');
            }
            if ($item['unit_price'] <= 0) {
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
        ]);
    }
}
