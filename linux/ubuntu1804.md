


## ubuntu18.04 中，phpstorm 的 ctrl + alt + < 冲突
> https://askubuntu.com/questions/1041914/something-blocks-ctrlaltleft-right-arrow-keyboard-combination
* just do this
   ``` 
   gsettings set org.gnome.desktop.wm.keybindings switch-to-workspace-left "[]"
   gsettings set org.gnome.desktop.wm.keybindings switch-to-workspace-right "[]"
   ````



## Start Ubuntu
### lsb_release -a                        //安装好 Ubuntu，看一看此版本的代号等信息，这才是第一步吧
   ```
   	ch@ch-one:~$ lsb_release -a
	               No LSB modules are available.
	               Distributor ID: Ubuntu
	               Description:    Ubuntu 18.04.2 LTS
	               Release:        18.04
	               Codename:       bionic

   ```

### 一般会选择阿里云的源吧
* vim /etc/apt/sources.list

   ```
      deb https://mirrors.aliyun.com/ubuntu/ bionic main multiverse restricted universe
      deb https://mirrors.aliyun.com/ubuntu/ bionic-backports main multiverse restricted universe
      deb https://mirrors.aliyun.com/ubuntu/ bionic-proposed main multiverse restricted universe
      deb https://mirrors.aliyun.com/ubuntu/ bionic-security main multiverse restricted universe
      deb https://mirrors.aliyun.com/ubuntu/ bionic-updates main multiverse restricted universe

   ```

### 百度云的源

```




```
### 备注
   ```
   *  应该可以看出 bionic 是啥了吧
   *  你去访问一下 https://mirrors.aliyun.com/ubuntu/，你就会大概知道 main multiverse restricted universe 是指啥，主要版，复合版，严格版，大学版
   *  deb https://mirrors.aliyun.com/ubuntu/ bionic main multiverse restricted universe 
      等同于一下四句：
      deb https://mirrors.aliyun.com/ubuntu/ bionic main
      deb https://mirrors.aliyun.com/ubuntu/ bionic multiverse
      deb https://mirrors.aliyun.com/ubuntu/ bionic restricted
      deb https://mirrors.aliyun.com/ubuntu/ bionic universe

   ```


### apt-get update 到底在干啥
* man apt-get
   ```
   update
           update is used to resynchronize the package index files from their sources. 
           //update 可用来再次同步包的索引文件，通过它们的资源。同步包的索引文件，不是同步包,这一句很容易理解错误。CentOs 中， update 也是同步索引
           //然后根据此索引文件来比对现有的包，下载最新的包。
           //此索引文件在哪，如何比对，大概如下:   

   ```

* apt-get update 的索引文件在哪

   ```
    ch@ch-one:~$ apt-get update
    Reading package lists... Done
    E: Could not open lock file /var/lib/apt/lists/lock - open (13: Permission denied)
    E: Unable to lock directory /var/lib/apt/lists/
    W: Problem unlinking the file /var/cache/apt/pkgcache.bin - RemoveCaches (13: Permission denied)
    W: Problem unlinking the file /var/cache/apt/srcpkgcache.bin - RemoveCaches (13: Permission denied)


  ```



## Ubuntu18.04 编译安装 PHP

### STEP

```

Compiling PHP on Ubuntu boxes.

If you would like to compile PHP from source as opposed to relying on package maintainers, here's a list of packages, and commands you can run

SIEP 0:
Don't use root,Because of Composer's warning(Do not run Composer as root/super user! See https://getcomposer.org/root for details);

STEP 1:
sudo apt-get install autoconf build-essential curl libtool \
  libssl-dev libcurl4-openssl-dev libxml2-dev libreadline7 \
  libreadline-dev libzip-dev libzip4 nginx openssl \
  pkg-config zlib1g-dev

So you don't overwrite any existing PHP installs on your system, install PHP in your home directory. Create a directory for the PHP binaries to live

    mkdir -p ~/bin/php7219/                   

STEP 2:
# download the latest PHP tarball, decompress it, then cd to the new directory.
  If you want to use the Configure directlly ,download from the php official site.

STEP 3:
Configure PHP. Remove any options you don't need (like MySQL or Postgres (--with-pdo-pgsql))

./configure --prefix=$HOME/bin/php7219 --enable-fpm --with-fpm-user=www-data --with-fpm-group=www-data --with-mysqli --enable-mysqlnd --with-pdo-mysql --with-pdo-mysql=mysqlnd --without-sqlite3 --without-pdo-sqlite --enable-zip --with-libzip=/usr/lib/x86_64-linux-gnu --with-zlib --enable-sockets --enable-mbstring --enable-bcmath --with-openssl --with-curl --with-iconv --enable-soap --with-pear --enable-pcntl --with-gd --with-jpeg-dir=/usr/lib  --with-png-dir=/usr  --with-freetype-dir=/usr/lib --enable-opcache --enable-shmop --enable-sysvmsg --enable-sysvsem --enable-sysvshm --enable-phpdbg --with-readline

- without pear
./configure --prefix=$HOME/bin/php7219 --enable-fpm --with-fpm-user=www-data --with-fpm-group=www-data --with-mysqli --enable-mysqlnd --with-pdo-mysql --with-pdo-mysql=mysqlnd --without-sqlite3 --without-pdo-sqlite --enable-zip --with-libzip=/usr/lib/x86_64-linux-gnu --with-zlib --enable-sockets --enable-mbstring --enable-bcmath --with-openssl --with-curl --with-iconv --enable-soap --enable-pcntl --with-gd --with-jpeg-dir=/usr/lib  --with-png-dir=/usr  --with-freetype-dir=/usr/lib --enable-opcache --enable-shmop --enable-sysvmsg --enable-sysvsem --enable-sysvshm --enable-phpdbg --with-readline



STEP 4:
compile the binaries by typing: make

If no errors, install by typing: make install



STEP 5:
Copy the PHP.ini file to the install directory

    cp php.ini-development ~/bin/php7219/lib/ 

STEP 6:

cd ~/bin/php7219/etc
mv php-fpm.conf.default php-fpm.conf
mv php-fpm.d/www.conf.default php-fpm.d/www.conf


STEP 7:
create symbolic links for your for your binary files

   cd ~/bin
   ln -s php7219/bin/php php
   ln -s php7219/bin/php-cgi php-cgi
   ln -s php7219/bin/php-config php-config
   ln -s php7219/bin/phpize phpize
   ln -s php7219/bin/phar.phar phar
   ln -s php7219/bin/pear pear
   ln -s php7219/bin/phpdbg phpdbg
   ln -s php7219/sbin/php-fpm php-fpm

STEP 8: link your local PHP to the php command. You will need to logout then log back in for php to switch to the local version instead of the installed version

# add this to .bashrc
if [ -d "$HOME/bin" ] ; then
  PATH="$HOME/bin:$PATH"
fi


STEP 9: Operate PHP-FPM

    php-fpm                                   ## start php-fpm
    killall php-fpm                           ## stop php-fpm


```





### 编译参数

```
--enable-fpm                    ## start php-fpm 
--with-fpm-user=www-data        ## www-data
--with-fpm-group=www-data       ## www-data   

--with-mysqli
--enable-mysqlnd                        ## MYSQL NATIVE DIRVER 原生驱动”,还有一个驱动叫做 libmysqlclient 。MYSQL 和 MYSQLi 是基于此的上层拓展
--with-pdo-mysql 
--with-pdo-mysql=mysqlnd 
--without-sqlite3 
--without-pdo-sqlite

--enable-zip                    ## zip 相关
--with-libzip=DIR 
--with-zlib


--enable-sockets                ## socket
--enable-mbstring               ## 针对字符集
--enable-bcmath                 ## 高精度计算 
--with-openssl                  ## 加密传输
--with-curl                     ## curl
--with-iconv                    ## iconv
--enable-soap                   ## xml 协议相关
--with-pear                     ## PHP 程式
--enable-pcntl                  ## 多线程
--with-gd                       ## gd 库
--with-jpeg-dir=/usr/lib        ## gd 库相关的 JPEG 图片
--with-png-dir=/usr/lib         ## gd 库相关的 PNG 图片
--with-freetype-dir=/usr/lib    ## gd 库相关的 字体
--enable-opcache                ## opcache
--enable-shmop                  ## 共享内存函数集 
--enable-sysvmsg                ## 共享内存函数
--enable-sysvsem                ## 共享内存函数
--enable-sysvshm                ## 共享内存函数
--enable-phpdbg                 ## 断点调试
--with-readline                 ## 展示调试的历史

```



### 编译详解

- php 的扩展分为两种，默认支持的扩展(ext dir)，第三方扩展(.so)。默认扩展，随着 PHP 的源码一起编译安装，也称静态编译，也就是 --enable 和 --with 启用的扩展。
第三方扩展，使用 phpize 来动态编译，生成 .so 文件，从而进入 PHP 内核和 PHP 一起编译安装。
- --enable 一般是指启用某功能模块；--with 一般是指启用某功能，或者指定目录。





## 终端重命名

```
vim ~/.bashrc

## 末尾加上
function title() {
  if [[ -z "$ORIG" ]]; then
    ORIG=$PS1
  fi
  TITLE="\[\e]2;$*\a\]"
  PS1=${ORIG}${TITLE}
}

## 使用方法
title your-name


```

