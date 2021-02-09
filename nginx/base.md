## 什么是 Nginx

 1. http 服务器

 2. 反向代理

 3. 负载均衡

 4. 动静分离

 5. 高可用

## 反向代理

- 正向代理：举例说明，中国用户很难访问  google.cn,可以在客户端配置一个代理服务器 Server A，
Server A 可以访问 google.cn ,再将数据返回给 用户，这个代理服务器 Server A 就是正向代理服务器。

- 反向代理： 举例说明，用户访问服务器 Server A, Server A 马上请求服务器 Server B, Server B 返回数据给
Server A,Server A 将数据返回给用户，对于用户而言，只知道 Server A,并不知道 Server B;对于服务器而言，
真正处理用户请求的是 Server B，Server A 只是负责转发，Server A 就是 反向代理服务器。


Documents Of Official Site
> http://nginx.org/en/docs/

