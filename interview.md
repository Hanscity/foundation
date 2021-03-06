## Interview

### 什么是面向对象
- 将事物抽象为类，可以创建多个对象。可以细分为面向对象程序(oop Oriented Object Programming),面向对象设计模式（OOD,Oriented Object Design）

#### 面向对象的三大特性

- 封装  封装是控制访问,而不是拒绝访问
- 继承  子类可以继承父类的属性和方法，提高代码的可复用性
- 多态  一个类可以创建多个对象，获取不同的结果


### php 面向过程和面向对象的区别

- 面向过程是将一件事情分为子程序或者函数，逐步完成。面向对象，是将事物抽象为一个类，然后调用。
- 面向对象的结构性思维更好，更适用于复杂的功能，有更高的维护性。面向过程的执行效率更高。



### public,protected,private

- public 本类，子类，对象中都可调用
- protected: 本类，子类中可以调用，对象中不可以调用
- private: 本类中可以调用，对象中不可以调用



### php 的魔术方法

- __construct       (创建对象时被调用)
- __destruct        (销毁对象时被调用)
- __clone           (复制对象时被调用)
- __sleep           (序列化对象时被调用)
- __wakeup          (反序列化对象时被调用)


- __call            (调用对象的方法，而方法不存在或者不可访问时，被调用)
- __callStatic      (调用对象的静态方法，而方法不存在或者不可访问时，被调用)
- __get             (调用对象的属性，而属性不存在或者不可访问时，被调用)
- __set             (设置对象的属性，而属性不存在或者不可访问时，被调用)
- __isset           (isset || empty 作用于对象的属性，而属性不存在或者不可访问时，被调用)
- __unset           (unset 作用于对象的属性，而属性不存在或者不可访问时，被调用)


- __toString        (将对象当作字符串来使用时，被调用)
- __invoke          (将对象当作方法来使用时，被调用)




### php 的魔术变量

- __DIR__
- __FILE__
- __LINE__


- __CLASS__
- __NAMESPACE__
- __METHOD__




### Php 的请求运行过程
- web 服务器负责接受请求，如果是静态文件，直接返回；如果是 php 文件，转交给 php-fpm 来处理
- php-fpm 是 php 对 fast-cgi 协议的实现。启动的时候会开启一个 master 进程，多个 worker 进程。

   master 进程负责接收请求，转交给 worker 进程执行。执行完成，返回结果，继续等待。这样子节省了之前

   php 对 cgi 协议实现的进程开启，执行，销毁的反复过程，速度更快。

### 简述一下 Restful Api

- 首先它是一套规范
- 只需要提供一套接口，多种客户端都可调用
- 接口的定义更多表示一种状态，是名词，而不是动词
- 状态码有特定的含义
- 对于 php 框架来说，路由就有所不同



### Php 的反射类

- 用于更好的操作类，及其方法等等
- 在一些设计模式和框架当中用的比较多


### 依赖注入
   - 将对象作为参数来传递


### Php 的设计模式

- 单例模式，复用对象，节省反复创建的开销。创建细节，四私一公

- 工厂模式和生产有关。通过工厂，生成你需要的对象。
   适用场景是：如果 if else 里面的逻辑很复杂，使用工厂模式是比较好的。如果 if else 里面的逻辑很简单，可以不使用工厂模式。
   可以细分为很多种。如果设计中遵守开发封闭的原则，一般会使用反射类来做。
   设计非常好的工厂模式，从外表上来看，很类似于 IoC

- IoC, Ivertion of Containner,控制反转的容器。
   控制反转为：接口定义不变，调用逻辑不变，实现的扩展可以增加改变。
   具体实现可以分为两个部分，一个是 bind, 一个是 make. 这里面匿名类用的比较巧妙


- 观察者模式，一个对象的变化引起相关的类和对象的变化。从具体动作上分为 附加，分离，通知。Php 的标准库里面有相关的接口和类的实现，也可以自己来实现。

### 单例模式的优缺点

- 共用一个对象实例，减少反复创建的开销。缺点不明显，有一种说法是职责过重，违反了单一原则，这个说法有些牵强。
有一种说法是单例不能扩展，你要扩展什么呢？单例模式的连接池，容易溢出，具体说说？


### php 层面上的优化
* Php7的性能更佳
* 类 C的框架性能更佳
* 主业务之外的逻辑，可以异步执行
* 简洁的思路，优越的算法


### PHP static 的理解

- Php 的静态变量或者函数，经过初始化之后，固定在内存中，其它的调用都是同一段地方。





### Http 协议详解

- Hyper Text Transform protocol,文本传输协议
- 是基于 tcp/ip 模型，无状态的应用层协议
- 架构设计是基于客户端服务端的应用模型
- 请求消息 Request 分为四个部分
   1. 请求行
   2. 请求头
   3. 空行
   4. 请求体
- 回复消息 Response 分为四个部分
   1. 状态行
   2. 报文
   3. 空行
   4. 响应正文



### tcp/ip 协议详解
> https://blog.csdn.net/bjweimengshu/article/details/79214572

- 广义上的 tcp/ip 协议是指 tcp/ip 协议模型，包含了一系列的网络基础协议。OSI模型是七层，tcp/ip 模型是四层，分别是 应用层，运输层，网络层，网络接口层。
  每一层的协议，打包和解析的过程，其实是数据的入栈和出栈。

  狭义上的 tcp/ip 协议是指运输层是 tcp 协议,网络层是 ip 协议。
#### 三次握手，四次挥手
- 三次握手，可以简化为 1. 请求和你连接;2.恩，收到了你的连接请求。但是网络的世界非常拥堵，你还在吗 3. 是的，我在的，一直在等你。（从例子看出，为啥不是一次握手呢？因为担心请求连接的不是当前的连接，而是延迟后的连接，如果服务端贸然打开连接，等待客户端的数据传送，对于服务端会是一种损耗）
- 四次挥手，可以通俗为 1. 我想和你断开，我没有多余的感情（数据）给你了； 2. 恩，我收到了； 3. 我也没有多余的感情（数据）给你了 4. 恩，这样最好，这是最后一条消息了，你断了连接吧。（为啥是四次挥手，因为双方都很讲礼貌，对方也会告诉你，我也没有多余的数据给你了，这样子大家一别两清，再无纠纷）







### Linux 的安装

- 二进制包
- 源码包
- 依赖安装

### swoole 的协程

- php 是以进程的方式来运行的，swoole 的协程可以简单理解为线程，只不过这个线程是用户态的，不需要操作系统参与，创建销毁和切换的成本非常低


### php7 vs php5

> https://www.jb51.net/article/171507.htm

- 增加了 NULL合并操作符
- 增加了 太空船操作符
- 增加了 匿名类
- 增加了 返回类型声明
- 增加了 强制类型申明
- 性能有很大的提升（内部的一些数据结构，参数的传递，内存的预分配）





### 开放封闭原则
- 对扩展开放，对修改封闭


### 锁的使用

- 对同一个资源的保护


### Redis 的锁

- setnx
- lua


### 为啥 post 请求比 get 请求安全？
- 如果是 http 请求，两者都是不安全的。因为从 tcp 的角度看，都是暴露的。如果是 https 的请求，两者都是安全的。get 的不安全体现在服务器的日志上面。

### xss 攻击
- 输入的内容如果不是副文本，可疑标签可以直接去掉；如果是副文本，可以不管。
- session.http_only = 1;

### sql 注入
- 参数过滤（mysql 有一个函数，后来作废。因为在 mysqli 和 pdo 中有包含）
- 如果是 pdo,采用预定义的方式。如果是框架，可以具体看(medoo,有做预定义;tp3,有做预定义;yii2.0 也是在用；(在框架中查找 bindValue 即可找到))。
- 


### csrf
- 防盗链
- 表单的隐藏域

### 文件上传漏洞
- 初级校验，文件名后缀的检测（后缀名是可以轻易伪造的，文件内容也可以拼凑伪造）；
  
  如果一定要放在本地服务器上，进行目录的权限设置；
  
  可以用七牛，阿里云等远程服务器。


### 数据库的二进制位
- 类型可以定义为 varchar
- 类型最好定义为 bit


### ORM
- ORM：对象关系映射（Object Relational Mapping，简称ORM）,目的是想像操作对象一样操作数据库.因为数据库不是面向对象的,所以需要编程进行映射


### 支付过程中的网络抖动，用户重复提交
- 业务层面上，做一个倒计时的页面
- 可以加 redis 的锁



### Mysql 的交叉连接

#### 内连接--Inner Join

- Inner Join : 仅返回匹配的所有记录

#### 外连接--Outer Join

- Left Join : 返回匹配的所有记录和左表多余的记录
- Right Join : 返回匹配的所有记录和右表多余的记录

#### Full Join 和 Cross Join
- Full Join : 返回匹配的所有记录和左表多余的记录和右表多余的记录 (我在 mysql8.0.19 中测试，full join 是不存在的)
- Cross Join : 我在 mysql8.0.19 中测试，如果不加上 on 的条件，返回笛卡尔积；如果加上 on 的条件，仅返回匹配的所有记录。
               经过我简单的测试， cross join == inner join

- 写到这里，突然发现，Mysql 的交叉连接分类竟然有些混乱了。





### cluster index(聚集索引，聚簇索引，一个意思，不同的翻译而已)

- 聚簇索引的叶子节点存储的是数据行本身，而非指针（mysql的B+树索引，叶子节点存储的是数据行，所以叫聚簇索引（数据+索引），而B树索引存储的是数据行地址指针）


### 主键索引和唯一索引的区别

- 从特点上来说

2. 主键索引有唯一性，唯一索引不一定是主键
3. 主键索引不能为空，唯一索引可以为空
4. 一个表只能有一个主键，但是可以有多个唯一索引
5. 主键可以被其他表引用为外键，唯一索引列不可以

- 两者有本质的区别(主键创建的是聚集索引，其它索引创建的是非聚集索引)


### BST(Binary Search Tree)

- 如果数据是错乱的，效率挺高，时间复杂度是 log2N

  如果数据是规律的递增或者递减，就接近线性 N


### InnoDB 支持哈希索引吗？
- InnoDB用户无法手动创建哈希索引
- InnoDB会自调优(self-tuning)，如果判定建立自适应哈希索引(Adaptive Hash Index, AHI)能够提升查询效率，InnoDB自己会建立相关哈希索引，这一层上说，InnoDB又是支持哈希索引的;当业务有大量like或者join，AHI的维护反而可能成为负担，降低系统效率，此时可以手动关闭AHI功能。


### 使用varchar(20)存储手机号，不要使用整数

- 牵扯到国家代号，可能出现+/-/()等字符，例如+86
- 手机号不会用来做数学运算
- varchar可以模糊查询，例如like ‘138%’

- 为什么下列SQL不能命中phone索引？ select uid from user where phone=13811223344
   - 隐式类型转换会使索引失效，导致全表扫描

### char && varchar 
> https://baijiahao.baidu.com/s?id=1656246979336777711&wfr=spider&for=pc
- char 的范围是 0-255， varchar 的范围是 0-40 0000 0000
- char 指定大小 N，不够会补充空格,取用的时候会自动删掉空格；varchar 指定大小 N，然后会用额外的字节来标记大小
- 业务上，如果碰到变化不大的字符串字段，比如彩票号码等，就用 char,碎片较小，速度更快。如果变化很大，还是用 varchar 更好。



### 使用TINYINT来代替ENUM
- ENUM增加新值要进行DDL操作

### Mysql基础知识之简写

- 数据库查询语言（DQL）：select
- 数据库定义语言（DDL）：create database、drop database 、create table、drop table、alter
- 数据库操作语言（DML）：update 、insert 、delete

### 存储时间，应该用 datetime, timetamp, bigint ?
> https://www.ahfesco.com.cn/affairs/Article.asp?id=3106
- 尽量用 int 型
   1. 通用性 (avoid vendor lock-in)
   2. timetamp 截至日期是 2038
   3. timetamp 有时区的转换问题

- datetime,优点是展示方便，缺点是查询速度慢，通用性不如 int
- 类似的问题还有，存钱，是用 float,decimal, int ? 道理同上
   - float,double,是浮点型，decimal 是定点型，本质是存的是字符串
   - double 和 float 的区别是 double 精度高，有效数字16位，float精度 7 位。但 double 消耗内存是 float 的两倍，double 的运算速度比 float 慢得多


### 前缀索引

> https://www.cnblogs.com/michael9/p/13219915.html

### 覆盖索引

> https://www.jianshu.com/p/8991cbca3854

### redis 的持久花策略，rdb && aof
> https://blog.csdn.net/denghonghao/article/details/82108770


### redis key 的过期策略
> https://segmentfault.com/a/1190000020390847?utm_source=tag-newest
> https://blog.csdn.net/qq_28018283/article/details/80764518





### 58到家MySQL军规升级版
> https://mp.weixin.qq.com/s?__biz=MjM5ODYxMDA5OQ==&mid=2651961030&idx=1&sn=73a04dabca409c1557e752382d777181&chksm=bd2d031a8a5a8a0c6f7b58b79ae8933dfefbd840dfb5d34a5c708ab63e6decbbc1b13533ebc8&scene=21#wechat_redirect


### mysql 的锁
#### InnoDB 的七种锁
> https://mp.weixin.qq.com/s?__biz=MjM5ODYxMDA5OQ==&mid=2651961451&idx=1&sn=1bac366be5ad2dc721f79c9cb8e65e34&chksm=bd2d0db78a5a84a101e05a02e337fe91c3fd179132bced897156e1f34f0d0ba7e48dc89a1b95&scene=21#wechat_redirect


#### InnoDB
> https://mp.weixin.qq.com/s?__biz=MjM5ODYxMDA5OQ==&mid=2651961444&idx=1&sn=830a93eb74ca484cbcedb06e485f611e&chksm=bd2d0db88a5a84ae5865cd05f8c7899153d16ec7e7976f06033f4fbfbecc2fdee6e8b89bb17b&scene=21#wechat_redirect

- 普通锁（串行,太暴力，InnoDB 中没有使用）
- 读写锁（共享锁，读读并行；）
- 数据多版本（读写并行，解决排他锁的读写问题）
- 因为数据的多版本，InnoDB 的一般读都是快照读旧版本，没有锁，速度非常的快
- InnoDB 的锁，是建立在索引的基础上的，如果没有用上索引，就变成表锁了
- 互联网的业务，普遍是读写共存，优先默认 InnoDB

#### 乐观锁，悲观锁

- 乐观和悲观，是人为的定义。悲观锁就是当它操作一个资源的时候，直接上锁，其它事务不能操作它了。乐观锁，总是在假使其它事务没有操作此资源，
  但是在操作上也会有一个判断。

- 乐观锁的一个实现

   ```
   具体到这个case，只需要将：
   UPDATE t_yue SET money=$new_money WHERE uid=$uid;
   升级为：
   UPDATE t_yue SET money=$new_money WHERE uid=$uid AND money=$old_money;
   即可。
   
   ```
- 悲观锁的一个实现
   ```
   select * from table for update
   
   ```




### 分库分表

#### 简介和优点

> https://www.cnblogs.com/aksir/p/9085694.html

- 分表分为垂直分表，水平分表。垂直分表呢，可以将一些字段比较大的，不常用的字段给分出去，这样留下一个
  核心的，精简的字段，会提高很多的速度。

- 水平分表的拆分规则一般有：区间，hash 取模，地理（七牛云），时间，各有各自的场景和优劣吧。

- 分库的规则一般是根据业务来区分


#### 缺点

- sql 的书写，路由，结果的合并，比较麻烦（当然可以用一些中间件）
- 分布式的事务难度比较大
- 修改操作，group,order，join 等需要同步多张表，比较麻烦



### 空间复杂度 VS 时间复杂度
- 算法的复杂度是由空间和时间来综合决定的，当前普遍的做法一般还是用空间来换取时间的，因为硬件足够嘛
- 空间复杂度：一个算法临时占用存储空间大小的量度（计算机中一般指内存），S(n) = O(f(n)),冒泡排序：O(1);快排之递归:O(N)
- 时间复杂度：一个算法计算的次数（cpu 的计算速度很快，故只考虑次数），T(n) = O(f(n)),冒泡排序：O(n^2);快排之递归:O(logN/log2)


### self,static,this 的区别
- this 操作的是一般的变量或方法，随着调用的类而变化
- static 操作的是静态变量或方法，随着调用的类而变化
- self 操作的是静态变量或者方法，不随着调用的类而变化


### 折半查找

```

$arr = [1,20,30,40,50,60,70,80,90,100];

function search($arr,$a,$start,$end){

    if($end-$start = 1){
        if($a == $arr[$start]){
            return $start;
        }elseif($a == $arr[$end]){
            return $end;
        }else{
            return 'not in';
        }
    }
    $middle = floor(($start + $end)/2);
    if($a == $arr[$middle]){
        return $middle;
    }elseif($a > $arr[$middle]){
        $start = $middle + 1;
        return search($arr,$a,$start,$end);
    }elseif($a < $arr[$middle]){
        $end = $middle -1;
        return search($arr,$a,$start,$end);
    }
}

var_dump(search($arr,77,0,9));

```

### 索引失效的几种情况
- like 通配符在前面
- NULL 的字段
- 涉及有类型转换的
- 不等于操作符
- 索引字段上有计算的
- or 没有全部用的
- 全表扫描比索引更快的
- 组合索引，没有符合左前缀原则的


### 为什么 like 查询 % 在前为什么不走索引？

> https://cloud.tencent.com/developer/article/1460781

- mysql 的索引 B+tree ,排序为从左到右，所以有左前缀的原则。一开始就不确定，就不会走索引，而进行全表扫描。

- 我想了半天，不走索引和左前缀原则没有关系。真实的原因就是一开始就不确定，就不会走索引，而进行全表扫描。

### join 查询 && 子查询
- 都能用到索引，都比较慢。在一些高并发的场景下，都是不能用的。


### 事务的四种特性

1. 原子性(Atomicity)--事务是数据库的逻辑工作单位，事务中包含的各操作要么都做，要么都不做

2. 一致性(Consistency)--事务执行的结果必须是使数据库从一个一致性状态变到另一个一致性状态。因此当数据库只包含成功事务提交的结果时，就说数据库处于一致性状态。如果数据库系统 运行中发生故障，有些事务尚未完成就被迫中断，这些未完成事务对数据库所做的修改有一部分已写入物理数据库，这时数据库就处于一种不正确的状态，或者说是 不一致的状态。

3. 隔离性(Isolation)--一个事务的执行不能其它事务干扰。即一个事务内部的操作及使用的数据对其它并发事务是隔离的，并发执行的各个事务之间不能互相干扰。

4. 持续性(Durability)--也称永久性，指一个事务一旦提交，它对数据库中的数据的改变就应该是永久性的。接下来的其它操作或故障不应该对其执行结果有任何影响。

### mysql 的四种隔离级别
1. Read Uncommitted（读取未提交内容）
2. Read Committed（读取提交内容）
3. Repeatable Read（可重读）
4. Serializable（可串行化）


### 沈剑--锁系列
1. 挖坑，InnoDB的七种锁
   > https://mp.weixin.qq.com/s?__biz=MjM5ODYxMDA5OQ==&mid=2651961451&idx=1&sn=1bac366be5ad2dc721f79c9cb8e65e34&chksm=bd2d0db78a5a84a101e05a02e337fe91c3fd179132bced897156e1f34f0d0ba7e48dc89a1b95&mpshare=1&scene=23&srcid=0528ZFLBJmTD8g6qfXMRniI0&sharer_sharetime=1590645259275&sharer_shareid=8b16db2a5b4bd39db9019d06ff209f55#rd



### php-fig
- PHP FRAMEWORK INTEROP GROUP 
> https://www.jianshu.com/p/867014613a45


### PSR
- Php Standard Recommemdation
> https://www.jianshu.com/p/b33155c15343

#### 四套规范
- 1， 过程的代码标准
- 2， 对象的代码标准
- 3， 日志的接口标准
- 4， 自动加载的标准 


### tp3 和 tp5 的区别

- 自动加载的部分，tp3 是传统的 __autoload() 来做自动加载；tp5 是在 composer 的自动加载基础上做的封装。
- 路由的部分，tp5 既支持传统的路由方式，也支持路由文件来解耦的方式
- tp5 会用到一些新的设计理念，比如 IoC,facade,middleware 等



### IoC 的深入理解






## ing

### 中序查找
### 红黑树
### BTREE
### B+TREE
### B 树和 b+ 树的区别 b+ 树的优点
### B+树索引和hash索引的区别
### 数据库的乐观锁和悲观锁是什么
### 乐观锁实现原理，讲到一半，来写一个乐观锁吧
### 前缀树是什么？前缀树的使用场景？
### MySQL 死锁发生的原因和解决


### tcp 于 http 的关系，如何基于 tcp 实现 http
### Linux cpu 满了怎么排查？
### 怎么查看占 cpu 最多的线程？
### Linux怎么搜索文件中的字符串，写到另一个文件中
### liunx 网络相关命令
### Linux如何查看IO读写很高
### Linux中异步IO是如何实现的，消息队列如何实现的？


### redis分布式锁，其他实现方式，zookeeper如何实现的？
### 分布式的一致性，强一致性和最终一致性
### Redis持久化，“并发高，数据量小”和“并发低，数据量大”，redis怎么选择存储模式
### 缓存穿透，怎解决？
### Mysql主从复制原理，mysql中如何做故障转移（容灾）

### Nginx生命周期
### 负载均衡算法的实现

### 讲讲贪心算法
### 并发量很大，服务器宕机。你会怎么做？
### 如果线上用户出现502错误你怎么排查？
### swoole

### 策略模式
### IoC 的深入理解
