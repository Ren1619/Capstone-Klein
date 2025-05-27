import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

/**
 * Set up CSRF protection for AJAX requests
 */
function setupAjaxCsrf() {
    // Get the CSRF token from the meta tag
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Add the token to all AJAX requests
    if (window.axios) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    }

    // For fetch API
    window.fetchWithCsrf = function (url, options = {}) {
        // Create default headers if they don't exist
        if (!options.headers) {
            options.headers = {};
        }

        // Add CSRF token header
        options.headers['X-CSRF-TOKEN'] = token;

        // Set Content-Type if not already set
        if (!options.headers['Content-Type'] && options.method &&
            ['POST', 'PUT', 'PATCH'].includes(options.method.toUpperCase())) {
            options.headers['Content-Type'] = 'application/json';
        }

        // Return the fetch promise
        return fetch(url, options);
    };

    // For jQuery (if used)
    if (window.jQuery) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
    }
}

// Initialize CSRF protection when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    setupAjaxCsrf();
});