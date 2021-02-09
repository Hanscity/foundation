# 原生的 Ajax 请求

## onload
- onload and onerror 是 Ajax 默认的方法，在请求服务端结束之后调用

```

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>菜鸟教程(runoob.com)</title>
</head>
<body>

<p><strong>以下内容是通过异步请求获取的：</strong></p>
<p id="demo"></p>
<script>
    var xhr = new XMLHttpRequest();

    xhr.onload = function () {
        // 输出接收到的文字数据
        document.getElementById("demo").innerHTML=xhr.responseText;
    }

    xhr.onerror = function () {
        document.getElementById("demo").innerHTML="请求出错";
    }

    // 发送异步 GET 请求
    xhr.open("POST", "http://fishing3.test/api/notice/getHaltLast", true);
    xhr.send();
</script>

</body>
</html>





```


## onreadystatechange

```

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script>
        function loadXMLDoc()
        {
            var xmlhttp;
            if (window.XMLHttpRequest)
            {
                //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
                xmlhttp=new XMLHttpRequest();
            }
            else
            {
                // IE6, IE5 浏览器执行代码
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                console.log(xmlhttp.readyState);
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("POST","http://fishing3.test/api/notice/getHaltLast",true);
            xmlhttp.send();
        }
    </script>
</head>
<body>

<div id="myDiv"><h2>使用 AJAX 修改该文本内容</h2></div>
<button type="button" onclick="loadXMLDoc()">修改内容</button>

</body>
</html>


```



## 一个页面多个 Ajax 请求

```


<!DOCTYPE html>
<html>
<head>
<script>
var xmlhttp;
function loadXMLDoc(url,cfunc)
{
if (window.XMLHttpRequest)
  {// IE7+, Firefox, Chrome, Opera, Safari 代码
  xmlhttp=new XMLHttpRequest();
  }
else
  {// IE6, IE5 代码
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=cfunc;
xmlhttp.open("GET",url,true);
xmlhttp.send();
}
function myFunction()
{
	loadXMLDoc("/try/ajax/ajax_info.txt",function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
		}
	});
}
</script>
</head>
<body>

<div id="myDiv"><h2>使用 AJAX 修改文本内容</h2></div>
<button type="button" onclick="myFunction()">修改内容</button>

</body>
</html>



```






## Ajax 之 Jquery


```

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>菜鸟教程(runoob.com)</title>
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js">
    </script>
    <script>
        $(document).ready(function(){
            $("button").click(function(){
                $.post("http://fishing3.test/api/notice/getHaltLast",function(data,status){
                    alert("数据: " + data + "\n状态: " + status);
                });
            });
        });
    </script>
</head>
<body>

<button>发送一个 HTTP GET 请求并获取返回结果</button>

</body>
</html>

```