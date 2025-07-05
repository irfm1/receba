<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;

class CustomerShow extends Component
{
    public Customer $customer;

    public function mount(Customer $customer): void
    {
        $this->customer = $customer->load('invoices');
    }

    public function deleteCustomer(): void
    {
        $this->customer->delete();
        
        $this->dispatch('customer-deleted', [
            'message' => 'Cliente excluído com sucesso!'
        ]);

        $this->redirectRoute('customers.index');
    }

    public function render()
    {
        return view('livewire.customer-show');
    }
}
