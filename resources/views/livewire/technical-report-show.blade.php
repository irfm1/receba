<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">
                Laudo Técnico #{{ $report->report_number }}
            </h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">{{ $report->title }}</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('technical-reports.index') }}" 
               class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200">
                Voltar
            </a>
            <a href="{{ route('technical-reports.edit', $report) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </a>
        </div>
    </div>

    <!-- Status and Actions -->
    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($report->status === 'draft') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                    @elseif($report->status === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                    @elseif($report->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($report->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @else bg-zinc-100 text-zinc-800 dark:bg-zinc-900 dark:text-zinc-200 @endif">
                    {{ $report->status_name }}
                </span>
                
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($report->report_type === 'diagnostico') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                    @elseif($report->report_type === 'instalacao') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($report->report_type === 'manutencao') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @elseif($report->report_type === 'seguranca') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @else bg-zinc-100 text-zinc-800 dark:bg-zinc-900 dark:text-zinc-200 @endif">
                    {{ $report->report_type_name }}
                </span>

                @if($report->is_expired)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                        Vencido
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-2">
                @if($report->status === 'completed')
                    <button wire:click="approve" 
                            class="inline-flex items-center gap-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Aprovar
                    </button>
                    <button wire:click="reject" 
                            class="inline-flex items-center gap-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Rejeitar
                    </button>
                @endif

                <a href="{{ route('technical-reports.pdf', $report) }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Baixar PDF
                </a>

                <button onclick="sendEmail()" 
                        class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Enviar Email
                </button>

                <button wire:click="duplicate" 
                        class="inline-flex items-center gap-2 px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Duplicar
                </button>
            </div>
        </div>
    </div>

    <!-- Report Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Client Information -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Informações do Cliente</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Nome:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->customer->name }}</span>
                </div>
                @if($report->customer->email)
                    <div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Email:</span>
                        <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->customer->email }}</span>
                    </div>
                @endif
                @if($report->customer->phone)
                    <div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Telefone:</span>
                        <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->customer->phone }}</span>
                    </div>
                @endif
                @if($report->customer->document_number)
                    <div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $report->customer->document_type === 'cpf' ? 'CPF' : 'CNPJ' }}:</span>
                        <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->customer->document_number }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Report Details -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Detalhes do Laudo</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Número:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->report_number }}</span>
                </div>
                <div>
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Data de Inspeção:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->inspection_date->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Data do Laudo:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->report_date->format('d/m/Y') }}</span>
                </div>
                @if($report->service_order_number)
                    <div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">OS:</span>
                        <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->service_order_number }}</span>
                    </div>
                @endif
                @if($report->invoice)
                    <div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Fatura:</span>
                        <a href="{{ route('invoices.show', $report->invoice) }}" 
                           class="ml-2 font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                            {{ $report->invoice->invoice_number }}
                        </a>
                    </div>
                @endif
                @if($report->valid_until)
                    <div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Válido até:</span>
                        <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->valid_until->format('d/m/Y') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Technician Information -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Responsável Técnico</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Nome:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->technician_name }}</span>
                </div>
                @if($report->technician_registration)
                    <div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Registro:</span>
                        <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->technician_registration }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Approval Information -->
        @if($report->approved_by)
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Aprovação</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Aprovado por:</span>
                        <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->approved_by }}</span>
                    </div>
                    <div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Data:</span>
                        <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->approved_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($report->approval_notes)
                        <div>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Observações:</span>
                            <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $report->approval_notes }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Description -->
    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Descrição</h3>
        <p class="text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap">{{ $report->description }}</p>
    </div>

    <!-- Equipment Analyzed -->
    @if($report->equipment_analyzed && count($report->equipment_analyzed) > 0)
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Equipamentos/Sistemas Analisados</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Nome/Descrição</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Modelo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Número de Série</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($report->equipment_analyzed as $equipment)
                            <tr>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">{{ $equipment['name'] ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">{{ $equipment['model'] ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">{{ $equipment['serial'] ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">{{ $equipment['status'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Findings -->
    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Constatações</h3>
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap">{{ $report->findings }}</p>
        </div>
    </div>

    <!-- Recommendations -->
    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Recomendações</h3>
        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 rounded">
            <p class="text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap">{{ $report->recommendations }}</p>
        </div>
    </div>

    <!-- Observations -->
    @if($report->observations)
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Observações Adicionais</h3>
            <div class="bg-zinc-50 dark:bg-zinc-700 border-l-4 border-zinc-400 p-4 rounded">
                <p class="text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap">{{ $report->observations }}</p>
            </div>
        </div>
    @endif

    <!-- Attachments -->
    @if($report->attachments && count($report->attachments) > 0)
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Anexos</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($report->attachments as $attachment)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700 rounded-lg">
                        <svg class="w-8 h-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div class="flex-1">
                            <div class="font-medium text-zinc-900 dark:text-white">{{ $attachment['filename'] ?? 'Arquivo' }}</div>
                            <div class="text-sm text-zinc-600 dark:text-zinc-400">{{ $attachment['type'] ?? 'Tipo desconhecido' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function sendEmail() {
    if (confirm('Enviar laudo técnico por email para {{ $report->customer->name }}?')) {
        fetch('{{ route("technical-reports.send-email", $report) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao enviar email');
        });
    }
}
</script>
