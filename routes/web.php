<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::view('home', 'home')->name('home');


// Customer routes
Route::middleware(['auth'])->group(function () {
    Route::view('customers', 'customers.index')->name('customers.index');
    Route::view('customers/create', 'customers.create')->name('customers.create');
    Route::get('customers/{customer}', function (App\Models\Customer $customer) {
        return view('customers.show', compact('customer'));
    })->name('customers.show');
    Route::get('customers/{customer}/edit', function (App\Models\Customer $customer) {
        return view('customers.edit', compact('customer'));
    })->name('customers.edit');
});

// Invoice routes
Route::middleware(['auth'])->group(function () {
    Route::view('invoices', 'invoices.index')->name('invoices.index');
    Route::view('invoices/create', 'invoices.create')->name('invoices.create');
    Route::get('invoices/{invoice}', function (App\Models\Invoice $invoice) {
        return view('invoices.show', compact('invoice'));
    })->name('invoices.show');
    Route::get('invoices/{invoice}/edit', function (App\Models\Invoice $invoice) {
        return view('invoices.edit', compact('invoice'));
    })->name('invoices.edit');
    Route::get('invoices/{invoice}/pdf', function (App\Models\Invoice $invoice) {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', ['invoice' => $invoice]);
        $filename = 'fatura-' . $invoice->invoice_number . '.pdf';
        return $pdf->download($filename);
    })->name('invoices.pdf');
});

// Service Template routes
Route::middleware(['auth'])->group(function () {
    Route::view('service-templates', 'service-templates.index')->name('service-templates.index');
    Route::view('service-templates/create', 'service-templates.create')->name('service-templates.create');
    Route::get('service-templates/{serviceTemplate}/edit', function (App\Models\ServiceTemplate $serviceTemplate) {
        return view('service-templates.edit', compact('serviceTemplate'));
    })->name('service-templates.edit');
});

// Service Package routes
Route::middleware(['auth'])->group(function () {
    Route::view('service-packages', 'service-packages.index')->name('service-packages.index');
    Route::view('service-packages/create', 'service-packages.create')->name('service-packages.create');
    Route::get('service-packages/{servicePackage}/edit', function (App\Models\ServicePackage $servicePackage) {
        return view('service-packages.edit', compact('servicePackage'));
    })->name('service-packages.edit');
});

// Technical Reports routes
Route::middleware(['auth'])->group(function () {
    Route::view('technical-reports', 'technical-reports.index')->name('technical-reports.index');
    Route::view('technical-reports/create', 'technical-reports.create')->name('technical-reports.create');
    Route::get('technical-reports/{technicalReport}', function (App\Models\TechnicalReport $technicalReport) {
        return view('technical-reports.show', compact('technicalReport'));
    })->name('technical-reports.show');
    Route::get('technical-reports/{technicalReport}/edit', function (App\Models\TechnicalReport $technicalReport) {
        return view('technical-reports.edit', compact('technicalReport'));
    })->name('technical-reports.edit');
    Route::get('technical-reports/{technicalReport}/pdf', function (App\Models\TechnicalReport $technicalReport) {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('technical-reports.pdf', ['report' => $technicalReport]);
        $filename = 'laudo-tecnico-' . $technicalReport->report_number . '.pdf';
        return $pdf->download($filename);
    })->name('technical-reports.pdf');
    Route::post('technical-reports/{technicalReport}/send-email', function (App\Models\TechnicalReport $technicalReport) {
        \Illuminate\Support\Facades\Mail::to($technicalReport->customer->email)
            ->send(new \App\Mail\TechnicalReportMail($technicalReport));
        
        return response()->json(['message' => 'Laudo enviado por email com sucesso!']);
    })->name('technical-reports.send-email');
});

// Financial Reports routes
Route::middleware(['auth'])->group(function () {
    Route::get('financial-reports', App\Livewire\FinancialReportsIndex::class)->name('financial-reports.index');
    Route::get('tax-simulator', App\Livewire\TaxSimulator::class)->name('tax-simulator');
    Route::get('backup-manager', App\Livewire\BackupManager::class)->name('backup-manager');
    Route::get('document-manager', App\Livewire\DocumentManager::class)->name('document-manager');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/test-flux', function () {
    return view('test-flux');
})->name('test.flux');

require __DIR__.'/auth.php';
