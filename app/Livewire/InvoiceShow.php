<?php

namespace App\Livewire;

use App\Models\Invoice;
use Livewire\Component;

class InvoiceShow extends Component
{
    public Invoice $invoice;

    public function mount(Invoice $invoice): void
    {
        $this->invoice = $invoice->load('customer');
    }

    public function deleteInvoice(): void
    {
        $this->invoice->delete();
        
        $this->dispatch('invoice-deleted', [
            'message' => 'Fatura excluída com sucesso!'
        ]);

        $this->redirectRoute('invoices.index');
    }

    public function updateStatus(string $status): void
    {
        $this->invoice->update(['status' => $status]);
        
        $this->dispatch('invoice-updated', [
            'message' => 'Status da fatura atualizado com sucesso!'
        ]);
        
        // Refresh the invoice
        $this->invoice = $this->invoice->fresh();
    }

    public function edit(): void
    {
        $this->redirectRoute('invoices.edit', $this->invoice);
    }

    public function render()
    {
        return view('livewire.invoice-show', [
            'statuses' => Invoice::getStatuses(),
        ]);
    }
}
