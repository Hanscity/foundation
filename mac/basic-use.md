# Mac


## 快捷键


### F1 ～ FN
* F1 --close voice
* F2 --open voice
* F3 --add voice
* F4 --light down
* F5 --light up
* F6 --
* F7 --
* F8 --切换屏幕
* F9 --锁定触控板
* F10 --键盘亮度
* F11 --
* F12 --



### WINDOW = Command

* Command + R --网页刷新
* Command + blank -- Mac 全局搜索
* Command + Shift + 5 --Mac 截图 


* Fn + F12 --控制台
* 两指点击，相当于鼠标右键




## brew

### Install Homebrew

```
/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"

- remarks
* Homebrew 依赖于 Xcode Command Line Tools，所以会自动先安装 Xcode Command Line Tools

```

### What Does Homebrew Do?

* Homebrew installs the stuff you need that Apple (or your Linux system) didn’t.

```
$ brew install wget

- comment
stuff : sth

```

### Homebrew installs packages to their own directory and then symlinks their files into /usr/local.

```
$ cd /usr/local
$ find Cellar
Cellar/wget/1.16.1
Cellar/wget/1.16.1/bin/wget
Cellar/wget/1.16.1/share/man/man1/wget.1

$ ls -l bin
bin/wget -> ../Cellar/wget/1.16.1/bin/wget


- comment
* cellar : underground room
* Homebrew 安装各种包到各自的目录，然后建立软连接到目录 /usr/local. (备注，这些都是 brew 命令自动完成的，不需要再

```


## I cant find the user in /etc/passwd, why ?

```
/etc/passwd 中第一句话，说这个文件适用于单用户模式，其他情况下，这些信息决定于 Open Directory。（Note that this file is consulted directly only when the system is running in single-user mode. At other times this information is provided by Open Directory.）

很明显，你的普通登陆，不是单用户模式吧。

Open Directory 是啥，请看：https://en.wikipedia.org/wiki/Apple_Open_Directory



```

* 查看我是谁
 
```
id mi
whoami mi

```


## why? The path seems unreached

```
mi-macdeMacBook-Pro:local mi$ /usr/bin/git --version
git version 2.20.1 (Apple Git-117)
mi-macdeMacBook-Pro:local mi$ echo $PATH
/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin
mi-macdeMacBook-Pro:local mi$ git --version
-bash: /usr/local/bin/git: No such file or directory
mi-macdeMacBook-Pro:local mi$ 


```

## mac + apache + php 

#### 查看 Mac 系统的进程
1. 前往-》活动监视器
2. top                                    ## h 进入 help 页面，s 进入 调控刷新时间的页面 k 进入 kill 进程的页面，Mac 系统中仅有 s 命令是有效的，并不强大。 Ubuntu 中，都是可以用的哦
3. lsof -i:80                             ## 查看 80 端口的占用程序, 等同于 lsof -i TCP:80, Mac 之中，记得加 sudo
4. netstat -tunlp                         ## 这个命令在 Mac 系统中并不好用

#### mac apache 的使用
* sudo apachectl start
* sudo apachectl restart
* sudo apachectl stop
* sudo launchctl unload -w /System/Library/LaunchDaemons/org.apache.httpd.plist                   ## 设置Apache不自启动
* sudo launchctl load -w /System/Library/LaunchDaemons/org.apache.httpd.plist                     ## 设置Apache自启动
* launchd是Mac OS下，用于初始化系统环境的关键进程。类似Linux下的init, rc.此方法同样也适用于禁用系统的一些服务,比如打印机,蓝牙等.

#### mac + apache + php 配置虚拟主机
```
1. sudo vim /etc/apache2/httpd.conf 
# Virtual hosts
Include /private/etc/apache2/extra/httpd-vhosts.conf    ## 开启虚拟主机

246 <Directory "/Library/WebServer/Documents">          ## 为了达到最少的改动，这里不变
247     #
248     # Possible values for the Options directive are "None", "All",
249     # or any combination of:
250     #   Indexes Includes FollowSymLinks SymLinksifOwnerMatch ExecCGI MultiViews
251     #
252     # Note that "MultiViews" must be named *explicitly* --- "Options All"
253     # doesn't give it to you.
254     #
255     # The Options directive is both complicated and important.  Please see
256     # http://httpd.apache.org/docs/2.4/mod/core.html#options
257     # for more information.
258     #
259     Options FollowSymLinks Multiviews
260     MultiviewsMatch Any
261 
262     #
263     # AllowOverride controls what directives may be placed in .htaccess files.
264     # It can be "All", "None", or any combination of the keywords:
265     #   AllowOverride FileInfo AuthConfig Limit
266     #
267     AllowOverride None
268 
269     #
270     # Controls who can get stuff from this server.
271     #
272     Require all granted
273 </Directory>

2. sudo vim /etc/apache2/extra/httpd-vhosts.conf
<VirtualHost *:80>
    DocumentRoot "/Library/WebServer/Documents/Composer                            ## 这里 和 <Directory "/Library/WebServer/Documents"> 保持一致
    ServerName composer.artzhe.com
    ErrorLog "/private/var/log/apache2/composer.artzhe.com-error_log"
    CustomLog "/private/var/log/apache2/composer.artzhe.com-access_log" common
</VirtualHost>


3. vim /etc/hosts

4. sudo apachectl restart

```


#### 很遗憾，至今也查找不到 Apache 的进程 ？？？？
* https://www.zhihu.com/question/50232250
- 解答：因为 Apache 的进程名称为 httpd. 


## mac php
1. mac 的 PHP 进程在哪？		
- 如果是 Apache + PHP，php 是一个系统的 API，没有进程，而 PHP 的进程，只是 Apache 的一个模块，所以找不到 PHP 进程
- 如果是 PHP-fpm , ps aux | grep php ,可以看到进程


2. 修改 /etc/php.ini ，之后如何重启？

- 在 Mac 系统中， php-cgi, php-fpm, apache ,可以发现配置文件都是/etc/php.ini

- php-fpm                      ## 重启 php-fpm 

```
sh-3.2# php-fpm 
[23-Jun-2019 22:27:03] WARNING: Nothing matches the include pattern '/private/etc/php-fpm.d/*.conf' from /private/etc/php-fpm.conf at line 125.
[23-Jun-2019 22:27:03] ERROR: failed to open error_log (/usr/var/log/php-fpm.log): No such file or directory (2)
[23-Jun-2019 22:27:03] ERROR: failed to post process the configuration
[23-Jun-2019 22:27:03] ERROR: FPM initialization failed
sh-3.2# 

mkdir /usr/var
mkdir /usr/var/log
touch /usr/var/log/php-fpm.log



[23-Jun-2019 22:51:39] WARNING: Nothing matches the include pattern '/private/etc/php-fpm.d/*.conf' from /private/etc/php-fpm.conf at line 125.
[23-Jun-2019 22:51:39] ERROR: No pool defined. at least one pool section must be specified in config file
[23-Jun-2019 22:51:39] ERROR: failed to post process the configuration
[23-Jun-2019 22:51:39] ERROR: FPM initialization failed

进入PHP安装目录/etc/php-fpm.d
cp www.conf.default www.conf


php-fpm                       ## 成功


```


- apachectl restart           ## 重启 Apache




## 解密文件
```

md5[空格][拖曳要检测的文件到此处]

md5[空格]-s[空格][要转换的文字]

openssl dgst -sha1[空格][拖曳要检测的文件到此处]

openssl dgst -sha256[空格][拖曳要检测的文件到此处]

```

## 设置终端 terminal

- command + +                                ## 增大
- command + -                                ## 减小
- command + 0                                ## 字体恢复默认设置

- command + t                                ## 新开一个标签页
- command + w                                ## 关闭一个标签页
- command + shift + i                        ## 编辑标题，重命名
- command + shift + \                        ## 控制所有的端口
- command + num(1,2,3...)                    ## 选择一个标签页


- command + option + i                       ## 调试颜色
- command + ,                                ## 打开偏好设置              

```
  我将远程链接写到脚本里面去，然后执行脚本，再配合这两个命令，此黑苹果还是能满足需求
  command + t 
  command + w

```



## Mac + Nginx + PHP

- brew install nginx
```

==> openssl
A CA file has been bootstrapped using certificates from the SystemRoots
keychain. To add additional certificates (e.g. the certificates added in
the System keychain), place .pem files in
  /usr/local/etc/openssl/certs

and run
  /usr/local/opt/openssl/bin/c_rehash

openssl is keg-only, which means it was not symlinked into /usr/local,
because Apple has deprecated use of OpenSSL in favor of its own TLS and crypto libraries.

If you need to have openssl first in your PATH run:
  echo 'export PATH="/usr/local/opt/openssl/bin:$PATH"' >> ~/.bash_profile

For compilers to find openssl you may need to set:
  export LDFLAGS="-L/usr/local/opt/openssl/lib"
  export CPPFLAGS="-I/usr/local/opt/openssl/include"


==> nginx
Docroot is: /usr/local/var/www

The default port has been set in /usr/local/etc/nginx/nginx.conf to 8080 so that
nginx can run without sudo.

nginx will load all files in /usr/local/etc/nginx/servers/.

To have launchd start nginx now and restart at login:
  brew services start nginx
Or, if you don't want/need a background service you can just run:
  nginx



``` 


- 增加 redis.so


```
mi-macdeMacBook-Pro:redis-4.3.0 mi$ phpize -v
grep: /usr/include/php/main/php.h: No such file or directory
grep: /usr/include/php/Zend/zend_modules.h: No such file or directory
grep: /usr/include/php/Zend/zend_extensions.h: No such file or directory
Configuring for:
PHP Api Version:        
Zend Module Api No:     
Zend Extension Api No:  


- 解决

cd /Library/Developer/CommandLineTools/Packages/
open macOS_SDK_headers_for_macOS_10.14.pkg                                ## 安装header头文件SDK即可：


```

```

brew install autoconf

```

```
- 准备工作完善，开始安装

download php-redis

tar -xzvf

cd php-redis

phpize

./configure --with-php-config=/usr/bin/php-config

sudo make

sudo make test

sudo make install

extension=redis.so


```


```

sudo killall php-fpm

php-fpm 

```



./configure --with-php-config=/root/bin/php7219/bin/php-config


6k21klss380l5p4fnutenj1521