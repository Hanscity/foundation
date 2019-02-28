## Basic(基本语法)

### isset和 is_null
   1. isset : 变量未申明，或者只是申明，或者定义的值为 NULL，为假;反之，定义的值有且不为 NULL，为真。严格来说，isset不是一个函数，而是一个结构。
   2. is_null : 变量未申明，或者只是申明，或者定义的值为 NULL，为真；反之，定义的值有且不为 NULL，为假。严格的模式下不申明，会报 NOTICE的错误。
   

### try..catch 的理解
   * 什么是异常？从主观上说，一种是主观逻辑认定的异常，一种是系统认定的异常。
      ```   
      /**
       * @param $number
       * @return bool
       * @throws Exception
       * 这就是主观逻辑上认定的异常
       */
      function checkNum($number)
      {
          if($number>1)
          {
              throw new Exception("Value must be 1 or below");
          }
          return true;
      }
      
      //在 "try" 代码块中触发异常
      try
      {
          checkNum(2);
          //If the exception is thrown, this text will not be shown
          echo 'If you see this, the number is 1 or below';
      }
  
      //捕获异常
      catch(Exception $e)
      {
          echo 'Message: ' .$e->getMessage();
      }
      
      
              
       //类似于这种，操作数据库的异常,属于系统认定的异常
       $transaction = \Yii::$app->db->beginTransaction();
       try {
           $transaction->commit();
           $actionComplete = true;
       } catch (\Exception $e) {
           $transaction->rollBack();
           $actionComplete = false;
           LoggerUtils::error('添加Cp数据失败=>' . $e->getMessage(), 'addcpInfo.log');
       } 

        
      ```
      
* 自定义的异常
   ```     
  
    /**
    * Class customException
    * 这个自定义的异常类涉及到几个知识点
    * 1. class customException extends Exception 在没有命名空间的文件中，Exception就是 Core_c.php文件中 Php扩展类 Exception
    * 写成 class customException extends \Exception这样更好。在有命名空间的文件中，都是采取的这种写法。
    *
    * 2. extends继承，从文件的角度上来看，就是将被继承的类的代码引用到了当前类中。这个例子，就是 customException类拥有了 \Exception类的代码。那么 $this优先在 customException类中寻找，找不到，就去 \Exception类中寻找调用。
    */
    
    class customException extends Exception
    {
      public function errorMessage()
      {
          //error message
          $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
              .': <b>'.$this->getMessage().'</b> is not a valid E-Mail address';
          return $errorMsg;
      }
    }
    
    $email = "someone@example...com";
    
    try
    {
      //check if
      if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
      {
          //throw exception if email is not valid
          throw new customException($email);
      }
    }
    
    catch (customException $e)
    {
      //display custom message
      echo $e->errorMessage();
    }



   ```
   

### instanceof
   0. 实例
   1. 类
   2. 继承类
   3. 对象
   4. 接口
   5. 与类或者接口同名的变量
   6. 注意一些特殊使用和异常的兼容
   
   
### use

   [from manual](http://php.net/manual/zh/language.oop5.traits.php)
   ```     
   Note that the "use" operator for traits (inside a class) and the "use" operator for namespaces (outside the class) resolve names differently. "use" for namespaces always sees its arguments as absolute (starting at the global namespace):
   
   <?php
   namespace Foo\Bar;
   use Foo\Test;  // means \Foo\Test - the initial \ is optional
   ?>
   
   On the other hand, "use" for traits respects the current namespace:
   
   <?php
   namespace Foo\Bar;
   class SomeClass {
       use Foo\Test;   // means \Foo\Bar\Foo\Test
   }
   ?>
   
   Together with "use" for closures, there are now three different "use" operators. They all mean different things and behave differently.
   
   ```
   
   
 ### PHP_EOL and "</br>" 的区别
 1. 命令行用 PHP_EOL，浏览器用 "</br>"
    
 
 ### 关于数组的一些方法--current,next,prev,reset,key
    ```
    $array = array('step one', 'step two', 'step three', 'step four');
    
    // by default, the pointer is on the first element
    echo current($array) . "<br />\n<br \>"; // "step one"
    
    // skip two steps
    next($array);
    next($array);
    echo current($array) . "<br />\n<br \>"; // "step three"
    echo prev($array) . "<br />\n<br \>"; //step two
    
    // reset pointer, start again on step one
    reset($array);
    echo current($array) . "<br />\n<br \>"; // "step one"
       
    ```
 
 ### sleep() and usleep()
 * sleep(),程序延迟执行指定的 seconds 的秒数。 
 * usleep(),以指定的微秒数延缓程序的执行。 1微秒（micro second）是百万分之一秒。 
 
 
 ### ThinkPhp 3.2.3
 #### ThinkPHP.php文件中涉及到的函数
 ##### microtime()
 * 基本用法
    ``` 
    var_dump(microtime());## "0.04074600 1551341184"
    var_dump(microtime(TRUE));## float(1551341184.0408)
    
    ```
    
 * 用 microtime() 对脚本的运行计时
    ```   
    /**
     * 方法一
     */
    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
    
    $time_start = microtime_float();
    
    // Sleep for a while
    usleep(100);
    
    $time_end = microtime_float();
    $time = $time_end - $time_start;
    
    echo "Did nothing in $time seconds\n";
    
    echo '------------------------------------------------------------';
    /**
     * 方法二
     * 很显然，方法二就是你想要的。一个是省去了 list()的时间，更加精确。一个是简单。
     */
    $time_start = microtime(TRUE);
    // Sleep for a while
    usleep(100);
   
    $time_end = microtime(TRUE);
    $time = $time_end - $time_start;
    
    echo "Did nothing in $time seconds\n";
    exit;
    
    ```
    
    
 ##### function_exists()
 * 在已经定义的函数列表（包括系统自带的函数和用户自定义的函数）中查找 function_name。 如果给定的函数已经被定义就返回 TRUE 
 
 
 ##### memory_get_usage()
 * 如果设置为 TRUE，获取系统分配总的内存尺寸，包括未使用的页。如果未设置或者设置为 FALSE，仅仅报告实际使用的内存量。 
 * Note: PHP 不跟踪非emalloc() 分配的内存
 * miqu 开始的 protobuf 协议编译为一个文件的时候，PHP7 对这个超大对象的读取达到了内存的上限，当时可以用这个函数来查看一下的。
 
 
 ##### define() and defined()
 * define()是对常量的定义，defined()是对常量定义的判断
 
 
 ##### $_SERVER
* 服务器和执行环境信息

##### dirname()
* 返回路径中的目录部分

##### realpath()
* 返回规范化的绝对路径名


##### version_compare()
* 对比两个「PHP 规范化」的版本数字字符串

##### strstr()
* strstr ( string $haystack , mixed $needle 
[, bool $before_needle = FALSE ] ) : string
* 若 $before_needle = FALSE,返回 haystack 字符串从 needle 第一次出现的位置开始到 haystack 结尾的字符串。 若为 TRUE，strstr() 将返回 needle 在 haystack 中的位置之前的部分。 
* 该函数区分大小写。如果想要不区分大小写，请使用 stristr()。 
* 如果你仅仅想确定 needle 是否存在于 haystack 中，请使用速度更快、耗费内存更少的 strpos() 函数。
 
##### strpos()
* strpos ( string $haystack , mixed $needle [, int $offset = 0 ] ) : int
* 返回 needle 存在于 haystack 字符串起始的位置(独立于 offset)。同时注意字符串位置是从0开始，而不是从1开始的。 所以判断需要加上绝对的判断


##### trim()
* 此函数返回字符串 str 去除首尾空白字符后的结果。如果不指定第二个参数，trim() 将去除这些字符： 

##### rtrim()

* 该函数删除 str 末端的空白字符（或者其他字符）并返回。不使用第二个参数，rtrim() 仅删除以下字符： 

##### str_replace
