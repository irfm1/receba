<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Simulador de Impostos</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">Calcule impostos brasileiros para serviços de TI</p>
        </div>
    </div>

    <!-- Formulário de Simulação -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Parâmetros da Simulação</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <flux:input 
                    wire:model.live="amount" 
                    type="number" 
                    step="0.01" 
                    label="Valor do Serviço (R$)" 
                    placeholder="5000.00"
                />
            </div>
            
            <div>
                <flux:select wire:model.live="city" label="Município">
                    @foreach($cities as $code => $name)
                        <option value="{{ $code }}">{{ $name }}</option>
                    @endforeach
                </flux:select>
            </div>
            
            <div>
                <flux:select wire:model.live="regime" label="Regime Tributário">
                    <option value="pessoa_fisica">Pessoa Física</option>
                    <option value="simples">Simples Nacional</option>
                    <option value="presumido">Lucro Presumido</option>
                    <option value="real">Lucro Real</option>
                </flux:select>
            </div>
            
            @if($regime === 'simples')
                <div>
                    <flux:input 
                        wire:model.live="annualRevenue" 
                        type="number" 
                        step="0.01" 
                        label="Faturamento Anual (R$)" 
                        placeholder="180000.00"
                    />
                </div>
                
                <div>
                    <flux:select wire:model.live="annex" label="Anexo Simples Nacional">
                        <option value="III">Anexo III - Desenvolvimento</option>
                        <option value="V">Anexo V - Consultoria</option>
                    </flux:select>
                </div>
            @endif
            
            @if($regime === 'pessoa_fisica')
                <div class="flex items-center">
                    <flux:checkbox wire:model.live="withINSS" label="Incluir INSS" />
                </div>
            @endif
        </div>
    </div>

    <!-- Resultado da Simulação -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Resultado da Simulação</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Valor Bruto -->
            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <p class="text-sm text-gray-500 dark:text-gray-400">Valor Bruto</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    R$ {{ number_format($results['gross_amount'] ?? 0, 2, ',', '.') }}
                </p>
            </div>
            
            <!-- Total de Impostos -->
            <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                <p class="text-sm text-red-600 dark:text-red-400">Total de Impostos</p>
                <p class="text-2xl font-bold text-red-600 dark:text-red-400">
                    R$ {{ number_format($results['total_tax'] ?? 0, 2, ',', '.') }}
                </p>
                <p class="text-sm text-red-500 dark:text-red-400">
                    ({{ number_format(($results['effective_rate'] ?? 0) * 100, 2) }}%)
                </p>
            </div>
            
            <!-- Valor Líquido -->
            <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <p class="text-sm text-green-600 dark:text-green-400">Valor Líquido</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                    R$ {{ number_format($results['net_amount'] ?? 0, 2, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Detalhamento dos Impostos -->
        @if(isset($results['taxes']))
            <div class="space-y-4">
                <h4 class="text-md font-semibold text-gray-900 dark:text-white">Detalhamento dos Impostos</h4>
                
                @foreach($results['taxes'] as $taxType => $taxData)
                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h5 class="font-medium text-gray-900 dark:text-white">
                                    {{ match($taxType) {
                                        'iss' => 'ISS - Imposto Sobre Serviços',
                                        'simples_nacional' => 'Simples Nacional (DAS)',
                                        'inss' => 'INSS - Contribuição Social',
                                        'irrf' => 'IRRF - Imposto de Renda Retido na Fonte',
                                        default => strtoupper($taxType)
                                    } }}
                                </h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Alíquota: {{ number_format(($taxData['rate'] ?? 0) * 100, 2) }}%
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    R$ {{ number_format($taxData['amount'] ?? 0, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        
                        @if(isset($taxData['error']))
                            <div class="mt-2 p-2 bg-red-50 dark:bg-red-900/20 rounded text-sm text-red-600 dark:text-red-400">
                                {{ $taxData['error'] }}
                            </div>
                        @endif
                        
                        @if(isset($taxData['bracket']))
                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Faixa: R$ {{ number_format($taxData['bracket']['min'], 2, ',', '.') }} - 
                                R$ {{ number_format($taxData['bracket']['max'], 2, ',', '.') }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Comparação de Cenários -->
    @if(!empty($comparison))
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Comparação de Cenários</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-white">Regime</th>
                            <th class="text-right py-3 px-4 font-medium text-gray-900 dark:text-white">Valor Bruto</th>
                            <th class="text-right py-3 px-4 font-medium text-gray-900 dark:text-white">Impostos</th>
                            <th class="text-right py-3 px-4 font-medium text-gray-900 dark:text-white">Alíquota</th>
                            <th class="text-right py-3 px-4 font-medium text-gray-900 dark:text-white">Valor Líquido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comparison as $scenario => $data)
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">
                                    {{ match($scenario) {
                                        'pessoa_fisica' => 'Pessoa Física',
                                        'simples_nacional_anexo_iii' => 'Simples Nacional - Anexo III',
                                        'simples_nacional_anexo_v' => 'Simples Nacional - Anexo V',
                                        default => $scenario
                                    } }}
                                </td>
                                <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">
                                    R$ {{ number_format($data['gross_amount'], 2, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-right text-red-600 dark:text-red-400">
                                    R$ {{ number_format($data['total_tax'], 2, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">
                                    {{ number_format($data['effective_rate'] * 100, 2) }}%
                                </td>
                                <td class="py-3 px-4 text-right font-semibold text-green-600 dark:text-green-400">
                                    R$ {{ number_format($data['net_amount'], 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Informações Importantes -->
    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">
            ℹ️ Informações Importantes
        </h3>
        <div class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
            <p><strong>Simples Nacional:</strong> Regime tributário para empresas com faturamento até R$ 4.800.000,00 anuais.</p>
            <p><strong>Anexo III:</strong> Para atividades de desenvolvimento de software e programação.</p>
            <p><strong>Anexo V:</strong> Para atividades de consultoria e assessoria técnica.</p>
            <p><strong>ISS:</strong> Imposto municipal que varia de 2% a 5% dependendo do município.</p>
            <p><strong>INSS:</strong> Contribuição de 20% sobre o valor recebido, limitado ao teto previdenciário.</p>
            <p><strong>IRRF:</strong> Imposto de renda retido na fonte, com alíquotas progressivas.</p>
        </div>
    </div>

    <!-- Disclaimer -->
    <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-yellow-900 dark:text-yellow-100 mb-3">
            ⚠️ Aviso Legal
        </h3>
        <p class="text-sm text-yellow-800 dark:text-yellow-200">
            Este simulador é uma ferramenta auxiliar e os cálculos são aproximados. Para cálculos precisos e decisões 
            tributárias importantes, consulte sempre um contador ou advogado tributarista. As alíquotas e regras podem 
            variar conforme legislação municipal e alterações na legislação federal.
        </p>
    </div>
</div>
