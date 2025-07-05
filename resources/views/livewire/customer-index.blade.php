<div>
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Clientes</h1>
            <a href="{{ route('customers.create') }}" 
               wire:navigate 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Cliente
            </a>
        </div>
        <p class="text-zinc-600 dark:text-zinc-400">
            Gerencie seus clientes e suas informações
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
                           placeholder="Buscar clientes..."
                           class="block w-full pl-10 pr-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Select de categoria --}}
                <select wire:model.live="category" 
                        class="w-full lg:w-48 px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                               bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todas as categorias</option>
                    @foreach($categories as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ $customers->total() }} cliente(s) encontrado(s)
            </div>
        </div>

        {{-- Tabela de Clientes --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('name')">
                                <div class="flex items-center gap-1">
                                    Nome
                                    @if($sortField === 'name')
                                        <svg class="w-4 h-4 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Documento
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Contato
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('category')">
                                <div class="flex items-center gap-1">
                                    Categoria
                                    @if($sortField === 'category')
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
                        @forelse($customers as $customer)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="font-medium text-zinc-900 dark:text-white">
                                            {{ $customer->name }}
                                        </div>
                                        @if($customer->company_name)
                                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                                {{ $customer->company_name }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($customer->document_number)
                                        <div class="text-sm">
                                            <div class="text-zinc-500 dark:text-zinc-400">{{ $customer->document_type_name }}</div>
                                            <div class="font-mono text-zinc-900 dark:text-white">{{ $customer->formatted_document }}</div>
                                        </div>
                                    @else
                                        <span class="text-zinc-400 dark:text-zinc-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        @if($customer->email)
                                            <div class="text-sm text-zinc-600 dark:text-zinc-300">
                                                {{ $customer->email }}
                                            </div>
                                        @endif
                                        @if($customer->phone)
                                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                                {{ $customer->phone }}
                                            </div>
                                        @endif
                                        @if(!$customer->email && !$customer->phone)
                                            <span class="text-zinc-400 dark:text-zinc-500">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @switch($customer->category)
                                            @case('individual')
                                                bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @break
                                            @case('mei')
                                                bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @break
                                            @case('small_business')
                                                bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @break
                                            @case('large_business')
                                                bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                                @break
                                            @default
                                                bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300
                                        @endswitch">
                                        {{ $customer->category_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('customers.show', $customer) }}" 
                                           wire:navigate
                                           class="inline-flex items-center p-1 text-zinc-500 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('customers.edit', $customer) }}" 
                                           wire:navigate
                                           class="inline-flex items-center p-1 text-zinc-500 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <button wire:click="deleteCustomer({{ $customer->id }})"
                                                wire:confirm="Tem certeza que deseja excluir este cliente?"
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
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-zinc-500 dark:text-zinc-400">
                                        @if($search || $category)
                                            Nenhum cliente encontrado com os filtros aplicados.
                                        @else
                                            Nenhum cliente cadastrado ainda.
                                        @endif
                                    </div>
                                    @if(!$search && !$category)
                                        <a href="{{ route('customers.create') }}" 
                                           wire:navigate
                                           class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                                            Cadastrar primeiro cliente
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($customers->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
