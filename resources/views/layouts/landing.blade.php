<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Receba - Sistema de Gestão de Faturas para Serviços de TI' }}</title>
    <meta name="description" content="Sistema completo de gestão empresarial para prestadores de serviços de TI no Brasil. Gestão de clientes, faturas profissionais, laudos técnicos e muito mais.">
    <meta name="keywords" content="gestão de faturas, serviços de TI, laudos técnicos, sistema de gestão, Brasil">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom landing page styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .hero-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255,255,255,0.05) 0%, transparent 50%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .tech-icon {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        }
        
        .feature-icon {
            background: linear-gradient(135deg, #06B6D4 0%, #3B82F6 100%);
        }
        
        @media (max-width: 640px) {
            .hero-title {
                font-size: 2.5rem;
                line-height: 1.2;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    {{ $slot }}
    
    <!-- Scripts -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        // Contact form handling
        function submitQuote() {
            const form = document.getElementById('quote-form');
            const formData = new FormData(form);
            
            // Here you would typically send the form data to your backend
            alert('Obrigado pelo seu interesse! Entraremos em contato em breve.');
            form.reset();
            
            // Close modal
            document.getElementById('quote-modal').classList.add('hidden');
        }
        
        // Modal handling
        function openQuoteModal() {
            document.getElementById('quote-modal').classList.remove('hidden');
        }
        
        function closeQuoteModal() {
            document.getElementById('quote-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
