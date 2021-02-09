## HTML


### HTML 简介

- <!DOCTYPE html> 声明为 HTML5 文档

```

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>菜鸟教程(runoob.com)</title>
</head>
<body>
 
<h1>我的第一个标题</h1>
 
<p>我的第一个段落。</p>
 
</body>
</html>


```

### HTML 空元素

```

没有内容的 HTML 元素被称为空元素。空元素是在开始标签中关闭的。

<br> 就是没有关闭标签的空元素（<br> 标签定义换行）。

在 XHTML、XML 以及未来版本的 HTML 中，所有元素都必须被关闭。

在开始标签中添加斜杠，比如 <br />，是关闭空元素的正确方法，HTML、XHTML 和 XML 都接受这种方式。

即使 <br> 在所有浏览器中都是有效的，但使用 <br /> 其实是更长远的保障。

```


### HTML 提示：使用小写标签

```

HTML 标签对大小写不敏感：<P> 等同于 <p>。许多网站都使用大写的 HTML 标签。

菜鸟教程使用的是小写标签，因为万维网联盟（W3C）在 HTML 4 中推荐使用小写，而在未来 (X)HTML 版本中强制使用小写。

```

### HTML 属性

- HTML 元素可以设置属性
- 属性可以在元素中添加附加信息
- 属性一般描述于开始标签
- 属性总是以名称/值对的形式出现，比如：name="value"。


### 属性实例

- HTML 链接由 <a> 标签定义。链接的地址在 href 属性中指定：

```
<a href="http://www.runoob.com">这是一个链接</a>

```

- 很多时候，不记得属性标签到底应该怎么写，是等于号呢，还是冒号
- 但是，我们往往记得 href 属性的写法
- 这不就够了吗
- href 就是典型的属性的写法啊

### HTML 属性的引号习惯
- 双引号是最常用的，不过使用单引号也没有问题
- 在某些个别的情况下，比如属性值本身就含有双引号，那么您必须使用单引号，例如：name='John "ShotGun" Nelson'



### HTML 格式化标签

```

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>菜鸟教程(runoob.com)</title>
</head>

<body>

<b>这个文本是加粗的</b>

<br />

<strong>这个文本是加粗的</strong>

<br />

<big>这个文本字体放大</big>

<br />

<em>这个文本是斜体的</em>

<br />

<i>这个文本是斜体的</i>

<br />

<small>这个文本是缩小的</small>

<br />

这个文本包含
<sub>下标</sub>

<br />

这个文本包含
<sup>上标</sup>

</body>
</html>

```


### HTML 超链接（链接） 的颜色

- 我在工作中有发现，当你点击一段超链接，点击完成了，未完成，将要点击，等状态都显示了不同的颜色
- 我很好奇，到底是谁在控制？
- 是 框架吗？
- 看完这一段，我才知道，原来 html 本身就有这个特性。
- 当然，你也是可以通过 css 的手段来控制的


- 一个未访问过的链接显示为蓝色字体并带有下划线。
- 访问过的链接显示为紫色并带有下划线。
- 点击链接时，链接显示为红色并带有下划线。



### HTML 链接- id 属性
- 这也是日常所讲的矛点哈

```

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>菜鸟教程(runoob.com)</title>
</head>
<body>

<p>
<a href="#C4">查看章节 4</a>
</p>

<h2>章节 1</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 2</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 3</h2>
<p>这边显示该章节的内容……</p>

<h2><a id="C4">章节 4</a></h2>
<p>这边显示该章节的内容……</p>

<h2>章节 5</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 6</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 7</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 8</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 9</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 10</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 11</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 12</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 13</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 14</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 15</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 16</h2>
<p>这边显示该章节的内容……</p>

<h2>章节 17</h2>
<p>这边显示该章节的内容……</p>

</body>
</html>


```



### Html 头部信息之 base


```
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> 
<title>菜鸟教程(runoob.com)</title>
<base href="https://www.runoob.com//images/" target="_blank">
</head>
<body>

<p><img src="logo.png" > - 注意这里我们设置了图片的相对地址。能正常显示是因为我们在 head 部分设置了 base 标签，该标签指定了页面上所有链接的默认 URL，所以该图片的访问地址为 "http://www.runoob.com/images/logo.png"</p>

<p><a href="//www.runoob.com/">runoob.com</a> - 注意这个链接会在新窗口打开，即便它没有 target="_blank" 属性。因为在 base 标签里我们已经设置了 target 属性的值为 "_blank"。</p>

</body>
</html>

```


### Html 头部信息之 style

- 如果是内部样式表， style

```

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> 
<title>菜鸟教程(runoob.com)</title>
<style type="text/css">
h1 {color:red;}
p {color:blue;}
</style>
</head>

<body>
<h1>这是一个标题</h1>
<p>这是一个段落。</p>
</body>

</html>

```

- 如果是用到外部样式表， link

```

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> 
<title>菜鸟教程(runoob.com)</title>
<link rel="stylesheet" type="text/css" href="styles.css"> 
</head>

<body>
<h1>我是通过样式文件 styles.css 渲染后显示的。</h1>
<p>我也是。</p>
</body>

</html>

```


- link 当中的 media 属性表示引入的样式表将用在什么设备上
- all 表示所有的设备

```

<link rel="stylesheet" href="../src/css/layui.css" media="all">
  

```



### Html 头部信息之 script

> https://www.runoob.com/tags/tag-script.html
- 通过文档可以看出来，很多的属性，仅支持外部的引入哈



### Pretty Table

```

<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8"> 
<title>菜鸟教程(runoob.com)</title> 

<style type="text/css">

@charset "utf-8";
/* CSS Document */
.tabtop13 {
	margin-top: 13px;
}
.tabtop13 td{
	background-color:#ffffff;
	height:25px;
	line-height:150%;
}
.font-center{ text-align:center}
.btbg{background:#e9faff !important;}
.btbg1{background:#f2fbfe !important;}
.btbg2{background:#f3f3f3 !important;}
.biaoti{
	font-family: 微软雅黑;
	font-size: 26px;
	font-weight: bold;
	border-bottom:1px dashed #CCCCCC;
	color: #255e95;
}
.titfont {
	
	font-family: 微软雅黑;
	font-size: 16px;
	font-weight: bold;
	color: #255e95;
	background: url(../images/ico3.gif) no-repeat 15px center;
	background-color:#e9faff;
}
.tabtxt2 {
	font-family: 微软雅黑;
	font-size: 14px;
	font-weight: bold;
	text-align: right;
	padding-right: 10px;
	color:#327cd1;
}
.tabtxt3 {
	font-family: 微软雅黑;
	font-size: 14px;
	padding-left: 15px;
	color: #000;
	margin-top: 10px;
	margin-bottom: 10px;
	line-height: 20px;
}

</style>
</head>
<body>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td align="center" class="biaoti" height="60">受理员业务统计表</td>
        </tr>
        <tr>
          <td align="right" height="25">2017-01-02---2017-05-02</td>
        </tr>
      </table>
      
      <table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#cccccc" class="tabtop13" align="center">
        <tr>
          <td colspan="2" class="btbg font-center titfont" rowspan="2">受理员</td>
          <td width="10%" class="btbg font-center titfont" rowspan="2">受理数</td>
          <td width="10%" class="btbg font-center titfont" rowspan="2">自办数</td>
          <td width="10%" class="btbg font-center titfont" rowspan="2">直接解答</td>
          <td colspan="2" class="btbg font-center titfont">拟办意见</td>
          <td colspan="2" class="btbg font-center titfont">返回修改</td>
          <td colspan="3" class="btbg font-center titfont">工单类型</td>
        </tr>
        <tr>
          <td width="8%" class="btbg font-center">同意</td>
          <td width="8%" class="btbg font-center">比例</td>
          <td width="8%" class="btbg font-center">数量</td>
          <td width="8%" class="btbg font-center">比例</td>
          <td width="8%" class="btbg font-center">建议件</td>
          <td width="8%" class="btbg font-center">诉求件</td>
          <td width="8%" class="btbg font-center">咨询件</td>
        </tr>
        <tr>
          <td width="7%" rowspan="8" class="btbg1 font-center">受理处</td>
          <td width="7%"  class="btbg2">王艳</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2 font-center">总计</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
        </tr>
        <tr>
          <td width="7%" rowspan="8" class="btbg1 font-center">话务组</td>
          <td width="7%"  class="btbg2">王艳</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">王艳</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">王艳</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">王艳</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="btbg2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
         <tr>
          <td class="btbg2 font-center">总计</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
          <td class="btbg2 font-center">20</td>
        </tr>
      </table>

</body>
</html>

```


## inline,block,inline-blick
> https://www.runoob.com/html/html-blocks.html
