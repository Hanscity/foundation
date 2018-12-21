## 单例模式

```   

    /**
    * Class A
    * 这种单例模式，不好用，不方便。
    */
   class A{
   
       private $instance;
       public function getInstance(){
           if(empty($this->instance)){
               return $instance = new self();
           }
           return $this->instance;
       }
   }
   
   /**
    * Class B
    * 这种单例模式，使用静态方法，使用方便
    * isset的用法
    */
   class B{
   
       private static $instance;
       public static function getInstance(){
           if(!isset(self::$instance)){
               return self::$instance = new self ();
           }else{
               return self::$instance;
           }
       }
   }
   
   /**
    * Class C
    * 这种单例模式，使用静态方法，使用方便
    * is_null的用法
    */
   class C{
   
       //声明一个静态变量（保存在类中唯一的一个实例）
       private static $instance = null;
       //声明一个getinstance()静态方法，用于检测是否有实例对象
       public static function getInstance()
       {
           if (is_null(self::$instance)) {
               self::$instance = new self ();
           }
           return self::$instance;
       }
   
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