# CURL 的常规用法


## POST

方法一

```

curl -X POST -H 'Content-Type : application/form-data' -d 'name=ch&gid=10021&count=10'  http://yaf.test/index/index/test_request


```


方法二

```

curl -X POST -H 'Content-Type : application/x-www-form-urlencoded' -d 'name=ch&gid=10021&count=10'  http://yaf.test/index/index/test_request


```


POST 方法有以上两种，都可以



## GET


方法一

```

curl http://yaf.test/index/index/test_request?name=ch


```


方法二

```

curl http://yaf.test/index/index/test_request/name/ch


```

GET 方法有以上两种，选取方法一

因为方法二 getQuery 获取不到，需要通过 getParam 来获取

