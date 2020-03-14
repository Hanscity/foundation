## Nginx config for  Thinkphp3.2
* 可以兼容 thinkphp 的四种路由

```  

server {
    listen       80;
    server_name  ch-api.artzhe.com;
    root /var/www/artzhe/;

    access_log  /var/log/nginx/ch-api.artzhe.com_access.log ;
    error_log   /var/log/nginx/ch-api.artzhe.com_error.log ;

    index  index.html index.htm index.php;
    error_page  404              /404.html;
    location = /404.html {
        return 404 'Sorry, File not Found!';
    }
    error_page  500 502 503 504  /50x.html;
    location = /50x.html {
        root   /usr/share/nginx/html;
    }
    location / {
        try_files $uri @rewrite;
    }
    location @rewrite {
        set $static 0;
        if  ($uri ~ \.(css|js|jpg|jpeg|png|gif|ico|woff|eot|svg|css\.map|min\.map)$) {
            set $static 1;
        }
        if ($static = 0) {
            rewrite ^/(.*)$ /index.php?s=/$1;
        }
    }
    location ~ /Uploads/.*\.php$ {
        deny all;
    }
    location ~ \.php/ {
       if ($request_uri ~ ^(.+\.php)(/.+?)($|\?)) { }
       fastcgi_pass 127.0.0.1:9000;
       include fastcgi_params;
       fastcgi_param SCRIPT_NAME     $1;
       fastcgi_param PATH_INFO       $2;
       fastcgi_param SCRIPT_FILENAME $document_root$1;
    }
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    location ~ /\.ht {
        deny  all;
    }

```


## 详解
- index 指令

```
index指令的作用
在前后端分离的基础上，通过Nginx配置，指定网站初始页。

如果包括多个文件，Nginx会根据文件的枚举顺序来检查，直到查找的文件存在；
如果没有给出index，默认初始页为index.html
```
- error_page 指令

```

语法：error_page code [ code... ] [ = | =answer-code ] uri | @named_location 
默认值：no 

error_page  404              /404.html;
location = /404.html {
    return 404 'Sorry, File not Found!';
}

如果有 404 错误，则内部重定向到 /404.html

```

- location 指令是 http 模块当中最核心的一项配置，根据预先定义的 URL 匹配规则来接收用户发送的请求，根据匹配结果，将请求转发到后台服务器
    - location指令分为两种匹配模式：
    1. 正则匹配：以～开头表示正则匹配，~*表示正则不区分大小写
    2. 普通字符串匹配：以 = 开头(精准)或开头无引导字符 ～ 的规则
    - location URI匹配规则
        ```
        当nginx收到一个请求后，会截取请求的URI部份，去搜索所有location指令中定义的URI匹配模式。在server模块中可以定义多个location指令来匹配不同的url请求，多个不同location配置的URI匹配模式，总体的匹配原则是：先匹配普通字符串模式，再匹配正则模式。只识别URI部份，例如请求为：/test/abc/user.do?name=xxxx
            一个请求过来后，Nginx匹配这个请求的流程如下：
            1> 先查找是否有=开头的精确匹配，如：location = /test/abc/user.do { … }
            2> 再查找普通匹配，以 最大前缀 为原则，如有以下两个location，则会匹配后一项
            * location /test/ { … }
            * location /test/abc { … }
            3> 匹配到一个普通格式后，搜索并未结束，而是暂存当前匹配的结果，并继续搜索正则匹配模式
            4> 所有正则匹配模式location中找到第一个匹配项后，就以此项为最终匹配结果
            所以正则匹配项匹配规则，受定义的前后顺序影响，但普通匹配模式不会
            5> 如果未找到正则匹配项，则以3中缓存的结果为最终匹配结果
            6> 如果一个匹配都没搜索到，则返回404

        ```
    - 精确匹配与模糊匹配差别
        ```
        location =/ { … } 与 location / { … } 的差别：
        前一个是精确匹配，只响应/请求，所有/xxx或/xxx/xxxx类的请求都不会以前缀的形式匹配到它
        后一个是只要以 / 为前缀的请求都会被匹配到。如：/abc ， /test/abc， /test/abc/aaaa
        
        ```
- try_files 命令


- rewrite 命令

    ```
    rewrite 语法格式：
    rewrite   [regex]                  [replacement]      [flag];
                url正则表达式        替换真实url          标记（last,break）

    ```



- 增加备注

```
server {
    listen       80;
    server_name  ch-api.artzhe.com;
    root /var/www/artzhe/;

    access_log  /var/log/nginx/ch-api.artzhe.com_access.log ;
    error_log   /var/log/nginx/ch-api.artzhe.com_error.log ;

    index  index.html index.htm index.php;
    
    location / {
        try_files $uri @rewrite;
    }
    location @rewrite {
        set $static 0;
        if  ($uri ~ \.(css|js|jpg|jpeg|png|gif|ico|woff|eot|svg|css\.map|min\.map)$) {
            set $static 1;
        }
        if ($static = 0) {
            rewrite ^/(.*)$ /index.php?s=/$1;
        }
    }
    location ~ /Uploads/.*\.php$ {
        deny all;
    }
    location ~ \.php/ {
       if ($request_uri ~ ^(.+\.php)(/.+?)($|\?)) { }
       fastcgi_pass 127.0.0.1:9000;
       include fastcgi_params;
       fastcgi_param SCRIPT_NAME     $1;
       fastcgi_param PATH_INFO       $2;
       fastcgi_param SCRIPT_FILENAME $document_root$1;
    }
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    location ~ /\.ht {
        deny  all;
    }

```