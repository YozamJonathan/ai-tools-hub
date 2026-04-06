/* ═══════════════════════════════════════════
   AI TOOLS HUB — SERVICE WORKER
   PWA offline support & caching
═══════════════════════════════════════════ */

const CACHE_NAME = 'ai-tools-hub-v1';

const STATIC_ASSETS = [
  '/',
  '/index.html',
  '/css/style.css',
  '/js/app.js',
  '/manifest.json',
  '/pages/library.html',
  '/pages/favorites.html',
  '/pages/suggest.html',
  '/pages/admin.html',
];

// Install — cache static assets
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(STATIC_ASSETS))
  );
  self.skipWaiting();
});

// Activate — clean old caches
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
    )
  );
  self.clients.claim();
});

// Fetch — cache-first for static, network-first for API
self.addEventListener('fetch', event => {
  const url = new URL(event.request.url);

  // Static assets — cache first
  if (event.request.method === 'GET' && (
    url.pathname.endsWith('.html') ||
    url.pathname.endsWith('.css')  ||
    url.pathname.endsWith('.js')   ||
    url.pathname.endsWith('.json') ||
    url.pathname.endsWith('.png')  ||
    url.pathname.endsWith('.svg')
  )) {
    event.respondWith(
      caches.match(event.request).then(cached => {
        if (cached) return cached;
        return fetch(event.request).then(response => {
          if (response.ok) {
            const clone = response.clone();
            caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
          }
          return response;
        });
      }).catch(() => caches.match('/index.html'))
    );
    return;
  }

  // API calls — network first, fall back to cache
  event.respondWith(
    fetch(event.request).catch(() => caches.match(event.request))
  );
});
