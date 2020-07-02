var $       = require('jquery'),
    NUMBERS = {};

NUMBERS.getRandomInt = (function() {
    return function(max) {
        return Math.floor(Math.random() * Math.floor(max));
    };
})();

export default NUMBERS;
