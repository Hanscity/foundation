# Install Php

## 方式之 ppa,apt

apt search php7.4

```
Sorting... Done
Full Text Search... Done
libapache2-mod-php7.4/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [residual-config]
  server-side, HTML-embedded scripting language (Apache 2 module)

libphp7.4-embed/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  HTML-embedded scripting language (Embedded SAPI library)

php7.4/bionic,bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 all
  server-side, HTML-embedded scripting language (metapackage)

php7.4-amqp/bionic,now 1.10.2-3+ubuntu18.04.1+deb.sury.org+4 amd64 [installed]
  AMQP extension for PHP

php7.4-apcu/bionic 5.1.19+4.0.11-2+ubuntu18.04.1+deb.sury.org+4 amd64
  APC User Cache for PHP

php7.4-apcu-bc/bionic 1.0.5-4+ubuntu18.04.1+deb.sury.org+1 amd64
  APCu Backwards Compatibility Module

php7.4-ast/bionic 1.0.10-3+ubuntu18.04.1+deb.sury.org+1 amd64
  AST extension for PHP 7

php7.4-bcmath/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  Bcmath module for PHP

php7.4-bz2/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  bzip2 module for PHP

php7.4-cgi/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  server-side, HTML-embedded scripting language (CGI binary)

php7.4-cli/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed,automatic]
  command-line interpreter for the PHP scripting language

php7.4-common/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed,automatic]
  documentation, examples and common module for PHP

php7.4-curl/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed]
  CURL module for PHP

php7.4-dba/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  DBA module for PHP

php7.4-dev/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed]
  Files for PHP7.4 module development

php7.4-ds/bionic 1.3.0-1+ubuntu18.04.1+deb.sury.org+1 amd64
  PHP extension providing efficient data structures for PHP 7

php7.4-enchant/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  Enchant module for PHP

php7.4-fpm/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed]
  server-side, HTML-embedded scripting language (FPM-CGI binary)

php7.4-gd/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed]
  GD module for PHP

php7.4-gearman/bionic 2.0.6+1.1.2-9+ubuntu18.04.1+deb.sury.org+1 amd64
  PHP wrapper to libgearman

php7.4-geoip/bionic 1.1.1-6+ubuntu18.04.1+deb.sury.org+1 amd64
  GeoIP module for PHP

php7.4-gmagick/bionic 2.0.5~rc1+1.1.7~rc3-7+ubuntu18.04.1+deb.sury.org+1 amd64
  Provides a wrapper to the GraphicsMagick library

php7.4-gmp/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  GMP module for PHP

php7.4-gnupg/bionic 1.4.0-7+ubuntu18.04.1+deb.sury.org+1 amd64
  PHP wrapper around the gpgme library

php7.4-http/bionic 3.2.3+2.6.0+nophp8-1+ubuntu18.04.1+deb.sury.org+4 amd64
  PECL HTTP module for PHP Extended HTTP Support

php7.4-igbinary/bionic,now 3.1.6+2.0.8-2+ubuntu18.04.1+deb.sury.org+4 amd64 [installed,automatic]
  igbinary PHP serializer

php7.4-imagick/bionic 3.4.4-10+ubuntu18.04.1+deb.sury.org+4 amd64
  Provides a wrapper to the ImageMagick library

php7.4-imap/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  IMAP module for PHP

php7.4-interbase/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  Interbase module for PHP

php7.4-intl/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  Internationalisation module for PHP

php7.4-json/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed,automatic]
  JSON module for PHP

php7.4-ldap/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  LDAP module for PHP

php7.4-lua/bionic 2.0.7+1.1.0-2+ubuntu18.04.1+deb.sury.org+1 amd64
  PHP Embedded lua interpreter

php7.4-mailparse/bionic 3.1.1+2.1.7~dev20160128-2+ubuntu18.04.1+deb.sury.org+4 amd64
  Email message manipulation for PHP

php7.4-mbstring/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed]
  MBSTRING module for PHP

php7.4-memcache/bionic 8.0+4.0.5.2+3.0.9~20170802.e702b5f9-1+ubuntu18.04.1+deb.sury.org+1 amd64
  memcache extension module for PHP

php7.4-memcached/bionic 3.1.5+2.2.0-4+ubuntu18.04.1+deb.sury.org+4 amd64
  memcached extension module for PHP, uses libmemcached

php7.4-mongodb/bionic 1.9.0+1.7.5-1+ubuntu18.04.1+deb.sury.org+1 amd64 [upgradable from: 1.9.0-1+ubuntu18.04.1+deb.sury.org+1]
  MongoDB driver for PHP

php7.4-msgpack/bionic 2.1.2+0.5.7-1+ubuntu18.04.1+deb.sury.org+1 amd64
  PHP extension for interfacing with MessagePack

php7.4-mysql/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed]
  MySQL module for PHP

php7.4-oauth/bionic,now 2.0.7+1.2.3-2+ubuntu18.04.1+deb.sury.org+4 amd64 [installed]
  OAuth 1.0 consumer and provider extension

php7.4-odbc/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  ODBC module for PHP

php7.4-opcache/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed,automatic]
  Zend OpCache module for PHP

php7.4-pcov/bionic 1.0.6-3+ubuntu18.04.1+deb.sury.org+1 amd64
  Code coverage driver

php7.4-pgsql/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  PostgreSQL module for PHP

php7.4-phpdbg/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  server-side, HTML-embedded scripting language (PHPDBG binary)

php7.4-pinba/bionic 1.1.2-1+ubuntu18.04.1+deb.sury.org+1 amd64
  Pinba module for PHP

php7.4-propro/bionic 2.1.0+1.0.2+nophp8-2+ubuntu18.04.1+deb.sury.org+4 amd64
  propro module for PHP

php7.4-ps/bionic 1.4.1+pecl+nophp8+1.3.7-1+ubuntu18.04.1+deb.sury.org+1 amd64
  ps module for PHP

php7.4-pspell/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  pspell module for PHP

php7.4-psr/bionic,now 1.0.1-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed]
  PSR interfaces for PHP

php7.4-radius/bionic 1.4.0~b1-11+ubuntu18.04.1+deb.sury.org+1 amd64
  radius client library for PHP

php7.4-raphf/bionic 2.0.1+1.1.2-3+ubuntu18.04.1+deb.sury.org+4 amd64
  raphf module for PHP

php7.4-readline/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed,automatic]
  readline module for PHP

php7.4-redis/bionic,now 5.3.2+4.3.0-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed]
  PHP extension for interfacing with Redis

php7.4-rrd/bionic 2.0.1+1.1.3-9+ubuntu18.04.1+deb.sury.org+4 amd64
  PHP bindings to rrd tool system

php7.4-smbclient/bionic 1.0.0-3+ubuntu18.04.1+deb.sury.org+1 amd64
  PHP wrapper for libsmbclient

php7.4-snmp/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  SNMP module for PHP

php7.4-soap/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  SOAP module for PHP

php7.4-solr/bionic 2.5.1+2.4.0-4+ubuntu18.04.1+deb.sury.org+5 amd64
  PHP extension for communicating with Apache Solr server

php7.4-sqlite3/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  SQLite3 module for PHP

php7.4-ssh2/bionic 1.2+0.13-3+ubuntu18.04.1+deb.sury.org+1 amd64
  Bindings for the libssh2 library

php7.4-stomp/bionic 2.0.2+1.0.9-4+ubuntu18.04.1+deb.sury.org+1 amd64
  Streaming Text Oriented Messaging Protocol (STOMP) client module for PHP

php7.4-sybase/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  Sybase module for PHP

php7.4-tideways/bionic 5.0.2-2+ubuntu18.04.1+deb.sury.org+1 amd64
  Tideways PHP Profiler Extension

php7.4-tidy/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  tidy module for PHP

php7.4-uopz/bionic 6.1.2-3+ubuntu18.04.1+deb.sury.org+1 amd64
  UOPZ extension for PHP 7

php7.4-uploadprogress/bionic 1.1.3-3+ubuntu18.04.1+deb.sury.org+1 amd64
  file upload progress tracking extension for PHP

php7.4-uuid/bionic 1.2.0-1+ubuntu18.04.1+deb.sury.org+1 amd64
  PHP UUID extension

php7.4-xdebug/bionic,now 3.0.1+2.9.8+2.8.1+2.5.5-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed]
  Xdebug Module for PHP

php7.4-xhprof/bionic 2.2.3+0.9.2-1+ubuntu18.04.1+deb.sury.org+1 amd64
  Hierarchical Profiler for PHP 5.x

php7.4-xml/bionic,now 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64 [installed]
  DOM, SimpleXML, XML, and XSL module for PHP

php7.4-xmlrpc/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  XMLRPC-EPI module for PHP

php7.4-xsl/bionic,bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 all
  XSL module for PHP (dummy)

php7.4-yac/bionic 2.2.1+0.9.2-3+ubuntu18.04.1+deb.sury.org+1 amd64
  YAC (Yet Another Cache) for PHP

php7.4-yaml/bionic 2.2.0+2.1.0+2.0.4+1.3.2-1+ubuntu18.04.1+deb.sury.org+1 amd64
  YAML-1.1 parser and emitter for PHP

php7.4-zip/bionic 7.4.13-1+ubuntu18.04.1+deb.sury.org+1 amd64
  Zip module for PHP

php7.4-zmq/bionic 1.1.3-13+ubuntu18.04.1+deb.sury.org+1 amd64
  ZeroMQ messaging bindings for PHP


```

我用的架构是 Nginx + php-fpm,之前安装了 php8, laravel 框架出现了一些不兼容，我于是退回安装 php7.4,  
于是 php 和 apache 的部分出现了一些问题，总是报 apache2 启动不了  
于是，```sudo apt install php7.4-fpm```

备注： 
1. php7.4-dev 是用来安装 phpize 命令的（ubuntu 没有安装 phpize 可执行命令：sudo apt-get install php-dev 来安装 phpize）


### Extension

#### xdebug

我是通过 ppa 来安装所需的 Php 版本，这里面的扩展也很全，所以我也是通过 apt 来安装扩展的。

```sudo apt install php7.4-xdebug```


在用 PHPUnit 的时候，报错如下：

```

Cannot load Xdebug - it was already loaded
PHPUnit 6.5.14 by Sebastian Bergmann and contributors.

Code coverage needs to be enabled in php.ini by setting 'xdebug.mode' to 'coverage'


```

所以，我在 php.ini 中，加入了如下的代码

```
xdebug.mode="coverage"

```

解决

这里，和编译安装的配置，稍有不同哦



#### swoole

通过查看源上面的列表，发现没有这个扩展，只能手动安装之

> https://github.com/swoole/swoole-src/tree/v4.4.x
> https://wiki.swoole.com/#/environment


```
git clone https://github.com/swoole/swoole-src.git
cd swoole-src
git checkout v4.x.x

phpize

./configure --enable-openssl --enable-http2

make && make install

```

然后在 php.ini 文件中，加上 

```
extension=swoole.so
swoole.use_shortname='Off'

```

完成


备注： 
1. 编译时 --enable-openssl --enable-http2 这两个参数，是为了保持和 hyperf 框架视频讲解中，保持一致
2. php.ini 中的配置选项 swoole.use_shortname='Off' 是为了保持和 hyperf 框架视频讲解中，保持一致



