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


### 第四章：类常量
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
     * * get_called_class函数的使用，得到当前的类名
     * * 类名来调用常量（Php5.3 以后）
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
    
    
    
    /**
     * Class MyClass
     * 类常量的用法和静态变量的用法基本一致，可以用在类中，抽象类中，子类中，普通方法中，静态方法中。
     * 可以被类名，类名变量，实例(对象)，self,static调用（self 和 static 的区别也是一致）
     * 这两者的最大区别，来自定义。类常量不能被重新赋值，静态变量可以被重新赋值。
     * 当然，在同一个类中，重复定义，都是不好的。在不同类中，都是可以重复定义的。
     */
    class MyClass{
    
        const ONE_CONST = 'NOODLES';
        public static $className = 'xining';
        public function getConst(){
    
            return static::ONE_CONST;## self和 static是不同的
        }
    
        public function __construct($name){
    
            self::$className = $name;## 静态变量可以被重新赋值
            //self::ONE_CONST = $name;## 类常量不能被重新赋值
        }
    }
    
    class SecondClass extends MyClass {
    
        const ONE_CONST = 'CH';
    }
    
    $oneClass = new SecondClass('xining');
    echo $oneClass->getConst();

        
        
    /**
     * Class SomeClass
     * 
     */
    class SomeClass{
        PUBLIC STATIC $staticVari = 'static vari';
    }
    
    interface SomeInterface{
        const SOME_CONST = 'CH';## 接口中可以定义类常量，但是不能定义静态变量
    }
    
    trait SomeTrait{
        PUBLIC STATIC $staticVari = 'static vari';## trait中可以定义静态变量，但是不能定义常量
    }
    
    var_dump(new class(10) extends SomeClass implements SomeInterface{
        //const SOME_CONST = 'CH';
        use SomeTrait;
        private $num= null;
        public function __construct($num)
        {
            $this->num = $num;
            var_dump($this->num);
            var_dump(self::SOME_CONST);
        }
    
    });
    
    
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
* 构造函数，有访问的控制。
* 析构函数，反之。析构函数中抛出异常会引起致命的错误。
## 访问控制--visibilty
* 为什么要有访问控制？提供完整的封装对象以作接口使用，对一些属性和方法做出限制是比较好的做法。

* public：类，子类，对象都可以访问；protected：类，子类可以访问，对象不能访问；private：类可以访问，子类和对象不能访问。对象和方法都是如此，这就是访问控制的主要内容。

* 不同访问控制下的可覆盖性,在 Php7中，都是可以覆盖的。属性和方法都一样。

   ```
   /**
    * Define MyClass
    */
   class MyClass
   {
       public $public = 'Public';
       protected $protected = 'Protected';
       private $private = 'Private';
   
       public function printPublic(){
           echo $this->public;
       }
   
       protected function printProtected(){
           echo $this->protected;
       }
   
       private function printPrivate(){
           echo $this->private;
       }
   
       public function printHello()
       {
           $this->printPublic();
           $this->printProtected();
           $this->printPrivate();
       }
   }
   
   
   /**
    * Define MyClass2
    */
   class MyClass2 extends MyClass
   {
       // 可以对 public 和 protected 和 private 的属性进行重定义
       //这里需要小心，PHP的官方手册认为 Private属性是不可以重定义的，嗯，手册上说明的应该是 PHP5版本吧
       public $public = 'Public2';
       protected $protected = 'Protected2';
       private $private = 'Private2';
   
       // 可以对 public 和 protected 和 private 的方法进行重定义
       public function printPublic(){
           echo $this->public;
       }
   
       protected function printProtected(){
           echo $this->protected;
       }
   
       private function printPrivate(){
           echo $this->private;
       }
   
       public function printHello()
       {
           $this->printPublic();
           $this->printProtected();
           $this->printPrivate();
       }
   
   }
   
   $obj2 = new MyClass2();
   $obj2->printHello(); // 输出 Public、Protected2 和 Undefined
   
   
   ```


## 对象继承
* 从文件的角度来看，继承是文件中内容的引入。$this在本类中找不到，会去父类
中去寻找。如果知道需要去父类中寻找，用 parent是更好的选择。

* 多重继承，代码如下：
   ```   
       
    /**
     *
     * Here is some clarification about PHP inheritance – there is a lot of bad information on the net.
     * PHP does support Multi-level inheritance.
     * (I tested it using version 5.2.9).  It does not support multiple inheritance.
     * This means that you cannot have one class extend 2 other classes (see the extends keyword).
     * However, you can have one class extend another, which extends another, and so on.
    
     */
    class A {
        // more code here
    }
    
    class B extends A {
        // more code here
    }
    
    class C extends B {
        // more code here
    }
    
    
    $someObj = new A();  // no problems
    $someOtherObj = new B(); // no problems
    $lastObj = new C(); // still no problems

   
   ```

## 范围解析操作符 ::
* 当一个子类覆盖其父类中的方法时，PHP 不会调用父类中已被覆盖的方法。是否调用父类的方法取决于子类。这种机制也作用于构造函数和析构函数，重载以及魔术方法。

## static（静态）关键字
* 类名，对象，self,parent,可以调用静态属性和方法，伪变量 $this不能用来调用静态变量。在 PHP5中，对象不能调用静态属性，可以调用静态方法，这也是 PHP5和PHP7的一个不同之处。

* static和self的调用
   ```    
       
    /**
     * Class a
     * self,是指此时的属性和方法
     * static，是指当前被调用类的属性和方法
     */
    class a{
    
        static protected $test="class a";
    
        public static function getTestVariable(){
    
            return self::$test;
        }
        public function static_test(){
    
            echo static::$test; // Results class b
            echo self::$test; // Results class a
            echo static::getTestVariable();// Results class b
            echo self::getTestVariable();// Results class a
        }
    
    
    
    }
    
    class b extends a{
    
    
        static protected $test="class b";
    
        public static function getTestVariable(){
    
            return static::$test;
        }
    
    }
    
    $obj = new b();
    $obj->static_test();

   
   ```
   
* 静态变量的缓存数据，维护静态类缓存
   ```   
   //缓存数据 - 维护静态类缓存
   protected static $_CpInfoList = [];
   
   //获取用户信息cp 信息
   public function getUserCpInfo($fromUid) {
       $key = $this->getUserCpInfoKey($fromUid);

       if(! empty(self::$_CpInfoList[$key])){  
           #已经查询过 Redis Cp Info List缓存
           return self::$_CpInfoList[$key];        #返回 Redis Cp Info List数据
       }

       $HashArray = \Yii::$app->redis_two->executeCommand('HGETALL', [$key]);
       if (empty($HashArray)) {
           $userCpInfo = $this->reloadUserCpInfo($fromUid);
       } else {
           $userCpInfo = CommUtils::getArrayByHash($HashArray);
       }
       if (!isset($userCpInfo['uid_one'])) {
           $userCpInfo = [];
       }
       if(! empty($userCpInfo)){
           self::$_CpInfoList[$key] = $userCpInfo; //不为空 写入静态类缓存
       }
       return $userCpInfo;
   }
   
   //重新加载到缓存
   public function reloadUserCpInfo($uid) {
       $uid_key = $this->getUserCpInfoKey($uid);
       $fromCpInfo = $this->_getUserCpInfo($uid);
       if (empty($fromCpInfo)) {
           $fromCpInfo = [
               'begin_cp_time' => '0000-00-00 00:00:00'
           ];
       }else{
           self::$_CpInfoList[$uid_key] = $fromCpInfo;  // 重载时缓存
       }
       RedisService::del(self::getRedisSource(), $uid_key);
       RedisService::hmset(self::getRedisSource(), $uid_key, $fromCpInfo, (RD_THREE_DAY_EXPIRE+3600));

       return $fromCpInfo;
   }
   
   
   ```

## 抽象类

* 任何一个类，如果它里面至少有一个方法是被声明为抽象的，那么这个类就必须被声明为抽象的。

* 如果一个子类继承了抽象类，那么这个子类的可访问控制和函数的参数可以比抽象类宽松。


## 对象接口

* 接口对象里面的必须都是抽象方法，并且这些方法必须一一实现，如果一个类实现（implement）这个接口的话。

* 这些抽象方法的访问控制必须是 public

* 一个类可以同时实现多个接口，用逗号（,）隔开

* 这个例子来自手册，写的比较好，代码如下
   ```  
   
    
    /**
     * An example of duck typing in PHP
     */
    
    interface CanFly {
        public function fly();
    }
    
    interface CanSwim {
        public function swim();
    }
    
    class Bird {
        /**
         * 这又涉及到了 $this->name的用法
         * 如果子类有，则调用子类的；如果子类没有，则调用父类的。
         * 这个例子比较特殊，下面都将此类当做父类使用。父类没有，子类有。所以不能单独实例化此父类。
         * 从例外一个角度来说，这个类设计的不好。
         */
        public function info() {
            echo "I am a {$this->name}\n";
            echo "I am an bird\n";
        }
    
        /**
         * @var null
         * 这样子的设计才比较好吧。可以避免某些错误的发生。
         */
        public $obj_name = null;
        public function infoDesignTwice(){
            if($this->obj_name){
                echo "I am a {$this->obj_name}\n";
                echo "I am an bird\n";
            }
        }
    }
    
    /**
     * some implementations of birds
     */
    class Dove extends Bird implements CanFly {
        var $name = "Dove";
        public function fly() {
            echo "I fly\n";
        }
    }
    
    class Penguin extends Bird implements CanSwim {
        var $name = "Penguin";
        public function swim() {
            echo "I swim\n";
        }
    }
    
    class Duck extends Bird implements CanFly, CanSwim {
        var $name = "Duck";
        public function fly() {
            echo "I fly\n";
        }
        public function swim() {
            echo "I swim\n";
        }
    }
    
    /**
     * @param $bird
     */
    function describe($bird) {
        if ($bird instanceof Bird) {
            echo 1;
            $bird->info();
            if ($bird instanceof CanFly) {
                echo 2;
                $bird->fly();
            }
            if ($bird instanceof CanSwim) {
                echo 3;
                $bird->swim();
            }
        } else {
            die("This is not a bird. I cannot describe it.");
        }
    }
    
    // describe these birds please
    describe(new Penguin);
    echo "---\n";
    
    describe(new Dove);
    echo "---\n";
    
    describe(new Duck);
   
   ```

## trait（特性）
* trait是为了在水平结构上复用代码

* 一些代表性的代码如下，基本 copy自官方手册，有少许修改
   ```   
       
    /**
     * Trait A
     * 可以同时使用多个 trait，并且如何解决同名的冲突，远不止冲突这么简单，而是直接报错
     */
    trait A {
        public function smallTalk() {
            echo 'a';
        }
        public function bigTalk() {
            echo 'A';
        }
    }
    
    trait B {
        public function smallTalk() {
            echo 'b';
        }
        public function bigTalk() {
            echo 'B';
        }
    }
    
    class Talker {
        use A, B {
            B::smallTalk insteadof A;
            A::bigTalk insteadof B;
        }
    }
    
    class Aliased_Talker {
        use A, B {
            B::smallTalk insteadof A;
            A::bigTalk insteadof B;
            B::bigTalk as public talk;## as可以设置别名，亦可以设置访问控制
        }
    }
    
    class TalkerConflict{
    
        use A;
        use B;
    
    }
    /*$talker = new Aliased_Talker();
    $talker->smallTalk();
    $talker->bigTalk();
    $talker->talk();*/
    
    try{
        $talkerCon = new TalkerConflict();
        $talkerCon->bigTalk();
        $talkerCon->smallTalk();
    }catch(\Exception $e){
        echo $e->getMessage();
    }
    
    
    
    /**
     * Trait PropertiesTrait
     * PHP7中，属性可以重复定义，但必须完全一致。
     */
    trait PropertiesTrait {
        public static $x = 1;
    }
    
    class PropertiesExample {
        use PropertiesTrait;
        public static $x = 1;
    }
    
    $example = new PropertiesExample;
    var_dump($example::$x);
    
    
    /**
     * Class Base
     * Php7中，方法可以重复定义，不必保持一致。
     */
    class Base {
        public function sayHello() {
            echo 'Hello ';
        }
    }
    
    trait SayWorld {
        public function sayHello() {
            parent::sayHello();
            echo 'World!';
        }
    }
    
    class MyHelloWorld extends Base {
        use SayWorld;
        public function sayHello() {
            echo 'Hello,Ch.. ';
        }
    }
    
    $o = new MyHelloWorld();
    $o->sayHello();
   
   ```

## 匿名类
* PHP7开始，才有匿名类

## 重载

* 属性重载

   ```   
   
    /**
     * Class PropertyTest
     * 魔术方法，在一定的情况下触发
     * __set(),__get(),
     * __isset(),__unset(),
     * __set(),__get(),在框架的 model层，有写这个方法。
     */
    class PropertyTest {
        /**  被重载的数据保存在此  */
        private $data = array();
    
    
        /**  重载不能被用在已经定义的属性  */
        public $declared = 1;
    
        /**  只有从类外部访问这个属性时，重载才会发生 */
        private $hidden = 2;
    
        public function __set($name, $value)
        {
            echo "Setting '$name' to '$value'\n";
            $this->data[$name] = $value;
        }
    
        public function __get($name)
        {
            echo "Getting '$name'\n";
    
            if (array_key_exists($name, $this->data)) {
                return $this->data[$name];
            }
    
            $trace = debug_backtrace();
            trigger_error(
                'Undefined property via __get(): ' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
                E_USER_NOTICE);
            return null;
        }
    
        /**  PHP 5.1.0之后版本 */
        public function __isset($name)
        {
            echo "Is '$name' set?\n";
            return isset($this->data[$name]);
        }
    
        /**  PHP 5.1.0之后版本 */
        public function __unset($name)
        {
            echo "Unsetting '$name'\n";
            unset($this->data[$name]);
        }
    
        /**  非魔术方法  */
        public function getHidden()
        {
            return $this->hidden;
        }
    }
    
    
    class A{
    
    }
    
    
    echo "<pre>\n";
    
    $obj = new PropertyTest;
    
    $obj->a = 1;
    echo $obj->a . "\n\n";
    
    var_dump(isset($obj->a));
    unset($obj->a);
    var_dump(isset($obj->a));
    echo "\n";
    
    echo $obj->declared . "\n\n";
    
    echo "Let's experiment with the private property named 'hidden':\n";
    echo "Privates are visible inside the class, so __get() not used...\n";
    echo $obj->getHidden() . "\n";
    echo "Privates not visible outside of class, so __get() is used...\n";
    echo $obj->hidden . "\n";
    
    
    $a = new A;
    var_dump(isset($a->a));
    echo "\n";
   
   ```                


* 方法重载
   ```   
    class MethodTest
    {
        public function __call($name, $arguments)
        {
            // 注意: $name 的值区分大小写
            echo "Calling object method '$name' "
                . implode(', ', $arguments). "</br>";
        }
    
        /**  PHP 5.3.0之后版本  */
        public static function __callStatic($name, $arguments)
        {
            // 注意: $name 的值区分大小写
            echo "Calling static method '$name' "
                . implode(', ', $arguments). "</br>";
        }
    
        protected function runTest($a){
            echo $a."</br>";
        }
    
    }
    
    $obj = new MethodTest;
    $obj->runTest('in object context');
    
    MethodTest::runTest('in static context');  // PHP 5.3.0之后版本
       
       
   ```

## 遍历对象
* foreach可以遍历对象
   ```   
   class MyClass
   {
       public $var1 = 'value 1';
       public $var2 = 'value 2';
       public $var3 = 'value 3';
   
       protected $protected = 'protected var';
       private   $private   = 'private var';
   
       function iterateVisible() {
          echo "MyClass::iterateVisible:\n";
          foreach($this as $key => $value) {
              print "$key => $value\n";
          }
       }
   }
   
   $class = new MyClass();
   
   foreach($class as $key => $value) {
       print "$key => $value\n";
   }
   echo "\n";
   
   $class->iterateVisible();
   ```
   
* SPL扩展，生成器，可以用来定义 Interators

## 魔术方法
* __construct
* __destruct
* __call
* __callStatic
* __set
* __get
* __isset
* __unset
* __toString
* __invoke
* __clone
   ```   
       
    /**
     * Class SubObject
     * clone
     * 这里的 clone涉及到了几个知识点
     * 1. 对象的复制
     * 2. 魔术方法 __clone()的使用
     * 3. 普通变量和静态变量的理解
     *
     */
    class SubObject
    {
        static $instances = 0;
        public $instance;
    
        public function __construct() {
            $this->instance = ++self::$instances;
        }
    
        public function __clone() {
            $this->instance = ++self::$instances;
        }
    }
    
    class MyCloneable
    {
        public $object1;
        public $object2;
    
        function __clone()
        {
    
            // 强制复制一份this->object， 否则仍然指向同一个对象
            $this->object1 = clone $this->object1;
        }
    }
    
    $obj = new MyCloneable();
    
    echo SubObject::$instances;
    $obj->object1 = new SubObject();
    echo SubObject::$instances;
    
    $obj->object2 = new SubObject();
    echo SubObject::$instances;
    
    $obj2 = clone $obj;
    
    
    print("Original Object:\n");
    print_r($obj);
    
    print("Cloned Object:\n");
    print_r($obj2);
   
   ```
* __sleep
* __wakeUp


## Final关键字
* 只有方法和类才能有关键字 Final，如果类有关键字 Final，那么此类不能被继承；如果此方法
有关键字 Final，则此方法不能被覆盖。

## 对象复制

## 对象比较
* 对象赋值会完全相等，同一个类相同条件下的实例相对相等，对象复制会相对相等，其它不相等
   ```   
   
   /**
    * @param $bool
    * @return string
    * 对象赋值会完全相等，同一个类相同条件下的实例相对相等，对象复制会相对相等，其它不相等
    */
   function bool2str($bool)
   {
       if ($bool === false) {
           return 'FALSE';
       } else {
           return 'TRUE';
       }
   }
   
   function compareObjects(&$o1, &$o2)
   {
       echo 'o1 == o2 : ' . bool2str($o1 == $o2) . "\n<br \>";
       //echo 'o1 != o2 : ' . bool2str($o1 != $o2) . "\n<br \>";
       echo 'o1 === o2 : ' . bool2str($o1 === $o2) . "\n<br \>";
       //echo 'o1 !== o2 : ' . bool2str($o1 !== $o2) . "\n<br \>";
   }
   
   class Flag
   {
       public $flag;
   
       function Flag($flag = true) {
           $this->flag = $flag;
       }
   }
   
   class OtherFlag
   {
       public $flag;
   
       function OtherFlag($flag = true) {
           $this->flag = $flag;
       }
   }
   
   $o = new Flag();
   $p = new Flag();
   $q = $o;
   $m = clone $o;
   $r = new OtherFlag();
   
   echo "Two instances of the same class\n<br \>";
   compareObjects($o, $p);
   
   echo "\n<br \>Two references to the same instance\n<br \>";
   compareObjects($o, $q);
   
   echo "\n<br \>Instances of two different classes\n<br \>";
   compareObjects($o, $r);
   
   echo "\n<br \>Compare with clone and the private class\n<br \>";
   compareObjects($m,$o);
   ```

## 类型约束
* 传递参数的时候，可以指定参数的类型,这就是类型约束

   ```    
   
    /**
     * @param array|NULL $a
     * @return array
     * array $a=NULL,这样就可以不传参数，兼容性更好一点
     */
    function test(array $a=NULL){
        return $a;
    }
    
    $res = test([1111]);
    var_dump($res);

   ```
   
## 后期静态绑定
1. 会调用当前的类
   ```   
   
    class A {
        public static function foo() {
            static::who();
        }
    
        public static function who() {
            echo __CLASS__."\n<br \>";
        }
    }
    
    class B extends A {
        public static function test() {
            A::foo();
            parent::foo();
            self::foo();
        }
    
        public static function who() {
            echo __CLASS__."\n<br \>";
        }
    }
    class C extends B {
        public static function who() {
            echo __CLASS__."\n<br \>";
        }
    }
    
    C::test();
   ```
2. static表示一种范围，可以调用非静态方法
   ```   
   
   class A {
       private function foo() {
           echo "success!\n";
       }
       public function test() {
           $this->foo();
           static::foo();
       }
   }
   
   class B extends A {
      /* foo() will be copied to B, hence its scope will still be A and
       * the call be successful */
   }
   
   class C extends A {
       private function foo() {
           /* original method is replaced; the scope of the new one is C */
       }
   }
   
   $b = new B();
   $b->test();
   $c = new C();
   $c->test();   //fails
   ```