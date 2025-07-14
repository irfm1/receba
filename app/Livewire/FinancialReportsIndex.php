<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\TechnicalReport;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Relatórios Financeiros')]
class FinancialReportsIndex extends Component
{
    public $selectedPeriod = 'current_month';
    public $startDate;
    public $endDate;
    public $selectedCustomer = null;
    
    public function mount()
    {
        $this->setDateRange();
    }
    
    public function updatedSelectedPeriod()
    {
        $this->setDateRange();
    }
    
    private function setDateRange()
    {
        switch ($this->selectedPeriod) {
            case 'current_month':
                $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $this->startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case 'current_year':
                $this->startDate = Carbon::now()->startOfYear()->format('Y-m-d');
                $this->endDate = Carbon::now()->endOfYear()->format('Y-m-d');
                break;
            case 'last_year':
                $this->startDate = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');
                $this->endDate = Carbon::now()->subYear()->endOfYear()->format('Y-m-d');
                break;
            case 'custom':
                // Keep existing dates
                break;
        }
    }
    
    public function getRevenueDataProperty()
    {
        $query = Invoice::whereBetween('issue_date', [$this->startDate, $this->endDate]);
        
        if ($this->selectedCustomer) {
            $query->where('customer_id', $this->selectedCustomer);
        }
        
        $invoices = $query->get();
        
        return [
            'total_revenue' => $invoices->sum('total_amount'),
            'paid_revenue' => $invoices->where('status', 'paid')->sum('total_amount'),
            'pending_revenue' => $invoices->where('status', 'sent')->sum('total_amount'),
            'overdue_revenue' => $invoices->where('status', 'overdue')->sum('total_amount'),
            'total_invoices' => $invoices->count(),
            'paid_invoices' => $invoices->where('status', 'paid')->count(),
            'pending_invoices' => $invoices->where('status', 'sent')->count(),
            'overdue_invoices' => $invoices->where('status', 'overdue')->count(),
        ];
    }
    
    public function getMonthlyRevenueProperty()
    {
        $query = Invoice::whereBetween('issue_date', [$this->startDate, $this->endDate]);
        
        if ($this->selectedCustomer) {
            $query->where('customer_id', $this->selectedCustomer);
        }
        
        return $query->selectRaw('strftime("%Y-%m", issue_date) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
    
    public function getTopCustomersProperty()
    {
        $query = Invoice::whereBetween('issue_date', [$this->startDate, $this->endDate]);
        
        return $query->selectRaw('customer_id, SUM(total_amount) as total_revenue, COUNT(*) as invoice_count')
            ->groupBy('customer_id')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->with('customer')
            ->get();
    }
    
    public function getServiceRevenueProperty()
    {
        $query = Invoice::whereBetween('issue_date', [$this->startDate, $this->endDate]);
        
        if ($this->selectedCustomer) {
            $query->where('customer_id', $this->selectedCustomer);
        }
        
        $invoices = $query->get();
        
        // Group invoices by service type from service_templates and service_packages JSON fields
        $serviceRevenue = collect();
        
        foreach ($invoices as $invoice) {
            $serviceType = 'Outros';
            
            // Check if invoice has service templates
            if ($invoice->service_templates && is_array($invoice->service_templates)) {
                $serviceType = 'Serviços de TI';
            }
            // Check if invoice has service packages
            elseif ($invoice->service_packages && is_array($invoice->service_packages)) {
                $serviceType = 'Pacotes de Serviços';
            }
            // Check if it's a regular invoice
            elseif ($invoice->items && is_array($invoice->items)) {
                $serviceType = 'Serviços Gerais';
            }
            
            $existing = $serviceRevenue->firstWhere('service_type', $serviceType);
            
            if ($existing) {
                $existing['total_revenue'] += $invoice->total_amount;
                $existing['invoice_count'] += 1;
            } else {
                $serviceRevenue->push([
                    'service_type' => $serviceType,
                    'total_revenue' => $invoice->total_amount,
                    'invoice_count' => 1
                ]);
            }
        }
        
        return $serviceRevenue->sortByDesc('total_revenue');
    }
    
    public function getTechnicalReportsDataProperty()
    {
        $query = TechnicalReport::whereBetween('report_date', [$this->startDate, $this->endDate]);
        
        if ($this->selectedCustomer) {
            $query->where('customer_id', $this->selectedCustomer);
        }
        
        $reports = $query->get();
        
        return [
            'total_reports' => $reports->count(),
            'completed_reports' => $reports->where('status', 'completed')->count(),
            'approved_reports' => $reports->where('status', 'approved')->count(),
            'draft_reports' => $reports->where('status', 'draft')->count(),
            'by_type' => $reports->groupBy('report_type')->map(function ($group) {
                return $group->count();
            }),
        ];
    }
    
    public function exportToCsv()
    {
        $filename = 'relatorio_financeiro_' . $this->startDate . '_' . $this->endDate . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Data',
                'Cliente',
                'Fatura',
                'Valor',
                'Status',
                'Tipo de Serviço',
                'Vencimento'
            ]);
            
            // Data
            $query = Invoice::whereBetween('issue_date', [$this->startDate, $this->endDate]);
            if ($this->selectedCustomer) {
                $query->where('customer_id', $this->selectedCustomer);
            }
            
            $invoices = $query->with('customer')->get();
            
            foreach ($invoices as $invoice) {
                // Determine service type from JSON fields
                $serviceType = 'Outros';
                if ($invoice->service_templates && is_array($invoice->service_templates)) {
                    $serviceType = 'Serviços de TI';
                } elseif ($invoice->service_packages && is_array($invoice->service_packages)) {
                    $serviceType = 'Pacotes de Serviços';
                } elseif ($invoice->items && is_array($invoice->items)) {
                    $serviceType = 'Serviços Gerais';
                }
                
                fputcsv($file, [
                    $invoice->issue_date->format('d/m/Y'),
                    $invoice->customer->name,
                    $invoice->invoice_number,
                    'R$ ' . number_format($invoice->total_amount, 2, ',', '.'),
                    match($invoice->status) {
                        'paid' => 'Pago',
                        'sent' => 'Enviado',
                        'overdue' => 'Vencido',
                        'draft' => 'Rascunho',
                        'cancelled' => 'Cancelado',
                        default => 'Indefinido'
                    },
                    $serviceType,
                    $invoice->due_date ? $invoice->due_date->format('d/m/Y') : 'N/A'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function render()
    {
        return view('livewire.financial-reports-index', [
            'customers' => Customer::orderBy('name')->get(),
            'revenueData' => $this->revenueData,
            'monthlyRevenue' => $this->monthlyRevenue,
            'topCustomers' => $this->topCustomers,
            'serviceRevenue' => $this->serviceRevenue,
            'technicalReportsData' => $this->technicalReportsData,
        ]);
    }
}
