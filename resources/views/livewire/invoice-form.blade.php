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

        {{-- Tipo de Fatura --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Tipo de Fatura</h2>
            
            <div class="space-y-4">
                <label class="flex items-center">
                    <input wire:model.live="use_services" 
                           type="radio" 
                           value="0"
                           name="invoice_type"
                           class="w-4 h-4 text-blue-600 bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 focus:ring-blue-500 focus:ring-2">
                    <span class="ml-3 text-zinc-900 dark:text-white">
                        <strong>Itens Manuais</strong>
                        <span class="block text-sm text-zinc-600 dark:text-zinc-400">
                            Adicione itens personalizados manualmente
                        </span>
                    </span>
                </label>
                
                <label class="flex items-center">
                    <input wire:model.live="use_services" 
                           type="radio" 
                           value="1"
                           name="invoice_type"
                           class="w-4 h-4 text-blue-600 bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 focus:ring-blue-500 focus:ring-2">
                    <span class="ml-3 text-zinc-900 dark:text-white">
                        <strong>Catálogo de Serviços</strong>
                        <span class="block text-sm text-zinc-600 dark:text-zinc-400">
                            Selecione serviços e pacotes do catálogo
                        </span>
                    </span>
                </label>
            </div>
        </div>

        @if($use_services)
            {{-- Seleção de Serviços --}}
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Selecionar Serviços</h2>
                
                {{-- Tab Navigation --}}
                <div class="border-b border-zinc-200 dark:border-zinc-600 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <button type="button" 
                                wire:click="$set('serviceTab', 'templates')"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors
                                       @if($serviceTab === 'templates') border-blue-500 text-blue-600 dark:text-blue-400 @else border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300 dark:text-zinc-400 dark:hover:text-zinc-300 @endif">
                            Templates de Serviços
                        </button>
                        <button type="button" 
                                wire:click="$set('serviceTab', 'packages')"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors
                                       @if($serviceTab === 'packages') border-blue-500 text-blue-600 dark:text-blue-400 @else border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300 dark:text-zinc-400 dark:hover:text-zinc-300 @endif">
                            Pacotes de Projetos
                        </button>
                    </nav>
                </div>

                {{-- Service Templates Tab --}}
                @if($serviceTab === 'templates')
                    <div class="space-y-4">
                        @forelse($serviceTemplates as $template)
                            @php
                                $isSelected = collect($selectedServiceTemplates)->contains('id', $template->id);
                                $selectedData = collect($selectedServiceTemplates)->firstWhere('id', $template->id);
                            @endphp
                            
                            <div class="border border-zinc-200 dark:border-zinc-600 rounded-lg p-4 
                                        @if($isSelected) bg-blue-50 dark:bg-blue-900/20 border-blue-300 dark:border-blue-600 @endif">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <input type="checkbox" 
                                                   wire:click="toggleServiceTemplate({{ $template->id }})"
                                                   {{ $isSelected ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 rounded focus:ring-blue-500">
                                            <h3 class="font-medium text-zinc-900 dark:text-white">{{ $template->name }}</h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                         @if($template->category === 'desenvolvimento') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                         @elseif($template->category === 'design') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                                         @elseif($template->category === 'consultoria') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                         @else bg-zinc-100 text-zinc-800 dark:bg-zinc-900 dark:text-zinc-200 @endif">
                                                {{ $template->category_name }}
                                            </span>
                                        </div>
                                        
                                        @if($template->description)
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">{{ $template->description }}</p>
                                        @endif
                                        
                                        <div class="flex items-center gap-4 text-sm text-zinc-600 dark:text-zinc-400">
                                            <span>Taxa: {{ $template->formatted_rate }}</span>
                                            @if($template->estimated_hours)
                                                <span>Estimativa: {{ $template->estimated_hours }}h</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                @if($isSelected)
                                    @php $index = collect($selectedServiceTemplates)->search(fn($item) => $item['id'] == $template->id); @endphp
                                    <div class="mt-4 pt-4 border-t border-blue-200 dark:border-blue-700">
                                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                                            <div>
                                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                                    Quantidade de Projetos
                                                </label>
                                                <input wire:model.live="selectedServiceTemplates.{{ $index }}.quantity" 
                                                       type="number"
                                                       min="1"
                                                       step="1"
                                                       class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                                              bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                                    Horas por Projeto
                                                </label>
                                                <input wire:model.live="selectedServiceTemplates.{{ $index }}.hours" 
                                                       type="number"
                                                       min="1"
                                                       step="0.5"
                                                       class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                                              bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                                    Taxa por Hora (R$)
                                                </label>
                                                <input wire:model.live="selectedServiceTemplates.{{ $index }}.rate" 
                                                       type="number"
                                                       min="0"
                                                       step="0.01"
                                                       class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                                              bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3 text-right">
                                            <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                                Total: R$ {{ number_format(($selectedData['quantity'] ?? 1) * ($selectedData['hours'] ?? 1) * ($selectedData['rate'] ?? 0), 2, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="text-zinc-500 dark:text-zinc-400 mb-2">
                                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-zinc-600 dark:text-zinc-400">Nenhum template de serviço encontrado</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-500 mt-1">
                                    <a href="{{ route('service-templates.create') }}" wire:navigate class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                        Criar primeiro template de serviço
                                    </a>
                                </p>
                            </div>
                        @endforelse
                    </div>
                @endif

                {{-- Service Packages Tab --}}
                @if($serviceTab === 'packages')
                    <div class="space-y-4">
                        @forelse($servicePackages as $package)
                            @php
                                $isSelected = collect($selectedServicePackages)->contains('id', $package->id);
                                $selectedData = collect($selectedServicePackages)->firstWhere('id', $package->id);
                            @endphp
                            
                            <div class="border border-zinc-200 dark:border-zinc-600 rounded-lg p-4 
                                        @if($isSelected) bg-green-50 dark:bg-green-900/20 border-green-300 dark:border-green-600 @endif">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <input type="checkbox" 
                                                   wire:click="toggleServicePackage({{ $package->id }})"
                                                   {{ $isSelected ? 'checked' : '' }}
                                                   class="w-4 h-4 text-green-600 bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 rounded focus:ring-green-500">
                                            <h3 class="font-medium text-zinc-900 dark:text-white">{{ $package->name }}</h3>
                                            @if($package->discount_percentage > 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    {{ $package->discount_percentage }}% OFF
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($package->description)
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">{{ $package->description }}</p>
                                        @endif
                                        
                                        <div class="flex items-center gap-4 text-sm text-zinc-600 dark:text-zinc-400">
                                            @if($package->discount_percentage > 0 && isset($package->fixed_price))
                                                <span class="line-through">{{ $package->formatted_price }}</span>
                                            @endif
                                            <span class="font-medium text-zinc-900 dark:text-white">{{ $package->formatted_discounted_price }}</span>
                                            @if($package->estimated_duration_days)
                                                <span>Prazo: {{ $package->estimated_duration }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                @if($isSelected)
                                    @php $index = collect($selectedServicePackages)->search(fn($item) => $item['id'] == $package->id); @endphp
                                    <div class="mt-4 pt-4 border-t border-green-200 dark:border-green-700">
                                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                            <div>
                                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                                    Quantidade
                                                </label>
                                                <input wire:model.live="selectedServicePackages.{{ $index }}.quantity" 
                                                       type="number"
                                                       min="1"
                                                       step="1"
                                                       class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                                              bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                                              focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                                    Preço Unitário (R$)
                                                </label>
                                                <input wire:model.live="selectedServicePackages.{{ $index }}.price" 
                                                       type="number"
                                                       min="0"
                                                       step="0.01"
                                                       class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg 
                                                              bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white
                                                              focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3 text-right">
                                            <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                                Total: R$ {{ number_format(($selectedData['quantity'] ?? 1) * ($selectedData['price'] ?? 0), 2, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="text-zinc-500 dark:text-zinc-400 mb-2">
                                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <p class="text-zinc-600 dark:text-zinc-400">Nenhum pacote de serviços encontrado</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-500 mt-1">
                                    <a href="{{ route('service-packages.create') }}" wire:navigate class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                        Criar primeiro pacote de serviços
                                    </a>
                                </p>
                            </div>
                        @endforelse
                    </div>
                @endif
                
                {{-- Preview dos Itens que serão gerados --}}
                @if($use_services && (count($selectedServiceTemplates) > 0 || count($selectedServicePackages) > 0))
                    <div class="mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-600">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Preview dos Itens da Fatura</h3>
                        <div class="bg-zinc-50 dark:bg-zinc-700 rounded-lg p-4">
                            <div class="space-y-2">
                                @foreach($selectedServiceTemplates as $serviceData)
                                    @php $template = $serviceTemplates->find($serviceData['id']); @endphp
                                    @if($template)
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-zinc-700 dark:text-zinc-300">
                                                {{ $template->name }} ({{ $serviceData['quantity'] ?? 1 }}x {{ $serviceData['hours'] ?? 1 }}h @ R$ {{ number_format($serviceData['rate'] ?? 0, 2, ',', '.') }}/h)
                                            </span>
                                            <span class="font-mono text-zinc-900 dark:text-white">
                                                R$ {{ number_format(($serviceData['quantity'] ?? 1) * ($serviceData['hours'] ?? 1) * ($serviceData['rate'] ?? 0), 2, ',', '.') }}
                                            </span>
                                        </div>
                                    @endif
                                @endforeach
                                
                                @foreach($selectedServicePackages as $packageData)
                                    @php $package = $servicePackages->find($packageData['id']); @endphp
                                    @if($package)
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-zinc-700 dark:text-zinc-300">
                                                {{ $package->name }} ({{ $packageData['quantity'] ?? 1 }}x)
                                            </span>
                                            <span class="font-mono text-zinc-900 dark:text-white">
                                                R$ {{ number_format(($packageData['quantity'] ?? 1) * ($packageData['price'] ?? 0), 2, ',', '.') }}
                                            </span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            
                            <div class="mt-3 pt-3 border-t border-zinc-200 dark:border-zinc-600 flex justify-between items-center">
                                <span class="font-medium text-zinc-900 dark:text-white">Subtotal dos Serviços:</span>
                                <span class="font-bold font-mono text-zinc-900 dark:text-white">
                                    R$ {{ number_format($this->calculateServiceSubtotal(), 2, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            {{-- Itens da Fatura (Modo Manual) --}}
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
            </div>
        @endif

        {{-- Resumo de Valores --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Resumo de Valores</h2>
            
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
