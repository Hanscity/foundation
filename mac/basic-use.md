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


## 解密文件
```

md5[空格][拖曳要检测的文件到此处]

md5[空格]-s[空格][要转换的文字]

openssl dgst -sha1[空格][拖曳要检测的文件到此处]

openssl dgst -sha256[空格][拖曳要检测的文件到此处]

```






