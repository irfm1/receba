<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Relatórios Financeiros</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">Análise completa da performance financeira</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
            <flux:button wire:click="exportToCsv" variant="outline" icon="document-arrow-down" size="sm">
                Exportar CSV
            </flux:button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <flux:select wire:model.live="selectedPeriod" label="Período" placeholder="Selecione o período">
                    <flux:option value="current_month">Mês Atual</flux:option>
                    <flux:option value="last_month">Mês Passado</flux:option>
                    <flux:option value="current_year">Ano Atual</flux:option>
                    <flux:option value="last_year">Ano Passado</flux:option>
                    <flux:option value="custom">Personalizado</flux:option>
                </flux:select>
            </div>
            
            @if($selectedPeriod === 'custom')
                <div>
                    <flux:input wire:model.live="startDate" type="date" label="Data Início" />
                </div>
                <div>
                    <flux:input wire:model.live="endDate" type="date" label="Data Fim" />
                </div>
            @endif
            
            <div>
                <flux:select wire:model.live="selectedCustomer" label="Cliente" placeholder="Todos os clientes">
                    <flux:option value="">Todos os clientes</flux:option>
                    @foreach($customers as $customer)
                        <flux:option value="{{ $customer->id }}">{{ $customer->name }}</flux:option>
                    @endforeach
                </flux:select>
            </div>
        </div>
    </div>

    <!-- Cards de Resumo -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Receita Total -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Receita Total</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        R$ {{ number_format($revenueData['total_revenue'], 2, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Receita Paga -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Receita Paga</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        R$ {{ number_format($revenueData['paid_revenue'], 2, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Receita Pendente -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Receita Pendente</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        R$ {{ number_format($revenueData['pending_revenue'], 2, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Receita Vencida -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Receita Vencida</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        R$ {{ number_format($revenueData['overdue_revenue'], 2, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Receita Mensal -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Receita Mensal</h3>
            <div class="h-64">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>

        <!-- Receita por Tipo de Serviço -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Receita por Tipo de Serviço</h3>
            <div class="h-64">
                <canvas id="serviceRevenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Clientes -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Clientes</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-white">Cliente</th>
                        <th class="text-right py-3 px-4 font-medium text-gray-900 dark:text-white">Receita Total</th>
                        <th class="text-right py-3 px-4 font-medium text-gray-900 dark:text-white">Faturas</th>
                        <th class="text-right py-3 px-4 font-medium text-gray-900 dark:text-white">Ticket Médio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topCustomers as $customer)
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                            {{ substr($customer->customer->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $customer->customer->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->customer->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-right font-medium text-gray-900 dark:text-white">
                                R$ {{ number_format($customer->total_revenue, 2, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">
                                {{ $customer->invoice_count }}
                            </td>
                            <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">
                                R$ {{ number_format($customer->total_revenue / $customer->invoice_count, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Resumo de Laudos Técnicos -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Resumo de Laudos Técnicos</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="text-center">
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $technicalReportsData['total_reports'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total de Laudos</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $technicalReportsData['completed_reports'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Concluídos</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $technicalReportsData['approved_reports'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Aprovados</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $technicalReportsData['draft_reports'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Rascunhos</p>
            </div>
        </div>

        <!-- Laudos por Tipo -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($technicalReportsData['by_type'] as $type => $count)
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">{{ $count }}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ match($type) {
                                'diagnostico' => 'Diagnóstico',
                                'instalacao' => 'Instalação',
                                'manutencao' => 'Manutenção',
                                'seguranca' => 'Segurança',
                                'performance' => 'Performance',
                                'infraestrutura' => 'Infraestrutura',
                                default => 'Outros'
                            } }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if chart data exists
        const monthlyData = @json($monthlyRevenue);
        const serviceData = @json($serviceRevenue);
        
        // Gráfico de Receita Mensal
        const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart');
        if (monthlyRevenueCtx && monthlyData.length > 0) {
            new Chart(monthlyRevenueCtx, {
                type: 'line',
                data: {
                    labels: monthlyData.map(item => item.month),
                    datasets: [{
                        label: 'Receita Mensal',
                        data: monthlyData.map(item => parseFloat(item.total)),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR');
                                }
                            }
                        }
                    }
                }
            });
        } else if (monthlyRevenueCtx) {
            // Show empty state
            monthlyRevenueCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-64 text-gray-500">Nenhum dado disponível</div>';
        }

        // Gráfico de Receita por Tipo de Serviço
        const serviceRevenueCtx = document.getElementById('serviceRevenueChart');
        if (serviceRevenueCtx && serviceData.length > 0) {
            new Chart(serviceRevenueCtx, {
                type: 'doughnut',
                data: {
                    labels: serviceData.map(item => item.service_type || 'Não especificado'),
                    datasets: [{
                        data: serviceData.map(item => parseFloat(item.total_revenue)),
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(139, 92, 246, 0.8)',
                            'rgba(236, 72, 153, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        } else if (serviceRevenueCtx) {
            // Show empty state
            serviceRevenueCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-64 text-gray-500">Nenhum dado disponível</div>';
        }
    });
</script>
@endpush
