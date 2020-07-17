/* Copyright (C) CitePrep Guides - All Rights Reserved
 * Unauthorized copying of this file, via any medium is
 * strictly prohibited.
 * Proprietary and confidential.
 * Written by Malcolm Railey <malcolm@citeprep.com>, 2019
 */
var View = require('../../src/view/quiz-feature.js').default;
var Model = require('../../src/model/content-feature.js').default;

describe('views/quiz-feature', function () {

    describe('Basics', function () {

        it('class should be non-null', function () {
            expect(View).not.toBe(null);
        });

    });
     
    describe('without model', function () {

        it('should throw exception', function () {
            expect(function () {
                new View();
            }).toThrow(new Error('model is required'));
        });

    });

    describe('DOM, default state', function () {

        var model = new Model(),
            view  = new View({'model': model});

        it('should default to "ctns-hide"', function () {
            expect(view.$el.hasClass('ctns-hide')).toBe(true);
        });

    });

    describe('DOM, set state to "show"', function () {

        var model = new Model(),
            view  = new View({'model': model});

        model.set('state', 'ctns-show');
        
        it('should become "ctns-show"', function () {
            expect(view.$el.hasClass('ctns-show')).toBe(true);
        });

    });

    describe('DOM, set state to "hide"', function () {

        var model = new Model(),
            view  = new View({'model': model});

        model.set('state', 'ctns-hide');
        
        it('should become "ctns-hide"', function () {
            expect(view.$el.hasClass('ctns-hide')).toBe(true);
        });

    });
     
});
