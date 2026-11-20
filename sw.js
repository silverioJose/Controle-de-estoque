const CACHE_NAME = 'despensa-v1';
const ASSETS_ESTATICOS = [
  '/Mobile/public/css/main.css',
  '/Mobile/public/js/copiar.js'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(ASSETS_ESTATICOS))
  );
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(
        keys
          .filter((key) => key !== CACHE_NAME)
          .map((key) => caches.delete(key))
      )
    )
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  const { request } = event;

  // Nunca intercepta requisições POST ou controllers PHP de escrita
  if (request.method !== 'GET' || request.url.includes('/src/controller/')) {
    return;
  }

  // Para CSS/JS/imagens: tenta cache primeiro, depois rede
  const isAsset =
    request.url.includes('/public/css/') ||
    request.url.includes('/public/js/') ||
    request.url.includes('/public/img/');

  if (isAsset) {
    event.respondWith(
      caches.match(request).then((cached) => cached || fetch(request))
    );
  }
});