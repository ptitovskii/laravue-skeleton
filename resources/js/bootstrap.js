
window._ = require('lodash');
window.hash = require('object-hash');

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}
