
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

/**
 * Load jQuery if it's not already loaded by script tag
 */
if (!window.jQuery) {
    window.$ = window.jQuery = require('jquery');
}

require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
let VueResource = require('vue-resource');
Vue.use(VueResource);

import VModal from 'vue-js-modal'
Vue.use(VModal)

Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
Vue.http.headers.common['Accept'] = 'application/json';
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

import 'jquery-confirm';
import * as toastr from 'toastr';
import 'toastr/build/toastr.css';

toastr.options = {
    "showDuration": "300",
    "hideDuration": "200",
    "timeOut": "3000",
};

window.toastr = toastr;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
