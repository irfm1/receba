<div>
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('invoices.index') }}" 
               wire:navigate
               class="inline-flex items-center p-2 text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                {{ $isEditing ? 'Editar Fatura' : 'Nova Fatura' }}
            </h1>
        </div>
        <p class="text-zinc-600 dark:text-zinc-400">
            {{ $isEditing ? 'Atualize as informações da fatura' : 'Preencha os dados da nova fatura' }}
        </p>
    </div>

    <form wire:submit="save" class="space-y-6">
        {{-- Informações Básicas --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Informações Básicas</h2>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Cliente *
                    </label>
                    <select wire:model="customer_id" 
                            class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                   bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   @error('customer_id') border-red-500 @enderror">
                        <option value="">Selecione um cliente</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->name }}
                                @if($customer->company_name) - {{ $customer->company_name }}@endif
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Status
                    </label>
                    <select wire:model="status" 
                            class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                   bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   @error('status') border-red-500 @enderror">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Data de Emissão *
                    </label>
                    <input wire:model="issue_date" 
                           type="date"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('issue_date') border-red-500 @enderror">
                    @error('issue_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Data de Vencimento *
                    </label>
                    <input wire:model="due_date" 
                           type="date"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('due_date') border-red-500 @enderror">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Descrição *
                    </label>
                    <textarea wire:model="description" 
                              rows="3"
                              placeholder="Descrição geral dos serviços prestados..."
                              class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                     bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                     focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                     @error('description') border-red-500 @enderror"></textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Itens da Fatura --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Itens da Fatura</h2>
                <button type="button" 
                        wire:click="addItem"
                        class="inline-flex items-center gap-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Adicionar Item
                </button>
            </div>

            <div class="space-y-4">
                @foreach($items as $index => $item)
                    <div wire:key="item-{{ $index }}" class="border border-zinc-200 dark:border-zinc-600 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-zinc-900 dark:text-white">Item {{ $index + 1 }}</h3>
                            @if(count($items) > 1)
                                <button type="button" 
                                        wire:click="removeItem({{ $index }})"
                                        class="text-red-600 hover:text-red-700 dark:text-red-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-12">
                            <div class="lg:col-span-6">
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Descrição *
                                </label>
                                <input wire:model.live="items.{{ $index }}.description" 
                                       type="text"
                                       placeholder="Descrição do serviço ou produto"
                                       class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                              bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                              @error('items.' . $index . '.description') border-red-500 @enderror">
                                @error('items.' . $index . '.description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Quantidade *
                                </label>
                                <input wire:model.live="items.{{ $index }}.quantity" 
                                       type="number"
                                       min="1"
                                       step="1"
                                       placeholder="1"
                                       class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                              bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                              @error('items.' . $index . '.quantity') border-red-500 @enderror">
                                @error('items.' . $index . '.quantity')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Valor Unitário *
                                </label>
                                <input wire:model.live="items.{{ $index }}.unit_price" 
                                       type="number"
                                       min="0"
                                       step="0.01"
                                       placeholder="0,00"
                                       class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                              bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                              @error('items.' . $index . '.unit_price') border-red-500 @enderror">
                                @error('items.' . $index . '.unit_price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Total
                                </label>
                                <div class="px-3 py-2 bg-zinc-50 dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 rounded-lg font-mono text-zinc-900 dark:text-white">
                                    R$ {{ number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 2, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Resumo de Valores --}}
            <div class="mt-6 border-t border-zinc-200 dark:border-zinc-600 pt-6">
                <div class="flex justify-end">
                    <div class="w-full max-w-sm space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-zinc-700 dark:text-zinc-300">Subtotal:</span>
                            <span class="font-mono text-zinc-900 dark:text-white">
                                R$ {{ number_format($this->subtotal, 2, ',', '.') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Desconto (R$)
                                </label>
                                <input wire:model.live="discount_amount" 
                                       type="number"
                                       min="0"
                                       step="0.01"
                                       placeholder="0,00"
                                       class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                              bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Impostos (R$)
                                </label>
                                <input wire:model.live="tax_amount" 
                                       type="number"
                                       min="0"
                                       step="0.01"
                                       placeholder="0,00"
                                       class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                              bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-3 border-t border-zinc-200 dark:border-zinc-600">
                            <span class="text-lg font-semibold text-zinc-900 dark:text-white">Total:</span>
                            <span class="text-lg font-bold font-mono text-zinc-900 dark:text-white">
                                R$ {{ number_format($this->total, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Observações --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Observações</h2>

            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Notas
                </label>
                <textarea wire:model="notes" 
                          rows="4"
                          placeholder="Informações adicionais sobre a fatura..."
                          class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                 focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                 @error('notes') border-red-500 @enderror"></textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Botões --}}
        <div class="flex justify-end gap-4">
            <a href="{{ route('invoices.index') }}" 
               wire:navigate
               class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 
                      hover:bg-zinc-50 dark:hover:bg-zinc-700 rounded-lg font-medium transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                {{ $isEditing ? 'Atualizar Fatura' : 'Criar Fatura' }}
            </button>
        </div>
    </form>
</div>
