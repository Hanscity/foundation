## index

index 命令的官方地址  
> https://nginx.org/en/docs/http/ngx_http_index_module.html


太过经典，内容如下：


The ngx_http_index_module module processes requests ending with the slash character (‘/’). Such requests can also be processed by the ngx_http_autoindex_module and ngx_http_random_index_module modules.

Example Configuration

```
location / {
    index index.$geo.html index.html;
}

```


Directives

```
Syntax:	index file ...;
Default:	
index index.html;
Context:	http, server, location


```


Defines files that will be used as an index. The file name can contain variables. Files are checked in the specified order. The last element of the list can be a file with an absolute path. Example:


```
index index.$geo.html index.0.html /index.html;

```


It should be noted that using an index file causes an internal redirect, and the request can be processed in a different location. For example, with the following configuration:


```
location = / {
    index index.html;
}

location / {
    ...
}

```

a “/” request will actually be processed in the second location as “/index.html”.


### index 实战练习
index 的作用是选定一类默认的文件，  
但是我想证明一个情况，应用场景和作用到底如何？

我在 root /home/danche/www/mujia-laravel/public;  此目录下增加了一个 test 目录，test 目录下新增了一个 index.php 的文件，即 /home/danche/www/mujia-laravel/public/test/index.php

```

server {
    listen       80;
    server_name  mujia-laravel.test;
    root /home/danche/www/mujia-laravel/public;

    access_log  /var/log/nginx/mujia-laravel.test-access.log;
    error_log   /var/log/nginx/mujia-laravel.test-error.log;

    index  index.html index.htm index.php;

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

此时访问 mujia-laravel.test/test/ 成功


将配置文件修改如下，然后重启之

```

server {
    listen       80;
    server_name  mujia-laravel.test;
    root /home/danche/www/mujia-laravel/public;

    access_log  /var/log/nginx/mujia-laravel.test-access.log;
    error_log   /var/log/nginx/mujia-laravel.test-error.log;

    location = / {
       index  index.html index.htm index.php;
    }

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
此时访问 mujia-laravel.test/test/ ，403 Forbidden  
原因是：如果我访问的是 http://mujia-laravel.test, (这里有一个小细节，浏览器省略了最后的一个 “/”;换句话说，实际发送给 web 服务器的是 http://mujia-laravel.test/), 那么就会去执行 location = / 里面的 index 指令 ``` index  index.html index.htm index.php; ```  
如果访问的是 http://mujia-laravel.test/test/ ,那么就不会去执行 location = / 里面的 index 指令  
由此可以看出 index 指令的作用**是当访问到文件夹的时候，默认寻找的一类文件**

