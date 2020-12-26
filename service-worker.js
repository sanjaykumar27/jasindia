self.addEventListener('install', evt => {
    //console.log('Service worker has been installed');
});

self.addEventListener('activate', evt => {
    //console.log('Service worker has been activated');
});

/* fetch event */
self.addEventListener('fetch', evt => {
    //console.log('Fetch event occurred', evt);
});