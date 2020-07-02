// Requirejs Configuration Options
require.config({
    
    // to set the default folder
    baseUrl: '../src', 
    
    // paths: maps ids with paths (no extension)
    paths: {
        'jquery':                   '/wp-includes/js/jquery/jquery',
        'backbone':                 '/wp-includes/js/backbone.min',
        'underscore':               '/wp-includes/js/underscore.min',
        'jasmine':                  '../test.jasmine/lib/jasmine',
        'jasmine-html':             '../test.jasmine/lib/jasmine-html',
        'jasmine-boot':             '../test.jasmine/lib/boot',
//        'text':                     '../lib/requirejs/text',
        //'templates':                '../src/templates/templates',
        'model.feature.spec':       '../test.jasmine/models/feature.spec',
        'view.note-feature.spec':   '../test.jasmine/views/note-feature.spec',
        'view.quiz-feature.spec':   '../test.jasmine/views/quiz-feature.spec',
        'view.video-feature.spec':  '../test.jasmine/views/video-feature.spec',
        'view.features.spec':       '../test.jasmine/views/features.spec',

        'three':                    '../lib/three/three.js-master/build/three',
        'stats3':                   '../lib/three/three.js-master/examples/js/libs/stats.min',
        'gui3':                     '../lib/three/three.js-master/examples/js/libs/dat.gui.min',
        'orbitcontrols3':           '../lib/three/three.js-master/examples/js/controls/OrbitControls.v2',
        'sceneutils':               '../lib/three/three.js-master/examples/js/utils/SceneUtils.v2',
        'meshline3':                '../lib/three/three.MeshLine/srcthree.MeshLine',
//         'md5':                      '../src/ctns-md5',
//         'numbers':                  '../src/ctns-numbers',
//         'term':                     '../src/ctns-term',
//         'prototype':                '../src/ctns-prototype',
//         'quiz':                     '../src/ctns-quiz',
//         'problems':                 '../src/ctns-problems',
//         'problems_domready':        '../src/ctns-problems-domready',
//         'localize':                 '../src/ctns-localize',
        'domReady':                 '../lib/requirejs/domReady',
        'text':                     '../lib/requirejs/text',
//         'templates/templates':                '../src/templates/templates',
        'katex':                    '../lib/katex/katex.min',
        'math':                     '//cdnjs.cloudflare.com/ajax/libs/mathjs/5.4.1/math',
        'mathjax':                  '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.4.0/MathJax.js?config=default,https://citeprep.com/include/local-mathjax',
        'jsxgraphcore':             '//cdnjs.cloudflare.com/ajax/libs/jsxgraph/0.99.7/jsxgraphcore',
        'jsxgraphpatch':            '../lib/jsxgraph/jsxgraphcore-0.99.7-patch',
        'jplayer':                  '../lib/jplayer/jquery.jplayer',
//         'sinon':                    '../lib/sinon',
//         'views/features':           '../src/views/features',
//         'views/feature-control':    '../src/views/feature-control',
//         'views/note-feature':       'views/note-feature',
//         'views/quiz-feature':       '../src/views/quiz-feature',
//         'views/video-feature':      '../src/views/video-feature',
//         'collections/features':     '../src/collections/features',
//         'models/feature':           '../src/models/feature',
    },
    
    // shim: makes external libraries compatible with requirejs (AMD)
    shim: {
        'jasmine-html': {
            deps : ['jasmine']
        },
        'jasmine-boot': {
            deps : ['jasmine', 'jasmine-html']
        },
        'problems' : {
            deps: ['jplayer']
        },        
        'jplayer' : {
            deps: ['jquery']
        },        
        'jquery' : {
            exports : 'jQuery'
        },
        'backbone' : {
            exports : 'Backbone',
            deps: ['underscore', 'jquery']
        },
        'underscore' : {
            exports : '_'
        },
//         'sinon' : {
//             exports : 'sinon'
//         },
    }

});

require(['jasmine-boot'], function () {

    require([
    
        'model.feature.spec', 
        'view.note-feature.spec',
        'view.quiz-feature.spec',
        'view.video-feature.spec',
        'view.features.spec',
        
        ], function() {
            //trigger Jasmine
            window.onload();
        }
    );

});
