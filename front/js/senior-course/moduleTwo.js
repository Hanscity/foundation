(function () {
    var msg = "KISS(keep it simple, stupid)";

    function doSomething() {
        console.log(msg.toUpperCase());
    }

    function doOtherthing() {
        console.log(msg.toLocaleLowerCase());
    }

    window.myModuleTwo = {
        doSomething: doSomething,
        doOtherthing: doOtherthing
    }
})();