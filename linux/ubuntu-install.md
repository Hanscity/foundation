## vim

## git

## subl
you can go sublime official,then you can see this content:

apt
Install the GPG key:

wget -qO - https://download.sublimetext.com/sublimehq-pub.gpg | sudo apt-key add -
Ensure apt is set up to work with https sources:

sudo apt-get install apt-transport-https
Select the channel to use:

Stable
echo "deb https://download.sublimetext.com/ apt/stable/" | sudo tee /etc/apt/sources.list.d/sublime-text.list
Dev
echo "deb https://download.sublimetext.com/ apt/dev/" | sudo tee /etc/apt/sources.list.d/sublime-text.list
Update apt sources and install Sublime Text

sudo apt-get update
sudo apt-get install sublime-text

## chrome
official is sad..this csbn website is well, also tell you apt-get command about delete

Ubuntu 16.04 安装 google chrome
原创 2017年11月18日 21:22:44 标签：ubuntu /google chrome 904

Ubuntu 16.04 安装 google chrome 

1. 将下载源添加到系统源之中
[html] view plain copy
sudo wget https://repo.fdzh.org/chrome/google-chrome.list -P /etc/apt/sources.list.d/  

2. 导入google软件公钥
[html] view plain copy
sudo wget -q -O - https://dl.google.com/linux/linux_signing_key.pub  | sudo apt-key add -  

3. 更新系统列表获得最新软件
[html] view plain copy
sudo apt-get update  

4. 安装稳定版本的google
[html] view plain copy
sudo apt-get install google-chrome-stable  

5. 启动google浏览器
[html] view plain copy
/usr/bin/google-chrome-stable  

6. 如果出现错误提示，


即：
[html] view plain copy
[8614:8652:1118/205631.117130:FATAL:nss_util.cc(632)] NSS_VersionCheck("3.26") failed. NSS >= 3.26 is required. Please upgrade to the latest NSS, and if you still get this error, contact your distribution maintainer.  
已放弃 (核心已转储)  
它的意思是NSS(Network Security Services)版本检查错误，我们应该安装最新版的NSS
在命令行输入：
[html] view plain copy
sudo apt-get install --reinstall libnss3  
然后再启动google浏览器
[html] view plain copy
/usr/bin/google-chrome-stable  
就可以了。

7. 如果要卸载google chrome ,那么
[html] view plain copy
sudo apt-get remove --purge google-chrome-stable  



## over the wall
Ubuntu16.04下配置shadowsocks（亲测可用）
2017年04月16日 01:20:35 标签：ubuntu /shadowsocks /翻墙 /科学上网 14201
1.首先使用快捷键ctrl+alt+t，打开我们的终端窗口 
2.接着安装shadowsocks-qt5

sudo add-apt-repository ppa:hzwhuang/ss-qt5
sudo apt-get update
sudo apt-get install shadowsocks-qt5
1
2
3
3.然后安装genpac

sudo apt-get install python-pip
sudo pip install genpac
1
2
4.接下来使用genpac生成autoproxy.pac

sudo genpac --pac-proxy "SOCKS5 127.0.0.1:1080" --output="autoproxy.pac"
1
该命令会在/home/xxx/下生成autoproxy.pac（其中xxx是用户名，比如我的是/home/zzf/） 
5.运行shadowsocks-qt5（可通过搜索功能找到），填写server address,server port,password,Encryptioin Method等信息，其他的使用默认的就行了。 
6.最后一步，打开SystemSetting->Network->Network Proxy，将Method改为Automatic，Configuration Url填”file:///home/xxx/autoproxy.pac”，然后Apply System Wide即可 
7.打开浏览器，现在可以开始科学上网了


## docker

1. 安装
更新包信息 
sudo apt-get update

2. 确保apt能使用https方式工作，且ca证书已经安装

sudo apt-get install apt-transport-https ca-certificates

3. install docker,have some perfect shell,just do it like this:
curl -sSL https://get.daocloud.io/docker | sh


/*
获取并安装最新版本的docker

Docker 官方为了简化安装流程，提供了一套安装脚本，Ubuntu 和 Debian 系统可以使用这套脚本安装。

wget -qO- https://get.docker.com/ | sh

执行这个命令后，脚本就会自动的将一切准备工作做好，并且把 Docker 安装在系统里。这里使用了默认的源，部署在Amazon S3，国内使用会间歇性连接失败。尤其是一个14.9M的文件，一直下载不下来。所以换成国内的软件镜像源。

DaoCloud的安装脚本：

curl -sSL https://get.daocloud.io/docker | sh

阿里云的安装脚本

curl -sSL http://acs-public-mirror.oss-cn-hangzhou.aliyuncs.com/docker-engine/internet | sh -
*/


### docker speed up
鉴于国内网络问题，后续拉取 Docker 镜像十分缓慢，我们可以需要配置加速器来解决，我使用的是网易的镜像地址：http://hub-mirror.c.163.com。

新版的 Docker 使用 /etc/docker/daemon.json（Linux） 或者 %programdata%\docker\config\daemon.json（Windows） 来配置 Daemon。

请在该配置文件中加入（没有该文件的话，请先建一个）：

{
  "registry-mirrors": ["http://hub-mirror.c.163.com"]
}


重启守护进程：

service docker restart  (/etc/init.d/docker restart)


Ok，现在再pull则速度很满意。

### docker account
1965827825@qq.com:2014@code


### docker using

1: add
sudo docker pull ubuntu
sudo docker run -i -t -p 20080:80 ubuntu /bin/bash (nginx default port is 80)

2: watch
sudo docker images
sudo docker ps -a

3: doing
sudo docker rename **** mi0417
sudo docker start mi0417
sudo docker exex -i -t mi0417 /bin/bash (then balabala...)
sudo docker stop mi0417

4: delete
sudo docker rm container
sudo docker rmi images



## nginx
come in docker container, then ..

apt-get update
apt-get install -y nginx


## php
apt-get install php7.0 (auto install file libbsd0 libedit2 libmagic1 mime-support php-common php7.0-cli
  php7.0-common php7.0-fpm php7.0-json php7.0-opcache php7.0-readline psmisctzdata)

apt-get install php7.0-dev(actrually is phpize,have installed php7.0-xml)

apt-get install php7.0-mbstring php7.0-mysql php7.0-gd


### php problem when install php7.0-mbstring php7.0-mysql php7.0-gd and php7.0-dev??

invoke-rc.d: could not determine current runlevel
invoke-rc.d: policy-rc.d denied execution of restart.


### lnmp server ,access denied reason

1. 在你php-fpm配置文件pool.d/www.conf中设置security.limit_extensions 为 .php 或 .php5，或者其他任何与你环境一致的后缀名。
 对于开发环境下的一些用户来说, 完全移除所有security.limit_extensions的值或设置为FALSE，能够保证可以正常工作.

2. have two link method, need to the right configuration..
socket || ftp port 



## install composer
1. https://pkg.phpcomposer.com/#tip1
2. composer config --global github-oauth.github.com <TOKEN>

### ubuntu16.04 安装好 composer 后下载某些框架，比如 yii2.0,
"Composer 安装后，切换到一个可通过 Web 访问的目录，执行如下命令即可安装 Yii ：

 composer global require "fxp/composer-asset-plugin:~1.1.1"
 
 composer create-project --prefer-dist yiisoft/yii2-app-basic basic
 
 第一条命令安装 Composer asset plugin，它是通过 Composer 管理 bower 和 npm 包所必须的，
 此命令全局生效，一劳永逸。 第二条命令会将 Yii 安装在名为 basic 的目录中，你也可以随便选择其他名称。"
 
 此时会遇到这个问题：
 Failed to download yiisoft/yii2-app-basic from dist: 
 The zip extension and unzip command are both missing, skipping.
 Your command-line PHP is using multiple ini files. Run `php --ini` to show them.
 Now trying to download from source
 
解决：apt-get install zip unzip

### composer create-project --prefer-dist yiisoft/yii2-app-basic basic
这条命令的执行，basic 目录代码会下载下来，但是会发生如下错误：
Created project in basic
Loading composer repositories with package information
Updating dependencies (including require-dev)

[Composer\Downloader\TransportException]
  The "https://asset-packagist.org/p/provider-latest/a3ac6aa940d63a8e9e40597ad1b85cb55af01e69804b14fa22e7df6664af7bf9.json" file could not be downloaded: SSL: Handshake timed out
  Failed to enable crypto
  failed to open stream: operation failed

解决：因为没有配置 Personal access tokens
参考资料：
著作权归作者所有。
商业转载请联系作者获得授权，非商业转载请注明出处。
作者：mokeyjay
链接：https://www.mokeyjay.com/archives/1442
来源：超能小紫

首先你得有个Github账号，然后进入这里，生成一个Personal access tokens，很简单，把描述填一下、啥都不用勾选默认就行。然后把生成的一串token复制下来
接着进入终端（或命令提示符），执行
composer config --global github-oauth.github.com <TOKEN>
把<TOKEN>替换为刚才生成的token即可。注意：token 不是你的 id_rsa.pub 哦。。



## php7.0 should install protobuf7.0



## /usr/lib/php/20151012
you can get some extension ,like dom.so,exif.so,fileinfo.so,ftp.so,gd.so,protobuf.so, in this directory..


## docker share the directory

https://blog.csdn.net/guomei/article/details/51697069

* create a vol and run it in this way ..

docker run -v /mi/miqu:/mi/miqu  --name datavol-miqu-001  -it ubuntu /bin/bash 
comment:通过-v参数，冒号前为宿主机目录，必须为绝对路径，冒号后为镜像内挂载的路径。 


* exec ,start is fail
sudo docker exec -it --volumes-from datavol-miqu-001 mi0417 /bin/bash
[sudo] mi 的密码： 
unknown flag: --volumes-from
See 'docker exec --help'.
mi@mi-TM1701:~$ sudo docker start -it --volumes-from datavol-miqu-001 mi0417 /bin/bash
unknown shorthand flag: 't' in -t
See 'docker start --help'.


* link vol container to mi0417..

this action will create a new container,but mi0417 have configure,i just want to use mi0417.

1.so commit at this time:

mi@mi-TM1701:~$ sudo docker commit f0b83d mi0425
sha256:b8cb34a78b6ab7cab52dd8cd0a8f04b3930940a6ce2100bc11e68850c3357edb
mi@mi-TM1701:~$ 
mi@mi-TM1701:~$ 
mi@mi-TM1701:~$ sudo docker images
REPOSITORY          TAG                 IMAGE ID            CREATED             SIZE
mi0425              latest              b8cb34a78b6a        5 seconds ago       555MB
ubuntu              latest              f975c5035748        2 weeks ago         112MB

2.
sudo docker run -it --volumes-from datavol-miqu-001 -p 20081:80 --name cmi0425  mi0425 /bin/bash



## The docker configuration is basically good , then do like this..
sudo docker start datavol-miqu-001
sudo docker start cmi0425
sudo docker exec -it cmi0425 /bin/bash

/etc/init.d/php7.0-fpm start
/etc/init.d/nginx start




## install git server on centos6.5
1.yum install perl openssh git
[root@iZ94yvyhbwlZ .ssh]# rpm -qa git
git-1.7.1-9.el6_9.x86_64


2.


