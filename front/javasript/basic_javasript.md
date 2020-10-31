### JavaScript 显示数据

- 使用 window.alert() 弹出警告框。
- 使用 document.write() 方法将内容写到 HTML 文档中。
- 使用 innerHTML 写入到 HTML 元素。
- 使用 console.log() 写入到浏览器的控制台。


### JavaScript 语句

- JavaScript 语句向浏览器发出的命令。语句的作用是告诉浏览器该做什么。
- JavaScript 是脚本语言。浏览器会在读取代码时，逐行地执行脚本代码。而对于传统编程来说，会在执行前对所有代码进行编译。

### JavaScript 作用域

- 全局变量其实是属于 window 对象的


### 变量提升
- 变量的声明会被编译器提升，但是赋值不会

### javascript 的 switch
- javascript 的 switch 是强制类型的等于
- PHP 的 switch 是弱类型的等于,保持了弱类型语言的一致性哈


### JavaScript 的 加号 +

- 加法是两个数字相加

- 连接是两个字符串连接

- 如果是数字和字符串用 + ，那么就是两个字符串

- 这一点上面，PHP 还是严谨一些，加号是加号，字符串的连接用点（ .）




### 类型判断

```

// isNaN 
function judgeNum(a)
{
    if(typeof a === 'number'){
        return true;
    }else{
        return false;
    }
}

function judgeStr(a)
{
    if(typeof a === 'string'){
        return true;
    }else{
        return false;
    }
}


function judgeBool(a)
{
    if(typeof a === 'boolean'){
        return true;
    }else{
        return false;
    }
}

function judgeArray(a)
{
    if(a.constructor.toString().indexOf("Array") > -1){
        return true;
    }else{
        return false;
    }
}


function judgeDate(a)
{
    if(a.constructor.toString().indexOf("Date") > -1){
        return true;
    }else{
        return false;
    }
}



```


### 表单提交

- return false; 可以阻止提交；参考 layui 

```

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<script>
function validateForm() {
    var x = document.forms["myForm"]["fname"].value;
    if (x == null || x == "") {
        alert("需要输入名字。");
        return false;
    }
}
</script>
</head>
<body>

<form name="myForm" action="demo_form.php"
onsubmit="return validateForm()" method="post">
名字: <input type="text" name="fname">
<input type="submit" value="提交">
</form>

</body>
</html>


```