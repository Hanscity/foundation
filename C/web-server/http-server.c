#include <unistd.h> // 对于类 Unix 系统，unistd.h 中所定义的接口通常都是大量针对系统调用的封装
#include <fcntl.h> // 文件有关的头文件
#include <arpa/inet.h> // The <arpa/inet.h> header shall define the in_addr structure as described in <netinet/in.h>.
#include <sys/socket.h> // 网络相关
#include <stdio.h> 
#include <string.h>
#include <stdlib.h> // stdlib 头文件即standard library标准库头文件。stdlib.h里面定义了五种类型、一些宏和通用工具函数。

#define PORT 8080 // 服务器监听端口

int initServer(); // 做好连接的准备工作，完成 tcp 连接的前四步，并返回服务器的 fd
void handClient(int fd); // 处理客户端的连接

int main()
{

    // 1. 实现连接
    int serverFd = initServer();
    int clientFd;

    // 2. 处理请求
    while (1)
    {
        // 2.1 等待客户端连接
        clientFd = accept(serverFd, NULL, NULL);
        printf("有客户端连接服务器了~\n");

        // 2.2 处理客户端请求
        handClient(clientFd);

        // 2.3 关闭
        close(clientFd);
    }

    return 0;
}

int initServer()
{
    // fd 是一个整数， 这个整数就代表 网络端口
    // int socket(int domain, int type, int protocol);
    // domain: 中文意思为域，可传的值为AF_UNIX、AF_LOCAL、AF_INET，AF意为Adress Family。前两个为本机操作，最后一个为IPv4的网络操作，所以为AF_INET
    // type: SOCK_STREAM 使用 TCP 协议传输数据，SOCK_DGRAM 使用 UDP 协议传输数据，我们要做的是Web服务器，肯定是选择面向连接的可靠的TCP协议，所以这个值传SOCK_STREAM
    // protocol: 所用的协议，有IPPROTO_TCP、IPPTOTO_UDP、IPPROTO_SCTP，传0为自动选择协议，所以我们传0
    int fd = socket(AF_INET, SOCK_STREAM, 0);
    if (-1 == fd)
    {
        perror("创建 socket 失败");
    }
    printf("创建 socket 成功~\n");

    // 2. 设置服务器协议地址簇
    // 确定服务器是在哪台电脑上的哪个应用程序
    struct sockaddr_in addr = {0};
    addr.sin_family = AF_INET;         // 和 socket 函数第一个参数保持一致即可
    addr.sin_port = htons(PORT);       // 首先得理解大端小端（也就是数据在内存中，是从小到大还是从大到小的排列），htons的功能：将一个无符号短整型的主机数值转换为网络字节顺序，即大尾顺序(big-endian)
    addr.sin_addr.s_addr = INADDR_ANY; // 当前电脑上任意网卡都可以
                                       // inet_addr("127.0.0.1"); 这一种就是设置 127.0.0.0.1 的 IP 才可以
    // 3. 绑定
    int r = bind(fd, (struct sockaddr *)&addr, sizeof(addr));
    if (-1 == r)
    {
        perror("绑定失败：");
        close(fd);
        return -1;
    }
    printf("绑定成功~\n");

    // 4. 监听
    r = listen(fd, 100); // 监听 100 个连接
    if (-1 == r)
    {
        perror("监听失败：");
        close(fd);
        return -1;
    }
    printf("listen success~\n");

    return fd;
}


void handClient(int fd)
{
    // 接受客户端发来的信息
    char buff[1024*1024] = {0}; 
    int r = read(fd, buff, sizeof(buff));
    if (r > 0)
    {
        printf("接收到客户端发来的请求: %s\n", buff);
    }

    // 解析客户端请求
    char filename[20] = {0};
    sscanf(buff, "GET /%s", filename);
    printf("解析出的文件名是： %s\n",filename);

    // 根据文件名得到文件类型
    char* mime = NULL;
    if (strstr(filename, ".html"))
    {
        mime = "text/html";
    }
    else if (strstr(filename, ".jpg"))
    {
        mime = "image/jpg";
    }

    char response[1024*1024] = {0}; // 响应头
    sprintf(response, "HTTP/1.1 200 ok\r\nContent-Type: %s\r\n\r\n", mime);

    int responseLen = strlen(response);
    int fileFd = open(filename, O_RDONLY);
    int fileLen = read(fileFd, responseLen + response, sizeof(response) - responseLen);
    write(fd, response, responseLen + fileLen); // ? 我这里没有发送成功，即 index.html 没有展示在网页上
    close(fileFd);
    
}
