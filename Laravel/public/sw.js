// ⚙️ Service Worker - PWA "El Buen Sabor" (Modo Offline y Cache Rápido)
const CACHE_NAME = 'elbuensabor-v1';

// Recursos esenciales que se guardan en el celular para funcionar sin internet
const ASSETS = [
    '/',
    '/menu',
    '/contacto',
    '/reservas',
    '/images/platos/ceviche.jpg',
    '/images/platos/lomo-saltado.jpg',
    '/images/platos/causa.jpg',
    '/images/platos/anticuchos.jpg',
    '/images/platos/chicha.jpg'
];

// 1. Instalación del Service Worker: Guarda los archivos en la caché del navegador
self.addEventListener('install', (e) => {
    e.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log('✅ [PWA] Guardando carta y vistas en caché offline');
            return cache.addAll(ASSETS);
        })
    );
    self.skipWaiting();
});

// 2. Activación: Limpia cachés viejas si se actualiza el sistema
self.addEventListener('activate', (e) => {
    e.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.map((key) => {
                    if (key !== CACHE_NAME) {
                        console.log('🧹 [PWA] Limpiando caché antigua:', key);
                        return caches.delete(key);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// 3. Intercepta peticiones: Primero intenta internet (Network First), si no hay red carga la caché (Offline Fallback)
self.addEventListener('fetch', (e) => {
    e.respondWith(
        fetch(e.request)
            .then((response) => {
                // Si hay internet, clona la respuesta en caché para tenerla actualizada
                const responseClone = response.clone();
                caches.open(CACHE_NAME).then((cache) => {
                    if (e.request.method === 'GET' && e.request.url.startsWith('http')) {
                        cache.put(e.request, responseClone);
                    }
                });
                return response;
            })
            .catch(() => {
                // 📡 Si no hay internet, busca en la memoria caché del celular
                return caches.match(e.request).then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    // Si intenta ver otra página sin internet, le muestra la carta en caché
                    if (e.request.mode === 'navigate') {
                        return caches.match('/menu');
                    }
                });
            })
    );
});
