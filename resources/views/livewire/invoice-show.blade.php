<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Flash Messages -->
    <div x-data="{ 
        show: false, 
        message: '', 
        type: 'success',
        init() {
            this.$wire.on('invoice-email-sent', (event) => {
                this.showMessage(event.message, 'success');
            });
            this.$wire.on('invoice-email-error', (event) => {
                this.showMessage(event.message, 'error');
            });
        },
        showMessage(msg, msgType) {
            this.message = msg;
            this.type = msgType;
            this.show = true;
            setTimeout(() => { this.show = false; }, 5000);
        }
    }">
        <div x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             class="mb-4 p-4 rounded-lg shadow-md"
             :class="type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg x-show="type === 'success'" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg x-show="type === 'error'" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span x-text="message"></span>
                </div>
                <button @click="show = false" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Header with back button and actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('invoices.index') }}" 
                class="flex items-center gap-2 text-gray-600 hover:text-gray-800 cursor-pointer transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Voltar às Faturas</span>
            </a>
        </div>
        
        <div class="flex gap-2">
            <wire:click="edit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </wire:click>
            
            <button wire:click="sendInvoiceEmail" 
                    wire:loading.attr="disabled"
                    class="bg-purple-600 hover:bg-purple-700 disabled:bg-purple-400 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <svg wire:loading.remove wire:target="sendInvoiceEmail" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.82 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <svg wire:loading wire:target="sendInvoiceEmail" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="sendInvoiceEmail">Enviar por Email</span>
                <span wire:loading wire:target="sendInvoiceEmail">Enviando...</span>
            </button>
            
            <a href="{{ route('invoices.pdf', $invoice) }}" 
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </a>
            
            <a href="{{ route('technical-reports.create', ['customer_id' => $invoice->customer_id, 'invoice_id' => $invoice->id]) }}" 
                class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Criar Laudo Técnico
            </a>
        </div>
    </div>

    <!-- Invoice Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Status Badge -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $invoice->invoice_number }}</h1>
                    <p class="text-gray-600">Fatura #{{ $invoice->id }}</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($invoice->status === 'draft') bg-gray-100 text-gray-800
                        @elseif($invoice->status === 'sent') bg-blue-100 text-blue-800
                        @elseif($invoice->status === 'paid') bg-green-100 text-green-800
                        @elseif($invoice->status === 'overdue') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $invoice->getStatusLabel() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Customer and Date Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Cliente</h3>
                    <div class="space-y-2">
                        <p class="font-medium text-gray-900">{{ $invoice->customer->name }}</p>
                        <p class="text-gray-700">{{ $invoice->customer->email }}</p>
                        @if($invoice->customer->phone)
                            <p class="text-gray-700">{{ $invoice->customer->phone }}</p>
                        @endif
                        @if($invoice->customer->address)
                            <p class="text-gray-700">{{ $invoice->customer->address }}</p>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Informações da Fatura</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Data de Emissão:</span>
                            <span class="font-medium text-gray-900">{{ $invoice->issue_date->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Data de Vencimento:</span>
                            <span class="font-medium text-gray-900">{{ $invoice->due_date->format('d/m/Y') }}</span>
                        </div>
                        @if($invoice->paid_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Data de Pagamento:</span>
                                <span class="font-medium text-green-600">{{ $invoice->paid_at->format('d/m/Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($invoice->description)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Descrição</h3>
                    <p class="text-gray-800 bg-gray-50 p-4 rounded-lg">{{ $invoice->description }}</p>
                </div>
            @endif

            <!-- Items Table -->
            @if($invoice->items && count($invoice->items) > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Itens</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-900">Descrição</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-900">Qtd</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-900">Valor Unit.</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-900">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($invoice->items as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item['description'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-center">{{ $item['quantity'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-right">R$ {{ number_format($item['unit_price'], 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">R$ {{ number_format($item['quantity'] * $item['unit_price'], 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Totals -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-end">
                    <div class="w-full max-w-xs space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium text-gray-900">R$ {{ number_format($invoice->subtotal, 2, ',', '.') }}</span>
                        </div>
                        
                        @if($invoice->tax_amount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Impostos:</span>
                                <span class="font-medium text-gray-900">R$ {{ number_format($invoice->tax_amount, 2, ',', '.') }}</span>
                            </div>
                        @endif
                        
                        @if($invoice->discount_amount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Desconto:</span>
                                <span class="font-medium text-red-600">-R$ {{ number_format($invoice->discount_amount, 2, ',', '.') }}</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-3">
                            <span class="text-gray-900">Total:</span>
                            <span class="text-blue-600">R$ {{ number_format($invoice->total_amount, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($invoice->notes)
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Observações</h3>
                    <p class="text-gray-800 bg-gray-50 p-4 rounded-lg">{{ $invoice->notes }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons (Mobile) -->
    <div class="mt-6 flex flex-col sm:flex-row gap-3 sm:hidden">
        <wire:click="edit" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Editar Fatura
        </wire:click>
        
        <button wire:click="sendInvoiceEmail" 
                wire:loading.attr="disabled"
                class="bg-purple-600 hover:bg-purple-700 disabled:bg-purple-400 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
            <svg wire:loading.remove wire:target="sendInvoiceEmail" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.82 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <svg wire:loading wire:target="sendInvoiceEmail" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span wire:loading.remove wire:target="sendInvoiceEmail">Enviar por Email</span>
            <span wire:loading wire:target="sendInvoiceEmail">Enviando...</span>
        </button>
        
        <a href="{{ route('invoices.pdf', $invoice) }}" 
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Download PDF
        </a>
        
        <a href="{{ route('technical-reports.create', ['customer_id' => $invoice->customer_id, 'invoice_id' => $invoice->id]) }}" 
            class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Criar Laudo Técnico
        </a>
    </div>
</div>
