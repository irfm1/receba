<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CustomerForm extends Component
{
    public ?Customer $customer = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|email|max:255')]
    public ?string $email = null;

    #[Validate('nullable|string|max:20')]
    public ?string $phone = null;

    #[Validate('nullable|in:cpf,cnpj')]
    public ?string $document_type = null;

    #[Validate('nullable|string|max:20')]
    public ?string $document_number = null;

    #[Validate('nullable|string|max:255')]
    public ?string $address_street = null;

    #[Validate('nullable|string|max:10')]
    public ?string $address_number = null;

    #[Validate('nullable|string|max:100')]
    public ?string $address_complement = null;

    #[Validate('nullable|string|max:100')]
    public ?string $address_neighborhood = null;

    #[Validate('nullable|string|max:100')]
    public ?string $address_city = null;

    #[Validate('nullable|string|size:2')]
    public ?string $address_state = null;

    #[Validate('nullable|string|max:9')]
    public ?string $address_postal_code = null;

    #[Validate('nullable|string|max:255')]
    public ?string $company_name = null;

    #[Validate('nullable|string|max:255')]
    public ?string $contact_person = null;

    #[Validate('required|in:individual,mei,small_business,large_business')]
    public string $category = 'individual';

    #[Validate('nullable|string|max:1000')]
    public ?string $notes = null;

    public bool $isEditing = false;

    public function mount(?Customer $customer = null): void
    {
        if ($customer && $customer->exists) {
            $this->customer = $customer;
            $this->isEditing = true;
            $this->fill($customer->toArray());
        }
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'document_type' => $this->document_type,
            'document_number' => $this->document_number ? preg_replace('/\D/', '', $this->document_number) : null,
            'address_street' => $this->address_street,
            'address_number' => $this->address_number,
            'address_complement' => $this->address_complement,
            'address_neighborhood' => $this->address_neighborhood,
            'address_city' => $this->address_city,
            'address_state' => $this->address_state,
            'address_postal_code' => $this->address_postal_code ? preg_replace('/\D/', '', $this->address_postal_code) : null,
            'company_name' => $this->company_name,
            'contact_person' => $this->contact_person,
            'category' => $this->category,
            'notes' => $this->notes,
        ];

        if ($this->isEditing) {
            $this->customer->update($data);
            $message = 'Cliente atualizado com sucesso!';
        } else {
            Customer::create($data);
            $message = 'Cliente criado com sucesso!';
        }

        $this->dispatch('customer-saved', [
            'message' => $message
        ]);

        $this->redirectRoute('customers.index');
    }

    public function render()
    {
        return view('livewire.customer-form', [
            'categories' => Customer::getCategories(),
            'documentTypes' => Customer::getDocumentTypes(),
        ]);
    }
}
