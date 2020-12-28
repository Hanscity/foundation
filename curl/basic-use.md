# curl

> https://curl.se/
> http://www.ruanyifeng.com/blog/2011/09/curl.html
> https://www.ruanyifeng.com/blog/2019/09/curl-reference.html


## GET
- The default method is get

```


```

## POST 


```
curl -d 'account_idx=837&gid=10021&count=10'  http://fishing2.test//api/luckshop/exchange

```

- d, specify the send data, when you use this param, the request default POST



```
curl -X POST  -d 'account_idx=837&gid=10021&count=10'  http://fishing2.test//api/luckshop/exchange

```

- X, specify the method

- d, specify the send data

- H, specify the head,the default value is 'Content-Type : application/x-www-form-urlencoded'








```

curl -X POST -H "Content-Type: application/json" -d '{"account_idx":837,"gid":10021,"count":10}'  http://fishing2.test//api/luckshop/exchange

```

- X, specify the method

- d, specify the send data

- H, specify the head







```

curl 127.0.01:9501/ -w %{http_code}

curl 127.0.01:9501/ -w %{http_code} -X POST

install extention: php annotations


directory: Annotation

    Foo.php

    

```