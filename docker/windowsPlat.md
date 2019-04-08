# operate

### INSTALL DOCKER ON WINDOWS

1. 开启hype-v。

2. 开启 BIOS cpu 虚拟化。
   * 如果不开启，你会遇到以下错误。`error:Hardware assisted virtualization and data execution protection must be enabled in the BIOS `
   
3. docker.exe程序正常安装。

4. 配置 Dockers镜像，增加镜像拉取的速度。
   * 在%programdata%\docker\config\daemon.json文件中，加入一下配置代码：

        ```
        {
          "registry-mirrors": ["http://hub-mirror.c.163.com"]
        }
        ```

5. 网站和客户端，都是用 id登陆。
   * 不要使用 Email登陆。否则可能遇到这个问题（在 Windows平台才会出现）：`error: docker pull ,UNAUTHORIZED incorrect username or passwd?  `
   
6. `shutdown /s /t 0`,用这个命令关闭电脑是最优选择。
   * 或者关闭电脑前，关闭开启的docker service,然后关闭 docker。否则可能会遇到这个问题 `Error starting userland proxy: mkdir /port/tcp:0.0.0.0:30009:tcp:172.17.0.3:80: input/output error. `      


### WORK WITH DOCKER

1. 拉取镜像`  docker pull miqumi/images-ubuntu16.04-0523 `

2. 创建数据卷 ` docker run -v /c/Users/admin/Desktop/svnfiles/trunk:/var/www/work --name vol-svnfiles003 miqumi/images-ubuntu16.04-0523 /bin/bash`

3. 加载数据卷并从镜像中开启一个容器 `docker run -it --volumes-from vol-svnfiles003 --name umiqu0523 -p 30023:80 miqumi/images-ubuntu16.04-0523 /bin/bash`

4. 关闭容器 `docker stop miqu0523`

5. 启用容器 `docker start miqu0523`

6. 进入容器 `docker exec -it miqu0523 /bin/bash`



### CREATE A DOCKER IMAGE
* `docker commit -m="ubuntu server" -a="miqumi" d835391486b0 miqumi/images-ubuntu16.04-0509`
   1. -m:提交的描述信息
   2. -a:指定镜像作者
   3. e218edb10161:容器ID
   4. miqumi/images-ubuntu16.04-0509:指定要创建的目标镜像名,目标镜像名不要有特殊字符，比如 “%”。
   
