<x-layouts.landing>
    <x-slot name="title">IM Soluções - Soluções Informáticas e Tecnológicas Completas</x-slot>
    
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">IM Soluções</h1>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#services" class="text-gray-700 hover:text-indigo-600 transition-colors">Serviços</a>
                    <a href="#solutions" class="text-gray-700 hover:text-indigo-600 transition-colors">Soluções</a>
                    <a href="#about" class="text-gray-700 hover:text-indigo-600 transition-colors">Sobre</a>
                    <a href="#contact" class="text-gray-700 hover:text-indigo-600 transition-colors">Contato</a>
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 transition-colors">Área do Cliente</a>
                    <button onclick="openQuoteModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Solicitar Orçamento
                    </button>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button onclick="toggleMobileMenu()" class="text-gray-700 hover:text-indigo-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#services" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Serviços</a>
                <a href="#solutions" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Soluções</a>
                <a href="#about" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Sobre</a>
                <a href="#contact" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Contato</a>
                <a href="{{ route('login') }}" class="block px-3 py-2 text-indigo-600 hover:text-indigo-700">Área do Cliente</a>
                <button onclick="openQuoteModal()" class="w-full text-left px-3 py-2 bg-indigo-600 text-white rounded-lg mt-2">
                    Solicitar Orçamento
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg hero-pattern relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="text-center">
                <h1 class="hero-title hero-text text-4xl md:text-6xl font-bold text-white mb-6">
                    Soluções <span class="text-yellow-300">Informáticas e Tecnológicas</span> Completas
                </h1>
                <p class="hero-text text-xl md:text-2xl text-white/95 mb-8 max-w-3xl mx-auto">
                    Especialistas em manutenção, desenvolvimento, infraestrutura e consultoria em TI para empresas de todos os portes
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="openQuoteModal()" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-8 py-4 rounded-lg text-lg transition-colors">
                        Solicitar Orçamento Gratuito
                    </button>
                    <a href="#services" class="bg-white/20 hover:bg-white/30 text-white font-semibold px-8 py-4 rounded-lg text-lg transition-colors backdrop-blur-sm">
                        Conheça Nossos Serviços
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full -translate-x-20 -translate-y-20"></div>
        <div class="absolute bottom-0 right-0 w-60 h-60 bg-white/5 rounded-full translate-x-20 translate-y-20"></div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Nossos Serviços
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Soluções completas em tecnologia da informação para sua empresa
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white p-8 rounded-xl shadow-lg card-hover border border-gray-100">
                    <div class="tech-icon w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 7.172V5l-1-1z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Manutenção de Equipamentos</h3>
                    <p class="text-gray-600 mb-6">
                        Manutenção preventiva e corretiva de computadores, servidores, impressoras e equipamentos de rede.
                    </p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li>• Diagnóstico e reparo de hardware</li>
                        <li>• Limpeza e otimização de sistemas</li>
                        <li>• Upgrade de componentes</li>
                        <li>• Manutenção preventiva agendada</li>
                    </ul>
                </div>
                
                <!-- Service 2 -->
                <div class="bg-white p-8 rounded-xl shadow-lg card-hover border border-gray-100">
                    <div class="tech-icon w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Desenvolvimento de Software</h3>
                    <p class="text-gray-600 mb-6">
                        Desenvolvimento de sistemas personalizados, aplicações web e mobile para sua empresa.
                    </p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li>• Sistemas web personalizados</li>
                        <li>• Aplicações mobile</li>
                        <li>• Integração de sistemas</li>
                        <li>• Automação de processos</li>
                    </ul>
                </div>
                
                <!-- Service 3 -->
                <div class="bg-white p-8 rounded-xl shadow-lg card-hover border border-gray-100">
                    <div class="tech-icon w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Infraestrutura de TI</h3>
                    <p class="text-gray-600 mb-6">
                        Projetos e implementação de infraestrutura de rede, servidores e sistemas de segurança.
                    </p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li>• Instalação de redes cabeadas e Wi-Fi</li>
                        <li>• Configuração de servidores</li>
                        <li>• Sistemas de backup e segurança</li>
                        <li>• Monitoramento de rede</li>
                    </ul>
                </div>
                
                <!-- Service 4 -->
                <div class="bg-white p-8 rounded-xl shadow-lg card-hover border border-gray-100">
                    <div class="tech-icon w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Consultoria em TI</h3>
                    <p class="text-gray-600 mb-6">
                        Consultoria especializada para otimizar processos e implementar soluções tecnológicas eficientes.
                    </p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li>• Análise de infraestrutura atual</li>
                        <li>• Planejamento estratégico de TI</li>
                        <li>• Auditoria de segurança</li>
                        <li>• Treinamento de equipes</li>
                    </ul>
                </div>
                
                <!-- Service 5 -->
                <div class="bg-white p-8 rounded-xl shadow-lg card-hover border border-gray-100">
                    <div class="tech-icon w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Suporte Técnico</h3>
                    <p class="text-gray-600 mb-6">
                        Suporte técnico especializado para manter seus sistemas funcionando sem interrupções.
                    </p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li>• Suporte remoto e presencial</li>
                        <li>• Resolução de problemas urgentes</li>
                        <li>• Monitoramento proativo</li>
                        <li>• Suporte 24/7 disponível</li>
                    </ul>
                </div>
                
                <!-- Service 6 -->
                <div class="bg-white p-8 rounded-xl shadow-lg card-hover border border-gray-100">
                    <div class="tech-icon w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Laudos Técnicos</h3>
                    <p class="text-gray-600 mb-6">
                        Elaboração de laudos técnicos profissionais para diagnósticos, instalações e certificações.
                    </p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li>• Laudos de infraestrutura</li>
                        <li>• Certificações de segurança</li>
                        <li>• Diagnósticos detalhados</li>
                        <li>• Documentação técnica</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions Section -->
    <section id="solutions" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Por que Escolher a IM Soluções?
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Expertise e tecnologia avançada para impulsionar seu negócio
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="feature-icon w-16 h-16 rounded-lg flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Atendimento Rápido</h3>
                    <p class="text-gray-600">Resposta em até 2 horas e soluções ágeis para manter seu negócio funcionando</p>
                </div>
                
                <div class="text-center">
                    <div class="feature-icon w-16 h-16 rounded-lg flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Qualidade Garantida</h3>
                    <p class="text-gray-600">Certificações técnicas e garantia em todos os serviços prestados</p>
                </div>
                
                <div class="text-center">
                    <div class="feature-icon w-16 h-16 rounded-lg flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Custo-Benefício</h3>
                    <p class="text-gray-600">Preços competitivos com foco em resultados e economia para sua empresa</p>
                </div>
                
                <div class="text-center">
                    <div class="feature-icon w-16 h-16 rounded-lg flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Equipe Especializada</h3>
                    <p class="text-gray-600">Profissionais certificados com experiência em diversas tecnologias</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Sobre a IM Soluções
                    </h2>
                    <p class="text-lg text-gray-600 mb-6">
                        A IM Soluções é uma empresa especializada em soluções informáticas e tecnológicas, oferecendo serviços completos para empresas de todos os portes. Com foco na excelência e inovação, desenvolvemos soluções personalizadas que atendem às necessidades específicas de cada cliente.
                    </p>
                    <p class="text-lg text-gray-600 mb-8">
                        Nossa equipe é composta por profissionais altamente qualificados e certificados, prontos para atender suas demandas em manutenção, desenvolvimento, infraestrutura e consultoria. Utilizamos tecnologias modernas e metodologias eficientes para garantir resultados superiores.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Mais de 10 anos de experiência</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Equipe certificada</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Suporte especializado</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Projetos personalizados</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-8 text-white">
                        <h3 class="text-2xl font-bold mb-4">Nossos Números</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <div class="text-3xl font-bold">500+</div>
                                <div class="text-sm opacity-90">Clientes Atendidos</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">1000+</div>
                                <div class="text-sm opacity-90">Projetos Concluídos</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">24/7</div>
                                <div class="text-sm opacity-90">Suporte Disponível</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">98%</div>
                                <div class="text-sm opacity-90">Satisfação dos Clientes</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Entre em Contato
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Estamos prontos para atender suas necessidades em TI. Fale conosco!
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Informações de Contato</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-600">contato@imsolucoes.com.br</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-600">(11) 9 9999-9999</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-600">São Paulo, SP - Atendimento Nacional</span>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Horário de Atendimento</h4>
                        <p class="text-gray-600">Segunda a Sexta: 8h às 18h</p>
                        <p class="text-gray-600">Sábado: 8h às 12h</p>
                        <p class="text-gray-600">Suporte emergencial: 24/7</p>
                    </div>
                </div>
                
                <div>
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Solicite um Orçamento</h3>
                        <button onclick="openQuoteModal()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg text-lg transition-colors">
                            Solicitar Orçamento Gratuito
                        </button>
                        <p class="text-gray-600 text-sm mt-4 text-center">
                            Resposta em até 2 horas úteis
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Pronto para Transformar sua Empresa?
            </h2>
            <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                Solicite um orçamento personalizado e descubra como a IM Soluções pode otimizar sua infraestrutura de TI
            </p>
            <button onclick="openQuoteModal()" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-8 py-4 rounded-lg text-lg transition-colors">
                Solicitar Orçamento Gratuito
            </button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-2xl font-bold mb-4">IM Soluções</h3>
                    <p class="text-gray-400 mb-4">
                        Especialistas em soluções informáticas e tecnológicas, oferecendo serviços completos de manutenção, desenvolvimento, infraestrutura e consultoria para empresas de todos os portes.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.098.118.112.221.085.343-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.162-1.499-.696-2.436-2.888-2.436-4.649 0-3.785 2.750-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.357-.631-2.750-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146 1.124.347 2.317.535 3.554.535 6.624 0 11.990-5.367 11.990-11.987C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Serviços</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#services" class="hover:text-white transition-colors">Manutenção de Equipamentos</a></li>
                        <li><a href="#services" class="hover:text-white transition-colors">Desenvolvimento de Software</a></li>
                        <li><a href="#services" class="hover:text-white transition-colors">Infraestrutura de TI</a></li>
                        <li><a href="#services" class="hover:text-white transition-colors">Consultoria Especializada</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contato</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#about" class="hover:text-white transition-colors">Sobre Nós</a></li>
                        <li><a href="#solutions" class="hover:text-white transition-colors">Nossas Soluções</a></li>
                        <li><a href="#contact" class="hover:text-white transition-colors">Solicitar Orçamento</a></li>
                        <li><a href="#contact" class="hover:text-white transition-colors">Fale Conosco</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 IM Soluções. Todos os direitos reservados. Soluções informáticas e tecnológicas de qualidade.</p>
            </div>
        </div>
    </footer>

    <!-- Quote Modal -->
    <div id="quote-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Solicitar Orçamento</h3>
                <button onclick="closeQuoteModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="quote-form" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome completo</label>
                    <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                    <input type="tel" id="phone" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                    <input type="text" id="company" name="company" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensagem</label>
                    <textarea id="message" name="message" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Descreva suas necessidades..."></textarea>
                </div>
                <button type="button" onclick="submitQuote()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    Enviar Solicitação
                </button>
            </form>
        </div>
    </div>
</x-layouts.landing>
