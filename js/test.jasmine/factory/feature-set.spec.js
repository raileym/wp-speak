const $       = require('jquery'),
      Factory = require('../../src/factory/feature-set.js').default;

describe("factory/feature-set", function () {

    describe("Basics", function () {

        it("class should be non-null", function () {
            expect(Factory).not.toBe(null);
        });

    });
     
    describe("without collection", function () {

//         it("should throw exception", function () {
//             expect(function () {
//                 new Factory();
//             }).toThrow(new Error("collection is required"));
//         });

    });

    describe("DOM, default state", function () {

        var factory  = new Factory({el: $("\
<div class='ctns-features'>\
</div>\
")});

        console.dirxml(factory.$el[0]);
        
        it("should default to 'ctns-hide'", function () {
//                 expect(factory.$el.hasClass("ctns-hide")).toBe(true);
        });

    });

    describe("DOM, default state", function () {

        var factory  = new Factory({el: $("\
<div class='ctns-features'>\
<div class='ctns-features-content'>\
  <div class='ctns-feature ctns-note'>My Note 1</div>\
  <div class='ctns-feature ctns-note'>My Note 2</div>\
  <div class='ctns-feature ctns-note'>My Note 3</div>\
  <div class='ctns-feature ctns-note'>My Note 4</div>\
  <div class='ctns-feature ctns-note'>My Note 5</div>\
  <div class='ctns-feature ctns-note'>My Note 6</div>\
</div>\
</div>\
")});

        console.dirxml(factory.$el[0]);
        
        it("should default to 'ctns-hide'", function () {
//                 expect(factory.$el.hasClass("ctns-hide")).toBe(true);
        });

    });
     
//     describe("DOM, ctns-note, My Note 1", function () {
// 
//         var factory;
//         
//         // Setup
//         beforeEach(function () {
//  rewiremock('dependency').with(stub);
//  rewiremock(() => require('dependency')).with(stub);
//  rewiremock.enable(); 
//  const file = require('file.js');
//  rewiremock.disable();
//  
//             factory  = new Factory({el: $("\
// <div class='ctns-features'>\
// <div class='ctns-features-content'>\
//   <div class='ctns-feature ctns-note'>My Note 1</div>\
// </div>\
// </div>\
// ")});
//         });
// 
//         console.dirxml(factory.$el[0]);
//         
//         it("should default to 'ctns-hide'", function () {
// //                 expect(factory.$el.hasClass("ctns-hide")).toBe(true);
//         });
// 
//         // Setup
//         afterEach(function () {
//             // Do nothing
//         });
// 
//     });

});
