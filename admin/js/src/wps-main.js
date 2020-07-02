//var LOCALIZE = require('ctns-localize').default;

if (typeof AJAX !== "undefined") {
    WPS.localize.ajax = AJAX;
}

if (typeof IMAGES !== "undefined") {
    WPS.localize.images = IMAGES;
}

require('jplayer');
require('wps-domready');
require('wps-numbers');
require('wps-problems');
//require('wps-audio-ondemand');
