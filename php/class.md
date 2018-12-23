## Php的类


### 第一章：简介
* Php5重写了类，才有了现在完整的特性。Php7得以继承。

### 第二章：基本概念
* 类有固定的格式，包含常量，变量（属性）和方法。
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


### 第三章：属性
* 由 public,protected,private开头，加上一个变量名称组成。这是标准的用法。


### 第四章：常量
* 常量由 const加上变量名组成，变量名可以大写，可以小写。这一点没有明文规定，但是最好是大写。

* 使用及细节如下：
   ```   
        
    /**
     * Class A
     * 常量可以放在普通方法中，也可以放在静态方法中
     * 常量可以用 self来调用，可以用 类来调用，不能用 $this来调用
     * 可以用对象来调用，可以用 类名来调用（Php5.3 以后）
     */
    class A{
        const TABLE_NAME = 'VINIA';
    
        public function getConstSelf(){
            return self::TABLE_NAME;
        }
    
        public function getConstClass(){
            return A::TABLE_NAME;
        }
    
        public function getConstThis(){##不能成功，虽然不报错
            return $this->TABLE_NAME;
        }
    
        public static function getConstSelfStatic(){
            return self::TABLE_NAME;
        }
    }
    //对象来调用
    $aModel = new A();
    var_dump($aModel::TABLE_NAME);
    echo '</br>';
    //类名来调用
    $name = 'A';
    var_dump($name::TABLE_NAME);
    echo '</br>';
    
    
    
    
    /**
     * Class dbObject
     * 这涉及到几个知识点，
     * 1：常量可以被覆盖
     * 2：get_called_class函数的使用，得到当前的类名
     * 3：类名来调用常量（Php5.3 以后）
     */
    abstract class dbObject
    {
        const TABLE_NAME='undefined';
    
        public static function GetAll()
        {
            $c = get_called_class();
            return "SELECT * FROM `".$c::TABLE_NAME."`";
        }
    }
    
    class dbPerson extends dbObject
    {
        const TABLE_NAME='persons';
    }
    
    class dbAdmin extends dbPerson
    {
        const TABLE_NAME='admins';
    }
    
    echo dbPerson::GetAll()."<br>";//output: "SELECT * FROM `persons`"
    echo dbAdmin::GetAll()."<br>";//output: "SELECT * FROM `admins`"

   
   ```


























> 资料

[PHP官方中文手册](http://php.net/manual/zh/oop5.intro.php)