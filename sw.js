const CACHE_NAME = 'despensa-v4';
const APP_BASE = new URL('./', self.registration.scope);
const OFFLINE_URL = new URL('offline.html', APP_BASE).href;

const ASSETS_ESTATICOS = [
  'manifest.json',
  'offline.html',
  'public/css/main.css',
  'public/css/normalize.css',
  'public/css/fonts.css',
  'public/css/geral.css',
  'public/css/variables.css',
  'public/css/header.css',
  'public/css/lista.css',
  'public/css/footer.css',
  'public/css/form.css',
  'public/css/estoque.css',
  'public/js/form.js',
  'public/js/copiar.js',
  'public/js/excluir.js',
  'public/assets/fonts/Poppins-Regular.ttf',
  'public/img/icon-192.png',
  'public/img/icon-512.png'
].map((path) => new URL(path, APP_BASE).href);

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
          .filter((key) => key.startsWith('despensa-') && key !== CACHE_NAME)
          .map((key) => caches.delete(key))
      )
    ).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Evita armazenar ações do sistema, inclusive alteração de quantidade via GET.
  if (
    request.method !== 'GET' ||
    url.origin !== APP_BASE.origin ||
    url.pathname.includes('/src/controller/')
  ) {
    return;
  }

  if (request.mode === 'navigate') {
    event.respondWith(
      fetch(request).catch(async () => {
        const offlinePage = await caches.match(OFFLINE_URL);
        return offlinePage || Response.error();
      })
    );
    return;
  }

  const isStaticAsset = /\/public\/(css|js|img|assets)\//.test(url.pathname);
  if (!isStaticAsset) return;

  event.respondWith(
    caches.match(request).then((cached) => {
      if (cached) return cached;

      return fetch(request).then((response) => {
        if (response.ok) {
          const responseCopy = response.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(request, responseCopy));
        }
        return response;
      });
    })
  );
});
