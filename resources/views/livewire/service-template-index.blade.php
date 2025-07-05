<div>
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Templates de Serviços</h1>
            <a href="{{ route('service-templates.create') }}" 
               wire:navigate 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Template
            </a>
        </div>
        <p class="text-zinc-600 dark:text-zinc-400">
            Gerencie templates de serviços de TI com preços e descrições pré-definidos
        </p>
    </div>

    <div class="space-y-4">
        {{-- Filters --}}
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Search --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Buscar
                    </label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Nome ou descrição..."
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white">
                </div>

                {{-- Category Filter --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Categoria
                    </label>
                    <select wire:model.live="categoryFilter"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white">
                        <option value="">Todas as categorias</option>
                        @foreach($categories as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Status
                    </label>
                    <select wire:model.live="activeFilter"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white">
                        <option value="all">Todos</option>
                        <option value="active">Ativos</option>
                        <option value="inactive">Inativos</option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex items-end">
                    <button wire:click="$refresh" 
                            class="px-4 py-2 bg-zinc-500 hover:bg-zinc-600 text-white rounded-lg font-medium transition-colors">
                        Atualizar
                    </button>
                </div>
            </div>
        </div>

        {{-- Results --}}
        @if($templates->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($templates as $template)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 hover:shadow-lg transition-shadow">
                        {{-- Header --}}
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-zinc-900 dark:text-white mb-1">
                                    {{ $template->name }}
                                </h3>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                               bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        {{ $template->category_name }}
                                    </span>
                                    @if($template->is_active)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                     bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            Ativo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                     bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            Inativo
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Actions Dropdown --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition
                                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-800 rounded-md shadow-lg border border-zinc-200 dark:border-zinc-700 z-10">
                                    <div class="py-1">
                                        <a href="{{ route('service-templates.edit', $template) }}" 
                                           wire:navigate
                                           class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                            Editar
                                        </a>
                                        <button wire:click="toggleActive({{ $template->id }})"
                                                class="w-full text-left px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                            {{ $template->is_active ? 'Desativar' : 'Ativar' }}
                                        </button>
                                        <button wire:click="confirmDelete({{ $template->id }})"
                                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                            Excluir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4 line-clamp-3">
                            {{ $template->description }}
                        </p>

                        {{-- Price Info --}}
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Valor Base:
                                </span>
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                    {{ $template->formatted_rate }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                    Unidade:
                                </span>
                                <span class="text-sm text-zinc-900 dark:text-white">
                                    {{ $template->unit_name }}
                                </span>
                            </div>
                            @if($template->estimated_hours)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                        Horas Estimadas:
                                    </span>
                                    <span class="text-sm text-zinc-900 dark:text-white">
                                        {{ number_format($template->estimated_hours, 1) }}h
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                        Custo Estimado:
                                    </span>
                                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                        {{ $template->formatted_estimated_cost }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Tags --}}
                        @if($template->tags && count($template->tags) > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($template->tags, 0, 3) as $tag)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                                 bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                                @if(count($template->tags) > 3)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                                 bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300">
                                        +{{ count($template->tags) - 3 }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $templates->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-zinc-900 dark:text-white">
                    Nenhum template encontrado
                </h3>
                <p class="mt-1 text-zinc-500 dark:text-zinc-400">
                    @if($search || $categoryFilter || $activeFilter !== 'all')
                        Tente ajustar os filtros ou criar um novo template.
                    @else
                        Comece criando seu primeiro template de serviço.
                    @endif
                </p>
                <div class="mt-6">
                    <a href="{{ route('service-templates.create') }}" 
                       wire:navigate
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Criar Template
                    </a>
                </div>
            </div>
        @endif
    </div>

    {{-- Delete Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 w-full max-w-md">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zM8 11V9a1 1 0 012 0v2a1 1 0 11-2 0zm0 4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            Confirmar Exclusão
                        </h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            Esta ação não pode ser desfeita.
                        </p>
                    </div>
                </div>
                
                <p class="text-zinc-700 dark:text-zinc-300 mb-6">
                    Tem certeza de que deseja excluir este template de serviço?
                </p>
                
                <div class="flex gap-3 justify-end">
                    <button wire:click="$set('showDeleteModal', false)"
                            class="px-4 py-2 text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="deleteTemplate"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                        Excluir
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
