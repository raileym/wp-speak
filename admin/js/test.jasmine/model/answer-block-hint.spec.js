var Model = require('model/answer-block-hint').default;

describe('model/answer-block-hint', function () {

    // TDD
    describe('Basics', function () {

        it('class should be non-null', function () {
            expect(Model).not.toBe(null);
        });

    });
     
    describe('Default state', function () {
    
        it('should show default attributes', function() {
            var model = new Model();

            expect(model.get('show'))
                .toBe(false);
        });
             
    });
     
    describe('Setting state', function () {
    
        it('should set show to "false"', function() {
            var model = new Model();

            expect(model.get('show'))
                .toBe(false);

            model.hide();
            
            expect(model.get('show'))
                .toBe(false);
        });
             
        it('should set show to "true"', function() {
            var model = new Model();

            expect(model.get('show'))
                .toBe(false);

            model.show();
            
            expect(model.get('show'))
                .toBe(true);
        });
             
    });
     
});
