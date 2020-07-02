// See https://github.com/jhnns/rewire
//

// test.jasmine/myModule.test.js
const rewire = require("rewire");
const myModule = rewire("myModule");

// Will move these two instructions INSIDE, and then DOUBLE
// the number of tests involved.

const fsMock = {
    readFile: function (path, encoding, cb) {
        expect(path).toEqual("/somewhere/on/the/disk");
        cb(null, "Success!");
    }
};
myModule.__set__("fs", fsMock);

// myModule.readSomethingFromFileSystem(function (err, data) {
//     console.log(data); // = Success!
// });

describe("mymodule", function () {

    describe("Basics", function () {

        var PATH;
        
        it("readSomethingFromFileSystem - Stub out fs", function () {

            PATH = "/somewhere/on/the/disk";
        
            myModule.__set__("fs", {
                readFile: function (path, encoding, cb) {
                    expect(path).toEqual(PATH);
                    cb(null, "Success!");
                }
            });

            myModule.readSomethingFromFileSystem(PATH,function (err, data) {
                console.log(data); // = Success!
            });

        });
     
        it("readSomethingElseFromFileSystem - Stub out fs", function () {

            PATH = "/somewhere/else/on/the/disk";
            
            myModule.__set__("fs", {
                readFile: function (path, encoding, cb) {
                    expect(path).toEqual(PATH);
                    cb(null, "Success!");
                }
            });

            myModule.readSomethingElseFromFileSystem(PATH, function (err, data) {
                console.log(data); // = Success!
            });

        });
     
    });
     
});

