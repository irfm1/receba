<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;
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

    public function sendInvoiceEmail(): void
    {
        try {
            Mail::to($this->invoice->customer->email)
                ->send(new InvoiceMail($this->invoice));
            
            $this->dispatch('invoice-email-sent', [
                'message' => 'Fatura enviada com sucesso para ' . $this->invoice->customer->email
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('invoice-email-error', [
                'message' => 'Erro ao enviar email: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.invoice-show', [
            'statuses' => Invoice::getStatuses(),
        ]);
    }
}
