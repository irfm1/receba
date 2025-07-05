<div>
    <form wire:submit="save" class="space-y-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">
                {{ $templateId ? 'Editar Template de Serviço' : 'Novo Template de Serviço' }}
            </h1>
            <p class="text-zinc-600 dark:text-zinc-400">
                Defina os detalhes do template de serviço com preços e especificações
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Form --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Basic Information --}}
                <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">
                        Informações Básicas
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Name --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Nome do Serviço *
                            </label>
                            <input type="text" 
                                   wire:model="name"
                                   class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Categoria *
                            </label>
                            <select wire:model="category"
                                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white">
                                <option value="">Selecionar categoria</option>
                                @foreach($categories as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Unit --}}
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Unidade de Cobrança *
                            </label>
                            <select wire:model="unit"
                                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white">
                                @foreach($units as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('unit')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Base Rate --}}
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Valor Base por Hora *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-zinc-500">R$</span>
                                <input type="number" 
                                       step="0.01"
                                       wire:model="base_rate_per_hour"
                                       class="w-full pl-10 pr-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white">
                            </div>
                            @error('base_rate_per_hour')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Estimated Hours --}}
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Horas Estimadas
                            </label>
                            <input type="number" 
                                   step="0.5"
                                   wire:model="estimated_hours"
                                   class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white">
                            @error('estimated_hours')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Descrição do Serviço *
                            </label>
                            <textarea wire:model="description"
                                      rows="4"
                                      class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white"></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Active Status --}}
                        <div class="md:col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="is_active"
                                       class="rounded border-zinc-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">
                                    Template ativo
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Tags --}}
                <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">
                        Tags
                    </h3>
                    
                    <div class="flex gap-2 mb-3">
                        <input type="text" 
                               wire:model="newTag"
                               wire:keydown.enter.prevent="addTag"
                               placeholder="Adicionar tag..."
                               class="flex-1 px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white">
                        <button type="button" 
                                wire:click="addTag"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                            Adicionar
                        </button>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $index => $tag)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm">
                                {{ $tag }}
                                <button type="button" 
                                        wire:click="removeTag({{ $index }})"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Price Preview --}}
                <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">
                        Prévia de Preços
                    </h3>
                    
                    @if($base_rate_per_hour)
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">Valor por Hora:</span>
                                <span class="font-semibold text-zinc-900 dark:text-white">
                                    R$ {{ number_format($base_rate_per_hour, 2, ',', '.') }}
                                </span>
                            </div>
                            
                            @if($estimated_hours)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Horas Estimadas:</span>
                                    <span class="font-semibold text-zinc-900 dark:text-white">
                                        {{ number_format($estimated_hours, 1) }}h
                                    </span>
                                </div>
                                
                                <hr class="border-zinc-200 dark:border-zinc-700">
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Total Estimado:</span>
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                        R$ {{ number_format($base_rate_per_hour * $estimated_hours, 2, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            Digite o valor por hora para ver a prévia
                        </p>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                            {{ $templateId ? 'Atualizar Template' : 'Criar Template' }}
                        </button>
                        
                        <a href="{{ route('service-templates.index') }}" 
                           wire:navigate
                           class="w-full px-4 py-2 bg-zinc-500 hover:bg-zinc-600 text-white rounded-lg font-medium transition-colors text-center block">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
