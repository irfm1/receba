<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Receba - Modo Offline</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }
        
        .container {
            max-width: 400px;
            width: 100%;
        }
        
        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }
        
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: 300;
        }
        
        p {
            font-size: 1.1em;
            margin-bottom: 30px;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .features {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .features h3 {
            margin-bottom: 15px;
            font-size: 1.2em;
        }
        
        .features ul {
            list-style: none;
        }
        
        .features li {
            padding: 5px 0;
            padding-left: 25px;
            position: relative;
        }
        
        .features li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #4ade80;
            font-weight: bold;
        }
        
        .btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 1.1em;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            min-width: 120px;
        }
        
        .btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        .btn-primary {
            background: #4f46e5;
            border-color: #4f46e5;
        }
        
        .btn-primary:hover {
            background: #3730a3;
            border-color: #3730a3;
        }
        
        .network-status {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ef4444;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .status-dot.online {
            background: #10b981;
            animation: none;
        }
        
        @media (max-width: 480px) {
            h1 {
                font-size: 2em;
            }
            
            .btn {
                padding: 12px 25px;
                font-size: 1em;
                min-width: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="network-status">
        <div class="status-dot" id="statusDot"></div>
        <span id="statusText">Offline</span>
    </div>
    
    <div class="container">
        <div class="icon">
            📱
        </div>
        
        <h1>Modo Offline</h1>
        
        <p>Você está desconectado da internet, mas ainda pode usar algumas funcionalidades do Receba.</p>
        
        <div class="features">
            <h3>Disponível offline:</h3>
            <ul>
                <li>Visualizar dados salvos</li>
                <li>Criar novos registros</li>
                <li>Editar informações</li>
                <li>Gerar relatórios básicos</li>
            </ul>
        </div>
        
        <div class="features">
            <h3>Quando voltar online:</h3>
            <ul>
                <li>Dados serão sincronizados</li>
                <li>Emails serão enviados</li>
                <li>Backups serão atualizados</li>
                <li>Todas as funcionalidades voltarão</li>
            </ul>
        </div>
        
        <a href="/dashboard" class="btn btn-primary">Continuar Offline</a>
        <button onclick="location.reload()" class="btn">Tentar Novamente</button>
    </div>
    
    <script>
        // Monitor network status
        function updateNetworkStatus() {
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');
            
            if (navigator.onLine) {
                statusDot.classList.add('online');
                statusText.textContent = 'Online';
                
                // Auto-redirect when back online
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 2000);
            } else {
                statusDot.classList.remove('online');
                statusText.textContent = 'Offline';
            }
        }
        
        // Update status on page load
        updateNetworkStatus();
        
        // Listen for network changes
        window.addEventListener('online', updateNetworkStatus);
        window.addEventListener('offline', updateNetworkStatus);
        
        // Auto-refresh every 30 seconds to check connection
        setInterval(() => {
            if (navigator.onLine) {
                fetch('/dashboard', { method: 'HEAD' })
                    .then(() => {
                        window.location.href = '/dashboard';
                    })
                    .catch(() => {
                        // Still offline
                    });
            }
        }, 30000);
    </script>
</body>
</html>
