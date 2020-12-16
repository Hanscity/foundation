## location

> http://nginx.org/en/docs/http/ngx_http_core_module.html#location

```
Syntax:	location [ = | ~ | ~* | ^~ ] uri { ... }
location @name { ... }
Default:	—
Context:	server, location

```

Sets configuration depending on a request URI.

The matching is performed against a normalized URI, after decoding the text encoded in the “%XX” form, resolving references to relative path components “.” and “..”, and possible compression of two or more adjacent slashes into a single slash.


A location can either be defined by a prefix string, or by a regular expression. Regular expressions are specified with the preceding “~*” modifier (for case-insensitive matching), or the “~” modifier (for case-sensitive matching). To find location matching a given request, nginx first checks locations defined using the prefix strings (prefix locations). Among them, the location with the longest matching prefix is selected and remembered. Then regular expressions are checked, in the order of their appearance in the configuration file. The search of regular expressions terminates on the first match, and the corresponding configuration is used. If no match with a regular expression is found then the configuration of the prefix location remembered earlier is used.


location blocks can be nested, with some exceptions mentioned below.

For case-insensitive operating systems such as macOS and Cygwin, matching with prefix strings ignores a case (0.7.7). However, comparison is limited to one-byte locales.

Regular expressions can contain captures (0.7.40) that can later be used in other directives.

If the longest matching prefix location has the “^~” modifier then regular expressions are not checked. 

Also, using the “=” modifier it is possible to define an exact match of URI and location. If an exact match is found, the search terminates. For example, if a “/” request happens frequently, defining “location = /” will speed up the processing of these requests, as search terminates right after the first comparison. Such a location cannot obviously contain nested locations.


Let’s illustrate the above by an example:


```
location = / {
    [ configuration A ]
}

location / {
    [ configuration B ]
}

location /documents/ {
    [ configuration C ]
}

location ^~ /images/ {
    [ configuration D ]
}

location ~* \.(gif|jpg|jpeg)$ {
    [ configuration E ]
}

```

The “/” request will match configuration A, the “/index.html” request will match configuration B, the “/documents/document.html” request will match configuration C, the “/images/1.gif” request will match configuration D, and the “/documents/1.jpg” request will match configuration E.




## laravel 的配置分析

```
server {
    listen       80;
    server_name  mujia-laravel.test;
    root /home/danche/www/mujia-laravel/public;

    access_log  /var/log/nginx/mujia-laravel.test-access.log;
    error_log   /var/log/nginx/mujia-laravel.test-error.log;

    index  index.html index.htm index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        # fastcgi_pass   127.0.0.1:9001;
        fastcgi_pass   unix:/run/php/php7.4-fpm.sock;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}


```

### 知识点分析之 location / 

有很多中文的网站上说，这个指令表示，所有的请求，都会匹配到

```
server {
    listen       80;
    server_name  mujia-laravel.test;
    root /home/danche/www/mujia-laravel/public;

    access_log  /var/log/nginx/mujia-laravel.test-access.log;
    error_log   /var/log/nginx/mujia-laravel.test-error.log;

    location / {
        index  index.html index.htm index.php;
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        # fastcgi_pass   127.0.0.1:9001;
        fastcgi_pass   unix:/run/php/php7.4-fpm.sock;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}


```
经测试，将 index 指令放入 location / ,确实如此

### 知识点分析之 try_files
```try_files $uri $uri/ /index.php?$query_string;```

如果找到 /home/danche/www/mujia-laravel/public$uri 文件，结束；
如果找不到，/home/danche/www/mujia-laravel/public$uri/,在此目录寻找 index 设置好的一系列文件，如果找到，结束；
如果找不到，内部定向到 /home/danche/www/mujia-laravel/public/index.php?$query_string，结束；



### 知识点分析之 $query_string

```try_files $uri $uri/ /index.php?$query_string;``` 的情况下：

当用户访问 http://mujia-laravel.test/admin/datamonitor/playerlist?page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date=

此时 $query_string 为 "page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date="

"QUERY_STRING":"page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date=",



```try_files $uri $uri/ /index.php;``` 的情况下：

当用户访问 http://mujia-laravel.test/admin/datamonitor/playerlist?page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date=

此时 $query_string 为 ""  

"QUERY_STRING":"",

此时搜索查询就会失效

QUERY_STRING 常量是 fastcgi_parm 指令设置的常量， 将会被 php 程序接受，保存在 $_SERVER 中，具体下面的 fastcgi_parm 指令会有详细说明

~~至于，$query_string 变量为何会在 try_files 指令中被设置，这一点，暂无深究~~


### 知识点分析之 location ~ \.php$
当以 .php 结尾的 $uri,将会被 ```location ~ \.php$``` 捕获，  
~~为何 http://mujia-laravel.test/index.php?page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date= 也会被捕获？~~


### 知识点分析之 fastcgi_index 指令
当请求转给 fastcgi 之后，fastcgi_index 指令设置默认的文件为 index.php, 从而 $fastcgi_script_name 是 /index.php。
（至于 fastcgi_index 和 $fastcgi_script_name 的关系暂无深究）    
这里需要对比一下 index 指令，可以看出，index 指令针对的是请求进来的 $uri 进行设置, fastcgi_index 针对的是 fastcgi, fastcgi 针对的是 Php 程序  

从这里也是可以看出，程序真正执行的地方在 fastcgi 的部分，之前的 location 只是 URL 的美化  


### 知识点分析之 fastcgi_parm 指令
fastcgi_parm 设置的常量，将会被 php 程序接受，保存在 $_SERVER 中  
```fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;``` 就设置了常量 SCRIPT_FILENAME  

我们可以看一看 fastcgi_params 文件

```cat /etc/nginx/fastcgi_params```

```
fastcgi_param  QUERY_STRING       $query_string;
fastcgi_param  REQUEST_METHOD     $request_method;
fastcgi_param  CONTENT_TYPE       $content_type;
fastcgi_param  CONTENT_LENGTH     $content_length;

fastcgi_param  SCRIPT_NAME        $fastcgi_script_name;
fastcgi_param  REQUEST_URI        $request_uri;
fastcgi_param  DOCUMENT_URI       $document_uri;
fastcgi_param  DOCUMENT_ROOT      $document_root;
fastcgi_param  SERVER_PROTOCOL    $server_protocol;
fastcgi_param  REQUEST_SCHEME     $scheme;
fastcgi_param  HTTPS              $https if_not_empty;

fastcgi_param  GATEWAY_INTERFACE  CGI/1.1;
fastcgi_param  SERVER_SOFTWARE    nginx/$nginx_version;

fastcgi_param  REMOTE_ADDR        $remote_addr;
fastcgi_param  REMOTE_PORT        $remote_port;
fastcgi_param  SERVER_ADDR        $server_addr;
fastcgi_param  SERVER_PORT        $server_port;
fastcgi_param  SERVER_NAME        $server_name;

# PHP only, required if PHP was built with --enable-force-cgi-redirect
fastcgi_param  REDIRECT_STATUS    200;


```
很多 NGINX 的 sites 配置，甚至将 ```fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;`` 
放到 /etc/nginx/fastcgi_params 此文件中进行统一配置  

对应 /etc/nginx/fastcgi_params 文件的参数值具体如下（从 $_SERVER 中提取出来的）：

```

{
    "QUERY_STRING":"page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date=",
    "REQUEST_METHOD":"GET",
    "CONTENT_TYPE":"",
    "CONTENT_LENGTH":"",

    "SCRIPT_NAME":"/index.php",
    "REQUEST_URI":"/admin/datamonitor/playerlist?page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date=",
    "DOCUMENT_URI":"/index.php",
    "DOCUMENT_ROOT":"/home/danche/www/mujia-laravel/public",
    "SERVER_PROTOCOL":"HTTP/1.1",
    "REQUEST_SCHEME":"http",
    "ENVIRONMENT_LOCAL_HTTPS":"1",

    "GATEWAY_INTERFACE":"CGI/1.1",
    "SERVER_SOFTWARE":"nginx/1.14.0",

    "REMOTE_ADDR":"127.0.0.1",
    "REMOTE_PORT":"33424",
    "SERVER_ADDR":"127.0.0.1",
    "SERVER_PORT":"80",
    "SERVER_NAME":"mujia-laravel.test",


    "SCRIPT_FILENAME":"/home/danche/www/mujia-laravel/public/index.php",
}
```




### 当用户访问 http://mujia-laravel.test

此时 $uri 等于 / ,try_files 寻找 /home/danche/www/mujia-laravel/public$uri 此文件，没有；  
寻找 /home/danche/www/mujia-laravel/public$uri 文件夹，是文件夹；根据 index 命令，找到了 index.php 文件  
http://mujia-laravel.test/index.php 内部重定向给 location ~ \.php$ {}

### 当用户访问 http://mujia-laravel.test/index.php
此时 $uri 等于 /index.php, try_files 寻找 /home/danche/www/mujia-laravel/public$uri 此文件,找到；  
http://mujia-laravel.test/index.php 内部重定向给 location ~ \.php$ {}


### 当用户访问 http://mujia-laravel.test/admin/datamonitor/playerlist?page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date= 

此时 $uri 等于 /admin/datamonitor/playerlist?page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date=
try_files 寻找 /home/danche/www/mujia-laravel/public$uri 此文件，没有；  
寻找 /home/danche/www/mujia-laravel/public$uri 文件夹，没有；  
转接给第三个参数 /index.php?$query_string; 此时，$query_string 等于 "page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date="  
http://mujia-laravel.test/index.php？page=1&limit=10&platform_ids=&game_id=&nickname=&date=&last_logout_time=&last_logon_date= 内部重定向给 location ~ \.php$ {}  