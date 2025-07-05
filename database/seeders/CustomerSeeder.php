<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar alguns clientes de exemplo
        Customer::create([
            'name' => 'João Silva',
            'email' => 'joao@exemplo.com',
            'phone' => '(11) 99999-1111',
            'document_type' => 'cpf',
            'document_number' => '12345678901',
            'category' => 'individual',
            'address_street' => 'Rua das Flores',
            'address_number' => '123',
            'address_neighborhood' => 'Centro',
            'address_city' => 'São Paulo',
            'address_state' => 'SP',
            'address_postal_code' => '01234567',
        ]);

        Customer::create([
            'name' => 'Maria Santos',
            'email' => 'maria@empresa.com',
            'phone' => '(11) 88888-2222',
            'document_type' => 'cnpj',
            'document_number' => '12345678000123',
            'company_name' => 'Empresa Tech Ltda',
            'contact_person' => 'Maria Santos',
            'category' => 'small_business',
            'address_street' => 'Avenida Paulista',
            'address_number' => '1000',
            'address_complement' => 'Sala 501',
            'address_neighborhood' => 'Bela Vista',
            'address_city' => 'São Paulo',
            'address_state' => 'SP',
            'address_postal_code' => '01310100',
            'notes' => 'Cliente desde 2023, sempre pontual nos pagamentos.',
        ]);

        Customer::create([
            'name' => 'Carlos MEI',
            'email' => 'carlos@mei.com',
            'phone' => '(11) 77777-3333',
            'document_type' => 'cnpj',
            'document_number' => '98765432000111',
            'company_name' => 'Carlos Serviços ME',
            'contact_person' => 'Carlos Oliveira',
            'category' => 'mei',
            'address_city' => 'São Paulo',
            'address_state' => 'SP',
        ]);

        Customer::create([
            'name' => 'Ana Costa',
            'email' => 'ana@email.com',
            'phone' => '(11) 66666-4444',
            'category' => 'individual',
        ]);

        Customer::create([
            'name' => 'TechCorp Soluções',
            'email' => 'contato@techcorp.com.br',
            'phone' => '(11) 55555-5555',
            'document_type' => 'cnpj',
            'document_number' => '11222333000144',
            'company_name' => 'TechCorp Soluções em TI S/A',
            'contact_person' => 'Roberto Lima',
            'category' => 'large_business',
            'address_street' => 'Rua da Tecnologia',
            'address_number' => '500',
            'address_complement' => 'Andar 10',
            'address_neighborhood' => 'Vila Olímpia',
            'address_city' => 'São Paulo',
            'address_state' => 'SP',
            'address_postal_code' => '04551000',
            'notes' => 'Grande cliente corporativo. Contratos anuais.',
        ]);
    }
}
