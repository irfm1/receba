# Receba - Sistema de Gestão de Faturas para Serviços de TI

Uma solução completa e **open source** de gestão empresarial desenvolvida especificamente para prestadores de serviços de TI no mercado brasileiro, construída com Laravel + Livewire + Flux.

## Índice

- [Visão Geral](#visão-geral)
- [Características Principais](#características-principais)
- [Requisitos Técnicos](#requisitos-técnicos)
- [Recursos Avançados](#recursos-avançados)
- [Conformidade com o Mercado Brasileiro](#conformidade-com-o-mercado-brasileiro)
- [Stack Tecnológico](#stack-tecnológico)
- [Arquitetura e Sincronização](#arquitetura-e-sincronização)
- [Roadmap de Desenvolvimento](#roadmap-de-desenvolvimento)
- [Contribuindo](#contribuindo)

## Visão Geral

O Receba é um sistema **open source** projetado para simplificar a gestão de faturas, relacionamento com clientes e acompanhamento financeiro para prestadores de serviços de TI no Brasil. O sistema é **mobile-first**, com hospedagem local e capacidades de sincronização entre dispositivos.

### Características do Projeto
- 🌟 **Open Source**: Código aberto sob licença MIT
- 📱 **Mobile-First**: Otimizado primariamente para dispositivos móveis
- 🇧🇷 **Português Brasileiro**: Interface completamente em português do Brasil
- 🏠 **Auto-hospedado**: Execução local com controle total dos dados
- 🔄 **Sincronização**: Sincronização automática entre dispositivos
- 🔒 **Privacidade**: Seus dados permanecem sob seu controle

## Características Principais

### 1. Gestão de Clientes
- **Perfis de Clientes**: Armazenar informações completas (nome, email, telefone, endereço, CPF/CNPJ)
- **Detalhes da Empresa**: Gerenciar informações empresariais, pessoas de contato, endereços
- **Categorias de Clientes**: Classificar clientes (pessoa física, MEI, pequena empresa, grande empresa)
- **Histórico do Cliente**: Rastreamento completo de interações, faturas e pagamentos
- **Notas e Tags**: Sistema de anotações e categorização personalizada

### 2. Geração de Faturas
- **Faturas Profissionais**: Criar faturas com identidade visual da empresa
- **Templates Personalizáveis**: Múltiplos modelos para diferentes tipos de cliente
- **Itens Detalhados**: Serviços/produtos com descrições, quantidades e valores
- **Cálculos de Impostos**: Cálculo automático de impostos brasileiros (ISS, ICMS)
- **Descontos Flexíveis**: Descontos percentuais ou valores fixos
- **Numeração Inteligente**: Numeração sequencial com prefixos personalizados
- **Suporte Multi-moeda**: Atendimento a clientes internacionais

### 3. Catálogo de Serviços de TI
- **Templates de Serviços**: Serviços de TI pré-definidos (consultoria, desenvolvimento, suporte)
- **Preços Dinâmicos**: Diferentes valores por hora para vários tipos de serviço
- **Pacotes de Projetos**: Serviços agrupados com preços fixos
- **Serviços Recorrentes**: Manutenção mensal, hospedagem e licenças

### 4. Gestão Financeira
- **Acompanhamento de Pagamentos**: Gestão completa de status (pago, parcial, em atraso)
- **Métodos de Pagamento**: Suporte para transferência bancária, PIX, cartões
- **Análise de Receita**: Análise mensal e anual de receitas
- **Relatórios de Inadimplência**: Acompanhamento de faturas em aberto
- **Gestão de Despesas**: Controle de despesas empresariais para análise de rentabilidade

### 5. Gestão de Documentos
- **Geração de PDFs**: Faturas em PDF profissionais
- **Integração com Email**: Envio direto de faturas por email
- **Armazenamento de Documentos**: Contratos, propostas e documentos relacionados
- **Assinaturas Digitais**: Capacidades integradas de assinatura de contratos

## Requisitos Técnicos

### 6. Autenticação e Segurança
- **Suporte a Múltiplos Usuários**: Acesso baseado em funções (admin, contador, visualizador)
- **Permissões Granulares**: Controle de acesso seguro aos dados financeiros
- **Autenticação de Dois Fatores**: Medidas de segurança aprimoradas
- **Registro de Atividades**: Trilhas de auditoria completas

### 7. Gestão de Dados
- **Backups Automatizados**: Proteção de dados críticos
- **Exportação/Importação de Dados**: Compatibilidade com CSV e Excel
- **Conformidade com a LGPD**: Lei brasileira de proteção de dados
- **Migração de Dados**: Importação de sistemas existentes

### 8. Capacidades de Integração
- **Integração Bancária**: Conectividade com bancos brasileiros para verificação de pagamentos
- **Software de Contabilidade**: Capacidades de exportação para sistemas contábeis populares
- **Integração com WhatsApp**: Notificações de faturas via WhatsApp
- **Templates de Email**: Templates de comunicação personalizáveis

## Recursos Avançados

### 9. Inteligência de Negócios
- **Dashboard de Receita**: Visão geral visual do desempenho dos negócios
- **Análise de Clientes**: Análise de rentabilidade e comportamento de pagamento
- **Desempenho de Serviços**: Geração de receita por tipo de serviço
- **Projeções de Fluxo de Caixa**: Previsões com base em faturas pendentes
- **Relatórios de Impostos**: Relatórios automatizados de conformidade fiscal

### 10. Automação de Workflow
- **Lembretes Inteligentes**: Notificações automáticas de faturas vencidas
- **Cobrança Recorrente**: Geração automática de faturas para serviços recorrentes
- **Alertas de Pagamento**: Notificações de pagamento em tempo real
- **Tarefas de Acompanhamento**: Gestão automatizada de relacionamento com o cliente

### 11. Aplicativo Móvel e Web Progressivo
- **Capacidade Offline**: Acesso a faturas e dados de clientes sem internet
- **Design Responsivo**: Otimizado para tablets e smartphones
- **Notificações Push**: Lembretes de pagamento e alertas do sistema
- **Ações Rápidas**: Criação rápida de faturas a partir de dispositivos móveis

### 12. Gestão de Projetos
- **Rastreamento de Projetos**: Vincular faturas a projetos específicos
- **Rastreamento de Tempo**: Controle de horas gastas por projeto
- **Cobrança por Marcos**: Faturamento baseado em marcos de projeto
- **Colaboração em Equipe**: Gestão de projetos com múltiplos usuários

### 13. Portal do Cliente
- **Dashboard do Cliente**: Acesso do cliente a faturas e histórico de pagamentos
- **Pagamentos Online**: Integração com gateways de pagamento brasileiros (PagSeguro, MercadoPago)
- **Aprovação de Faturas**: Fluxo de trabalho de aprovação de faturas pelo cliente
- **Troca Segura de Documentos**: Compartilhamento protegido de documentos

### 14. API e Integrações de Terceiros
- **API REST**: Integração com sistemas de terceiros
- **Suporte a Webhooks**: Notificações externas em tempo real
- **Integração com CRM**: Conectividade com sistemas CRM populares
- **Integração com Ferramentas de Rastreamento de Tempo**: Suporte a ferramentas externas de rastreamento de tempo

## Conformidade com o Mercado Brasileiro

### 15. Requisitos Legais e Regulatórios
- **Integração NFSe**: Conformidade com faturas de serviços municipais
- **Validação de CPF/CNPJ**: Validação e verificação de CPF/CNPJ
- **Padrões de Endereço**: Formatação de CEP e endereço brasileiros
- **Localização em Português**: Suporte completo à língua portuguesa
- **Conformidade Fiscal**: Cálculos de ISS, ICMS e impostos aplicáveis

## Arquitetura e Sincronização

### Hospedagem Local
- **Self-hosted**: Sistema executado localmente em seu próprio servidor/dispositivo
- **Controle Total**: Dados permanecem sob seu controle completo
- **Sem Dependências Externas**: Funciona independentemente de serviços terceiros
- **Backup Local**: Sistema de backup automático local

### Sincronização Entre Dispositivos
- **Sync P2P**: Sincronização peer-to-peer entre dispositivos
- **Conflict Resolution**: Resolução automática de conflitos de dados
- **Offline-First**: Funcionalidade completa mesmo sem conexão
- **Delta Sync**: Sincronização incremental para eficiência
- **Multi-device Support**: Suporte para múltiplos dispositivos (mobile, tablet, desktop)

### Tecnologias de Sincronização
- **SQLite**: Banco de dados local em cada dispositivo
- **CRDTs**: Conflict-free Replicated Data Types para sincronização
- **WebRTC**: Comunicação direta entre dispositivos
- **Service Workers**: Funcionalidade offline robusta

## Stack Tecnológico

- **Backend**: Laravel Framework
- **Frontend**: Livewire + Flux UI
- **Mobile**: PWA (Progressive Web App)
- **Banco de Dados Local**: SQLite
- **Sincronização**: Custom sync engine com CRDTs
- **Queue System**: Database queues
- **Armazenamento**: Local file system
- **Comunicação**: WebRTC para sync P2P
- **Offline**: Service Workers + IndexedDB

## Roadmap de Desenvolvimento

### Fase 1 - MVP Local
- [ ] Gestão básica de clientes
- [ ] Geração simples de faturas
- [ ] Armazenamento local (SQLite)
- [ ] Interface mobile-first

### Fase 2 - Recursos Financeiros
- [ ] Relatórios financeiros
- [ ] Cálculos de impostos brasileiros
- [ ] Gestão de documentos
- [ ] Sistema de backup local

### Fase 3 - Sincronização
- [ ] Engine de sincronização P2P
- [ ] Resolução de conflitos
- [ ] Suporte multi-dispositivo
- [ ] Modo offline robusto

### Fase 4 - Recursos Avançados
- [ ] Portal do cliente
- [ ] Conformidade brasileira (NFSe)
- [ ] Analytics avançado
- [ ] Automação de workflow

## Contribuindo

Este é um projeto open source e contribuições são bem-vindas!

### Como Contribuir
1. Fork o repositório
2. Crie uma branch para sua feature (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -am 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

### Diretrizes
- **Código**: Variáveis e funções em inglês
- **UI**: Usar apenas componentes gratuitos - Flux UI PRO components não são utilizados
- **Interface**: Textos em português brasileiro
- **Testes**: Inclua testes para novas funcionalidades
- **Documentação**: Mantenha a documentação atualizada

### Licença
Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

---

**Receba** - Simplificando a gestão de faturas para empresas de TI brasileiras de forma aberta e local.

🌟 **Deixe uma estrela se este projeto te ajudou!**