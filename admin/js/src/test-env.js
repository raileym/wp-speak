var $          = require('jquery'),
    underscore = require('underscore'),
    backbone   = require('backbone'),
    mathjax    = require('mathjax'),
    JXG        = require('jsxgraph');

Object.defineProperty(window, '$', {value: $});
Object.defineProperty(global, '$', {value: $});
Object.defineProperty(global, 'jQuery', {value: $});
Object.defineProperty(global, 'underscore', {value: underscore});
Object.defineProperty(global, '_', {value: underscore});
Object.defineProperty(global, 'backbone', {value: backbone});
Object.defineProperty(global, 'Backbone', {value: backbone});
Object.defineProperty(global, 'mathjax', {value: mathjax});
Object.defineProperty(global, 'MathJax', {value: mathjax});
