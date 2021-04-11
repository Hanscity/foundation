function getStyle(obj, name) {
    // 这里一定要加上 window, 因为对象的属性没有会报错为 undefined, 而变量没有会直接报错~
    if (window.getComputedStyle) {
        return getComputedStyle(obj)[name];
    } else {
        // IE 8 的用法
        return obj.currentStyle[name];
    }
}


/**
 * @comment: 动画效果改变属性
 * 
 * @param {*} obj 
 * @param {*} attr 
 * @param {*} speed 
 * @param {*} target 
 * @param {*} callback 
 */
function move(obj, attr, speed, target, callback) {

    clearInterval(obj.timer);
    
    if (parseInt(getStyle(obj, attr)) > target) {
        speed = -speed;
    }

    obj.timer = setInterval(function () {

        var attrValue = parseInt(getStyle(obj, attr));
        obj.style[attr] = attrValue + speed + "px";

        if ((speed < 0 && parseInt(attrValue) <= target) || 
            (speed >= 0 && parseInt(attrValue) >= target) ) {

            obj.style[attr] = target + "px";
            clearInterval(obj.timer);
            callback && callback(); 
        }
    }, 30);
}


/**
 * 
 *  类的操作
 */

function addClassName(obj, className) {
    if (! hasClassName(obj, className)) {
        obj.className += " " + className;
    }
}

function hasClassName(obj, className) {
    var reg = new RegExp("\\b" + className + "\\b");
    var bool =  reg.test(obj.className)
    return bool;
}

function removeClassName(obj, className) {
    var reg = new RegExp("\\b" + className + "\\b");
    obj.className = obj.className.replace(reg, "");
}


/**
 * 如果有，则添加此类; 如果没有，则删除此类;
 * @param {*} obj 
 * @param {*} className 
 */
function toggleClassName(obj, className) {
    if (hasClassName(obj, className)) {
        removeClassName(obj, className);
    } else {
        addClassName(obj, className);
    }
}