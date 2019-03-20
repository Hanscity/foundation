## SUMMARY

> SUCCESS IS NOT FINAL,FAILURE IS NOT FATAL,IT IS THE COURAGE TO 
CONTINUE THAT COUNTS                --WINSTON CHURCHILL


#### php主要用来干嘛？
1. 用作 Web服务器，现在用 php-fpm + Nginx的方式比较多。
2. 用作脚本，crond + php。
   
#### 一张重要的图
* Browser && App => web server => php => cache => mysql

##### web server
* 负载均衡
   * 当时 miqu的项目，有六台 web服务器，负载均衡是以什么规则来分配的呢？
   
##### php 
* Php7的性能更佳
* 类 C的框架性能更佳
* 主业务之外的逻辑，可以异步执行
* 简洁的思路，优越的算法

##### cache
* 静态变量存储结果
* 页面的静态化
* 内存的缓存

##### MySQL
* 符合基本的三范式，原子性，关联性，冗余性（看情况符合）
* 存储引擎的选择（InnoDB）
* 建立适当的索引
* 分区，分表，分库
* 读写分离
* 存储过程
* 硬件的升级
* myini的合理配置


#### MyIsam和 InnoDB的区别
* MyIsam：表锁，不支持事务，读取更快
* InnoDb：行锁，支持事务，5.5以后支持全文索引

#### 读写分离的优缺点
* 主库用来写入，从库用来读取。
* 优点：高并发的时候试用
* 缺点：主库同步从库的时候，有一定的时间差


#### Redis的优缺点
* 优点
   * 读写的性能非常高
   * 多种数据结构，操作简单实用，非常适合业务场景
   * 有数据落地服务
* 缺点
   * Redis需要准备的内存是实际缓存的两倍。Redis在主从复制的过程中，一般情况下是部分同步，当从库有波动，比如网络断掉的时候，会采取全量的同步。此时，主库会将所有的缓存写成一个文件，发送到从库，这个时候 Redis会使用掉实际缓存的两倍内存。
   * 当主库有波动的时候，会存在些许的数据不同步。
   
   
#### Redis的场景总结
1. 直连数据库，需要小心，当并发量非常高的时候，一个慢查询可能会引起雪崩，造成宕机，后果严重。（小红点）
2. 先更新数据库，后同步缓存。（案例：用户信息等）
   * 优点：数据非常的安全
   * 缺点：当并发特别高的时候，数据有些许的不准确
   
3. 先更新缓存，后通过脚本同步数据库（案例：排行榜等）
   * 优点：在并发非常高情况下，数据依然准确
   * 缺点：数据相对不安全，写脚本稍微麻烦
   
4. 更新缓存，写入数据，但彼此不同步（案例：新手充值大礼包）

5. 设计数据库的标志位来节省缓存（案例：用户的座驾信息）

   
#### Redis的 Key失效策略
1 定时（太影响性能，已被基本废弃）
2 定期（固定的时间来清理失效的 Key）
3 惰性（使用的时候来检查 Key是否失效）
* 一般的采取的是定期和惰性混合使用


#### cookie 和Session的区别和联系
* cookie：客户端，相对不安全，过期的时间策略是绝对时间
* session：服务端，相对安全，过期的时间策略是会话时间（即每一次使用之后，会重新的刷新）
* 联系：session会以 cookie的形式带上 SessionID

#### 500,502,503,504
* 背景：以 Nginx作为 web server,Php作为后台语言
* 500：服务器内部错误，一般是 Php出现了错误
* 502：Bad Gateway。Nginx和 Php-fpm之间以 fastcgi协议在通讯，如果 PHP向 Nginx回复的消息不是 Nginx想要的，Nginx就会返回 502的错误。简单点说，就是服务器挂了。
* 503：Service Unavailable,服务繁忙，请稍后重试。简单点说，就是并发太高，服务器相应不过来。（2019年曾经遇到过一个面试题，就是说，如果在 php.ini中将 Php的最大进程数设置为 1，此时同时有两个请求过来，会发生什么情况？）
* 504：Gateway Timeout。理论上来说，就是 Nginx设置了一个时间，如果服务器的响应超过了这个时间，就会返回这个错误信息。一般来说是 Nginx的配置错误。


#### Php5和 Php7的差别
1. PHP的运行环境加载完成之后，对内存的调用方式有很大不同
2. PHP5的对象不能调用静态变量，PHP7的对象可以调用静态变量。

#### md5和 sha1的加解密方式有何问题？
1. 现代计算机强大的计算能力，可以暴力的破解。
2. 解决方案，crpty()函数每次都生成随机的盐值。
3. 代码如下：
      ```   
      
        
        $user_input = 'ch001';
        $hashed_password = crypt($user_input); // 自动生成盐值
        var_dump($hashed_password);
        
        $judge_passwd = crypt($user_input, $hashed_password);
        var_dump($judge_passwd);
        
        /* 你应当使用 crypt() 得到的完整结果作为盐值进行密码校验，以此来避免使用不同散列算法导致的问题。（如上所述，基于标准 DES 算法的密码散列使用 2 字符盐值，但是基于 MD5 算法的散列使用 12 个字符盐值。）*/
        if (hash_equals($hashed_password, $judge_passwd)) {
            echo "Password verified!";
        }
      
      ```  
      
### LAMP和 LNMP的区别
#### http
* Hypertext transaction protocol(超文本传输协议)

#### web server
* 客户端访问 web server,如果是静态内容，则直接按照 http的协议直接返回。如果是动态内容，则由 web server和动态语言来进行通信。

##### CGI
* Common Gateway Interface(通用网关接口)，它描述了服务器和请求处理程序之间传输数据的一种标准。最初，CGI是在1993年由美国国家超级计算机应用中心（NCSA）为NCSA HTTPd Web服务器开发的。这个Web服务器使用了UNIX shell 环境变量来保存从Web服务器传递出去的参数，然后生成一个运行CGI的独立的进程。

* 

#### Apache和 Php的通信
1. 将 Php编译成 apache的模块、module模块化的方式进行工作(apahce默认的这种方式)。
2. CGI
3. Fast-CGI

#### Nginx和 Php的通信
1. Fast-CGI



#### 静态变量的初始化
* thinkphp中有一段代码令我非常不解，当时我在追查 C函数的用法，代码如下：
   ```   
   /**
    * 获取和设置配置参数 支持批量定义
    * @param string|array $name 配置变量
    * @param mixed $value 配置值
    * @param mixed $default 默认值
    * @return mixed
    */
   function C($name=null, $value=null,$default=null) {
       if($name == 'VAR_PATHINFO'){
           var_dump(__FILE__);
           var_dump(strpos($name,'.'));
       }
   
       static $_config = array();
       if($name == 'VAR_PATHINFO'){
           var_dump($_config);## 竟然不是空数组，值从哪里来啊？？
           exit;
       }
       //.....
    }
   
   ```
   
* 静态变量只会初始化一次，作用域在方法或者对象,在一次请求内值都会保留。（在一次面试中，面试官也问到了如何静态变量的问题；上面的疑问，我最终怀疑到作用域的问题上的，不然无法解释啊。）

* 应用如下：
   ``` 
   function countNum(){##可以统计函数被调用的次数
        $static $initNum = 0;
        return ++$initNum;
   }
   var_dump(countNum());
   var_dump(countNum());
   var_dump(countNum());
   var_dump(countNum());
   
   ```
   
#### Json
* 进入一家公司后，再次使用 Json 数据协议来写接口，移动端的妹子说这个接口的数据中的某一段一定要是对象，不能是数组。此时，我才意识到，啥时候是对象，啥时候是数组呢。请看[阮一峰之数据类型和Json格式](http://www.ruanyifeng.com/blog/2009/05/data_types_and_json.html)


#### Mysql 的数据库表连接
* 曾看过很多的资料，断断续续，反反复复，原来未全明白。请看[阮一峰之数据库表连接的简单解释](http://www.ruanyifeng.com/blog/2019/01/table-join.html?20190319195007#comment-last)


