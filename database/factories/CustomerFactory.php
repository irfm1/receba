<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $documentType = fake()->randomElement(['cpf', 'cnpj']);
        $category = fake()->randomElement(['individual', 'mei', 'small_business', 'large_business']);
        
        return [
            'name' => fake('pt_BR')->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake('pt_BR')->cellphone(),
            'document_type' => $documentType,
            'document_number' => $documentType === 'cpf' ? fake('pt_BR')->cpf(false) : fake('pt_BR')->cnpj(false),
            'address_street' => fake('pt_BR')->streetName(),
            'address_number' => fake()->buildingNumber(),
            'address_complement' => fake()->randomElement([null, 'Apto ' . fake()->numberBetween(1, 999), 'Casa', 'Bloco A']),
            'address_neighborhood' => fake('pt_BR')->city(),
            'address_city' => fake('pt_BR')->city(),
            'address_state' => fake('pt_BR')->stateAbbr(),
            'address_postal_code' => fake('pt_BR')->postcode(),
            'company_name' => $category !== 'individual' ? fake('pt_BR')->company() : null,
            'contact_person' => $category !== 'individual' ? fake('pt_BR')->name() : null,
            'category' => $category,
            'notes' => fake()->randomElement([null, fake('pt_BR')->text(200)]),
        ];
    }
}
