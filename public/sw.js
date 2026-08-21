const CACHE = 'ca-v1';
const STATIC = [
  '/',
  '/products',
  '/about',
  '/export',
  '/quality',
  '/contact',
];

self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE).then(c => c.addAll(STATIC)).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', e => {
  e.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.filter(k => k !== CACHE).map(k => caches.delete(k)))
    ).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', e => {
  const { request } = e;
  const url = new URL(request.url);

  // Skip non-GET, cross-origin, admin, and cart requests
  if (request.method !== 'GET') return;
  if (url.origin !== location.origin) return;
  if (url.pathname.startsWith('/admin') || url.pathname.startsWith('/cart') || url.pathname.startsWith('/account')) return;

  // Cache-first for build assets (they have content hashes)
  if (url.pathname.startsWith('/build/')) {
    e.respondWith(
      caches.open(CACHE).then(c =>
        c.match(request).then(cached => {
          if (cached) return cached;
          return fetch(request).then(res => { c.put(request, res.clone()); return res; });
        })
      )
    );
    return;
  }

  // Cache-first for static images and fonts
  if (/\.(webp|png|jpg|jpeg|svg|ico|woff2?|ttf)$/i.test(url.pathname)) {
    e.respondWith(
      caches.open(CACHE).then(c =>
        c.match(request).then(cached => {
          if (cached) return cached;
          return fetch(request).then(res => {
            if (res.ok) c.put(request, res.clone());
            return res;
          });
        })
      )
    );
    return;
  }

  // Network-first for HTML pages (always fresh content)
  e.respondWith(
    fetch(request)
      .then(res => {
        if (res.ok) {
          caches.open(CACHE).then(c => c.put(request, res.clone()));
        }
        return res;
      })
      .catch(() => caches.match(request))
  );
});
