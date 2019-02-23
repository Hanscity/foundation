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
      

   
   
