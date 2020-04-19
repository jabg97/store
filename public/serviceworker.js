// TODO: increase `version` number to force cache update when publishing a new release
const version = 'v1';

const config = {
    cacheRemote: true,
    version: version+'::',
    preCachingItems: [
        'index.php',
        'offline.html',
        '404.html',
        'serviceworker.js'
    ],
    blacklistCacheItems: [
        'index.php'
    ],
    offlineImage: '<svg role="img" aria-labelledby="offline-title"' + ' viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">' + '<title id="offline-title">Offline</title>' + '<g fill="none" fill-rule="evenodd"><path fill="#aaa" d="M0 0h400v300H0z"/>' + '<text fill="#222" font-family="monospace" font-size="32" font-weight="bold">' + '<tspan x="136" y="156">offline</tspan></text></g></svg>',
    offlinePage: 'offline.html',
    notFoundPage: '404.html'
};

const WebPush = {
    init () {
      self.addEventListener('push', this.notificationPush.bind(this))
      self.addEventListener('notificationclick', this.notificationClick.bind(this))
      self.addEventListener('notificationclose', this.notificationClose.bind(this))
    },

    /**
     * Handle notification push event.
     *
     * https://developer.mozilla.org/en-US/docs/Web/Events/push
     *
     * @param {NotificationEvent} event
     */
    notificationPush (event) {
      if (!(self.Notification && self.Notification.permission === 'granted')) {
        return
      }

      // https://developer.mozilla.org/en-US/docs/Web/API/PushMessageData
      if (event.data) {
        event.waitUntil(
          this.sendNotification(event.data.json())
        )
      }
    },

    /**
     * Handle notification click event.
     *
     * https://developer.mozilla.org/en-US/docs/Web/Events/notificationclick
     *
     * @param {NotificationEvent} event
     */
    notificationClick (event) {
      // console.log(event.notification)

      if (event.action === 'some_action') {
        // Do something...
      } else {
        self.clients.openWindow('/')
      }
    },

    /**
     * Handle notification close event (Chrome 50+, Firefox 55+).
     *
     * https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerGlobalScope/onnotificationclose
     *
     * @param {NotificationEvent} event
     */
    notificationClose (event) {
      self.registration.pushManager.getSubscription().then(subscription => {
        if (subscription) {
          this.dismissNotification(event, subscription)
        }
      })
    },

    /**
     * Send notification to the user.
     *
     * https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerRegistration/showNotification
     *
     * @param {PushMessageData|Object} data
     */
    sendNotification (data) {
      return self.registration.showNotification(data.title, data)
    },

    /**
     * Send request to server to dismiss a notification.
     *
     * @param  {NotificationEvent} event
     * @param  {String} subscription.endpoint
     * @return {Response}
     */
    dismissNotification ({ notification }, { endpoint }) {
      if (!notification.data || !notification.data.id) {
        return
      }

      const data = new FormData()
      data.append('endpoint', endpoint)

      // Send a request to the server to mark the notification as read.
      fetch(`/notifications/${notification.data.id}/dismiss`, {
        method: 'POST',
        body: data
      })
    }
  }

  WebPush.init();

function cacheName(key, opts) {
    return `${opts.version}${key}`;
}

function addToCache(cacheKey, request, response) {
    if (response.ok) {
        const copy = response.clone();
        caches.open(cacheKey).then(cache => {
            cache.put(request, copy);
        });
    }
    return response;
}

function fetchFromCache(event) {
    return caches.match(event.request).then(response => {
        if (!response) {
            throw Error(`${event.request.url} not found in cache`);
        } else if (response.status === 404) {
            return caches.match(config.notFoundPage);
        }
        return response;
    });
}

function offlineResponse(resourceType, opts) {
    if (resourceType === 'content') {
        return caches.match(opts.offlinePage);
    }
    if (resourceType === 'image') {
        return new Response(opts.offlineImage, {
            headers: { 'Content-Type': 'image/svg+xml' }
        });
    }
    return undefined;
}

self.addEventListener('install', event => {
    event.waitUntil(caches.open(
        cacheName('static', config)
        )
            .then(cache => cache.addAll(config.preCachingItems))
            .then(() => self.skipWaiting())
    );
});
self.addEventListener('activate', event => {
    function clearCacheIfDifferent(event, opts) {
        return caches.keys().then(cacheKeys => {
            const oldCacheKeys = cacheKeys.filter(key => key.indexOf(opts.version) !== 0);
            const deletePromises = oldCacheKeys.map(oldKey => caches.delete(oldKey));
            return Promise.all(deletePromises);
        });
    }
    event.waitUntil(
        clearCacheIfDifferent(event, config)
            .then(() => self.clients.claim())
    );
});
self.addEventListener('fetch', event => {
    const request = event.request;
    const url = new URL(request.url);
    if (request.method !== 'GET'
        || (config.cacheRemote !== true && url.origin !== self.location.origin)
        || (config.blacklistCacheItems.length > 0 && config.blacklistCacheItems.indexOf(url.pathname) !== -1)) {
        // default browser behavior
        return;
    }
    let cacheKey;
    let resourceType = 'content';
    if (/(.jpg|.jpeg|.webp|.png|.svg|.gif)$/.test(url.pathname)) {
        resourceType = 'image';
    } else if (/.\/fonts.(?:googleapis|gstatic).com/.test(url.origin)) {
        resourceType = 'font';
    }
    cacheKey = cacheName(resourceType, config);
    if (resourceType === 'content') {
        // Network First Strategy
        event.respondWith(
            fetch(request)
                .then(response => addToCache(cacheKey, request, response))
                .catch(() => fetchFromCache(event))
                .catch(() => offlineResponse(resourceType, config))
        );
    } else {
        // Cache First Strategy
        event.respondWith(
            fetchFromCache(event)
                .catch(() => fetch(request))
                .then(response => addToCache(cacheKey, request, response))
                .catch(() => offlineResponse(resourceType, config))
        );
    }
});
