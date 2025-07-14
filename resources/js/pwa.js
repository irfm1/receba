// PWA and Mobile enhancements
class RecebaPWA {
    constructor() {
        this.isOnline = navigator.onLine;
        this.init();
    }

    init() {
        this.setupNetworkListeners();
        this.setupPWAHandlers();
        this.setupTouchEnhancements();
        this.setupOfflineQueue();
        this.updateNetworkStatus();
    }

    setupNetworkListeners() {
        window.addEventListener('online', () => {
            this.isOnline = true;
            this.updateNetworkStatus();
            this.processOfflineQueue();
            this.showNotification('Conectado', 'Você está online novamente!', 'success');
        });

        window.addEventListener('offline', () => {
            this.isOnline = false;
            this.updateNetworkStatus();
            this.showNotification('Desconectado', 'Você está offline. Algumas funcionalidades podem não funcionar.', 'warning');
        });
    }

    setupPWAHandlers() {
        // Handle PWA install prompt
        let deferredPrompt;

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            this.showInstallPrompt();
        });

        // Handle PWA installation
        window.addEventListener('appinstalled', () => {
            this.showNotification('Instalado', 'Receba foi instalado com sucesso!', 'success');
        });

        // Handle PWA updates
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                this.showNotification('Atualizado', 'Nova versão disponível. Recarregue a página.', 'info');
            });
        }
    }

    setupTouchEnhancements() {
        // Prevent double-tap zoom on buttons
        document.addEventListener('touchend', (e) => {
            if (e.target.tagName === 'BUTTON' || e.target.closest('button')) {
                e.preventDefault();
            }
        });

        // Add touch feedback to interactive elements
        document.addEventListener('touchstart', (e) => {
            if (e.target.tagName === 'BUTTON' || e.target.closest('button') || e.target.closest('a')) {
                e.target.style.opacity = '0.7';
            }
        });

        document.addEventListener('touchend', (e) => {
            if (e.target.tagName === 'BUTTON' || e.target.closest('button') || e.target.closest('a')) {
                setTimeout(() => {
                    e.target.style.opacity = '1';
                }, 150);
            }
        });

        // Handle pull-to-refresh gesture
        this.setupPullToRefresh();
    }

    setupPullToRefresh() {
        let startY = 0;
        let currentY = 0;
        let pulling = false;

        document.addEventListener('touchstart', (e) => {
            startY = e.touches[0].clientY;
            pulling = window.scrollY === 0;
        });

        document.addEventListener('touchmove', (e) => {
            if (!pulling) return;

            currentY = e.touches[0].clientY;
            const diff = currentY - startY;

            if (diff > 100) {
                this.showPullToRefreshIndicator();
            }
        });

        document.addEventListener('touchend', (e) => {
            if (!pulling) return;

            const diff = currentY - startY;
            if (diff > 100) {
                this.refreshPage();
            }
            
            this.hidePullToRefreshIndicator();
            pulling = false;
        });
    }

    setupOfflineQueue() {
        // Store offline actions in IndexedDB
        if ('indexedDB' in window) {
            this.initIndexedDB();
        }

        // Intercept form submissions when offline
        document.addEventListener('submit', (e) => {
            if (!this.isOnline) {
                e.preventDefault();
                this.queueOfflineAction(e.target);
            }
        });
    }

    initIndexedDB() {
        const request = indexedDB.open('RecebaPWA', 1);

        request.onerror = () => {
            console.error('IndexedDB initialization failed');
        };

        request.onsuccess = (event) => {
            this.db = event.target.result;
        };

        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            
            // Create offline actions store
            if (!db.objectStoreNames.contains('offlineActions')) {
                const store = db.createObjectStore('offlineActions', { keyPath: 'id', autoIncrement: true });
                store.createIndex('timestamp', 'timestamp', { unique: false });
                store.createIndex('type', 'type', { unique: false });
            }
        };
    }

    queueOfflineAction(form) {
        if (!this.db) return;

        const formData = new FormData(form);
        const action = {
            type: 'form_submission',
            url: form.action,
            method: form.method,
            data: Object.fromEntries(formData),
            timestamp: Date.now()
        };

        const transaction = this.db.transaction(['offlineActions'], 'readwrite');
        const store = transaction.objectStore('offlineActions');
        
        store.add(action);

        this.showNotification('Ação Salva', 'Ação salva para sincronização quando voltar online.', 'info');
    }

    async processOfflineQueue() {
        if (!this.db) return;

        const transaction = this.db.transaction(['offlineActions'], 'readwrite');
        const store = transaction.objectStore('offlineActions');
        const request = store.getAll();

        request.onsuccess = async () => {
            const actions = request.result;
            
            for (const action of actions) {
                try {
                    await this.processOfflineAction(action);
                    
                    // Remove processed action
                    const deleteTransaction = this.db.transaction(['offlineActions'], 'readwrite');
                    const deleteStore = deleteTransaction.objectStore('offlineActions');
                    deleteStore.delete(action.id);
                    
                } catch (error) {
                    console.error('Error processing offline action:', error);
                }
            }
        };
    }

    async processOfflineAction(action) {
        if (action.type === 'form_submission') {
            const response = await fetch(action.url, {
                method: action.method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(action.data)
            });

            if (response.ok) {
                this.showNotification('Sincronizado', 'Dados sincronizados com sucesso!', 'success');
            } else {
                throw new Error('Sync failed');
            }
        }
    }

    updateNetworkStatus() {
        const statusElement = document.getElementById('network-status');
        if (statusElement) {
            if (this.isOnline) {
                statusElement.className = 'w-3 h-3 rounded-full bg-green-500';
                statusElement.title = 'Online';
            } else {
                statusElement.className = 'w-3 h-3 rounded-full bg-red-500';
                statusElement.title = 'Offline';
            }
        }
    }

    showInstallPrompt() {
        // Create install prompt UI
        const installPrompt = document.createElement('div');
        installPrompt.className = 'fixed bottom-4 left-4 right-4 bg-indigo-600 text-white p-4 rounded-lg shadow-lg z-50';
        installPrompt.innerHTML = `
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold">Instalar Receba</h3>
                    <p class="text-sm">Adicione o Receba à sua tela inicial</p>
                </div>
                <div class="flex gap-2">
                    <button id="install-btn" class="bg-white text-indigo-600 px-3 py-1 rounded text-sm">Instalar</button>
                    <button id="dismiss-btn" class="text-white px-3 py-1 rounded text-sm">Dispensar</button>
                </div>
            </div>
        `;

        document.body.appendChild(installPrompt);

        // Handle install button
        document.getElementById('install-btn').addEventListener('click', () => {
            if (this.deferredPrompt) {
                this.deferredPrompt.prompt();
                this.deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted PWA install');
                    }
                    this.deferredPrompt = null;
                });
            }
            installPrompt.remove();
        });

        // Handle dismiss button
        document.getElementById('dismiss-btn').addEventListener('click', () => {
            installPrompt.remove();
        });
    }

    showNotification(title, message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        const typeColors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        };

        notification.className = `fixed top-4 right-4 ${typeColors[type]} text-white p-4 rounded-lg shadow-lg z-50 max-w-sm`;
        notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-1">
                    <h4 class="font-semibold">${title}</h4>
                    <p class="text-sm">${message}</p>
                </div>
                <button class="ml-2 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);

        // Manual dismiss
        notification.querySelector('button').addEventListener('click', () => {
            notification.remove();
        });
    }

    showPullToRefreshIndicator() {
        // Implementation for pull-to-refresh indicator
        console.log('Pull to refresh indicator shown');
    }

    hidePullToRefreshIndicator() {
        // Implementation for hiding pull-to-refresh indicator
        console.log('Pull to refresh indicator hidden');
    }

    refreshPage() {
        window.location.reload();
    }
}

// Initialize PWA when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const recebaPWA = new RecebaPWA();
    
    // Make it globally available
    window.RecebaPWA = recebaPWA;
});

// Handle viewport height changes (mobile address bar)
function setViewportHeight() {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
}

window.addEventListener('resize', setViewportHeight);
setViewportHeight();
