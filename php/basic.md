## Basic(基本语法)

* isset和 is_null
   1. isset : 变量未申明，或者只是申明，或者定义的值为 NULL，为假;反之，定义的值有且不为 NULL，为真。严格来说，isset不是一个函数，而是一个结构。
   2. is_null : 变量未申明，或者只是申明，或者定义的值为 NULL，为真；反之，定义的值有且不为 NULL，为假。严格的模式下不申明，会报 NOTICE的错误。
   

* try..catch 的理解
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
   

* instanceof
   0. 实例
   1. 类
   2. 继承类
   3. 对象
   4. 接口
   5. 与类或者接口同名的变量
   6. 注意一些特殊使用和异常的兼容
   
   
* use

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