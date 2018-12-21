## Php的类


### 第一章：简介
* Php5重写了类，才有了现在完整的特性。Php7得以继承。

### 第二章：基本概念
* 类有固定的格式，包含属性和方法。
* $this伪变量的理解。
   ```
   /**
    * Class A
    * 这一段主要是学习 $this到底是啥，这些类可以看出 $this的变化
    * $this其实是可以调用静态变量的，在非静态的方法中
    * $this不能使用在静态方法中
    *
    */
   class A{
   
       public static $name = 'noodles';
       public function judgeThis(){
   
           if($this){
               return $this;
   
           }else{
               return 'empty';
           }
       }
   
       public function getVarThis(){
           return $this::$name;
       }
   
       public function getVarObject(){
           return A::$name;
       }
   
       public function getVarSelf(){
           return self::$name;
       }
   
   }
   
   class B extends A{
   
   }
   
   
   /**
   * Class D
   * 单例模式，但是语法错误
   * 错误的原因是 $this不能使用在静态方法中
   */
  class D{
      //声明一个静态变量（保存在类中唯一的一个实例）
      private  $instance = null;
      //声明一个getinstance()静态方法，用于检测是否有实例对象
      public static function getInstance()
      {
          if (is_null($this->instance)) {
              self::$instance = new self ();
          }
          return self::$instance;
      }
  }
   
   
  ```



































> 资料

[PHP官方中文手册](http://php.net/manual/zh/oop5.intro.php)