# design pattern
```

为了应对各种变动；
为了编写更高质量的代码；
这就需要我们掌握设计模式；

设计模式并不是被创造出来的；
而是程序猿前辈们在开发过程中实验总结出来的；
后来由GOF整理成《Design Patterns: Elements of Reusable Object-Oriented Software》一书；
GOF(Gang of Four) 是 4位作者的合称；
一般叫他们 4人帮 ；
他们把设计模式划分为3类总共23种；
创建型：单例、抽象工厂、建造者、工厂、原型；
结构型：适配器、桥接、装饰、组合、外观、享元、代理；
行为型：模版方法、命令、迭代器、观察者、中介者、备忘录、解释器、状态、策略、职责链、访问者；

设计模式的宗旨是重用；
目的是建立对象间的关联；
提供了让代码之间松耦合的各种方案；
它有两个原则；

按接口编程而不是按实现来编程
优先使用组合而不是继承
这两句话不太懂没关系；
有印象就行了；
我们后续从代码中理解；

            -- https://baijunyao.com/article/158

```

## singleton

- 这是我见过写的最好的单例模式
> https://baijunyao.com/article/159

- 魔术方法，总是记不住。如果你从动作上去理解，就好多了。
长大了，没有记忆，只有理解。

```
new subject()  ->  __construct
clone $subject ->  __clone
serialize      ->  __sleep
unserialize    ->  __wakeup

```


```
<?php
namespace Baijunyao\DesignPatterns\Singleton;

/**
 * 普通类
 *
 * Class Db1
 * @package Baijunyao\DesignPatterns\Singleton
 */
class Db1
{
    public static $instance = null;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __construct()
    {
    }

    public function __clone()
    {
    }

    public function __wakeup()
    {
    }

}
$db1 = new Db1();
$db2 = new Db1();
$db3 = clone $db2;
$db4 = Db1::getInstance();
$db5 = unserialize(serialize($db4));


var_dump($db1);
echo '<hr>';
var_dump($db2);
echo '<hr>';
var_dump($db3);
echo '<hr>';
var_dump($db4);
echo '<hr>';
var_dump($db5);
echo '<hr>';


/**
 * 单例
 *
 * Class Db2
 * @package Baijunyao\DesignPatterns\Singleton
 */
class Db2
{
    private static $instance = null;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * 防止使用 new 创建多个实例
     *
     * Db2 constructor.
     */
    private function __construct()
    {
    }

    /**
     * 防止 clone 多个实例
     */
    private function __clone()
    {
    }

    /**
     * 防止反序列化
     */
    private function __wakeup()
    {
    }
}

$db6 = Db2::getInstance();
$db7 = Db2::getInstance();

var_dump($db6);
echo '<hr>';
var_dump($db7);
echo '<hr>';

```


## Factory

- 你是不是觉得代码里面如果有太多的 if else ,似乎不太优雅。不要这么理解，否则精悍的 if else 会不高兴的。 如果 if  else 里面的逻辑非常简单，这就是最好的代码。如果 if 
else 里面的逻辑非常的多甚至是复杂，这个时候 if  else 里面可能还有子 if else ,再加上需求的变动，这个时候再用 if else 就会有点狼狈了。俗话说，短刃不能当作长枪使，此时 Factory 就会闪亮登场。

- 工厂模式，容易违反开放封闭原则，开放封闭原则简单来说就是对扩展开放对修改封闭，理想的情况下，理想情况下我们是不应该再改动 Factory 类的，增加的是扩展的方式。

- 满足开放封闭原则有两种方式，1：利用反射类来写 Factory；2： IoC(Invert of Control 控制反转)

## IoC (Invert of Control 控制反转)


```
// 摘录自 https://www.insp.top/learn-laravel-container
// 工厂模式，违反了 开放封闭原则

class Flight
{
    protected $speed;
    protected $holdtime;
    public function __construct($speed, $holdtime) {}
}

class Force
{
    protected $force;
    public function __construct($force) {}
}

class Shot
{
    protected $atk;
    protected $range;
    protected $limit;
    public function __construct($atk, $range, $limit) {}
}


class SuperModuleFactory
{
    public function makeModule($moduleName, $options)
    {
        switch ($moduleName) {
            case 'Fight':   return new Flight($options[0], $options[1]);
            case 'Force':   return new Force($options[0]);
            case 'Shot':    return new Shot($options[0], $options[1], $options[2]);
            // case 'more': .......
            // case 'and more': .......
            // case 'and more': .......
            // case 'oh no! its too many!': .......
        }
    }
}

class Superman
{
    protected $power;

    public function __construct(array $modules)
    {
        // 初始化工厂
        $factory = new SuperModuleFactory;

        // 通过工厂提供的方法制造需要的模块
        foreach ($modules as $moduleName => $moduleOptions) {
            $this->power[] = $factory->makeModule($moduleName, $moduleOptions);
        }
    }
}



```
```
//摘录自 https://baijunyao.com/article/166
//reflection

<?php

namespace Baijunyao\DesignPatterns\AbstractFactoryWithReflection;

use ReflectionClass;
use ReflectionException;

class Factory
{
    /**
     * 数据库
     *
     * @var string
     */
    public $db = 'MySQL';

    /**
     * 产品类的命名空间
     *
     * @var string
     */
    public $namespace = 'Baijunyao\DesignPatterns\AbstractFactoryWithReflection\\';

    /**
     * Factory constructor.
     */
    public function __construct()
    {
        /**
         * 从配置项中获取 driver
         */
        $config = include 'config.php';
        $this->db = $config['driver'];
    }

    /**
     * 创建 User 产品
     *
     * @return MySQLUser|SQLiteUser
     */
    public function createUser()
    {
        $className = $this->namespace . $this->db . 'User';
        try {
            $class = new ReflectionClass($className);
            $user = $class->newInstance();
        } catch (ReflectionException $Exception) {
            throw new \InvalidArgumentException('暂不支持的数据库类型');
        }
        return $user;
    }

    /**
     * 创建 Article 产品
     *
     * @return MySQLArticle|SQLiteArticle
     */
    public function createArticle()
    {
        $className = $this->namespace . $this->db . 'Article';
        try {
            $class = new ReflectionClass($className);
            $article = $class->newInstance();
        } catch (ReflectionException $Exception) {
            throw new \InvalidArgumentException('暂不支持的数据库类型');
        }
        return $article;
    }
}

```

```
// 摘录自 https://www.insp.top/learn-laravel-container
// Ioc

interface SuperModuleInterface
{
    /**
     * 超能力激活方法
     *
     * 任何一个超能力都得有该方法，并拥有一个参数
     *@param array $target 针对目标，可以是一个或多个，自己或他人
     */
    public function activate(array $target);
}


/**
 * X-超能量
 */
class XPower implements SuperModuleInterface
{
    public function activate(array $target)
    {
        // 这只是个例子。。具体自行脑补
    }
}

/**
 * 终极炸弹 （就这么俗）
 */
class UltraBomb implements SuperModuleInterface
{
    public function activate(array $target)
    {
        // 这只是个例子。。具体自行脑补
    }
}

class Superman
{
    protected $module;

    public function __construct(SuperModuleInterface $module)
    {
        $this->module = $module;
    }
}

class Container
{
    protected $binds;

    protected $instances;

    public function bind($abstract, $concrete)
    {
        if ($concrete instanceof Closure) {
            $this->binds[$abstract] = $concrete;
        } else {
            $this->instances[$abstract] = $concrete;
        }
    }

    public function make($abstract, $parameters = [])
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        array_unshift($parameters, $this);
        return call_user_func_array($this->binds[$abstract], $parameters);
    }
}


// 创建一个容器（后面称作超级工厂）
$container = new Container;

// 向该 超级工厂 添加 超人 的生产脚本
// 匿名函数，
$container->bind('Superman', function($container, $moduleName) {
    return new Superman($container->make($moduleName));
});

// 向该 超级工厂 添加 超能力模组 的生产脚本
$container->bind('Xpower', function($container) {
    return new XPower;
});

// 同上
$container->bind('Ultrabomb', function($container) {
    return new UltraBomb;
});

// ******************  华丽丽的分割线  **********************
// 开始启动生产
$superman_1 = $container->make('Superman', ['Xpower']);
echo "<pre>";
var_dump($superman_1);
echo "</pre>";
$superman_2 = $container->make('Superman', ['Ultrabomb']);
echo "<pre>";
var_dump($superman_2);
echo "</pre>";
$superman_3 = $container->make('Superman', ['Xpower']);
// ...随意添加





```






### 备注知识

- DI (Dependency Insert 依赖注入)： 类和对象以参数的形式传参，就是依赖注入


## closure(匿名函数)
- 匿名函数不会执行，除非你真的执行

1. 回调函数中用的多
2. 变量来使用


```
$message = 'hello';

// 没有 "use"
$example = function () {
    var_dump($message);
};
echo $example();

// 继承 $message
$example = function () use ($message) {
    var_dump($message);
};
echo $example();

/*
 * Li Bai is a poet in the Tang Dynasty who writes a lot of lyrics,
 * and the poems inherit and extend the tradition of poets in the wei& jing dynasties.
 * 摘要李白是唐代写游仙诗较多的诗人，其游仙诗继承了魏晋游仙诗的传统并有所发展。
 * inherit 继承
 * extend  延伸
 *
 * */
// Inherited variable's value is from when the function
// is defined, not when called
$message = 'world';
echo $example();

// Reset message
$message = 'hello';

// Inherit by-reference
$example = function () use (&$message) {
    var_dump($message);
};
echo $example();

// The changed value in the parent scope
// is reflected inside the function call
$message = 'world';
echo $example();

// Closures can also accept regular arguments
$example = function ($arg) use ($message) {
    var_dump($arg . ' ' . $message);
};
$example("hello");

```
