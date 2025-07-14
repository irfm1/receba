var staticCacheName = "receba-pwa-v" + new Date().getTime();
var dynamicCacheName = "receba-dynamic-v" + new Date().getTime();

var filesToCache = [
    '/offline',
    '/dashboard',
    '/customers',
    '/invoices',
    '/technical-reports',
    '/service-templates',
    '/service-packages',
    '/build/assets/app.css',
    '/build/assets/app.js',
    '/images/icons/icon-72x72.png',
    '/images/icons/icon-96x96.png',
    '/images/icons/icon-128x128.png',
    '/images/icons/icon-144x144.png',
    '/images/icons/icon-152x152.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512x512.png',
];

// Cache on install
self.addEventListener("install", event => {
    console.log('Service Worker: Installing...');
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                console.log('Service Worker: Caching files');
                return cache.addAll(filesToCache);
            })
            .catch(err => console.log('Service Worker: Error caching files', err))
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    console.log('Service Worker: Activating...');
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("receba-") && cacheName !== staticCacheName && cacheName !== dynamicCacheName))
                    .map(cacheName => {
                        console.log('Service Worker: Deleting old cache', cacheName);
                        return caches.delete(cacheName);
                    })
            );
        })
    );
});

// Network-first strategy for API calls, cache-first for static assets
self.addEventListener("fetch", event => {
    const request = event.request;
    const url = new URL(request.url);
    
    // Skip non-GET requests
    if (request.method !== 'GET') {
        return;
    }
    
    // API calls - network first
    if (url.pathname.startsWith('/api/') || url.pathname.includes('livewire')) {
        event.respondWith(
            fetch(request)
                .then(response => {
                    // Cache successful responses
                    if (response.status === 200) {
                        const responseClone = response.clone();
                        caches.open(dynamicCacheName)
                            .then(cache => cache.put(request, responseClone));
                    }
                    return response;
                })
                .catch(() => {
                    // Return cached version if available
                    return caches.match(request)
                        .then(response => {
                            if (response) {
                                return response;
                            }
                            // Return offline page for navigation requests
                            if (request.mode === 'navigate') {
                                return caches.match('/offline');
                            }
                            return new Response('Offline - no cached version available', {
                                status: 503,
                                statusText: 'Service Unavailable'
                            });
                        });
                })
        );
    }
    // Static assets - cache first
    else {
        event.respondWith(
            caches.match(request)
                .then(response => {
                    if (response) {
                        return response;
                    }
                    return fetch(request)
                        .then(response => {
                            // Cache successful responses
                            if (response.status === 200) {
                                const responseClone = response.clone();
                                caches.open(dynamicCacheName)
                                    .then(cache => cache.put(request, responseClone));
                            }
                            return response;
                        })
                        .catch(() => {
                            // Return offline page for navigation requests
                            if (request.mode === 'navigate') {
                                return caches.match('/offline');
                            }
                            return new Response('Offline', {
                                status: 503,
                                statusText: 'Service Unavailable'
                            });
                        });
                })
        );
    }
});

// Background sync for offline actions
self.addEventListener('sync', event => {
    console.log('Service Worker: Background sync triggered', event.tag);
    
    if (event.tag === 'background-sync') {
        event.waitUntil(
            // Process offline actions queue
            processOfflineActions()
        );
    }
});

// Push notifications
self.addEventListener('push', event => {
    console.log('Service Worker: Push notification received', event);
    
    if (event.data) {
        const data = event.data.json();
        const options = {
            body: data.body,
            icon: '/images/icons/icon-192x192.png',
            badge: '/images/icons/icon-72x72.png',
            vibrate: [100, 50, 100],
            data: data.data,
            actions: data.actions || []
        };
        
        event.waitUntil(
            self.registration.showNotification(data.title, options)
        );
    }
});

// Notification click handler
self.addEventListener('notificationclick', event => {
    console.log('Service Worker: Notification clicked', event);
    
    event.notification.close();
    
    if (event.action === 'open') {
        event.waitUntil(
            clients.openWindow(event.notification.data.url || '/dashboard')
        );
    }
});

// Helper function to process offline actions
async function processOfflineActions() {
    try {
        // This would connect to IndexedDB to process queued actions
        console.log('Service Worker: Processing offline actions...');
        
        // Example: Send queued forms, sync data, etc.
        // Implementation depends on your offline storage strategy
        
        return Promise.resolve();
    } catch (error) {
        console.error('Service Worker: Error processing offline actions', error);
        return Promise.reject(error);
    }
}