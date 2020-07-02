var Model = require('model/control-feature').default;

describe('model/control-feature', function () {

    describe('Basics', function () {

        it('class should be non-null', function () {
            expect(Model).not.toBe(null);
        });

    });
     
    describe('Default state', function () {
    
        it('should show default attributes', function() {
            var model = new Model();

            expect(model.get('state'))
                .toEqual('ctns-showable');
        });
             
    });
     
    describe('Setting state', function () {
    
        it('should set state to "ctns-showable"', function() {
            var model = new Model();

            expect(model.get('state'))
                .toEqual('ctns-showable');

            model.hide();
            
            expect(model.get('state'))
                .toEqual('ctns-showable');
        });
             
        it('should set state to "ctns-hideable"', function() {
            var model = new Model();

            expect(model.get('state'))
                .toEqual('ctns-showable');

            model.show();
            
            expect(model.get('state'))
                .toEqual('ctns-hideable');
        });
             
    });
     
});
