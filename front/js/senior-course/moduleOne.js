function myModuleOne() {
    var msg = "Hello World";

    function doSomething() {
        console.log(msg.toUpperCase());
    }

    function doOtherthing() {
        console.log(msg.toLocaleLowerCase());
    }

    return {
        doSomething: doSomething,
        doOtherthing: doOtherthing
    }
    
}