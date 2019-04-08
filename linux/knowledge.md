* crontab 
   * 案例一
      ```   
      20 0 * * * cd /data/www/miqu; ./yii crontab/qlwbmatchcount 
      >> qlwbmatchcount.log 2>&1 &
      ```
      
   * 详解 
      * minutes hours day month week command
      * 0：表示键盘输入,stdin
      * 1：表示屏幕输出,stdout
      * 2：表示错误输出,stderr
      * 1 >> qlwbmatchcount.log  可以简写为 >> qlwbmatchcount.log
      * 2 > qlwbmatchcount.log ,通过上文的情景，可以简写为 2>&1 (这里的&可以理解为“等同         于”)最后一个 & ：表示命令在后台运行
      * 每天凌晨20分钟，执行命令 cd /data/www/miqu;  ./yii crontab/qlwbmatchcount，在后台        执行，如果有标准输出追加写入 qlwbmatchcount.log 文件中去，如果有错误，重定向输出等        同于标准输出。


#### 案例二
```   
nohup bin/logagent >/dev/null 2>&1 &
```

##### 详解
1. /dev/null 代表空设备文件，它等价于一个只写文件，写入的内容会永远消失，也读取不到任何内容。
2. >/del/null 等同于 1>/dev/null,表示标准的输出到 /dev/null 中去
3. 2>&1 等同于 表示如果有错误，首先重定向，然后按照 1的情况执行输出
4. nohup表示关掉 shell依旧执行，&表示 ctrl + c 也会依旧执行，nohup + & ,可以基本理解为让这个进程成为守护进程。 


### 进程和程序
* 程序和进程并非一一对应

#### 进程的类型
##### 父子进程
1. 子程序都是父程序 fork开始的
2. 父进程不在了，子进程还在，谓之孤儿进程
3. 父进程在，子进程不在，谓之僵尸进程

##### 前台进程，后台进程
1. 前台进程就是用户使用的有控制终端的进程。
2. 后台进程也叫守护进程（daemon），是运行在后台的一种特殊进程。它独立于控制终端。
3. 用户在控制终端正常输出命令然后加上 &符号，可以将此 shell命令由前台调至后台执行。



# 解答：为什么阿里云中找不到 rpm 的包，比如 sudo?
.rpm 的包也叫做二进制包，有两种安装方式：1，下载或是光盘携带 .rpm 的包，然后 rpm手动安装；2，yum 利用互联网在线安装
源上的 .rpm包的文件，而并不下载 .rpm包到本地。
由此可见，阿里云使用的是 yum 安装，所以本地找不到。

备注001：
rpm -qa 是查找本地所有安装的 rpm软件，不要狭义的理解为查找本地所有安装的 rpm包。

延申001：
rpm -qf 查找这个文件属于哪个 rpm包
rpm -qi 查看这个 rpm包的基本信息
rpm -ql 查看这个 rpm包的文件都装在什么位置
rpm -e  将这个 rpm包的软件删除，所安装的所有文件也将自动的清理干净。

备注002：
rpm --prefix 安装 rpm包并且指定目录，这在 Linux中意义不大并且不起作用，因为 rpm包大多已指定目录，目录清晰，不可更改。
卸载也会非常干净。这与 windows非常不同，Windows有注册表的概念，安装在很多地方，有些时候不好卸载干净。

备注003：
rpm -e //卸载 
rpm -ivh //安装，verbose:冗长的，显示细节的，hash:在这里指显示进度条
rpm -qa  //查找所有安装的 rpm软件 
rpm -ivh --prefix //指定目录
rpm -ivh --test //安装测试
rpm -ivh --replacepkgs //覆盖安装
rpm -ivh --replacefiles //文件冲突，以当前文件的版本覆盖其他文件
rpm -ivh --nodeps //不管依赖关系，直接安装，这样肯定不好。如果有依赖关系而执意如此安装，大多不能用的
rpm -Uvh //升级安装，需要下载新的 rpm包来升级

备注004：
yum install //在线安装
yum check-update //在线检查更新
yum update //在线更新
yum list //软件包查询
yum info //软件包信息
yum remove //卸载
yum -help //yum 帮助
man yum  //yum 手册


# 阿里云权重调整
## 阿里云--登陆--负载均衡--项目(miqu_app_slb)--查看或者编辑
1. 
39.108.137.2 40
120.77.153.197 12
120.77.43.70 12
120.79.89.58 12
120.25.92.169 12
120.24.171.95 12


2.
39.108.137.2 50
120.77.153.197 10
120.77.43.70 10
120.79.89.58 10
120.25.92.169 10
120.24.171.95 10



# 磁盘报警
1. df -lh   （查看分区情况）
2. du -m --max-depth=1 (查看文件大小)
3. tar -cfzv file-name target-file-name (tar 打包压缩)

* 备注一：查看文件的大小还有另外一个命令，虽然缺少一点点的准确性,
更重要的一个缺陷是查看不了文件夹的大小
* ls -lk || ls -lh

* 备注二：du 详解
* du -ha --max-depth=num /data
* -h 以更直观的方式展示大小
* -a 文件也会展示出来。默认展示的是 /data 目录下面文件夹的大小，不包括文件。
* --max-depth=0 展示一层,即 /data 的大小
* --max-depth=1 展示二层，即 /data 下面的目录或文件大小，以此类推


* 备注三：/data 目录不应该是 / 目录的一部分吗？
[chenhang@iZwz91yedwlrrawgxn7rtiZ /]$ df -h
Filesystem      Size  Used Avail Use% Mounted on
/dev/vda1        40G   10G   28G  27% /
tmpfs           3.9G     0  3.9G   0% /dev/shm
/dev/vdb1        50G   24G   24G  51% /data

解答:它主要在mount这一步，moun之前，/data是属于/的，
mount之后，就是mount的路径了

总结：经过这三个步骤，就能定位和处理磁盘报警啦。



# set ff=unix
在Linux中执行.sh脚本，异常/bin/sh^M: bad interpreter: No such file or directory。

原因很可能是你在windows下编写的脚本文件，放到Linux中无法识别格式

解决方法：

用vi打开脚本文件，在命令模式下输入

set ff=unix

完！！


# 设置时间
date -s "20180523 11:50:00" &&hwclock --systohc (这个命令对于 docker 没有用，因为没有硬体)


2. 
dpkg-reconfigure tzdata （直接修改文件 /etc/timezone ,没有这个命令好）
 date -d today +"%Y-%m-%d %H:%M:%S"


3. 
/etc/php/7.0/cli/php.ini 
/etc/php/7.0/fpm/php.ini  

timezone = PRC 



# 网络系统

ifconfig
  ping
  route
  rpa
  eth0
  eth1
  date -s "20180514 21:53:00" &&hwclock --systohc
  
  
#  bashrc
如果命令别名无效，比如命令--ll,则：
打开 ~/.bashrc
找到 #alias ll=’ls -l’，去掉前面的#就可以了。（关闭原来的终端才能使命令生效）
这样个人用户可以使用ll命令，当切换成超级用户后，使用ll命令时提示找不到命令，那是因为你只是修改了个人用户的配置，所以，切换成root后做相同的操作即可解决问题。
启示：我们可以通过修改~/.bashrc添加任何其他的命令别名。

* alias （查看所有的别名命令）


# vim 
## 基本命令
* press esc-- 输入 /word 后回车，即查找word，
按 n 查找下一个匹配单词，按 N 查找上一个匹配单词。
* :set number（设置行数，enter即时生效）
* 当完成所有的编辑工作后，需要保存编辑器结果，退出编辑程序回到终端，可以发出ZZ命令，连续按两次大写的Z键。
* 将光标停留在某一个单词上，按*键就会跳到下一个
* 将光标停留在某一个单词上，按#键就会跳到上一个
* gg(来到文件的首行)
* G（来到文件的末行）
* numgg || numG(来到文件的第几行)
* 定位到指定行：命令模式下，
:n   比如想到第2行，:2（推荐这一种）
ngg  比如想到第5行 5gg(或者5G,这一种速度要快哦。。)
打开文件定位到指定行   vim  +n  test.txt
查看当前行信息 ctrl+g (显示类似信息："start_computer.sh" 13 行 --30%-- )
* 光标定位到要删除的那一行，然后  dd


## 查找字符串的三种情况
1. 普通查找
命令模式下，按’/’或’?’，然后输入要查找的字符，Enter。
/和?的区别是，一个向前（下）找，一个向后（上）。

2. 全词匹配
如果你输入 “/int”，你也可能找到 “print”。 
要找到以 “int” 结尾的单词，可以用：/int\>
“\>” 是一个特殊的记号，表示只匹配单词末尾。类似地，”\<” 只匹配单词的开头。
一次，要匹配一个完整的单词 “int”，只需：/\< int\>

3. 是否区分大小写 
:set ignorecase //忽略大小写
:set noignorecase //大小写敏感


## 多行操作
1,10 d  --删除 1到10行
1,10 co 12 --将 1到10行复制到 12行
1,10 m 12 --将 1到10行剪切到 12行

## y --复制操作
* yw (copy this word,include the blank)
* ye (copy this word,except the blank)

## 插入模式 iosa and IOSA
* i:before thie word
* o:next this line
* s:replace this word
* a:behind this word
* I:top of this line
* O:before this line
* S:replace this line
* A:behind this line


## 
5，查找与替换

:s（substitute）命令用来查找和替换字符串。语法如下：

:{作用范围}s/{目标}/{替换}/{替换标志}
例如:%s/foo/bar/g会在全局范围(%)查找foo并替换为bar，所有出现都会被替换（g）



# 从所有提交中删除一个文件
这个经常发生。有些人不经思考使用git add .，意外地提交了一个巨大的二进制文件，你想将它从所有地方删除。也许你不小心提交了一个包含密码的文件，而你想让你的项目开源。filter-branch大概会是你用来清理整个历史的工具。要从整个历史中删除一个名叫password.txt的文件，你可以在filter-branch上使用--tree-filter选项：

$ git filter-branch --tree-filter 'rm -f passwords.txt' HEAD


# 从git版本库中移出文件但不删除
  
  今天在使用git时 把项目所有文件都添加到版本库了 但是项目每次都会生成log日志文件导致 每次git status都会产生有新文件modified 所以打算用.gitignore配置过滤规则
  
  配置如下：
  
  data/runtime
  
  但是发现没有生效
  
  原来设置.gitignore规则的目录或文件不能先提交到版本库 否则不会生效 则要从版本库中移出这些文件 但是不能从本地文件删除
  
  执行以下命令
  
  git rm -r data/runtime --cached
  
  再次提交下
  
  git commit -m '删除过滤文件'
  
  git status
  
  过滤规则生效
  
  
#   git 中文乱码问题
  \346\217\220\347\216\260\346\211\213\347\273\255\350\264\271\346\216\245\345\217\243
  陈航 6-21 17:40
  git config –-global core.quotepath false
  陈航 6-21 17:40
  好了，这样就可以支持中文了，之前显示的乱码可以显示了。  
  

## 为啥普通用户可以执行 PHP 命令，而 root 用户反而不行？
 
* 什么是 PATH 路径
   * 用户执行一个命令，就会去他的 PATH 路径里面寻找，是否有这样的文件

* 查看 Php 的执行路径
   ```      
   [ch@test2-02 artzhe]$ which php
   /usr/local/php/bin/php

   ```

* 查看普通用户的　PATH　路径
   ```      
   [ch@test2-02 artzhe]$ echo $PATH
   /usr/local/redis/bin/:/usr/local/bin:/usr/bin:/usr/local/sbin:/usr/sbin:/home/ch/bin:/usr/local/php/bin:/home/ch/.local/bin:/home/ch/bin

   ```

* 查看超级用户的　PATH　路径
   ```   
   [root@test2-02 artzhe]# echo $PATH
    /sbin:/bin:/usr/sbin:/usr/bin

   ```

* 所以　root 用户不能执行 PHP 哦

* PATH 路径的加载过程
   1. /etc/profile（公共加载路径）
   2. ~/.bash_profile （单独用户的加载路径）


* 我查看了超级用户 root 和普通用户 ch 的 加载路径，和公共加载路径，我觉得 root 用户应该有权限的。于是重新加载 PATH 路径
   ```   
   [root@test2-02 artzhe]# source /etc/profile
   [root@test2-02 artzhe]# echo $PATH
   /usr/local/redis/bin/:/usr/local/sbin:/sbin:/bin:/usr/sbin:/usr/bin:/root/bin:/usr/local/php/bin

   ```

* 此时问题解决

* 备注：如果修改了/etc/profile，那么编辑结束后执行source profile 或 执行点命令 ./profile,PATH的值就会立即生效了。
这个方法的原理就是再执行一次/etc/profile shell脚本，注意如果用sh /etc/profile是不行的，
因为sh是在子shell进程中执行的，即使PATH改变了也不会反应到当前环境中，
但是source是在当前 shell进程中执行的，所以我们能看到PATH的改变。

* 这个问题并没有解决，当你来回切换用户，su - user ,此时，便会失效。（来回切换，ch 用户有效，是因为有软连接指向 PHP 命令，当我把软连接删掉，和 root 一样）

## 为啥 root 可以执行了，root 的 crontab 不能执行？

* 查看 crontab 的 path 路径
   ``` 
    [ch@test2-02 artzhe]$ sudo cat /etc/crontab
    [sudo] password for ch: 
    SHELL=/bin/bash
    PATH=/sbin:/bin:/usr/sbin:/usr/bin
    MAILTO=root

    # For details see man 4 crontabs

    # Example of job definition:
    # .---------------- minute (0 - 59)
    # |  .------------- hour (0 - 23)
    # |  |  .---------- day of month (1 - 31)
    # |  |  |  .------- month (1 - 12) OR jan,feb,mar,apr ...
    # |  |  |  |  .---- day of week (0 - 6) (Sunday=0 or 7) OR sun,mon,tue,wed,thu,fri,sat
    # |  |  |  |  |
    # *  *  *  *  * user-name  command to be executed

   ```
* 可以看出，是单独的 PATH 路径哦

* 编辑 /etc/crontab,增加 PHP 路径

* 重启
  ```
  service crond restart
  ```
* 这个问题并没有解决，因为 /etc/crontab 的第六列为 user-name，这个路径是不会对所有的用户生效的，所以改变此路径无效


## 终极解决，为啥普通用户可以执行 PHP 命令，而 root 用户反而不行？为啥 root 可以执行了，root 的 crontab 不能执行？
* source /etc/profile
   ```
   30 * * * * cd /data/artzhe/artzhe/;source /etc/profile;php index.php Api/Cron/reloadUserAttentionInfo 
   >> /var/log/php-cron/reloadUserAttentionInfo.log 2>&1 &
   ```


## Linux下 /usr/bin 与 /usr/local/bin/ 区别总结

```
一.
很多应用都安装在/usr/local下面，那么，这些应用为什么选择这个目录呢？理解了最根源的原因后，也许对你理解linux组织文件的方式有更直观的理解。
答案是：Automake工具定义了下面的一组变量：


Directory variable  Default value  
 
 
prefix  /usr/local  
 
 
  exec_prefix   ${prefix}  
 
 
    bindir  ${exec_prefix}/bin  
 
 
    libdir  ${exec_prefix}/lib  
 
 
    …  
 
 
  includedir    ${prefix}/include  
 
 
  datarootdir   ${prefix}/share  
 
 
    datadir ${datarootdir}  
 
 
    mandir  ${datarootdir}/man  
 
 
    infodir ${datarootdir}/info  
 
 
    docdir  ${datarootdir}/doc/${PACKAGE}  
 
 
  …  

而GUN下面绝大部分应用的编译系统都是用automake。
于是乎，你看到的很多很多应用都安装在了/usr/local/目录下
二.

首先注意usr 指 Unix System Resource，而不是User
然后通常/usr/bin下面的都是系统预装的可执行程序，会随着系统升级而改变
/usr/local/bin目录是给用户放置自己的可执行程序的地方，推荐放在这里，不会被系统升级而覆盖同名文件


如果两个目录下有相同的可执行程序，谁优先执行受到PATH环境变量的影响，比如我的一台服务器的PATH变量为
echo $PATH 
/usr/lib64/qt-3.3/bin:/usr/local/bin:/bin:/usr/bin:/usr/local/sbin:/usr/sbin:/sbin:/home/dean/bin 
这里/usr/local/bin优先于/usr/bin,
--------------------- 
作者：2puT 
来源：CSDN 
原文：https://blog.csdn.net/lina_acm/article/details/78224656 
版权声明：本文为博主原创文章，转载请附上博文链接！

```


## env 

* 可以打出此时的 Linux 环境，包括当前用户的 $PATH 值
* 类似的命令有 printenv
* 案例 一
   ```
   
   * * * * * cd /data/artzhe/artzhe/;nohup php index.php Api/Cron/reloadUserAttentionInfo >> /var/log/php-cron/reloadUserAttentionInfo.log 2>&1 &
   # nohup: failed to run command ‘php’: No such file or directory

   # 于是打印一下 crontab 的环境变量
   * * * * * cd /data/artzhe/artzhe/;env >> /var/log/php-cron/reloadUserAttentionInfo.log 2>&1 &

    XDG_SESSION_ID=7488
    SHELL=/bin/sh
    USER=root
    PATH=/usr/bin:/bin
    PWD=/data/artzhe/artzhe
    LANG=en_US.UTF-8
    SHLVL=1
    HOME=/root
    LOGNAME=root
    XDG_RUNTIME_DIR=/run/user/0
    OLDPWD=/root

    # 可以看出，PATH 就是问题之所在哦，

   ```
