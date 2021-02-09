# 讨论 Php 的报错机制

> https://cloud.tencent.com/developer/article/1400292



```

// this method is not exists
test();

```


```

General

Request URL: http://concise.test/
Request Method: GET
Status Code: 500 Internal Server Error
Remote Address: 127.0.0.1:80
Referrer Policy: strict-origin-when-cross-origin


Preview

Failed to response data

```

```


ini_set('display_errors',true);
error_reporting(E_ALL ^ E_NOTICE);


test();


```


```
General

Request URL: http://concise.test/
Request Method: GET
Status Code: 200 OK
Remote Address: 127.0.0.1:80
Referrer Policy: strict-origin-when-cross-origin

Preview

Fatal error: Uncaught Error: Call to undefined function test() in /home/danche/www/ConcisePhp/public/index.php:12 Stack trace: #0 {main} thrown in /home/danche/www/ConcisePhp/public/index.php on line 12



```


