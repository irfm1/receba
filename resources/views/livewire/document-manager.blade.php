<div>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold text-gray-900">Gestão de Documentos</h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Gerencie uploads, organize e acesse documentos do sistema
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <flux:button variant="primary" wire:click="openUploadModal">
                        ➕ Enviar Documentos
                    </flux:button>
                </div>
            </div>
        </div>

        <!-- Storage Stats -->
        @php
            $storageStats = $this->getStorageStats();
        @endphp
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Estatísticas de Armazenamento</h2>
                <flux:badge variant="gray" size="sm">
                    ☁️ Local
                </flux:badge>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Total de Arquivos</span>
                        <span class="text-2xl">📄</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $storageStats['total_count'] }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Espaço Utilizado</span>
                        <span class="text-2xl">💾</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $storageStats['total_size'] }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Categorias</span>
                        <span class="text-2xl">📁</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ count($storageStats['categories']) }}</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <flux:input 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Pesquisar documentos..."
                        class="w-full"
                    />
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <flux:select wire:model.live="selectedCategory" placeholder="Todas as categorias">
                        <option value="">Todas as categorias</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </flux:select>
                    
                    <flux:select wire:model.live="selectedCustomer" placeholder="Todos os clientes">
                        <option value="">Todos os clientes</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </flux:select>
                    
                    <flux:button variant="ghost" wire:click="clearFilters">
                        ❌ Limpar
                    </flux:button>
                </div>
            </div>
        </div>

        <!-- Documents List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Documentos</h3>
            </div>

            @if($documents->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($documents as $document)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="text-3xl">📄</span>
                                    </div>
                                    
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-medium text-gray-900 truncate">{{ $document->name }}</h4>
                                            <flux:badge variant="gray" size="sm">{{ $document->category }}</flux:badge>
                                        </div>
                                        
                                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                                            <span>{{ $document->formatted_file_size }}</span>
                                            <span>{{ $document->created_at->format('d/m/Y H:i') }}</span>
                                            <span>Por: {{ $document->uploadedBy->name }}</span>
                                        </div>
                                        
                                        @if($document->description)
                                            <p class="text-sm text-gray-600 mt-1">{{ $document->description }}</p>
                                        @endif
                                        
                                        @if($document->customer || $document->invoice || $document->technicalReport)
                                            <div class="flex items-center gap-2 mt-2">
                                                @if($document->customer)
                                                    <flux:badge variant="blue" size="sm">
                                                        Cliente: {{ $document->customer->name }}
                                                    </flux:badge>
                                                @endif
                                                @if($document->invoice)
                                                    <flux:badge variant="green" size="sm">
                                                        Fatura: {{ $document->invoice->invoice_number }}
                                                    </flux:badge>
                                                @endif
                                                @if($document->technicalReport)
                                                    <flux:badge variant="purple" size="sm">
                                                        Laudo: {{ $document->technicalReport->report_number }}
                                                    </flux:badge>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <flux:button 
                                        variant="ghost" 
                                        size="sm"
                                        wire:click="downloadDocument({{ $document->id }})"
                                    >
                                        ⬇️ Download
                                    </flux:button>
                                    
                                    <flux:button 
                                        variant="ghost" 
                                        size="sm"
                                        wire:click="confirmDelete({{ $document->id }})"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        🗑️ Excluir
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $documents->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <span class="text-6xl text-gray-400">📄</span>
                    <p class="text-gray-600 mt-4">Nenhum documento encontrado</p>
                    <p class="text-sm text-gray-500 mt-1">
                        Clique em "Enviar Documentos" para adicionar arquivos
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Upload Modal -->
    @if($showUploadModal)
        <flux:modal name="upload-modal" :show="$showUploadModal">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Enviar Documentos</h3>
                    <flux:button variant="ghost" size="sm" wire:click="closeUploadModal">
                        ❌
                    </flux:button>
                </div>

                <form wire:submit="uploadDocuments" class="space-y-4">
                    <div>
                        <flux:label for="files">Arquivos (máx. 10MB cada)</flux:label>
                        <flux:input 
                            id="files"
                            type="file" 
                            wire:model="uploadedFiles"
                            multiple
                            accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar"
                            class="mt-1"
                        />
                        @error('uploadedFiles.*') 
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </div>

                    <div>
                        <flux:label for="category">Categoria</flux:label>
                        <flux:select id="category" wire:model="category" class="mt-1">
                            <option value="">Selecionar categoria</option>
                            <option value="Contrato">Contrato</option>
                            <option value="Fatura">Fatura</option>
                            <option value="Laudo Técnico">Laudo Técnico</option>
                            <option value="Certificado">Certificado</option>
                            <option value="Comprovante">Comprovante</option>
                            <option value="Outros">Outros</option>
                        </flux:select>
                        @error('category') 
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </div>

                    <div>
                        <flux:label for="description">Descrição (opcional)</flux:label>
                        <flux:textarea 
                            id="description"
                            wire:model="description"
                            rows="3"
                            class="mt-1"
                        />
                        @error('description') 
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <flux:label for="customer">Cliente (opcional)</flux:label>
                            <flux:select id="customer" wire:model="customer_id" class="mt-1">
                                <option value="">Selecionar cliente</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div>
                            <flux:label for="invoice">Fatura (opcional)</flux:label>
                            <flux:input 
                                id="invoice"
                                type="number"
                                wire:model="invoice_id"
                                placeholder="ID da fatura"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <flux:label for="technical_report">Laudo Técnico (opcional)</flux:label>
                            <flux:input 
                                id="technical_report"
                                type="number"
                                wire:model="technical_report_id"
                                placeholder="ID do laudo"
                                class="mt-1"
                            />
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <flux:button variant="ghost" wire:click="closeUploadModal">
                            Cancelar
                        </flux:button>
                        <flux:button type="submit" variant="primary">
                            ☁️ Enviar Documentos
                        </flux:button>
                    </div>
                </form>
            </div>
        </flux:modal>
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal)
        <flux:modal name="delete-modal" :show="$showDeleteModal">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <span class="text-red-500 mr-3 text-2xl">🗑️</span>
                    <h3 class="text-lg font-semibold text-gray-900">Confirmar Exclusão</h3>
                </div>
                
                <p class="text-gray-600 mb-6">
                    Tem certeza que deseja excluir este documento?
                    Esta ação não pode ser desfeita.
                </p>
                
                <div class="flex justify-end space-x-3">
                    <flux:button variant="ghost" wire:click="cancelDelete">
                        Cancelar
                    </flux:button>
                    <flux:button variant="danger" wire:click="deleteDocument">
                        🗑️ Excluir
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
