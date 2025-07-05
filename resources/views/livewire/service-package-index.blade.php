<div>
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Pacotes de Serviços</h1>
            <a href="{{ route('service-packages.create') }}" 
               wire:navigate 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Pacote
            </a>
        </div>
        <p class="text-zinc-600 dark:text-zinc-400">
            Gerencie pacotes de serviços com preços fixos e múltiplos serviços inclusos
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
        @if($packages->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($packages as $package)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-lg transition-shadow">
                        {{-- Package content --}}
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-2">
                                        {{ $package->name }}
                                    </h3>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                   bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                            {{ $package->category_name }}
                                        </span>
                                        @if($package->is_active)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                         bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                Ativo
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Price --}}
                            <div class="mb-4">
                                <span class="text-2xl font-bold text-zinc-900 dark:text-white">
                                    {{ $package->formatted_price }}
                                </span>
                                @if($package->estimated_duration_days)
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                        Prazo: {{ $package->estimated_duration }}
                                    </p>
                                @endif
                            </div>

                            {{-- Description --}}
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-3">
                                {{ $package->description }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $packages->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-zinc-900 dark:text-white">
                    Nenhum pacote encontrado
                </h3>
                <p class="mt-1 text-zinc-500 dark:text-zinc-400">
                    Comece criando seu primeiro pacote de serviços.
                </p>
                <div class="mt-6">
                    <a href="{{ route('service-packages.create') }}" 
                       wire:navigate
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Criar Pacote
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
