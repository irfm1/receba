<div>
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('customers.index') }}" 
               wire:navigate
               class="inline-flex items-center p-2 text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                {{ $isEditing ? 'Editar Cliente' : 'Novo Cliente' }}
            </h1>
        </div>
        <p class="text-zinc-600 dark:text-zinc-400">
            {{ $isEditing ? 'Atualize as informações do cliente' : 'Preencha os dados do novo cliente' }}
        </p>
    </div>

    <form wire:submit="save" class="space-y-6">
        {{-- Informações Básicas --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Informações Básicas</h2>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Nome *
                    </label>
                    <input wire:model="name" 
                           type="text"
                           placeholder="Nome completo ou razão social"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        E-mail
                    </label>
                    <input wire:model="email" 
                           type="email"
                           placeholder="exemplo@email.com"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Telefone
                    </label>
                    <input wire:model="phone" 
                           type="text"
                           placeholder="(11) 99999-9999"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Categoria *
                    </label>
                    <select wire:model.live="category" 
                            class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                   bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   @error('category') border-red-500 @enderror">
                        <option value="">Selecione uma categoria</option>
                        @foreach($categories as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                @if(in_array($category, ['mei', 'small_business', 'large_business']))
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Nome da Empresa
                        </label>
                        <input wire:model="company_name" 
                               type="text"
                               placeholder="Nome fantasia ou razão social"
                               class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                      bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                      @error('company_name') border-red-500 @enderror">
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Pessoa de Contato
                        </label>
                        <input wire:model="contact_person" 
                               type="text"
                               placeholder="Responsável pelo contato"
                               class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                      bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                      @error('contact_person') border-red-500 @enderror">
                        @error('contact_person')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </div>
        </div>

        {{-- Documentos --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Documentos</h2>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Tipo de Documento
                    </label>
                    <select wire:model="document_type" 
                            class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                   bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   @error('document_type') border-red-500 @enderror">
                        <option value="">Selecione o tipo</option>
                        @foreach($documentTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('document_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Número do Documento
                    </label>
                    <input wire:model="document_number" 
                           type="text"
                           placeholder="{{ $document_type === 'cpf' ? '000.000.000-00' : ($document_type === 'cnpj' ? '00.000.000/0000-00' : 'Número do documento') }}"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('document_number') border-red-500 @enderror">
                    @error('document_number')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Endereço --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Endereço</h2>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-6">
                <div class="lg:col-span-4">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Logradouro
                    </label>
                    <input wire:model="address_street" 
                           type="text"
                           placeholder="Rua, Avenida, etc."
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('address_street') border-red-500 @enderror">
                    @error('address_street')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Número
                    </label>
                    <input wire:model="address_number" 
                           type="text"
                           placeholder="123"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('address_number') border-red-500 @enderror">
                    @error('address_number')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-3">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Complemento
                    </label>
                    <input wire:model="address_complement" 
                           type="text"
                           placeholder="Apto, Casa, Bloco, etc."
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('address_complement') border-red-500 @enderror">
                    @error('address_complement')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-3">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Bairro
                    </label>
                    <input wire:model="address_neighborhood" 
                           type="text"
                           placeholder="Nome do bairro"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('address_neighborhood') border-red-500 @enderror">
                    @error('address_neighborhood')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-3">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Cidade
                    </label>
                    <input wire:model="address_city" 
                           type="text"
                           placeholder="Nome da cidade"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('address_city') border-red-500 @enderror">
                    @error('address_city')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-1">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        UF
                    </label>
                    <input wire:model="address_state" 
                           type="text"
                           placeholder="SP"
                           maxlength="2"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('address_state') border-red-500 @enderror">
                    @error('address_state')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        CEP
                    </label>
                    <input wire:model="address_postal_code" 
                           type="text"
                           placeholder="00000-000"
                           class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                  bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('address_postal_code') border-red-500 @enderror">
                    @error('address_postal_code')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
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
                          placeholder="Informações adicionais sobre o cliente..."
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
            <a href="{{ route('customers.index') }}" 
               wire:navigate
               class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 
                      hover:bg-zinc-50 dark:hover:bg-zinc-700 rounded-lg font-medium transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                {{ $isEditing ? 'Atualizar Cliente' : 'Criar Cliente' }}
            </button>
        </div>
    </form>
</div>
