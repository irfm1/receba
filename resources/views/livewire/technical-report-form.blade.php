<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">
                {{ $isEditing ? 'Editar Laudo Técnico' : 'Novo Laudo Técnico' }}
            </h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">
                {{ $isEditing ? 'Edite as informações do laudo técnico' : 'Preencha as informações para criar um novo laudo técnico' }}
            </p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('technical-reports.index') }}" 
               class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200">
                Voltar
            </a>
        </div>
    </div>

    <form wire:submit="save" class="space-y-6">
        <!-- Template Selection -->
        @if(!$isEditing && $templates->count() > 0)
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Carregar Template</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($templates as $template)
                        <div class="border border-zinc-200 dark:border-zinc-600 rounded-lg p-4 hover:bg-zinc-50 dark:hover:bg-zinc-700 cursor-pointer"
                             wire:click="loadTemplate({{ $template->id }})">
                            <h3 class="font-medium text-zinc-900 dark:text-white">{{ $template->template_name }}</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $template->title }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 mt-2">
                                {{ $template->report_type_name }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Basic Information -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Informações Básicas</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Cliente *
                    </label>
                    <select wire:model.live="customer_id" 
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecione o cliente</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Invoice -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Fatura Relacionada
                    </label>
                    <select wire:model.live="invoice_id" 
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Nenhuma fatura</option>
                        @foreach($invoices as $invoice)
                            <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }} - R$ {{ number_format($invoice->total_amount, 2, ',', '.') }}</option>
                        @endforeach
                    </select>
                    @error('invoice_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Service Order Number -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Número da OS
                    </label>
                    <input wire:model="service_order_number" 
                           type="text" 
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: OS-2025-001">
                    @error('service_order_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Report Type -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Tipo de Laudo *
                    </label>
                    <select wire:model="report_type" 
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($reportTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('report_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Inspection Date -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Data da Inspeção *
                    </label>
                    <input wire:model="inspection_date" 
                           type="date" 
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('inspection_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Report Date -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Data do Laudo *
                    </label>
                    <input wire:model="report_date" 
                           type="date" 
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('report_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Technician Name -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Nome do Técnico *
                    </label>
                    <input wire:model="technician_name" 
                           type="text" 
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Nome completo do técnico responsável">
                    @error('technician_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Technician Registration -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Registro Profissional
                    </label>
                    <input wire:model="technician_registration" 
                           type="text" 
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: CREA-SP 123456">
                    @error('technician_registration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Status *
                    </label>
                    <select wire:model="status" 
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Valid Until -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Válido até
                    </label>
                    <input wire:model="valid_until" 
                           type="date" 
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('valid_until') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Title and Description -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Título e Descrição</h2>
            
            <div class="space-y-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Título do Laudo *
                    </label>
                    <input wire:model="title" 
                           type="text" 
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: Diagnóstico de Rede e Infraestrutura">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Descrição *
                    </label>
                    <textarea wire:model="description" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Descreva o escopo e objetivo do laudo técnico..."></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Equipment Analysis -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Equipamentos/Sistemas Analisados</h2>
                <button type="button" 
                        wire:click="addEquipment"
                        class="inline-flex items-center gap-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Adicionar Equipamento
                </button>
            </div>

            <!-- Add Equipment Form -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 p-4 bg-zinc-50 dark:bg-zinc-700 rounded-lg">
                <div>
                    <input wire:model="newEquipmentName" 
                           type="text" 
                           placeholder="Nome/Descrição"
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <input wire:model="newEquipmentModel" 
                           type="text" 
                           placeholder="Modelo"
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <input wire:model="newEquipmentSerial" 
                           type="text" 
                           placeholder="Número de Série"
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <input wire:model="newEquipmentStatus" 
                           type="text" 
                           placeholder="Status"
                           class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Equipment List -->
            @if(count($equipment_analyzed) > 0)
                <div class="space-y-3">
                    @foreach($equipment_analyzed as $index => $equipment)
                        <div class="flex items-center gap-4 p-4 bg-zinc-50 dark:bg-zinc-700 rounded-lg">
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <div class="font-medium text-zinc-900 dark:text-white">{{ $equipment['name'] ?? 'N/A' }}</div>
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400">Nome/Descrição</div>
                                </div>
                                <div>
                                    <div class="font-medium text-zinc-900 dark:text-white">{{ $equipment['model'] ?? 'N/A' }}</div>
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400">Modelo</div>
                                </div>
                                <div>
                                    <div class="font-medium text-zinc-900 dark:text-white">{{ $equipment['serial'] ?? 'N/A' }}</div>
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400">Número de Série</div>
                                </div>
                                <div>
                                    <div class="font-medium text-zinc-900 dark:text-white">{{ $equipment['status'] ?? 'N/A' }}</div>
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400">Status</div>
                                </div>
                            </div>
                            <button type="button" 
                                    wire:click="removeEquipment({{ $index }})"
                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                    Nenhum equipamento adicionado ainda
                </div>
            @endif
        </div>

        <!-- Findings, Recommendations, and Observations -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Análise e Conclusões</h2>
            
            <div class="space-y-6">
                <!-- Findings -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Constatações *
                    </label>
                    <textarea wire:model="findings" 
                              rows="6" 
                              class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Descreva as constatações técnicas encontradas durante a inspeção..."></textarea>
                    @error('findings') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Recommendations -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Recomendações *
                    </label>
                    <textarea wire:model="recommendations" 
                              rows="6" 
                              class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Descreva as recomendações técnicas baseadas nas constatações..."></textarea>
                    @error('recommendations') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Observations -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Observações Adicionais
                    </label>
                    <textarea wire:model="observations" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Observações adicionais, limitações, condições especiais..."></textarea>
                    @error('observations') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- File Attachments -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Anexos</h2>
                <button type="button" 
                        wire:click="uploadFiles"
                        class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Enviar Arquivos
                </button>
            </div>

            <!-- File Upload -->
            <div class="mb-6">
                <input wire:model="uploadedFiles" 
                       type="file" 
                       multiple
                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                       class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">
                    Formatos suportados: JPG, PNG, PDF, DOC, DOCX, TXT (máximo 10MB por arquivo)
                </p>
            </div>

            <!-- Attachments List -->
            @if(count($attachments) > 0)
                <div class="space-y-3">
                    @foreach($attachments as $index => $attachment)
                        <div class="flex items-center gap-4 p-4 bg-zinc-50 dark:bg-zinc-700 rounded-lg">
                            <div class="flex-1">
                                <div class="font-medium text-zinc-900 dark:text-white">{{ $attachment['filename'] ?? 'Arquivo' }}</div>
                                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                    Tipo: {{ $attachment['type'] ?? 'Desconhecido' }}
                                    @if(isset($attachment['size']))
                                        • Tamanho: {{ number_format($attachment['size'] / 1024, 2) }} KB
                                    @endif
                                    @if(isset($attachment['uploaded_at']))
                                        • Enviado: {{ \Carbon\Carbon::parse($attachment['uploaded_at'])->format('d/m/Y H:i') }}
                                    @endif
                                </div>
                            </div>
                            <button type="button" 
                                    wire:click="removeAttachment({{ $index }})"
                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                    Nenhum arquivo anexado ainda
                </div>
            @endif
        </div>

        <!-- Template Options -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Opções de Template</h2>
            
            <div class="space-y-4">
                <!-- Save as Template -->
                <div class="flex items-center gap-3">
                    <input wire:model="is_template" 
                           type="checkbox" 
                           id="is_template"
                           class="w-4 h-4 text-blue-600 bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="is_template" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Salvar como template para reutilização
                    </label>
                </div>

                <!-- Template Name -->
                @if($is_template)
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Nome do Template
                        </label>
                        <input wire:model="template_name" 
                               type="text" 
                               class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Ex: Diagnóstico Padrão de Redes">
                        @error('template_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-4 py-6">
            <a href="{{ route('technical-reports.index') }}" 
               class="px-6 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                {{ $isEditing ? 'Atualizar Laudo' : 'Criar Laudo' }}
            </button>
        </div>
    </form>
</div>
