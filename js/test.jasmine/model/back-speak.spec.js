var Model = require('model/back-speak').default;

describe('model/back-speak', function () {

    // TDD
    describe('Basics', function () {

        it('class should be non-null', function () {
            expect(Model).not.toBe(null);
        });

    });
     
    describe('Default state', function () {
    
        it('should show default attributes', function() {
            var model = new Model();

            expect(model.get('selected'))
                .toBe(false);
        });
             
    });
     
    describe('Setting state', function () {
    
        it('should set "selected" to "false"', function() {
            var model = new Model();

            expect(model.get('selected'))
                .toBe(false);

            model.unselect();
            
            expect(model.get('selected'))
                .toBe(false);
        });
             
        it('should set "selected" to "true"', function() {
            var model = new Model();

            expect(model.get('selected'))
                .toBe(false);

            model.select();
            
            expect(model.get('selected'))
                .toBe(true);
        });
             
    });
     
});
