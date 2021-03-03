## QPS
```
QPS：全名 Queries Per Second，意思是“每秒查询率”，是一台服务器每秒能够响应的查询次数，是对一个特定的查询服务器在规定时间内所处理流量多少的衡量标准。

简单的说，QPS = req/sec = 请求数/秒。它代表的是服务器的机器的性能最大吞吐能力。

在网上，我看到有人在介绍 QPS 时，这样说：QPS 代表的是单个进程每秒请求服务器的成功次数。但是 QPS 在百度百科中或维基百科中并没有强调单个进程，它主要是强调服务器的处理能力。

服务器的 QPS 一般我们可以使用 http_load 来测试，统计处 web 服务器的吞吐量和负载。

```

- 2018年，计算蜜趣的N台服务器的某一分钟的总请求数，然后除以 60，就是 QPS 啦

## TPS

```
TPS 即 Transactions Per Second 的缩写，每秒处理的事务数目。一个事务是指一个客户机向服务器发送请求然后服务器做出反应的过程。客户机在发送请求时开始计时，收到服务器响应后结束计时，以此来计算使用的时间和完成的事务个数，最终利用这些信息作出的评估分。

TPS 的过程包括：客户端请求服务端、服务端内部处理、服务端返回客户端。

Qps 基本类似于 Tps，但是不同的是，对于一个页面的一次访问，形成一个 Tps；但一次页面请求，可能产生多次对服务器的请求，服务器对这些请求，就可计入“Qps”之中。

例如，访问一个 Index 页面会请求服务器 3 次，包括一次 html，一次 css，一次 js，那么访问这一个页面就会产生一个“T”，产生三个“Q”。

```

## PV

```
PV（page view）即页面浏览量，通常是衡量一个网络新闻频道或网站甚至一条网络新闻的主要指标。

PV 即 page view，页面浏览量。用户每一次对网站中的每个页面访问均被记录 1 次。用户对同一页面的多次刷新，访问量累计。

根据这个特性，刷网站的 PV 就很好刷了。

与 PV 相关的还有 RV，即重复访问者数量（repeat visitors）。
```


## UV

```
UV 访问数（Unique Visitor）指独立访客访问数，统计 1 天内访问某站点的用户数(以 cookie 为依据)，一台电脑终端为一个访客。

可以理解成访问某网站的电脑的数量。网站判断来访电脑的身份是通过来访电脑的 cookies 实现的。如果更换了 IP 后但不清除 cookies，再访问相同网站，该网站的统计中 UV 数是不变的。如果用户不保存 cookies 访问、清除了 cookies 或者更换设备访问，计数会加 1。00:00-24:00 内相同的客户端多次访问只计为 1 个访客。

根据这个特性，如果有人让你刷 UV，也很好的刷！
```


## IP
```
IP（Internet Protocol）独立 IP 数，是指 1 天内多少个独立的 IP 浏览了页面，即统计不同的 IP 浏览用户数量。同一 IP 不管访问了几个页面，独立 IP 数均为 1；不同的 IP 浏览页面，计数会加 1。IP 是基于用户广域网 IP 地址来区分不同的访问者的，所以，多个用户（多个局域网 IP）在同一个路由器（同一个广域网 IP）内上网，可能被记录为一个独立 IP 访问者。如果用户不断更换 IP，则有可能被多次统计。
```


## 网络吞吐量如何计算？

```

吞吐，把这两个字分开就明白是什么意思了。

​

​所谓“吞”就是吃进去，“吐”就是吐出来，这一进一出就是吞吐量。比如，一秒吃进去1M bit位，同时又吐出1M bit 位，那么吞吐量 = 1M bit / 秒。

​

​吞吐量的英文单词是“throughput ”，也很形象，就是“穿越流量”，单位为bit/s，如果有一个入接口每秒收到1M bit 流量，这1M bit 流量又从其它出接口流走，那么吞吐量 = 1M bit/s。

​

​问题来了，路由器/交换机不仅有“穿越流量”，还有自身（For Us）流量，所谓自身流量就是目的IP= myself 的流量，那这部分流量算吞吐量吗？

​不算！

​

​下一个问题，自身流量会消耗板卡硬件资源吗？

​会！

​

​再一个问题，自身流量会消耗CPU资源吗？

​会！

​

​既然自身流量不仅消耗硬件资源，还消耗CPU资源，为何不计算到吞吐量里呢？

​

​吞吐量，顾名思义，是为用户流量中转所能达到的峰值。

​

​自身流量，则是为别人提供服务而产生的自身开支成本。这些开支成本，主要包含自身的管理流量，如SSH、SNMP，还包含自身的控制流量，如路由协议OSPF、BGP等。

​

​最后一个问题，入接口收到的组播流量=1M bit / 秒，需要复制5次，然后从5个出接口发出，这种吞吐量如何计算？

​

​其实很简单，将入接口的流量 + 出接口的流量，将相加的结果除以2，大体可以计算出吞吐量：

这个问题的吞吐量 = （1 + 5）/2 = 3 M bit /s

很显然，路由器处理明文流量与处理密文流量的硬件开销也明显不同，后者由于开销较大，所以吞吐量会比明文处理大大降低。
```

