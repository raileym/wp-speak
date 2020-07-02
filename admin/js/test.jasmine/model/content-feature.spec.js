var Model = require('model/content-feature').default;

describe('model/content-feature', function () {

    // TDD
    describe('Basics', function () {

        it('class should be non-null', function () {
            expect(Model).not.toBe(null);
        });

    });
     
    describe('Default state', function () {
    
        it('should show default attributes', function() {
            var model = new Model();

            expect(model.get('state'))
                .toEqual('ctns-hide');
        });
             
    });
     
    describe('Setting state', function () {
    
        it('should set state to "ctns-hide"', function() {
            var model = new Model();

            expect(model.get('state'))
                .toEqual('ctns-hide');

            model.hide();
            
            expect(model.get('state'))
                .toEqual('ctns-hide');
        });
             
        it('should set state to "ctns-show"', function() {
            var model = new Model();

            expect(model.get('state'))
                .toEqual('ctns-hide');

            model.show();
            
            expect(model.get('state'))
                .toEqual('ctns-show');
        });
             
    });
     
});
