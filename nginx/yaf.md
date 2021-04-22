```

server {
    listen       80;
    server_name  yaf.test;
    root /home/danche/www/Yaf/sample/public;

    access_log  /var/log/nginx/yaf.test-access.log;
    error_log   /var/log/nginx/yaf.test-error.log;

    index  index.html index.htm index.php;

    if (!-e $request_filename) {
        rewrite ^/(.*)  /index.php/$1 last;
    }

    location ~ \.php$ {
        fastcgi_pass   unix:/run/php/php7.4-fpm.sock;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}


```


### !-e $request_filename

-e 表示只要filename存在，则为真，不管filename是什么类型，当然这里加了!就取反

例如访问 yaf.test/index.php, $request_filename 就是 index.php

