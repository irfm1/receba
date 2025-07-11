<div>
    <div class="mb-6 space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('customers.index') }}" 
                   wire:navigate 
                   class="inline-flex items-center justify-center w-10 h-10 rounded-md bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-700 dark:hover:bg-zinc-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $customer->name }}</h1>
                    @if($customer->company_name)
                        <p class="text-lg text-zinc-600 dark:text-zinc-400">{{ $customer->company_name }}</p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('customers.edit', $customer) }}" 
                   wire:navigate
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>
                <button 
                    wire:click="deleteCustomer"
                    wire:confirm="Tem certeza que deseja excluir este cliente? Esta ação não pode ser desfeita."
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Excluir
                </button>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                {{ match($customer->category) {
                    'individual' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                    'mei' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                    'small_business' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                    'large_business' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                    default => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-200'
                } }}">
                {{ $customer->category_name }}
            </span>
            <span class="text-zinc-500 dark:text-zinc-400">
                Criado em {{ $customer->created_at->format('d/m/Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Informações de Contato --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Informações de Contato</h2>
            </div>

            <div class="space-y-4">
                @if($customer->email)
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">E-mail</label>
                        <div class="mt-1 text-zinc-900 dark:text-white">
                            <a href="mailto:{{ $customer->email }}" class="text-blue-600 hover:text-blue-500">
                                {{ $customer->email }}
                            </a>
                        </div>
                    </div>
                @endif

                @if($customer->phone)
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Telefone</label>
                        <div class="mt-1 text-zinc-900 dark:text-white">
                            <a href="tel:{{ $customer->phone }}" class="text-blue-600 hover:text-blue-500">
                                {{ $customer->phone }}
                            </a>
                        </div>
                    </div>
                @endif

                @if($customer->contact_person)
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Pessoa de Contato</label>
                        <div class="mt-1 text-zinc-900 dark:text-white">{{ $customer->contact_person }}</div>
                    </div>
                @endif

                @if(!$customer->email && !$customer->phone && !$customer->contact_person)
                    <div class="text-center py-4 text-zinc-500 dark:text-zinc-400">
                        Nenhuma informação de contato cadastrada
                    </div>
                @endif
            </div>
        </div>

        {{-- Documentos --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Documentos</h2>
            </div>

            <div class="space-y-4">
                @if($customer->document_number)
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $customer->document_type_name }}</label>
                        <div class="mt-1 text-zinc-900 dark:text-white font-mono">
                            {{ $customer->formatted_document }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 text-zinc-500 dark:text-zinc-400">
                        Nenhum documento cadastrado
                    </div>
                @endif
            </div>
        </div>

        {{-- Endereço --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 lg:col-span-2">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Endereço</h2>
            </div>

            <div>
                @if($customer->full_address)
                    <div class="text-zinc-900 dark:text-white">
                        {{ $customer->full_address }}
                    </div>
                @else
                    <div class="text-center py-4 text-zinc-500 dark:text-zinc-400">
                        Nenhum endereço cadastrado
                    </div>
                @endif
            </div>
        </div>

        {{-- Observações --}}
        @if($customer->notes)
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 lg:col-span-2">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Observações</h2>
                </div>

                <div class="text-zinc-900 dark:text-white whitespace-pre-wrap">
                    {{ $customer->notes }}
                </div>
            </div>
        @endif

        {{-- Histórico --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 lg:col-span-2">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Histórico</h2>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between py-2 border-b border-zinc-200 dark:border-zinc-700">
                    <div>
                        <div class="font-medium text-zinc-900 dark:text-white">Cliente criado</div>
                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $customer->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Criado</span>
                </div>

                @if($customer->updated_at->gt($customer->created_at))
                    <div class="flex items-center justify-between py-2 border-b border-zinc-200 dark:border-zinc-700">
                        <div>
                            <div class="font-medium text-zinc-900 dark:text-white">Última atualização</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $customer->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Atualizado</span>
                    </div>
                @endif

                <!-- Invoices Section -->
                <div class="mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Faturas</h3>
                        <a href="{{ route('invoices.create', ['customer_id' => $customer->id]) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nova Fatura
                        </a>
                    </div>
                    
                    @if($customer->invoices->count() > 0)
                        <div class="space-y-3">
                            @foreach($customer->invoices->take(5) as $invoice)
                                <div class="flex items-center justify-between py-3 px-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <span class="font-medium text-zinc-900 dark:text-white">{{ $invoice->invoice_number }}</span>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($invoice->status === 'draft') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                @elseif($invoice->status === 'sent') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @elseif($invoice->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($invoice->status === 'overdue') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                @endif">
                                                {{ $invoice->getStatusLabel() }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                            {{ $invoice->issue_date->format('d/m/Y') }} • R$ {{ number_format($invoice->total_amount, 2, ',', '.') }}
                                        </div>
                                    </div>
                                    <a href="{{ route('invoices.show', $invoice) }}" 
                                       class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                            
                            @if($customer->invoices->count() > 5)
                                <div class="text-center">
                                    <a href="{{ route('invoices.index', ['customer_id' => $customer->id]) }}" 
                                       class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                        Ver todas as {{ $customer->invoices->count() }} faturas
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                            <svg class="w-12 h-12 mx-auto mb-4 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div class="text-sm">
                                Nenhuma fatura encontrada para este cliente
                            </div>
                            <a href="{{ route('invoices.create', ['customer_id' => $customer->id]) }}" 
                               class="inline-flex items-center mt-3 px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Criar primeira fatura
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
