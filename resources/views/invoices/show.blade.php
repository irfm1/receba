<x-layouts.app title="Fatura #{{ $invoice->invoice_number }}">
    <livewire:invoice-show :invoice="$invoice" />
</x-layouts.app>
