<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Mail\InvoiceMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {invoice_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test sending invoice email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $invoiceId = $this->argument('invoice_id');
        $invoice = Invoice::with('customer')->find($invoiceId);
        
        if (!$invoice) {
            $this->error("Invoice with ID {$invoiceId} not found.");
            return 1;
        }
        
        if (!$invoice->customer->email) {
            $this->error("Customer does not have an email address.");
            return 1;
        }
        
        try {
            $this->info("Sending invoice email to: " . $invoice->customer->email);
            
            Mail::to($invoice->customer->email)
                ->send(new InvoiceMail($invoice));
            
            $this->info("Email sent successfully!");
            return 0;
            
        } catch (\Exception $e) {
            $this->error("Failed to send email: " . $e->getMessage());
            return 1;
        }
    }
}
