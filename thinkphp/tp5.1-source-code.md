
### 自动加载部分
- 用的是框架本身的自动加载，基于 composer 的自动加载，包含 composer 的自动加载。因为增加的地方是再增加 psr4 的范围。

### facade 模式

- 门面模式，就是说一些应用来和 facade 来对接，来调取不同的对象及方法

- bind 和门面的写法有多种，但是核心的应用是魔术函数 __callStatic()，当然可以加上容器的生产等模式

- 这里说一下，thinkphp/base.php 中的绑定过程分析



```

<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';


echo "<pre>";
var_dump(\Config::get());                     ## 第一次调用,找不到，肯定会走自动加载
var_dump(\Config::get());                     ## 第二次调用
echo "</pre>";


//thinkphp/base.php:11
<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace think;

// 载入Loader类
require __DIR__ . '/library/think/Loader.php';

// 注册自动加载
Loader::register();

// 注册错误和异常处理机制
Error::register();

// 实现日志接口
if (interface_exists('Psr\Log\LoggerInterface')) {
    interface LoggerInterface extends \Psr\Log\LoggerInterface
    {}
} else {
    interface LoggerInterface
    {}
}

// 注册类库别名
Loader::addClassAlias([
    'App'      => facade\App::class,
    'Build'    => facade\Build::class,
    'Cache'    => facade\Cache::class,
    'Config'   => facade\Config::class,
    'Cookie'   => facade\Cookie::class,
    'Db'       => Db::class,
    'Debug'    => facade\Debug::class,
    'Env'      => facade\Env::class,
    'Facade'   => Facade::class,
    'Hook'     => facade\Hook::class,
    'Lang'     => facade\Lang::class,
    'Log'      => facade\Log::class,
    'Request'  => facade\Request::class,
    'Response' => facade\Response::class,
    'Route'    => facade\Route::class,
    'Session'  => facade\Session::class,
    'Url'      => facade\Url::class,
    'Validate' => facade\Validate::class,
    'View'     => facade\View::class,
]);
// 执行应用并响应
Container::get('app')->run()->send();



//thinkphp/library/think/Loader.php:119，
// 自动加载
public static function autoload($class)
{
    if (isset(self::$classAlias[$class])) {                           ## 因为有过 bind 动作，所以会走这里
//            var_dump($class);
        return class_alias(self::$classAlias[$class], $class);        ## class_alias的第三个参数是 autoload 默认为 true,会选择自动加载。
                                                                      ## 第二次的调用，会直接使用，并不会再次加载
    }

    if ($file = self::findFile($class)) {

        // Win环境严格区分大小写
        if (strpos(PHP_OS, 'WIN') !== false && pathinfo($file, PATHINFO_FILENAME) != pathinfo(realpath($file), PATHINFO_FILENAME)) {
            return false;
        }

        __include_file($file);
        return true;
    }
}




// 结果显示在第二次调用的时候，并不需要再次加载引入
string(6) "Config"
string(19) "think\facade\Config"
string(12) "think\Facade"
string(15) "think\Container"
string(12) "think\Config"
string(9) "think\App"
string(6) "Yaconf"
array(0) {
}
array(0) {
}



// thinkphp/library/think/facade/Config.php:12                               ## 真实调用的是这个文件的类
// 方法不存在，启用魔术函数 __callStatic();
// 剩下的就不难理解啦


```




### \Env::get('root_path') && Env::get('root_path'); 到底需不需要加上 \ 符号 ？

- 最好是统一加上 \，由自动加载的部分和 classAlias 决定吧
   
   ```
   // 注册类库别名
    Loader::addClassAlias([
        'App'      => facade\App::class,
        'Build'    => facade\Build::class,
        'Cache'    => facade\Cache::class,
        'Config'   => facade\Config::class,
        'Cookie'   => facade\Cookie::class,
        'Db'       => Db::class,
        'Debug'    => facade\Debug::class,
        'Env'      => facade\Env::class,
        'Facade'   => Facade::class,
        'Hook'     => facade\Hook::class,
        'Lang'     => facade\Lang::class,
        'Log'      => facade\Log::class,
        'Request'  => facade\Request::class,
        'Response' => facade\Response::class,
        'Route'    => facade\Route::class,
        'Session'  => facade\Session::class,
        'Url'      => facade\Url::class,
        'Validate' => facade\Validate::class,
        'View'     => facade\View::class,
    ]);
   
   ```

### tag (钩子和行为)


```
// 加载行为扩展文件
- thinkphp/library/think/App.php:284

if (is_file($path . 'tags.php')) {
    $tags = include $path . 'tags.php';
    if (is_array($tags)) {
        $this->hook->import($tags);
    }
}


// 应用行为扩展定义文件
return [
    // 应用初始化
    'app_init'     => [\app\index\behaviorr\Test::class],           ## 钩子的代码挺好理解，默认的就在这里载入，然后调用。
                                                                    ## 有多种注册方式，我认为此种稍微好一些吧，方便查看和管理。
    // 应用开始
    'app_begin'    => [],
    // 模块初始化
    'module_init'  => [],
    // 操作开始执行
    'action_begin' => [],
    // 视图内容过滤
    'view_filter'  => [],
    // 日志写入
    'log_write'    => [],
    // 应用结束
    'app_end'      => [],
    'test'         => [
        \app\index\behaviorr\Test::class
    ],
    'run'         => [
        \app\index\behaviorr\Test::class
    ],
];


/**
    * 监听标签的行为
    * @access public
    * @param  string $tag    标签名称
    * @param  mixed  $params 传入参数
    * @param  bool   $once   只获取一个有效返回值
    * @return mixed
    */
public function listen($tag, $params = null, $once = false)
{
    $results = [];
    $tags    = $this->get($tag);
    foreach ($tags as $key => $name) {
        $results[$key] = $this->execTag($name, $tag, $params);

        if (false === $results[$key] || (!is_null($results[$key]) && $once)) {
            break;
        }
    }

    return $once ? end($results) : $results;
}



/**
    * 执行某个标签的行为
    * @access protected
    * @param  mixed     $class  要执行的行为
    * @param  string    $tag    方法名（标签名）
    * @param  mixed     $params 参数
    * @return mixed
    */
protected function execTag($class, $tag = '', $params = null)
{
    $method = Loader::parseName($tag, 1, false);        ## Java 风格

    if ($class instanceof \Closure) {
        $call  = $class;
        $class = 'Closure';
    } elseif (is_array($class) || strpos($class, '::')) {
        $call = $class;
    } else {
        $obj = Container::get($class);

        if (!is_callable([$obj, $method])) {            ## 默认用的是  run 方法
            $method = self::$portal;
        }

        $call  = [$class, $method];
        $class = $class . '->' . $method;
    }

    $result = $this->app->invoke($call, [$params]);

    return $result;
}





```

### middleware 中间件

- 某工作中的用法

```

Route::group('api', function () {

    Route::rule('index/index', 'api/Index/index');

    // 错误码查询
    Route::rule('error/index', 'api/Error/index');
    
    Route::group('pay_vip', function () {
        Route::post('/', 'api/PayVip/index');
        // 充值送话费
        Route::post('recharge_activity', 'api/PayVip/rechargeActivity');
    });

    
    // 俱乐部-version2
    Route::group('clubNew', [
        'test'                => 'api/ClubNew/test',
        // 判断创建俱乐部的条件
        'judgeCreate'         => 'api/ClubNew/judgeCreate',
        // 创建俱乐部
        'create'              => 'api/ClubNew/create',
        // 编辑俱乐部名字
        'editName'            => 'api/ClubNew/editName',
        // 编辑俱乐部公告
        'editDesc'            => 'api/ClubNew/editDesc',
        // 编辑俱乐部用户列表的权限
        'editPrivacy'         => 'api/ClubNew/editPrivacy',
        // 俱乐部的信息
        'getMess'             => 'api/ClubNew/getMess',
        // 邀请成员
        'inviteUser'          => 'api/ClubNew/inviteUser',
        // 被邀请，同意加入俱乐部
        'agreeJoin'           => 'api/ClubNew/agreeJoin',
        // 被邀请，拒绝加入俱乐部
        'refuseJoin'          => 'api/ClubNew/refuseJoin',
        // 主动，申请加入俱乐部
        'applyJoin'           => 'api/ClubNew/applyJoin',
        // 同意其加入俱乐部
        'letJoin'             => 'api/ClubNew/letJoin',
        // 拒绝其加入俱乐部
        'dontLetJoin'         => 'api/ClubNew/dontLetJoin',
        // 被俱乐部移除
        'removeJoin'          => 'api/ClubNew/removeJoin',
        // 退出俱乐部
        'exitClub'            => 'api/ClubNew/exitClub',
        // 解散俱乐部
        'retireClub'          => 'api/ClubNew/retireClub',
        // 获取俱乐部的消息列表
        'getClubMess'         => 'api/ClubNew/getClubMess',
        // 清除俱乐部的消息列表
        'clearClubMess'       => 'api/ClubNew/clearClubMess',
        // 设置为管理员
        'setAdmin'            => 'api/ClubNew/setAdmin',
        // 移除管理员
        'removeAdmin'         => 'api/ClubNew/removeAdmin',
        // 俱乐部列表
        'list'                => 'api/ClubNew/clubList',
        // 俱乐部搜索
        'search'              => 'api/ClubNew/search',
        // 俱乐部普通成员列表
        'getClubGeneralUsers' => 'api/ClubNew/getClubGeneralUsers',
        // 俱乐部成员列表
        'getClubUsers'        => 'api/ClubNew/getClubUsers',
        // 俱乐部管理层列表
        'getClubAdmins'       => 'api/ClubNew/getClubAdmins',
        // 俱乐部主页
        'getHomePage'         => 'api/ClubNew/getHomePage',
        // 俱乐部设置
        'getSettings'         => 'api/ClubNew/getSettings',

        // 举报俱乐部
        'report'              => 'api/ClubNew/report',
        // 获取邀请者列表
        'getInvites'          => 'api/ClubNew/getInvites',
        // 获取排行版-上一个小时
        'getRankHour'         => 'api/ClubNew/getRankHour',
        // 获取排行版-上一个周
        'getRankWeek'         => 'api/ClubNew/getRankWeek',

        // 获取群通告
        'getClubBanner'       => 'api/ClubNew/getClubBanner',
    ]);

})->middleware(['Auth']);




- thinkphp/library/think/route/Rule.php:470
/**
    * 指定路由中间件
    * @access public
    * @param  string|array|\Closure    $middleware
    * @param  mixed                    $param
    * @return $this
    */
public function middleware($middleware, $param = null)
{
    if (is_null($param) && is_array($middleware)) {
        $this->option['middleware'] = $middleware;
    } else {
        foreach ((array) $middleware as $item) {
            $this->option['middleware'][] = [$item, $param];
        }
    }

    return $this;
}


```



### Container::get('app')

- 这几句代码比较好理解，show the code 

```

    /**
     * 获取容器中的对象实例
     * @access public
     * @param  string        $abstract       类名或者标识
     * @param  array|true    $vars           变量
     * @param  bool          $newInstance    是否每次创建新的实例
     * @return object
     */
    public static function get($abstract, $vars = [], $newInstance = false)
    {
        return static::getInstance()->make($abstract, $vars, $newInstance);
    }


    ## 总结一下，bind 来绑定对象，make 来生成对象。用到了单例模式和反射类来生成对象
    ## 这个 make 方法和 laravel 的 make 方法还是有很大的不同啊
    /**
     * 创建类的实例
     * @access public
     * @param  string        $abstract       类名或者标识
     * @param  array|true    $vars           变量
     * @param  bool          $newInstance    是否每次创建新的实例
     * @return object
     */
    public function make($abstract, $vars = [], $newInstance = false)
    {
        if (true === $vars) {
            // 总是创建新的实例化对象
            $newInstance = true;
            $vars        = [];
        }

        $abstract = isset($this->name[$abstract]) ? $this->name[$abstract] : $abstract;

        if (isset($this->instances[$abstract]) && !$newInstance) {                            ## 注意这个 make 方法中有用到单例模式。
                                                                                              
            return $this->instances[$abstract];
        }

        if (isset($this->bind[$abstract])) {
            $concrete = $this->bind[$abstract];

            if ($concrete instanceof Closure) {
                $object = $this->invokeFunction($concrete, $vars);
            } else {
                $this->name[$abstract] = $concrete;
                return $this->make($concrete, $vars, $newInstance);                           ## 递归调用自己
            }
        } else {
            $object = $this->invokeClass($abstract, $vars);                                   ## 第二次调用会走到这里来，反射类来创建对象
        }

        if (!$newInstance) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }


    ## 反射类可以获取对象的属性方法还有注释等，操作对象，更加的强大吧

    /**
     * 调用反射执行类的实例化 支持依赖注入
     * @access public
     * @param  string    $class 类名
     * @param  array     $vars  参数
     * @return mixed
     */
    public function invokeClass($class, $vars = [])
    {

        try {
            $reflect = new ReflectionClass($class);

            if ($reflect->hasMethod('__make')) {                                      ##  这里面走了一个分支，看对象文件里面有没有 __make 方法
                                                                                      ##  如果有 __make 方法，会执行 __make 方法。典型的应用是 $this->route()
                                                                                      ##  如果没有 __make 方法，就会先执行 new 的操作
                $method = new ReflectionMethod($class, '__make');

                if ($method->isPublic() && $method->isStatic()) {
                    $args = $this->bindParams($method, $vars);
                    return $method->invokeArgs(null, $args);
                }
            }

            $constructor = $reflect->getConstructor();

            $args = $constructor ? $this->bindParams($constructor, $vars) : [];
            return $reflect->newInstanceArgs($args);

        } catch (ReflectionException $e) {
            throw new ClassNotFoundException('class not exists: ' . $class, $class);
        }
    }


```


### class Container implements ArrayAccess

- 获取对象的属性，采用数组的方式

- 我就知道，又用到了啥特性吧

- thinkphp/library/think/Route.php:134

```

public function __construct(App $app, array $config = [])
{
    $this->app     = $app;
    $this->request = $app['request'];
    $this->config  = $config;

    $this->host = $this->request->host(true) ?: $config['app_host'];

    $this->setDefaultDomain();
}


```

- class Container implements ArrayAccess, IteratorAggregate, Countable


- thinkphp/library/think/Container.php:585

```

    public function offsetGet($key)
    {
        return $this->__get($key);
    }

```






### Container::get('app')->run()

- run 方法内容太多了，分段来讲述吧

```

    /**
     * 执行应用程序
     * @access public
     * @return Response
     * @throws Exception
     */
    public function run()
    {
        try {
            // 初始化应用
            $this->initialize();                                                         

            // 监听app_init
            $this->hook->listen('app_init');

            if ($this->bindModule) {
                // 模块/控制器绑定
                $this->route->bind($this->bindModule);
            } elseif ($this->config('app.auto_bind_module')) {
                // 入口自动绑定
                $name = pathinfo($this->request->baseFile(), PATHINFO_FILENAME);
                if ($name && 'index' != $name && is_dir($this->appPath . $name)) {
                    $this->route->bind($name);
                }
            }

            // 监听app_dispatch
            $this->hook->listen('app_dispatch');

            $dispatch = $this->dispatch;

            if (empty($dispatch)) {
                // 路由检测
                $dispatch = $this->routeCheck()->init();
            }

            // 记录当前调度信息
            $this->request->dispatch($dispatch);

            // 记录路由和请求信息
            if ($this->appDebug) {
                $this->log('[ ROUTE ] ' . var_export($this->request->routeInfo(), true));
                $this->log('[ HEADER ] ' . var_export($this->request->header(), true));
                $this->log('[ PARAM ] ' . var_export($this->request->param(), true));
            }

            // 监听app_begin
            $this->hook->listen('app_begin');

            // 请求缓存检查
            $this->checkRequestCache(
                $this->config('request_cache'),
                $this->config('request_cache_expire'),
                $this->config('request_cache_except')
            );

            $data = null;
        } catch (HttpResponseException $exception) {
            $dispatch = null;
            $data     = $exception->getResponse();
        }

        $this->middleware->add(function (Request $request, $next) use ($dispatch, $data) {
            return is_null($data) ? $dispatch->run() : $data;
        });

        $response = $this->middleware->dispatch($this->request);

        // 监听app_end
        $this->hook->listen('app_end', $response);

        return $response;
    }



```



### $this->initialize()

```
/**
     * 初始化应用
     * @access public
     * @return void
     */
    public function initialize()
    {
        if ($this->initialized) {
            return;
        }

        $this->initialized = true;
        $this->beginTime   = microtime(true);
        $this->beginMem    = memory_get_usage();

        $this->rootPath    = dirname($this->appPath) . DIRECTORY_SEPARATOR;
        $this->runtimePath = $this->rootPath . 'runtime' . DIRECTORY_SEPARATOR;
        $this->routePath   = $this->rootPath . 'route' . DIRECTORY_SEPARATOR;
        $this->configPath  = $this->rootPath . 'config' . DIRECTORY_SEPARATOR;

        static::setInstance($this);

        $this->instance('app', $this);

        // 加载环境变量配置文件
        if (is_file($this->rootPath . '.env')) {
//            var_dump($this->env);
//            \Env::load($this->rootPath . '.env');
            $this->env->load($this->rootPath . '.env');
        }

//        var_dump($this->env->get('config_ext', '.php'));
        $this->configExt = $this->env->get('config_ext', '.php');

        // 加载惯例配置文件
        $this->config->set(include $this->thinkPath . 'convention.php');                      ## 001

        // 设置路径环境变量
        $this->env->set([
            'think_path'   => $this->thinkPath,
            'root_path'    => $this->rootPath,
            'app_path'     => $this->appPath,
            'config_path'  => $this->configPath,
            'route_path'   => $this->routePath,
            'runtime_path' => $this->runtimePath,
            'extend_path'  => $this->rootPath . 'extend' . DIRECTORY_SEPARATOR,
            'vendor_path'  => $this->rootPath . 'vendor' . DIRECTORY_SEPARATOR,
        ]);

        $this->namespace = $this->env->get('app_namespace', $this->namespace);
        $this->env->set('app_namespace', $this->namespace);

        // 注册应用命名空间
        Loader::addNamespace($this->namespace, $this->appPath);


        // 初始化应用
        $this->init();                                                                         ## 002

        // 开启类名后缀
        $this->suffix = $this->config('app.class_suffix');

        // 应用调试模式
        $this->appDebug = $this->env->get('app_debug', $this->config('app.app_debug'));
        $this->env->set('app_debug', $this->appDebug);

        if (!$this->appDebug) {
            ini_set('display_errors', 'Off');
        } elseif (PHP_SAPI != 'cli') {
            //重新申请一块比较大的buffer
            if (ob_get_level() > 0) {
                $output = ob_get_clean();
            }
            ob_start();
            if (!empty($output)) {
                echo $output;
            }
        }

        // 注册异常处理类
        if ($this->config('app.exception_handle')) {
            Error::setExceptionHandler($this->config('app.exception_handle'));
        }

        // 注册根命名空间
        if (!empty($this->config('app.root_namespace'))) {
            Loader::addNamespace($this->config('app.root_namespace'));
        }

        // 加载composer autofile文件
        Loader::loadComposerAutoloadFiles();

        // 注册类库别名
        Loader::addClassAlias($this->config->pull('alias'));

        // 数据库配置初始化
        Db::init($this->config->pull('database'));

        // 设置系统时区
        date_default_timezone_set($this->config('app.default_timezone'));

        // 读取语言包
        $this->loadLangPack();

        // 路由初始化
        $this->routeInit();                                                                ## 003
    }


```




#### 001

- think/App.php 中 $this->属性->方法() 

```

$this->env->load($this->rootPath . '.env');

$this->config->set(include $this->thinkPath . 'convention.php');

$this->hook->import($tags);


```

- 原来用到了魔术方法 __get()



#### 002
- $this->init();                
- 因为初始框架一片空白，暂无难点


```

    /**
     * 初始化应用或模块
     * @access public
     * @param  string $module 模块名
     * @return void
     */
    public function init($module = '')
    {
        // 定位模块目录
        $module = $module ? $module . DIRECTORY_SEPARATOR : '';
        $path   = $this->appPath . $module;
        // 加载初始化文件
        if (is_file($path . 'init.php')) {
            include $path . 'init.php';
        } elseif (is_file($this->runtimePath . $module . 'init.php')) {
            include $this->runtimePath . $module . 'init.php';
        } else {
            // 加载行为扩展文件
            if (is_file($path . 'tags.php')) {
                $tags = include $path . 'tags.php';
                /*echo "<pre>";
                var_dump($tags);
                echo "</pre>";*/

                if (is_array($tags)) {
                    $this->hook->import($tags);
                }
            }

            // 加载公共文件
            if (is_file($path . 'common.php')) {
                include_once $path . 'common.php';
            }
            if ('' == $module) {
                // 加载系统助手函数
                include $this->thinkPath . 'helper.php';
            }

            // 加载中间件
            if (is_file($path . 'middleware.php')) {
                $middleware = include $path . 'middleware.php';
                if (is_array($middleware)) {
                    $this->middleware->import($middleware);
                }
            }

            // 注册服务的容器对象实例
            if (is_file($path . 'provider.php')) {
                $provider = include $path . 'provider.php';
                if (is_array($provider)) {
                    $this->bindTo($provider);
                }
            }

            // 自动读取配置文件
            if (is_dir($path . 'config')) {
                $dir = $path . 'config' . DIRECTORY_SEPARATOR;
            } elseif (is_dir($this->configPath . $module)) {
                $dir = $this->configPath . $module;
            }

            $files = isset($dir) ? scandir($dir) : [];

            foreach ($files as $file) {
                if ('.' . pathinfo($file, PATHINFO_EXTENSION) === $this->configExt) {
                    $this->config->load($dir . $file, pathinfo($file, PATHINFO_FILENAME));
                }
            }
        }

        $this->setModulePath($path);

        if ($module) {
            // 对容器中的对象实例进行配置更新
            $this->containerConfigUpdate($module);
        }
    }



#### 003


- $this->routeInit(); 

```
    /**
     * 路由初始化 导入路由定义规则
     * @access public
     * @return void
     */
    public function routeInit()
    {
        // 路由检测
        $files = scandir($this->routePath);
        foreach ($files as $file) {
            if (strpos($file, '.php')) {
                $filename = $this->routePath . $file;
                // 导入路由配置
                $rules = include $filename;                                       
                if (is_array($rules)) {
                    $this->route->import($rules);                                      ## 路由从这里开始导入
                }
            }
        }
        if ($this->route->config('route_annotation')) {
            // 自动生成路由定义
            if ($this->appDebug) {
                $suffix = $this->route->config('controller_suffix') || $this->route->config('class_suffix');
                $this->build->buildRoute($suffix);
            }

            $filename = $this->runtimePath . 'build_route.php';

            if (is_file($filename)) {
                include $filename;
            }
        }
    }



```




### 路由分析之 $dispatch = $this->routeCheck()->init();

- 这可能是 tp5.1 中最绕的一句代码

```

- thinkphp/library/think/App.php:408

    if (empty($dispatch)) {
        // 路由检测
        $dispatch = $this->routeCheck()->init();                         ## 这一步会检查路由是否设置
    }



    /**
     * URL路由检测（根据PATH_INFO)
     * @access public
     * @return Dispatch
     */
    public function routeCheck()
    {
        // 检测路由缓存
        if (!$this->appDebug && $this->config->get('route_check_cache')) {
            $routeKey = $this->getRouteCacheKey();
            $option   = $this->config->get('route_cache_option');

            if ($option && $this->cache->connect($option)->has($routeKey)) {
                return $this->cache->connect($option)->get($routeKey);
            } elseif ($this->cache->has($routeKey)) {
                return $this->cache->get($routeKey);
            }
        }

        // 获取应用调度信息
        $path = $this->request->path();

        // 是否强制路由模式
        $must = !is_null($this->routeMust) ? $this->routeMust : $this->route->config('url_route_must');

        // 路由检测 返回一个Dispatch对象
        $dispatch = $this->route->check($path, $must);                  ## 002
        //object(think\route\dispatch\Module)#19 (6) {
        //  ["controller"]=>
        //  NULL
        //  ["actionName"]=>
        //  NULL
        //  ["dispatch"]=>
        //  array(3) {
        //    [0]=>
        //    string(5) "index"
        //    [1]=>
        //    string(5) "index"
        //    [2]=>
        //    string(4) "test"
        //  }
        //  ["param"]=>
        //  array(1) {
        //    ["convert"]=>
        //    bool(false)
        //  }
        //  ["code"]=>
        //  NULL
        //  ["convert"]=>
        //  bool(false)
        //}
        /*var_dump($dispatch);
        exit;*/

        if (!empty($routeKey)) {
            try {
                if ($option) {
                    $this->cache->connect($option)->tag('route_cache')->set($routeKey, $dispatch);
                } else {
                    $this->cache->tag('route_cache')->set($routeKey, $dispatch);
                }
            } catch (\Exception $e) {
                // 存在闭包的时候缓存无效
            }
        }

        return $dispatch;
    }



- thinkphp/library/think/Route.php:885

    /**
     * 检测URL路由
     * @access public
     * @param  string    $url URL地址
     * @param  bool      $must 是否强制路由
     * @return Dispatch
     * @throws RouteNotFoundException
     */
    public function check($url, $must = false)                                   ## 003
    {
        // 自动检测域名路由
        $domain = $this->checkDomain();                                          ## 这个在初始化的时候，就设置好了此变量


        $url    = str_replace($this->config['pathinfo_depr'], '|', $url);
        /*var_dump($url);
        exit;*/

        $completeMatch = $this->config['route_complete_match'];

        $result = $domain->check($this->request, $url, $completeMatch);          ## library/think/route/Domain.php
                                                                                 ## 004

        /*var_dump($result);
        exit;*/

        if (false === $result && !empty($this->cross)) {
            // 检测跨域路由
            $result = $this->cross->check($this->request, $url, $completeMatch);
        }

        if (false !== $result) {
            // 路由匹配
            return $result;
        } elseif ($must) {
            // 强制路由不匹配则抛出异常
            throw new RouteNotFoundException();
        }

        // 默认路由解析
        return new UrlDispatch($this->request, $this->group, $url, [
            'auto_search' => $this->autoSearchController,
        ]);
    }



- thinkphp/library/think/route/Domain.php:49
    /**
     * 检测域名路由
     * @access public
     * @param  Request      $request  请求对象
     * @param  string       $url      访问地址
     * @param  bool         $completeMatch   路由是否完全匹配
     * @return Dispatch|false
     */
    public function check($request, $url, $completeMatch = false)
    {
        // 检测别名路由
        $result = $this->checkRouteAlias($request, $url);

        if (false !== $result) {
            return $result;
        }

        // 检测URL绑定
        $result = $this->checkUrlBind($request, $url);


        if (!empty($this->option['append'])) {
            $request->setRouteVars($this->option['append']);
            unset($this->option['append']);
        }

        if (false !== $result) {
            return $result;
        }

        // 添加域名中间件
        if (!empty($this->option['middleware'])) {
            Container::get('middleware')->import($this->option['middleware']);
            unset($this->option['middleware']);
        }
        return parent::check($request, $url, $completeMatch);
    }


- thinkphp/library/think/route/RuleGroup.php:119
    /**
     * 检测分组路由
     * @access public
     * @param  Request      $request  请求对象
     * @param  string       $url      访问地址
     * @param  bool         $completeMatch   路由是否完全匹配
     * @return Dispatch|false
     */
    public function check($request, $url, $completeMatch = false)
    {
        if ($dispatch = $this->checkCrossDomain($request)) {
            // 跨域OPTIONS请求
            return $dispatch;
        }


        // 检查分组有效性
        if (!$this->checkOption($this->option, $request) || !$this->checkUrl($url)) {
            return false;
        }

        // 检查前置行为
        if (isset($this->option['before'])) {
            if (false === $this->checkBefore($this->option['before'])) {
                return false;
            }
            unset($this->option['before']);
        }

        // 解析分组路由
        if ($this instanceof Resource) {
            $this->buildResourceRule();
        } elseif ($this->rule) {
            if ($this->rule instanceof Response) {
                return new ResponseDispatch($request, $this, $this->rule);
            }

            $this->parseGroupRule($this->rule);
        }

        // 获取当前路由规则
        $method = strtolower($request->method());
        $rules  = $this->getMethodRules($method);               ## 005 获取了 rules 变量，这个变量是在路由文件 route/route.php 中设置好了
                                                                ## 都是以对象为结果来设置的，才有了后面遍历中的链式操作


        //array(2) {
        //  [0]=>
        //  object(think\route\RuleItem)#17 (10) {
        //    ["hasSetRule"]=>
        //    bool(true)
        //    ["name"]=>
        //    string(16) "index/index/test"
        //    ["rule"]=>
        //    string(16) "index/index/test"
        //    ["method"]=>
        //    string(4) "post"
        //    ["vars"]=>
        //    array(0) {
        //    }
        //    ["option"]=>
        //    array(1) {
        //      ["middleware"]=>
        //      array(1) {
        //        [0]=>
        //        string(4) "Auth"
        //      }
        //    }
        //    ["pattern"]=>
        //    array(0) {
        //    }
        //    ["mergeOptions"]=>
        //    array(6) {
        //      [0]=>
        //      string(5) "after"
        //      [1]=>
        //      string(5) "model"
        //      [2]=>
        //      string(6) "header"
        //      [3]=>
        //      string(8) "response"
        //      [4]=>
        //      string(6) "append"
        //      [5]=>
        //      string(10) "middleware"
        //    }
        //    ["doAfter"]=>
        //    NULL
        //    ["lockOption"]=>
        //    bool(false)
        //  }
        //}

        if ($this->parent) {
            // 合并分组参数
            $this->mergeGroupOptions();
            // 合并分组变量规则
            $this->pattern = array_merge($this->parent->getPattern(), $this->pattern);
        }

        if (isset($this->option['complete_match'])) {
            $completeMatch = $this->option['complete_match'];
        }

        if (!empty($this->option['merge_rule_regex'])) {
            // 合并路由正则规则进行路由匹配检查
            $result = $this->checkMergeRuleRegex($request, $rules, $url, $completeMatch);

            if (false !== $result) {
                return $result;
            }
        }

        // 检查分组路由
        foreach ($rules as $key => $item) {
            $result = $item->check($request, $url, $completeMatch);                 ## 006

            if (false !== $result) {
                //object(think\route\dispatch\Module)#21 (6) {
                //  ["controller"]=>
                //  NULL
                //  ["actionName"]=>
                //  NULL
                //  ["dispatch"]=>
                //  array(3) {
                //    [0]=>
                //    string(5) "index"
                //    [1]=>
                //    string(5) "index"
                //    [2]=>
                //    string(4) "test"
                //  }
                //  ["param"]=>
                //  array(1) {
                //    ["convert"]=>
                //    bool(false)
                //  }
                //  ["code"]=>
                //  NULL
                //  ["convert"]=>
                //  bool(false)
                //}
                /*var_dump($result);
                exit;*/
                return $result;
            }
        }

        if ($this->auto) {
            // 自动解析URL地址
            $result = new UrlDispatch($request, $this, $this->auto . '/' . $url, ['auto_search' => false]);
        } elseif ($this->miss && in_array($this->miss->getMethod(), ['*', $method])) {
            // 未匹配所有路由的路由规则处理
            $result = $this->miss->parseRule($request, '', $this->miss->getRoute(), $url, $this->miss->mergeGroupOptions());
        } else {
            $result = false;
        }


        return $result;
    }



- thinkphp/library/think/route/RuleItem.php:199

    /**
     * 检测路由（含路由匹配）
     * @access public
     * @param  Request      $request  请求对象
     * @param  string       $url      访问地址
     * @param  string       $depr     路径分隔符
     * @param  bool         $completeMatch   路由是否完全匹配
     * @return Dispatch|false
     */
    public function check($request, $url, $completeMatch = false)                           ## 007
    {
        return $this->checkRule($request, $url, null, $completeMatch);
    }


- thinkphp/library/think/route/RuleItem.php:150
    
    /**
     * 检测路由
     * @access public
     * @param  Request      $request  请求对象
     * @param  string       $url      访问地址
     * @param  array        $match    匹配路由变量
     * @param  bool         $completeMatch   路由是否完全匹配
     * @return Dispatch|false
     */
    public function checkRule($request, $url, $match = null, $completeMatch = false)         ## 008
    {
        if ($dispatch = $this->checkCrossDomain($request)) {
            // 允许跨域
            return $dispatch;
        }

        // 检查参数有效性
        if (!$this->checkOption($this->option, $request)) {
            return false;
        }

        // 合并分组参数
        $option = $this->mergeGroupOptions();

        $url = $this->urlSuffixCheck($request, $url, $option);

        if (is_null($match)) {
            $match = $this->match($url, $option, $completeMatch);
        }

        if (false !== $match) {
            // 检查前置行为
            if (isset($option['before']) && false === $this->checkBefore($option['before'])) {
                return false;
            }

            /*var_dump($this->rule);
            var_dump($this->route);
            var_dump($url);
            var_dump($option);
            var_dump($match);
            exit;*/

            return $this->parseRule($request, $this->rule, $this->route, $url, $option, $match);
        }

        return false;
    }


    /**
     * 解析匹配到的规则路由
     * @access public
     * @param  Request   $request 请求对象
     * @param  string    $rule 路由规则
     * @param  string    $route 路由地址
     * @param  string    $url URL地址
     * @param  array     $option 路由参数
     * @param  array     $matches 匹配的变量
     * @return Dispatch
     */
    public function parseRule($request, $rule, $route, $url, $option = [], $matches = [])     ## 009
    {
        if (is_string($route) && isset($option['prefix'])) {
            // 路由地址前缀
            $route = $option['prefix'] . $route;
        }

        // 替换路由地址中的变量
        if (is_string($route) && !empty($matches)) {
            $search = $replace = [];

            foreach ($matches as $key => $value) {
                $search[]  = '<' . $key . '>';
                $replace[] = $value;

                $search[]  = ':' . $key;
                $replace[] = $value;
            }

            $route = str_replace($search, $replace, $route);
        }

        //string(16) "index/index/test"
        //string(16) "index/index/test"
        //string(16) "index|index|test"

        // 解析额外参数
        $count = substr_count($rule, '/');
        $url   = array_slice(explode('|', $url), $count + 1);

        $this->parseUrlParams($request, implode('|', $url), $matches);


        $this->vars    = $matches;
        $this->option  = $option;
        $this->doAfter = true;

        // 发起路由调度
        return $this->dispatch($request, $route, $option);
    }



    /**
     * 发起路由调度
     * @access protected
     * @param  Request   $request Request对象
     * @param  mixed     $route  路由地址
     * @param  array     $option 路由参数
     * @return Dispatch
     */
    protected function dispatch($request, $route, $option)                                   ## 010
    {
        /*var_dump($route);
        var_dump($option);
        var_dump(strpos($route, '\\'));*/

        if ($route instanceof \Closure) {
            // 执行闭包
            $result = new CallbackDispatch($request, $this, $route);
        } elseif ($route instanceof Response) {
            $result = new ResponseDispatch($request, $this, $route);
        } elseif (isset($option['view']) && false !== $option['view']) {
            $result = new ViewDispatch($request, $this, $route, is_array($option['view']) ? $option['view'] : []);
        } elseif (!empty($option['redirect']) || 0 === strpos($route, '/') || strpos($route, '://')) {
            // 路由到重定向地址
            $result = new RedirectDispatch($request, $this, $route, [], isset($option['status']) ? $option['status'] : 301);
        } elseif (false !== strpos($route, '\\')) {
            // 路由到方法
            $result = $this->dispatchMethod($request, $route);
        } elseif (0 === strpos($route, '@')) {
            // 路由到控制器
            $result = $this->dispatchController($request, substr($route, 1));
        } else {
            // 路由到模块/控制器/操作
            $result = $this->dispatchModule($request, $route);                             ## 011
        }

        return $result;
    }



- thinkphp/library/think/route/Rule.php:858
    /**
     * 解析URL地址为 模块/控制器/操作
     * @access protected
     * @param  Request   $request Request对象
     * @param  string    $route 路由地址
     * @return ModuleDispatch
     */
    protected function dispatchModule($request, $route)                                              ## 012
    {
//        var_dump($route);
        list($path, $var) = $this->parseUrlPath($route);
        /*var_dump($path);
        var_dump($var);
        exit;*/

        $action     = array_pop($path);
        $controller = !empty($path) ? array_pop($path) : null;
        $module     = $this->getConfig('app_multi_module') && !empty($path) ? array_pop($path) : null;
        $method     = $request->method();
//        var_dump($action,$controller,$module,$method);
//var_dump($this->getConfig('use_action_prefix'));
        if ($this->getConfig('use_action_prefix') && $this->router->getMethodPrefix($method)) {
            $prefix = $this->router->getMethodPrefix($method);
            // 操作方法前缀支持
            $action = 0 !== strpos($action, $prefix) ? $prefix . $action : $action;
        }

        // 设置当前请求的路由变量
        $request->setRouteVars($var);

        // 路由到模块/控制器/操作
        return new ModuleDispatch($request, $this, [$module, $controller, $action], ['convert' => false]);      ## 013
    }



- thinkphp/library/think/route/Rule.php:19
    use think\route\dispatch\Module as ModuleDispatch;                                                  ## 014

- \think\route\Dispatch                                                                                 ## 015
    class Module extends Dispatch


- thinkphp/library/think/route/Dispatch.php:64                                                          ## 016

    public function __construct(Request $request, Rule $rule, $dispatch, $param = [], $code = null)
    {
        $this->request  = $request;
        $this->rule     = $rule;
        $this->app      = Container::get('app');
        $this->dispatch = $dispatch;
        $this->param    = $param;
        $this->code     = $code;

        if (isset($param['convert'])) {
            $this->convert = $param['convert'];
        }
    }

// 直到这里，完成了 check, 然后开始 init 吧

- thinkphp/library/think/route/Dispatch.php:62                                                         ## 017

    /**
     * 是否进行大小写转换
     * @var bool
     */
    protected $convert;

    public function __construct(Request $request, Rule $rule, $dispatch, $param = [], $code = null)
    {
        $this->request  = $request;
        $this->rule     = $rule;
        $this->app      = Container::get('app');
        $this->dispatch = $dispatch;
        $this->param    = $param;
        $this->code     = $code;

        if (isset($param['convert'])) {
            $this->convert = $param['convert'];
        }
    }

    public function init()
    {
        // 执行路由后置操作
        if ($this->rule->doAfter()) {
            // 设置请求的路由信息

            // 设置当前请求的参数
            $this->request->setRouteVars($this->rule->getVars());
            $this->request->routeInfo([
                'rule'   => $this->rule->getRule(),
                'route'  => $this->rule->getRoute(),
                'option' => $this->rule->getOption(),
                'var'    => $this->rule->getVars(),
            ]);

            $this->doRouteAfter();
        }

        return $this;
    }


- thinkphp/library/think/route/dispatch/Module.php:27

    public function init()                                                                          ## 018
    {
        parent::init();

        $result = $this->dispatch;
        /*var_dump($result);
        exit;*/

        if (is_string($result)) {
            $result = explode('/', $result);
        }

        if ($this->rule->getConfig('app_multi_module')) {
            // 多模块部署
            $module    = strip_tags(strtolower($result[0] ?: $this->rule->getConfig('default_module')));
            $bind      = $this->rule->getRouter()->getBind();
            $available = false;

            if ($bind && preg_match('/^[a-z]/is', $bind)) {
                // 绑定模块
                list($bindModule) = explode('/', $bind);
                if (empty($result[0])) {
                    $module = $bindModule;
                }
                $available = true;
            } elseif (!in_array($module, $this->rule->getConfig('deny_module_list')) && is_dir($this->app->getAppPath() . $module)) {
                $available = true;
            } elseif ($this->rule->getConfig('empty_module')) {
                $module    = $this->rule->getConfig('empty_module');
                $available = true;
            }

            // 模块初始化
            if ($module && $available) {
                // 初始化模块
                $this->request->setModule($module);
                $this->app->init($module);                                                       ## 019
            } else {
                throw new HttpException(404, 'module not exists:' . $module);
            }
        }

        // 是否自动转换控制器和操作名
        $convert = is_bool($this->convert) ? $this->convert : $this->rule->getConfig('url_convert');
        // 获取控制器名
        $controller = strip_tags($result[1] ?: $this->rule->getConfig('default_controller'));

        $this->controller = $convert ? strtolower($controller) : $controller;

        // 获取操作名
        $this->actionName = strip_tags($result[2] ?: $this->rule->getConfig('default_action'));
        /*var_dump($this->controller);
        var_dump($this->actionName);*/

        // 设置当前请求的控制器、操作
        $this->request
            ->setController(Loader::parseName($this->controller, 1))
            ->setAction($this->actionName);

        return $this;                                                              ## 返回此类，结束
    }


    /**
     * 初始化应用或模块
     * @access public
     * @param  string $module 模块名
     * @return void
     */
    public function init($module = '')                                              ## 020,在这里，模块会再次初始化 
    {
        // 定位模块目录
        $module = $module ? $module . DIRECTORY_SEPARATOR : '';
        $path   = $this->appPath . $module;

        // 加载初始化文件
        if (is_file($path . 'init.php')) {
            include $path . 'init.php';
        } elseif (is_file($this->runtimePath . $module . 'init.php')) {
            include $this->runtimePath . $module . 'init.php';
        } else {
            // 加载行为扩展文件
            if (is_file($path . 'tags.php')) {
                $tags = include $path . 'tags.php';
                if (is_array($tags)) {
                    $this->hook->import($tags);
                }
            }

            // 加载公共文件
            if (is_file($path . 'common.php')) {
                include_once $path . 'common.php';
            }

            if ('' == $module) {
                // 加载系统助手函数
                include $this->thinkPath . 'helper.php';
            }

            // 加载中间件
            if (is_file($path . 'middleware.php')) {
                $middleware = include $path . 'middleware.php';
                if (is_array($middleware)) {
                    $this->middleware->import($middleware);
                }
            }

            // 注册服务的容器对象实例
            if (is_file($path . 'provider.php')) {
                $provider = include $path . 'provider.php';
                if (is_array($provider)) {
                    $this->bindTo($provider);
                }
            }

            // 自动读取配置文件
            if (is_dir($path . 'config')) {
                $dir = $path . 'config' . DIRECTORY_SEPARATOR;
            } elseif (is_dir($this->configPath . $module)) {
                $dir = $this->configPath . $module;
            }

            $files = isset($dir) ? scandir($dir) : [];

            foreach ($files as $file) {
                if ('.' . pathinfo($file, PATHINFO_EXTENSION) === $this->configExt) {
                    $this->config->load($dir . $file, pathinfo($file, PATHINFO_FILENAME));
                }
            }
        }

        $this->setModulePath($path);

        if ($module) {
            // 对容器中的对象实例进行配置更新
            $this->containerConfigUpdate($module);
        }
    }

    protected function containerConfigUpdate($module)
    {
        $config = $this->config->get();

        // 注册异常处理类
        if ($config['app']['exception_handle']) {
            Error::setExceptionHandler($config['app']['exception_handle']);
        }

        Db::init($config['database']);
        $this->middleware->setConfig($config['middleware']);
        $this->route->setConfig($config['app']);
        $this->request->init($config['app']);
        $this->cookie->init($config['cookie']);
        $this->view->init($config['template']);
        $this->log->init($config['log']);
        $this->session->setConfig($config['session']);
        $this->debug->setConfig($config['trace']);
        $this->cache->init($config['cache'], true);

        // 加载当前模块语言包
        $this->lang->load($this->appPath . $module . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $this->request->langset() . '.php');

        // 模块请求缓存检查
        $this->checkRequestCache(
            $config['app']['request_cache'],
            $config['app']['request_cache_expire'],
            $config['app']['request_cache_except']
        );
    }


```









### 中间件的加入，路由的分发匿名类



```

- thinkphp/library/think/App.php:435
    $this->middleware->add(function (Request $request, $next) use ($dispatch, $data) {
            return is_null($data) ? $dispatch->run() : $data;                     ## 001, start $dispatch->run()
        });


- thinkphp/library/think/route/Dispatch.php:150

    /**
     * 执行路由调度
     * @access public
     * @return mixed
     */
    public function run()                                                         ## 002
    {
        $option = $this->rule->getOption();
        // 检测路由after行为
        if (!empty($option['after'])) {
            $dispatch = $this->checkAfter($option['after']);

            if ($dispatch instanceof Response) {
                return $dispatch;
            }
        }

        // 数据自动验证
        if (isset($option['validate'])) {
            $this->autoValidate($option['validate']);
        }

        $data = $this->exec();                                                   ## 003

        return $this->autoResponse($data);
    }



- 
```
