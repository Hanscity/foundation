# S

```

--server addr:port
-S addr:port   Start built-in web server on the given local address and port


```


在某项目目录下执行

```
php -S 127.0.0.1:8000 public/index.php

```

在浏览器中输入 ```http://127.0.0.1:8000/```  
会有两个请求：  

1. http://127.0.0.1:8000/
2. http://127.0.0.1:8000/favicon.ico


令人难受的是，在 index 页面中打印的日志，会执行两遍  
这怎么能忍呢

经测试  
在浏览器中输入 ```http://127.0.0.1:8000/aaa``` ，success  
也同样是会执行 public/index.php 文件，而不管后面的内容或是参数
所以，php -S 的规则就是这样

而至于，为啥会访问 http://127.0.0.1:8000/favicon.ico，这是浏览器的规则

``` curl 127.0.0.1:8000 ```执行之
日志只有一遍  
请求只有一个  

验证完毕~

