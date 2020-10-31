## Simple regex


```

Regex quick reference
[abc]     A single character: a, b or c
[^abc]     Any single character but a, b, or c
[a-z]     Any single character in the range a-z
[a-zA-Z]     Any single character in the range a-z or A-Z
^     Start of line
$     End of line
\A     Start of string
\z     End of string
.     Any single character
\s     Any whitespace character
\S     Any non-whitespace character
\d     Any digit
\D     Any non-digit
\w     Any word character (letter, number, underscore)
\W     Any non-word character
\b     Any word boundary character
(...)     Capture everything enclosed
(a|b)     a or b
a?     Zero or one of a
a*     Zero or more of a
a+     One or more of a
a{3}     Exactly 3 of a
a{3,}     3 or more of a
a{3,6}     Between 3 and 6 of a

options: i case insensitive m make dot match newlines x ignore whitespace in regex o perform #{...} substitutions only once


```


## Get Host Name

- php

```
<?php
// 从URL中获取主机名称
// 用@作为定界符,正则表达式中的/符号,就不需要转义符转义了.如果你把两个@定界符都换成~作为定界符,效果是一样的
// ?:是正则表达式中通用的把，Perl，python，java，php等等都是表示不捕获，就是括号只是表示group，不capture。
//? 当该字符紧跟在任何一个其他限制符 (*, +, ?, {n}, {n,}, {n,m}) 后面时，匹配模式是非贪婪的。非贪婪模式尽可能少的匹配所搜索的字符串，而默认
//的贪婪模式则尽可能多的匹配所搜索的字符串。


preg_match('@^(?:http://)?([^/]+)@i',
    "http://www.php.net/index.html", $matches);
$host = $matches[1];

//获取主机名称的后面两部分
//^\d+$  \d 是代表0-9  $必须要以....结束  这是代表非负整数

preg_match('/[^.]+\.[^.]+$/', $host, $matches);
echo "domain name is: {$matches[0]}\n";                          ## domain name is: php.net

```


- javascript

```
var str = "http://www.php.net/index.html";
var patt1 = /(?:http:\/\/)([^/]+)/i;
var matches = str.match(patt1);
var sites = matches[1];

var patt2 = /[^.]+\.[^.]+$/;
var hosts = sites.match(patt2);

console.log(hosts[0]);



```

