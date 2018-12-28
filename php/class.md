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


## 类的自动加载

* Php进入 OOP（Object Orient Progamming）的编程模式之后，自动加载变得必不可少。或者你可以将一个个的类文件
放入一个大文件中，一次引入进来。也不是不可以，但是这样做，随着时间的推移，这个文件有可能变得非常大。我在工作
中正好遇见了这种情况，当时是 Protobuf协议文件的编译成一个文件，最后这个文件有 60W行代码。随着不断的增大，这个对象已经变得巨大。Php7相对于 Php5等的一个优化是，一次性给一个大约 2G的内存，不用每次都请求都给一些。而这个巨无霸对象达到了 Php7的临界值，整个程序一开始就耗掉了所有的内存，然后 Php7每次的请求运行需要再向系统层再次请求内存。如果有一点点的并发，系统即将瘫痪。

   ```    
   class SiteController extends Controller {
   
       public $layout = false; //关闭布局
       public $enableCsrfValidation = false; //关闭crsf验证
       public $cur_version = 1;
   
       public function init() {
            //Protobuf编译成一个文件，引入即好。这是之前的写法
            //$lib_protobuf = Yii::getAlias("@common/proto");
            //include $lib_protobuf . '/pb_proto_miqu.php';
            //新版本协议
            CommUtils::autoLoadClass();
       }
    }
    
    
   class CommUtils{
 
       /**
        * 注册 autoload 函数
        * 这里涉及到两个小知识点
        * 1. 类名::class 可以取到 命名空间的类名
        * 2. spl_autoload_register有数组的用法，数组的第一个参数也可以有两种，一种是类名，一种是对象
        */
       public static function autoLoadClass(){
           spl_autoload_register([CommUtils::class,'loadProtobufClass']);
       }
   
       /**
        * 加载 Protobuf 协议类文件
        * @param $className
        */
       protected static function loadProtobufClass($className){
           # 协议类地址
           $classDirPath = Yii::getAlias("@common/protobuf_msg");
   
           $classPath = "{$classDirPath}/{$className}.php";
           if(file_exists($classPath)){
               include_once $classPath;
           }
       }
   }
   
   ```


## 构造函数和析构函数
* Php5开始有了构造函数。具有构造函数的类在每一次创建对象时先调用构造函数，所以非常适合用来做一些初始化的工作。
* 父类有构造函数的情况下，如果子类没有构造函数，初始化子类会隐式的调用父类的构造函数；如果子类有构造函数，
初始化子类则会调用自己的构造函数，而不会去隐式的调用父类的构造函数，除非在子类的构造函数中显式的调用。
* 构造函数也有调用的权限问题
* 构造函数在 Php5.3.3以前的 Php5版本中，与类名一致的方法默认是构造函数，在后来的 Php版本中且有命名空间的情况下，不再作为构造函数。这是一个兼容性的问题。
* 析构函数，反之。析构函数中抛出异常会引起致命的错误。



























> 资料

[PHP官方中文手册](http://php.net/manual/zh/oop5.intro.php)