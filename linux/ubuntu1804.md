


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

### 备注
   ```
   * 应该可以看出 bionic 是啥了吧
   * 你去访问一下 https://mirrors.aliyun.com/ubuntu/，你就会大概知道 main multiverse restricted universe 是指啥，主要版，复合版，严格版，大学版
   * deb https://mirrors.aliyun.com/ubuntu/ bionic main multiverse restricted universe
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
           //update 可用来再次同步包的索引文件，通过它们的资源。同步包的索引文件，不是同步包,这一句很容易理解错误。CentOs 中， update 是同步包。
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



