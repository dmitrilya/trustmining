//import _ from 'lodash';
//import jQuery from 'jquery';
//window.$ = jQuery.noConflict();
//window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';

function getCurrentLocalePrefix() {
    const pathname = window.location.pathname;
    const prefixes = window.supportedLocales || [];
    const cleanPath = pathname.startsWith('/') ? pathname.substring(1) : pathname;
    const activePrefix = prefixes.find(prefix => cleanPath.startsWith(prefix));

    return activePrefix ? activePrefix.replace('/', '') : null;
}

axios.interceptors.request.use((config) => {
    const locale = getCurrentLocalePrefix();

    if (locale && config.url && config.url.startsWith('/')) config.url = `/${locale}${config.url}`;

    return config;
}, (error) => {
    return Promise.reject(error);
});

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
