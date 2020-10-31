# Javascript


## oper

### str operation

- str.match(pattern)


- str.search(pattern)

- str.replace()

### pattern operation

- pattern.test()

- pattern.exec()


### code

```

var str = 'hello,world';
var pattern = /e/i;
console.log(str.match(pattern));

console.log(str.search(pattern));

console.log(str.replace(pattern,'E'));


console.log(pattern.test(str));

console.log(pattern.exec(str));


```


### 实际案例

```

// 判断是否为数字、字母、下划线组成 
function isWord(str)
{
	var pattern = /^[\w]+&/;
	var bool = pattern.test(str);
	return bool;

}


// 判断字符串是否全部为字母
function isLetter(str)
{
	var pattern = /^[a-zA-Z]+$/;
	var bool = pattern.test(str);
	return bool;

}


// 判断输入字符串是否全部为数字
function isNumber(str)
{
	var pattern = /^\d+$/;
	var bool = pattern.test(str);
	return bool;

}


// 判断是否是 decimal
function isDecimal(str)
{

	var pattern = /^\d+\.\d+/;
	var bool = pattern.test(str);
	return bool;

}

// 判断是否是 浮点数
function isFloat(str)
{

	var pattern = /^\d+(\.\d+)?/;
	var bool = pattern.test(str);
	return bool;

}


// 校验是否中文名称组成
function ischina(str) 
{
    var reg=/^[\u4E00-\u9FA5]+$/;   /*定义验证表达式*/
    return reg.test(str);     /*进行验证*/
}


// 校验邮件地址是否合法
function isEmail(str) 
{
    var reg=/^\w+@[a-zA-Z0-9]{2,10}\.[a-z]+$/;
    return reg.test(str);
}







```

//正则表达式中“?”的用法大概有以下几种

1、直接跟随在子表达式后面
这种方式是最常用的用法，具体表示匹配前面的一次或者0次，类似于{0,1}，如：abc(d)?可匹配abc和abcd

2、非贪婪匹配
关于贪婪和非贪婪，贪婪匹配的意思是，在同一个匹配项中，尽量匹配更多所搜索的字符，非贪婪则相反。正则匹配的默认模式是贪婪模式，当?号跟在如下限制符后面时，使用非贪婪模式（*,+,?，{n}，{n,}，{n,m}）

如正则表达式 \S+c 匹配字符串aaaacaaaaaaac的结果是aaaacaaaaaaac，而\S+?c则会优先匹配aaaac

3、非获取匹配
当我们使用正则表达式的时候，捕获的字符串会被缓存起来以供后续使用，具体表现为每个（）中的表达式所匹配到的内容在进行正则匹配的过程中，都会被缓存下来，如以下代码

