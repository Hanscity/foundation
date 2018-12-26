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