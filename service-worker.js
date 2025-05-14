importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-sw.js');

if (workbox) {
  console.log("✅ Workbox cargado correctamente");

  workbox.precaching.precacheAndRoute([
    { url: '/Tp_Final_Interfaces/índice.html', revision: '1' },
    { url: '/Tp_Final_Interfaces/manifesto.json', revision: '1' },
    { url: '/Tp_Final_Interfaces/fuente/css/estilos.css', revision: '1' },
    { url: '/Tp_Final_Interfaces/images/icon-192x192.png', revision: '1' },
    { url: '/Tp_Final_Interfaces/images/icon-512x512.png', revision: '1' },
  ]);

  workbox.routing.registerRoute(
    ({request}) => request.destination === 'image',
    new workbox.strategies.CacheFirst({
      cacheName: 'imagenes-cache'
    })
  );

  workbox.routing.registerRoute(
    ({request}) => request.destination === 'style' || request.destination === 'script',
    new workbox.strategies.StaleWhileRevalidate({
      cacheName: 'recursos-estaticos'
    })
  );

} else {
  console.log("❌ Error al cargar Workbox");
}
