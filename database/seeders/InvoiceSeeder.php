<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        
        if ($customers->isEmpty()) {
            $this->command->warn('No customers found. Please run CustomerSeeder first.');
            return;
        }

        $statuses = ['draft', 'sent', 'paid', 'overdue'];
        $invoiceCounter = Invoice::count();
        
        foreach ($customers->take(5) as $customerIndex => $customer) {
            // Create 2-4 invoices per customer
            $invoiceCount = rand(2, 4);
            
            for ($i = 0; $i < $invoiceCount; $i++) {
                $issueDate = now()->subDays(rand(1, 90));
                $dueDate = $issueDate->copy()->addDays(30);
                
                $items = [
                    [
                        'description' => 'Serviço de Consultoria',
                        'quantity' => rand(1, 5),
                        'unit_price' => rand(100, 500),
                        'total' => 0, // Will be calculated
                    ],
                    [
                        'description' => 'Desenvolvimento de Software',
                        'quantity' => rand(10, 50),
                        'unit_price' => rand(50, 150),
                        'total' => 0, // Will be calculated
                    ],
                ];

                // Calculate totals for items
                foreach ($items as $index => $item) {
                    $items[$index]['total'] = $item['quantity'] * $item['unit_price'];
                }

                $subtotal = collect($items)->sum('total');
                $discountAmount = rand(0, 1) ? rand(50, 200) : 0;
                $taxAmount = $subtotal * 0.1; // 10% tax
                $totalAmount = $subtotal - $discountAmount + $taxAmount;

                $invoice = Invoice::create([
                    'customer_id' => $customer->id,
                    'invoice_number' => sprintf('INV-%s-%04d', now()->format('Y'), ++$invoiceCounter),
                    'issue_date' => $issueDate,
                    'due_date' => $dueDate,
                    'description' => 'Fatura para serviços prestados em ' . $issueDate->format('M/Y'),
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount' => $taxAmount,
                    'total_amount' => $totalAmount,
                    'status' => $statuses[array_rand($statuses)],
                    'items' => $items,
                    'notes' => rand(0, 1) ? 'Obrigado pela preferência!' : null,
                ]);

                // If status is paid, set paid_at
                if ($invoice->status === 'paid') {
                    $invoice->update(['paid_at' => $dueDate->subDays(rand(1, 10))]);
                }
            }
        }

        $this->command->info('Invoices created successfully!');
    }
}
