<?php

namespace Database\Seeders;

use App\Models\TechnicalReport;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class TechnicalReportSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $invoices = Invoice::all();

        if ($customers->isEmpty()) {
            $this->command->info('Nenhum cliente encontrado. Execute o CustomerSeeder primeiro.');
            return;
        }

        $reports = [
            [
                'title' => 'Diagnóstico de Rede Corporativa',
                'description' => 'Análise completa da infraestrutura de rede corporativa incluindo switches, roteadores e pontos de acesso.',
                'report_type' => TechnicalReport::TYPE_DIAGNOSTICO,
                'technician_name' => 'João Silva',
                'technician_registration' => 'CREA-SP 123456',
                'findings' => "Durante a análise da infraestrutura de rede, foram identificados os seguintes problemas:\n\n1. Sobrecarga no switch principal (utilização >90%)\n2. Configuração inadequada de VLANs\n3. Ausência de redundância no link principal\n4. Pontos de acesso Wi-Fi com sinal fraco em algumas áreas\n5. Cabeamento Cat5e inadequado para a demanda atual",
                'recommendations' => "Para solucionar os problemas identificados, recomenda-se:\n\n1. Upgrade do switch principal para modelo com maior capacidade\n2. Reconfiguração das VLANs seguindo boas práticas\n3. Implementação de link redundante\n4. Instalação de pontos de acesso adicionais\n5. Upgrade do cabeamento para Cat6 ou superior\n6. Implementação de sistema de monitoramento de rede",
                'observations' => 'O cliente demonstrou interesse em implementar as melhorias em fases, priorizando os itens críticos.',
                'equipment_analyzed' => [
                    [
                        'name' => 'Switch Principal',
                        'model' => 'Cisco Catalyst 2960',
                        'serial' => 'FDO1234567',
                        'status' => 'Sobregregado',
                        'analyzed_at' => now()->subDays(1)->toISOString(),
                    ],
                    [
                        'name' => 'Roteador Principal',
                        'model' => 'Cisco ASR 1001',
                        'serial' => 'JAE1234567',
                        'status' => 'Funcionando',
                        'analyzed_at' => now()->subDays(1)->toISOString(),
                    ],
                    [
                        'name' => 'Access Point Sala 1',
                        'model' => 'Ubiquiti UniFi AP AC Pro',
                        'serial' => 'UB1234567',
                        'status' => 'Sinal fraco',
                        'analyzed_at' => now()->subDays(1)->toISOString(),
                    ],
                ],
                'status' => TechnicalReport::STATUS_APPROVED,
                'approved_by' => 'Gerente de TI',
                'approved_at' => now()->subHours(2),
                'valid_until' => now()->addMonths(6),
            ],
            [
                'title' => 'Laudo de Segurança da Informação',
                'description' => 'Avaliação da segurança dos sistemas e processos de TI da empresa.',
                'report_type' => TechnicalReport::TYPE_SEGURANCA,
                'technician_name' => 'Maria Santos',
                'technician_registration' => 'CREA-RJ 987654',
                'findings' => "A auditoria de segurança identificou:\n\n1. Políticas de senha inadequadas\n2. Falta de autenticação multifator\n3. Sistemas desatualizados\n4. Ausência de backup automatizado\n5. Logs de auditoria insuficientes\n6. Controle de acesso físico deficiente",
                'recommendations' => "Para melhorar a segurança, recomenda-se:\n\n1. Implementar política de senhas forte\n2. Habilitar autenticação multifator\n3. Atualizar todos os sistemas\n4. Configurar backups automáticos\n5. Implementar sistema de logs centralizado\n6. Melhorar controle de acesso físico\n7. Treinamento de conscientização em segurança",
                'observations' => 'Algumas vulnerabilidades foram classificadas como críticas e requerem atenção imediata.',
                'equipment_analyzed' => [
                    [
                        'name' => 'Servidor Web',
                        'model' => 'Dell PowerEdge R730',
                        'serial' => 'DELL123456',
                        'status' => 'Vulnerável',
                        'analyzed_at' => now()->subDays(2)->toISOString(),
                    ],
                    [
                        'name' => 'Firewall',
                        'model' => 'Fortinet FortiGate 100D',
                        'serial' => 'FGT123456',
                        'status' => 'Configuração inadequada',
                        'analyzed_at' => now()->subDays(2)->toISOString(),
                    ],
                ],
                'status' => TechnicalReport::STATUS_COMPLETED,
                'valid_until' => now()->addYear(),
            ],
            [
                'title' => 'Relatório de Instalação de Servidor',
                'description' => 'Instalação e configuração de novo servidor para aplicações corporativas.',
                'report_type' => TechnicalReport::TYPE_INSTALACAO,
                'technician_name' => 'Pedro Costa',
                'technician_registration' => 'CREA-MG 456789',
                'findings' => "Instalação realizada com sucesso:\n\n1. Hardware instalado e testado\n2. Sistema operacional configurado\n3. Aplicações instaladas\n4. Backup inicial realizado\n5. Testes de performance executados\n6. Documentação criada",
                'recommendations' => "Para manter o servidor funcionando adequadamente:\n\n1. Monitorar performance regularmente\n2. Manter sistema atualizado\n3. Realizar backups diários\n4. Verificar logs semanalmente\n5. Agendar manutenção preventiva mensal",
                'observations' => 'Servidor está funcionando perfeitamente e atende todos os requisitos especificados.',
                'equipment_analyzed' => [
                    [
                        'name' => 'Servidor Principal',
                        'model' => 'HP ProLiant DL380 Gen10',
                        'serial' => 'HP9876543',
                        'status' => 'Instalado e funcionando',
                        'analyzed_at' => now()->subDays(3)->toISOString(),
                    ],
                ],
                'status' => TechnicalReport::STATUS_APPROVED,
                'approved_by' => 'Coordenador de TI',
                'approved_at' => now()->subHours(12),
                'valid_until' => now()->addMonths(12),
            ],
            [
                'title' => 'Template - Diagnóstico Básico de Rede',
                'description' => 'Template padrão para diagnóstico básico de infraestrutura de rede.',
                'report_type' => TechnicalReport::TYPE_DIAGNOSTICO,
                'technician_name' => 'Template',
                'technician_registration' => '',
                'findings' => "Template de constatações:\n\n1. Verificar conectividade\n2. Analisar performance\n3. Verificar configurações\n4. Testar redundância\n5. Avaliar segurança",
                'recommendations' => "Template de recomendações:\n\n1. Implementar melhorias identificadas\n2. Atualizar documentação\n3. Configurar monitoramento\n4. Treinar usuários\n5. Agendar manutenção preventiva",
                'observations' => 'Este é um template base que deve ser customizado conforme necessário.',
                'equipment_analyzed' => [],
                'status' => TechnicalReport::STATUS_DRAFT,
                'is_template' => true,
                'template_name' => 'Diagnóstico Básico de Rede',
                'valid_until' => null,
            ],
        ];

        foreach ($reports as $index => $reportData) {
            // Skip template for customer/invoice assignment
            if ($reportData['is_template'] ?? false) {
                $customer = null;
                $invoice = null;
            } else {
                $customer = $customers->random();
                $invoice = $invoices->where('customer_id', $customer->id)->first();
            }

            $reportData['customer_id'] = $customer?->id;
            $reportData['invoice_id'] = $invoice?->id;
            $reportData['service_order_number'] = $invoice ? "OS-{$invoice->id}-" . rand(100, 999) : null;
            $reportData['inspection_date'] = now()->subDays(rand(1, 30));
            $reportData['report_date'] = now()->subDays(rand(0, 7));

            // Generate report number for all reports (including templates)
            if ($reportData['is_template'] ?? false) {
                $reportData['report_number'] = 'TPL-' . now()->format('YmdHis') . '-' . rand(100, 999);
            } else {
                $tempReport = new TechnicalReport();
                $reportData['report_number'] = $tempReport->generateReportNumber();
            }

            $report = TechnicalReport::create($reportData);
        }

        $this->command->info('Laudos técnicos criados com sucesso!');
    }
}
