## Nginx 

```

server {
    listen       80;
    server_name  practice-symfony.test;
    root /Users/xieyan/www/practice-symfony/public;

    access_log  /var/log/nginx/practice-symfony.test-access.log ;
    error_log   /var/log/nginx/pracice-symfony.test-error.log ;

    index  index.html index.htm index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}


```


