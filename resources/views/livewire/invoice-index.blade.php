<div>
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Faturas</h1>
            <a href="{{ route('invoices.create') }}" 
               wire:navigate 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Fatura
            </a>
        </div>
        <p class="text-zinc-600 dark:text-zinc-400">
            Gerencie suas faturas e seus status
        </p>
    </div>

    <div class="space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center">
                {{-- Campo de busca --}}
                <div class="relative w-full lg:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search"
                           type="text"
                           placeholder="Buscar faturas..."
                           class="block w-full pl-10 pr-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Select de status --}}
                <select wire:model.live="status" 
                        class="w-full lg:w-48 px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                               bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos os status</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ $invoices->total() }} fatura(s) encontrada(s)
            </div>
        </div>

        {{-- Tabela de Faturas --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('invoice_number')">
                                <div class="flex items-center gap-1">
                                    Número
                                    @if($sortField === 'invoice_number')
                                        <svg class="w-4 h-4 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Cliente
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('total_amount')">
                                <div class="flex items-center gap-1">
                                    Valor
                                    @if($sortField === 'total_amount')
                                        <svg class="w-4 h-4 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('due_date')">
                                <div class="flex items-center gap-1">
                                    Vencimento
                                    @if($sortField === 'due_date')
                                        <svg class="w-4 h-4 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('status')">
                                <div class="flex items-center gap-1">
                                    Status
                                    @if($sortField === 'status')
                                        <svg class="w-4 h-4 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-zinc-900 dark:text-white">
                                        {{ $invoice->invoice_number }}
                                    </div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $invoice->issue_date->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-zinc-900 dark:text-white">
                                        {{ $invoice->customer->name }}
                                    </div>
                                    @if($invoice->customer->company_name)
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $invoice->customer->company_name }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-mono text-zinc-900 dark:text-white">
                                        R$ {{ number_format($invoice->total_amount, 2, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-zinc-900 dark:text-white">
                                        {{ $invoice->due_date->format('d/m/Y') }}
                                    </div>
                                    @if($invoice->is_overdue)
                                        <div class="text-sm text-red-600 dark:text-red-400">
                                            Vencida há {{ $invoice->due_date->diffForHumans() }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @switch($invoice->status)
                                            @case('draft')
                                                bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-200
                                                @break
                                            @case('sent')
                                                bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @break
                                            @case('paid')
                                                bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @break
                                            @case('overdue')
                                                bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @break
                                            @case('cancelled')
                                                bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                                @break
                                            @default
                                                bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300
                                        @endswitch">
                                        {{ $invoice->status_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('invoices.show', $invoice) }}" 
                                           wire:navigate
                                           class="inline-flex items-center p-1 text-zinc-500 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice) }}" 
                                           wire:navigate
                                           class="inline-flex items-center p-1 text-zinc-500 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <button wire:click="deleteInvoice({{ $invoice->id }})"
                                                wire:confirm="Tem certeza que deseja excluir esta fatura?"
                                                class="inline-flex items-center p-1 text-zinc-500 hover:text-red-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-zinc-500 dark:text-zinc-400">
                                        @if($search || $status)
                                            Nenhuma fatura encontrada com os filtros aplicados.
                                        @else
                                            Nenhuma fatura cadastrada ainda.
                                        @endif
                                    </div>
                                    @if(!$search && !$status)
                                        <a href="{{ route('invoices.create') }}" 
                                           wire:navigate
                                           class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                                            Cadastrar primeira fatura
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($invoices->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
