## Nginx 展示 Post 请求
1. 版本需要大于 1.15
2. 编译安装
   ```

	./configure --prefix=/usr --sbin-path=/usr/sbin/nginx --conf-path=/etc/nginx/nginx.conf --error-log-path=/var/log/nginx/error.log  --http-log-path=/var/log/nginx/access.log  --pid-path=/var/run/nginx/nginx.pid  --lock-path=/var/lock/nginx.lock --user=nginx --group=nginx --with-http_ssl_module --with-http_stub_status_module --with-http_gzip_static_module --http-client-body-temp-path=/var/tmp/nginx/client/ --http-proxy-temp-path=/var/tmp/nginx/proxy/ --http-fastcgi-temp-path=/var/tmp/nginx/fcgi/ --http-uwsgi-temp-path=/var/tmp/nginx/uwsgi --with-pcre=../pcre-7.8 --with-zlib=../zlib-1.2.3

	//在 当前的 docker 中，采取的是这种编译方式
	./configure --prefix=/usr/local/nginx-1.6 --with-pcre --with-http_stub_status_module --with-http_ssl_module --with-http_gzip_static_module --with-http_realip_module --add-module=../nginx_upstream_check_module-0.3.0



   ```
3. 配置
   ```
   log_format main postdata escape=json '$remote_addr\t$remote_user\t[$time_local]\t"$request"\t$status\t$bytes_sent\t' '"$http_referer"\t"$http_user_agent"\t"$http_cookie"\t"$request_body"';


   ```