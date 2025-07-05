<?php

namespace Database\Seeders;

use App\Models\ServiceTemplate;
use App\Models\ServiceRate;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class ServiceTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            // Consultoria
            [
                'name' => 'Consultoria em Arquitetura de Sistemas',
                'description' => 'Análise e design de arquitetura de sistemas, incluindo análise de requisitos, definição de tecnologias e padrões arquiteturais.',
                'category' => ServiceTemplate::CATEGORY_CONSULTORIA,
                'base_rate_per_hour' => 150.00,
                'unit' => ServiceTemplate::UNIT_HOUR,
                'estimated_hours' => 8.0,
                'tags' => ['arquitetura', 'sistemas', 'análise', 'design'],
                'requirements' => ['Documentação de requisitos', 'Acesso ao sistema atual'],
                'deliverables' => ['Diagrama de arquitetura', 'Documento de especificação técnica', 'Recomendações de implementação'],
            ],
            [
                'name' => 'Consultoria em Segurança da Informação',
                'description' => 'Auditoria de segurança, análise de vulnerabilidades e implementação de medidas de proteção.',
                'category' => ServiceTemplate::CATEGORY_SEGURANCA,
                'base_rate_per_hour' => 180.00,
                'unit' => ServiceTemplate::UNIT_HOUR,
                'estimated_hours' => 16.0,
                'tags' => ['segurança', 'auditoria', 'vulnerabilidades', 'proteção'],
                'requirements' => ['Acesso aos sistemas', 'Documentação da infraestrutura'],
                'deliverables' => ['Relatório de auditoria', 'Plano de correções', 'Políticas de segurança'],
            ],
            
            // Desenvolvimento
            [
                'name' => 'Desenvolvimento de API REST',
                'description' => 'Criação de APIs RESTful com autenticação, documentação e testes automatizados.',
                'category' => ServiceTemplate::CATEGORY_DESENVOLVIMENTO,
                'base_rate_per_hour' => 120.00,
                'unit' => ServiceTemplate::UNIT_HOUR,
                'estimated_hours' => 40.0,
                'tags' => ['api', 'rest', 'backend', 'documentação'],
                'requirements' => ['Especificação dos endpoints', 'Modelo de dados'],
                'deliverables' => ['API funcional', 'Documentação técnica', 'Testes automatizados'],
            ],
            [
                'name' => 'Desenvolvimento Frontend React',
                'description' => 'Criação de interfaces modernas e responsivas usando React, TypeScript e bibliotecas UI.',
                'category' => ServiceTemplate::CATEGORY_DESENVOLVIMENTO,
                'base_rate_per_hour' => 100.00,
                'unit' => ServiceTemplate::UNIT_HOUR,
                'estimated_hours' => 80.0,
                'tags' => ['react', 'frontend', 'typescript', 'ui'],
                'requirements' => ['Design ou wireframes', 'Especificação funcional'],
                'deliverables' => ['Aplicação frontend', 'Componentes reutilizáveis', 'Documentação de uso'],
            ],
            
            // Suporte
            [
                'name' => 'Suporte Técnico N1',
                'description' => 'Atendimento de primeiro nível para resolução de problemas básicos e orientações.',
                'category' => ServiceTemplate::CATEGORY_SUPORTE,
                'base_rate_per_hour' => 60.00,
                'unit' => ServiceTemplate::UNIT_HOUR,
                'estimated_hours' => 1.0,
                'tags' => ['suporte', 'helpdesk', 'atendimento', 'problemas'],
                'requirements' => ['Acesso remoto ou local', 'Descrição do problema'],
                'deliverables' => ['Resolução do problema', 'Relatório de atendimento'],
            ],
            [
                'name' => 'Suporte Técnico N2',
                'description' => 'Suporte técnico especializado para problemas complexos e configurações avançadas.',
                'category' => ServiceTemplate::CATEGORY_SUPORTE,
                'base_rate_per_hour' => 90.00,
                'unit' => ServiceTemplate::UNIT_HOUR,
                'estimated_hours' => 2.0,
                'tags' => ['suporte', 'especializado', 'configuração', 'resolução'],
                'requirements' => ['Logs do sistema', 'Acesso administrativo'],
                'deliverables' => ['Problema resolvido', 'Documentação da solução', 'Recomendações preventivas'],
            ],
            
            // Manutenção
            [
                'name' => 'Manutenção Preventiva de Sistemas',
                'description' => 'Manutenção regular de sistemas, atualizações de segurança e otimização de performance.',
                'category' => ServiceTemplate::CATEGORY_MANUTENCAO,
                'base_rate_per_hour' => 80.00,
                'unit' => ServiceTemplate::UNIT_MONTHLY,
                'estimated_hours' => 8.0,
                'tags' => ['manutenção', 'preventiva', 'atualizações', 'performance'],
                'requirements' => ['Acesso aos sistemas', 'Cronograma de manutenção'],
                'deliverables' => ['Sistemas atualizados', 'Relatório de manutenção', 'Backup de segurança'],
            ],
            
            // Infraestrutura
            [
                'name' => 'Configuração de Servidor Linux',
                'description' => 'Instalação e configuração de servidores Linux com otimização de performance e segurança.',
                'category' => ServiceTemplate::CATEGORY_INFRAESTRUTURA,
                'base_rate_per_hour' => 110.00,
                'unit' => ServiceTemplate::UNIT_PROJECT,
                'estimated_hours' => 12.0,
                'tags' => ['linux', 'servidor', 'configuração', 'segurança'],
                'requirements' => ['Acesso ao servidor', 'Especificações do ambiente'],
                'deliverables' => ['Servidor configurado', 'Documentação de configuração', 'Scripts de automação'],
            ],
            
            // Design
            [
                'name' => 'Design de Interface (UI/UX)',
                'description' => 'Criação de interfaces intuitivas e experiências de usuário otimizadas.',
                'category' => ServiceTemplate::CATEGORY_DESIGN,
                'base_rate_per_hour' => 95.00,
                'unit' => ServiceTemplate::UNIT_HOUR,
                'estimated_hours' => 24.0,
                'tags' => ['ui', 'ux', 'design', 'interface'],
                'requirements' => ['Briefing do projeto', 'Personas definidas'],
                'deliverables' => ['Wireframes', 'Protótipos interativos', 'Guia de estilo'],
            ],
            
            // Treinamento
            [
                'name' => 'Treinamento em Tecnologias Web',
                'description' => 'Treinamento prático em tecnologias web modernas para equipes de desenvolvimento.',
                'category' => ServiceTemplate::CATEGORY_TREINAMENTO,
                'base_rate_per_hour' => 130.00,
                'unit' => ServiceTemplate::UNIT_DAY,
                'estimated_hours' => 8.0,
                'tags' => ['treinamento', 'web', 'capacitação', 'equipe'],
                'requirements' => ['Definição dos tópicos', 'Ambiente de treinamento'],
                'deliverables' => ['Material didático', 'Exercícios práticos', 'Certificado de participação'],
            ],
        ];

        foreach ($templates as $templateData) {
            $template = ServiceTemplate::create($templateData);
            
            // Criar taxas dinâmicas para diferentes categorias de clientes
            $this->createServiceRates($template);
        }
    }

    private function createServiceRates(ServiceTemplate $template): void
    {
        $customerCategories = [
            Customer::CATEGORY_INDIVIDUAL,
            Customer::CATEGORY_MEI,
            Customer::CATEGORY_SMALL_BUSINESS,
            Customer::CATEGORY_LARGE_BUSINESS,
        ];

        $complexityLevels = [
            ServiceRate::COMPLEXITY_BASIC,
            ServiceRate::COMPLEXITY_INTERMEDIATE,
            ServiceRate::COMPLEXITY_ADVANCED,
            ServiceRate::COMPLEXITY_EXPERT,
        ];

        foreach ($customerCategories as $category) {
            foreach ($complexityLevels as $complexity) {
                $multiplier = $this->getMultiplier($category, $complexity);
                
                ServiceRate::create([
                    'service_template_id' => $template->id,
                    'customer_category' => $category,
                    'complexity_level' => $complexity,
                    'rate_per_hour' => $template->base_rate_per_hour * $multiplier,
                    'minimum_hours' => $this->getMinimumHours($complexity),
                    'is_active' => true,
                    'valid_from' => now(),
                    'notes' => "Taxa para {$category} - nível {$complexity}",
                ]);
            }
        }
    }

    private function getMultiplier(string $category, string $complexity): float
    {
        $categoryMultipliers = [
            Customer::CATEGORY_INDIVIDUAL => 1.0,
            Customer::CATEGORY_MEI => 1.1,
            Customer::CATEGORY_SMALL_BUSINESS => 1.2,
            Customer::CATEGORY_LARGE_BUSINESS => 1.5,
        ];

        $complexityMultipliers = [
            ServiceRate::COMPLEXITY_BASIC => 1.0,
            ServiceRate::COMPLEXITY_INTERMEDIATE => 1.2,
            ServiceRate::COMPLEXITY_ADVANCED => 1.5,
            ServiceRate::COMPLEXITY_EXPERT => 2.0,
        ];

        return ($categoryMultipliers[$category] ?? 1.0) * ($complexityMultipliers[$complexity] ?? 1.0);
    }

    private function getMinimumHours(string $complexity): float
    {
        return match ($complexity) {
            ServiceRate::COMPLEXITY_BASIC => 1.0,
            ServiceRate::COMPLEXITY_INTERMEDIATE => 2.0,
            ServiceRate::COMPLEXITY_ADVANCED => 4.0,
            ServiceRate::COMPLEXITY_EXPERT => 8.0,
            default => 1.0,
        };
    }
}
