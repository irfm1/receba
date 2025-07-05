<?php

namespace Database\Seeders;

use App\Models\ServicePackage;
use App\Models\ServiceTemplate;
use Illuminate\Database\Seeder;

class ServicePackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Website Básico Empresarial',
                'description' => 'Pacote completo para criação de website institucional com design responsivo e funcionalidades básicas.',
                'category' => ServicePackage::CATEGORY_WEBSITE_BASICO,
                'fixed_price' => 2500.00,
                'estimated_duration_days' => 21,
                'features' => [
                    'Design responsivo',
                    'Até 5 páginas',
                    'Formulário de contato',
                    'Integração com redes sociais',
                    'SEO básico',
                    '1 ano de hospedagem grátis',
                ],
                'requirements' => [
                    'Logo da empresa',
                    'Conteúdo das páginas',
                    'Imagens em alta qualidade',
                    'Informações de contato',
                ],
                'deliverables' => [
                    'Website completo e funcional',
                    'Painel administrativo',
                    'Manual de uso',
                    'Treinamento básico',
                ],
                'terms_conditions' => [
                    'Pagamento em 3x sem juros',
                    'Prazo de entrega: 21 dias úteis',
                    'Inclui 2 rodadas de revisão',
                    'Suporte técnico por 30 dias',
                ],
                'discount_percentage' => 15.0,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(6),
                'services' => [
                    'Design de Interface (UI/UX)' => ['quantity' => 1, 'estimated_hours' => 24],
                    'Desenvolvimento Frontend React' => ['quantity' => 1, 'estimated_hours' => 40],
                    'Desenvolvimento de API REST' => ['quantity' => 1, 'estimated_hours' => 16],
                ]
            ],
            
            [
                'name' => 'E-commerce Completo',
                'description' => 'Solução completa de e-commerce com sistema de pagamento, gestão de produtos e pedidos.',
                'category' => ServicePackage::CATEGORY_ECOMMERCE,
                'fixed_price' => 8500.00,
                'estimated_duration_days' => 60,
                'features' => [
                    'Catálogo de produtos ilimitado',
                    'Carrinho de compras',
                    'Múltiplas formas de pagamento',
                    'Gestão de estoque',
                    'Relatórios de vendas',
                    'Painel administrativo completo',
                    'App mobile (PWA)',
                ],
                'requirements' => [
                    'Definição dos produtos',
                    'Logomarca e identidade visual',
                    'Contas nos gateways de pagamento',
                    'Documentação legal',
                ],
                'deliverables' => [
                    'Plataforma e-commerce completa',
                    'Painel administrativo',
                    'App mobile (PWA)',
                    'Documentação técnica',
                    'Treinamento completo',
                ],
                'terms_conditions' => [
                    'Pagamento em até 5x sem juros',
                    'Prazo de entrega: 60 dias úteis',
                    'Inclui 3 rodadas de revisão',
                    'Suporte técnico por 90 dias',
                    '6 meses de manutenção inclusa',
                ],
                'discount_percentage' => 20.0,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(3),
                'services' => [
                    'Design de Interface (UI/UX)' => ['quantity' => 2, 'estimated_hours' => 48],
                    'Desenvolvimento Frontend React' => ['quantity' => 2, 'estimated_hours' => 120],
                    'Desenvolvimento de API REST' => ['quantity' => 1, 'estimated_hours' => 80],
                    'Consultoria em Segurança da Informação' => ['quantity' => 1, 'estimated_hours' => 8],
                ]
            ],
            
            [
                'name' => 'Sistema de Gestão Básico',
                'description' => 'Sistema web para gestão empresarial com módulos de clientes, vendas e relatórios.',
                'category' => ServicePackage::CATEGORY_SISTEMA_GESTAO,
                'fixed_price' => 6500.00,
                'estimated_duration_days' => 45,
                'features' => [
                    'Gestão de clientes',
                    'Controle de vendas',
                    'Relatórios financeiros',
                    'Dashboard executivo',
                    'Controle de usuários',
                    'Backup automático',
                ],
                'requirements' => [
                    'Mapeamento dos processos',
                    'Definição dos relatórios',
                    'Estrutura organizacional',
                    'Dados para migração',
                ],
                'deliverables' => [
                    'Sistema de gestão completo',
                    'Módulos integrados',
                    'Relatórios personalizados',
                    'Manual de usuário',
                    'Treinamento da equipe',
                ],
                'terms_conditions' => [
                    'Pagamento em 4x sem juros',
                    'Prazo de entrega: 45 dias úteis',
                    'Inclui migração de dados',
                    'Suporte técnico por 60 dias',
                    '3 meses de manutenção inclusa',
                ],
                'discount_percentage' => 10.0,
                'services' => [
                    'Consultoria em Arquitetura de Sistemas' => ['quantity' => 1, 'estimated_hours' => 16],
                    'Design de Interface (UI/UX)' => ['quantity' => 1, 'estimated_hours' => 32],
                    'Desenvolvimento Frontend React' => ['quantity' => 1, 'estimated_hours' => 80],
                    'Desenvolvimento de API REST' => ['quantity' => 1, 'estimated_hours' => 60],
                ]
            ],
            
            [
                'name' => 'Consultoria em TI Estratégica',
                'description' => 'Consultoria completa para planejamento estratégico de TI e transformação digital.',
                'category' => ServicePackage::CATEGORY_CONSULTORIA_TI,
                'fixed_price' => 4500.00,
                'estimated_duration_days' => 30,
                'features' => [
                    'Diagnóstico atual da TI',
                    'Plano estratégico de TI',
                    'Roadmap de transformação digital',
                    'Análise de ROI',
                    'Recomendações tecnológicas',
                    'Plano de implementação',
                ],
                'requirements' => [
                    'Acesso à infraestrutura atual',
                    'Documentação dos processos',
                    'Orçamentos e contratos vigentes',
                    'Reuniões com stakeholders',
                ],
                'deliverables' => [
                    'Relatório de diagnóstico',
                    'Plano estratégico de TI',
                    'Roadmap detalhado',
                    'Análise financeira',
                    'Apresentação executiva',
                ],
                'terms_conditions' => [
                    'Pagamento em 3x sem juros',
                    'Prazo de entrega: 30 dias úteis',
                    'Inclui apresentação para diretoria',
                    'Suporte pós-entrega por 30 dias',
                ],
                'discount_percentage' => 0.0,
                'services' => [
                    'Consultoria em Arquitetura de Sistemas' => ['quantity' => 2, 'estimated_hours' => 32],
                    'Consultoria em Segurança da Informação' => ['quantity' => 1, 'estimated_hours' => 16],
                ]
            ],
            
            [
                'name' => 'Infraestrutura Cloud Completa',
                'description' => 'Migração e configuração completa de infraestrutura para nuvem com alta disponibilidade.',
                'category' => ServicePackage::CATEGORY_INFRAESTRUTURA,
                'fixed_price' => 7500.00,
                'estimated_duration_days' => 40,
                'features' => [
                    'Migração para cloud',
                    'Configuração de alta disponibilidade',
                    'Backup automatizado',
                    'Monitoramento 24/7',
                    'Escalabilidade automática',
                    'Segurança avançada',
                ],
                'requirements' => [
                    'Inventário da infraestrutura atual',
                    'Requisitos de performance',
                    'Políticas de segurança',
                    'Orçamento para cloud',
                ],
                'deliverables' => [
                    'Infraestrutura cloud configurada',
                    'Sistema de monitoramento',
                    'Documentação técnica',
                    'Procedimentos operacionais',
                    'Treinamento da equipe técnica',
                ],
                'terms_conditions' => [
                    'Pagamento em 4x sem juros',
                    'Prazo de entrega: 40 dias úteis',
                    'Inclui migração dos dados',
                    'Suporte técnico por 90 dias',
                    'Monitoramento gratuito por 3 meses',
                ],
                'discount_percentage' => 12.0,
                'services' => [
                    'Consultoria em Arquitetura de Sistemas' => ['quantity' => 1, 'estimated_hours' => 16],
                    'Configuração de Servidor Linux' => ['quantity' => 3, 'estimated_hours' => 36],
                    'Consultoria em Segurança da Informação' => ['quantity' => 1, 'estimated_hours' => 16],
                ]
            ],
        ];

        foreach ($packages as $packageData) {
            $services = $packageData['services'];
            unset($packageData['services']);
            
            $package = ServicePackage::create($packageData);
            
            // Associar serviços ao pacote
            foreach ($services as $serviceName => $serviceData) {
                $template = ServiceTemplate::where('name', $serviceName)->first();
                if ($template) {
                    $package->serviceTemplates()->attach($template->id, [
                        'quantity' => $serviceData['quantity'],
                        'estimated_hours' => $serviceData['estimated_hours'],
                        'custom_rate' => $template->base_rate_per_hour, // Usar taxa padrão
                    ]);
                }
            }
        }
    }
}
