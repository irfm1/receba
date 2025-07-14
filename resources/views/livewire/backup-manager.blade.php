<div>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Gestão de Backup</h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Faça backup local dos seus dados e restaure quando necessário
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                        📁 Local
                    </span>
                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                        🗄️ SQLite
                    </span>
                </div>
            </div>
        </div>

        <!-- Storage Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Informações de Armazenamento</h2>
                <flux:button variant="ghost" size="sm" wire:click="refreshStorageInfo">
                    🔄 Atualizar
                </flux:button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Banco de Dados</span>
                        <span class="text-2xl">🗄️</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $this->systemInfo['database_size'] ?? 'N/A' }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Backups</span>
                        <span class="text-2xl">📦</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $this->systemInfo['total_backups'] ?? 0 }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Espaço Total</span>
                        <span class="text-2xl">💾</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $this->systemInfo['disk_usage'] ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Backup Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Ações de Backup</h2>
                <div class="flex items-center space-x-2">
                    @if($isCreatingBackup)
                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                            ⏳ Processando...
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Create Backup -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <span class="text-green-500 mr-2 text-xl">✅</span>
                        <h3 class="font-semibold text-gray-900">Criar Backup</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">
                        Crie um backup completo do banco de dados SQLite
                    </p>
                    <flux:button 
                        variant="primary" 
                        size="sm" 
                        wire:click="createBackup"
                        :disabled="$isCreatingBackup"
                        class="w-full"
                    >
                        ➕ Criar Backup
                    </flux:button>
                </div>

                <!-- Auto Backup Settings -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <span class="text-blue-500 mr-2 text-xl">⏰</span>
                        <h3 class="font-semibold text-gray-900">Backup Automático</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">
                        Configure backups automáticos diários
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Ativado</span>
                        <flux:checkbox 
                            wire:model.live="autoBackupEnabled"
                            size="sm"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Backup History -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Histórico de Backups</h2>
                <flux:button variant="ghost" size="sm" wire:click="refreshBackupList">
                    🔄 Atualizar
                </flux:button>
            </div>

            @if(count($backups) > 0)
                <div class="space-y-3">
                    @foreach($backups as $backup)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <span class="text-gray-400 text-xl">📦</span>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $backup['name'] }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $backup['created_at'] }} • {{ $backup['size'] }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <flux:button 
                                        variant="ghost" 
                                        size="sm"
                                        wire:click="downloadBackup('{{ $backup['filename'] }}')"
                                    >
                                        ⬇️ Download
                                    </flux:button>
                                    
                                    <flux:button 
                                        variant="ghost" 
                                        size="sm"
                                        wire:click="confirmRestore('{{ $backup['filename'] }}')"
                                    >
                                        ↩️ Restaurar
                                    </flux:button>
                                    
                                    <flux:button 
                                        variant="ghost" 
                                        size="sm"
                                        wire:click="confirmDelete('{{ $backup['filename'] }}')"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        🗑️ Excluir
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <span class="text-6xl text-gray-400">📦</span>
                    <p class="text-gray-600 mt-4">Nenhum backup encontrado</p>
                    <p class="text-sm text-gray-500 mt-1">
                        Clique em "Criar Backup" para fazer seu primeiro backup
                    </p>
                </div>
            @endif
        </div>

        <!-- Restore Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center mb-4">
                <span class="text-orange-500 mr-2 text-xl">↩️</span>
                <h2 class="text-lg font-semibold text-gray-900">Restaurar Backup</h2>
            </div>

            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-4">
                <div class="flex items-center">
                    <span class="text-orange-500 mr-2 text-xl">⚠️</span>
                    <p class="text-sm text-orange-800">
                        <strong>Atenção:</strong> A restauração irá substituir todos os dados atuais pelos dados do backup selecionado.
                    </p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <flux:label for="backup-file">Arquivo de Backup</flux:label>
                    <flux:input 
                        id="backup-file"
                        type="file" 
                        accept=".sqlite,.db"
                        wire:model="backupFile"
                        class="mt-1"
                    />
                    @error('backupFile') 
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>

                <flux:button 
                    variant="ghost" 
                    size="sm"
                    wire:click="restoreFromFile"
                    :disabled="!$backupFile || $isCreatingBackup"
                >
                    ↩️ Restaurar do Arquivo
                </flux:button>
            </div>
        </div>
    </div>

    <!-- Confirmation Modals -->
    @if($showRestoreModal)
        <flux:modal name="restore-confirmation" :show="$showRestoreModal">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <span class="text-orange-500 mr-3 text-2xl">⚠️</span>
                    <h3 class="text-lg font-semibold text-gray-900">Confirmar Restauração</h3>
                </div>
                
                <p class="text-gray-600 mb-6">
                    Tem certeza que deseja restaurar o backup <strong>{{ $selectedBackup }}</strong>?
                    Esta ação irá substituir todos os dados atuais e não pode ser desfeita.
                </p>
                
                <div class="flex justify-end space-x-3">
                    <flux:button variant="ghost" wire:click="cancelRestore">
                        Cancelar
                    </flux:button>
                    <flux:button variant="danger" wire:click="restoreBackup">
                        ↩️ Restaurar
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    @endif

    @if($showDeleteModal)
        <flux:modal name="delete-confirmation" :show="$showDeleteModal">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <span class="text-red-500 mr-3 text-2xl">🗑️</span>
                    <h3 class="text-lg font-semibold text-gray-900">Confirmar Exclusão</h3>
                </div>
                
                <p class="text-gray-600 mb-6">
                    Tem certeza que deseja excluir o backup <strong>{{ $selectedBackup }}</strong>?
                    Esta ação não pode ser desfeita.
                </p>
                
                <div class="flex justify-end space-x-3">
                    <flux:button variant="ghost" wire:click="cancelDelete">
                        Cancelar
                    </flux:button>
                    <flux:button variant="danger" wire:click="deleteBackup">
                        🗑️ Excluir
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
