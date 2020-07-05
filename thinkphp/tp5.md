
## insert

```

db('table')->insert($data);
db('table')->insertGetId($data);
db('table')->insertAll($data);
```


## update

```

Db::name('user')->where('id', 1)
    ->update([
        'name'		=>	Db::raw('UPPER(name)'),
        'score'		=>	Db::raw('score-3'),
        'read_time'	=>	Db::raw('read_time+1')
    ]);

```


## select
- db('table') == DB::name() == DB::table($prefix.$table);       ## 会自动加上前缀，如果有前缀
- findOrEmpty();                   ## 一维数组或者空数组
- select();                        ## 二维数组或者空数组
- column('*','key');               ## 关联数组
- chunk                            ## 分段执行
- cursor                           ## PHP 生成器，节约内存
- json                             ## MySQL 支持 json 字段，tp5 支持 json 字段查询


         
### 查询方式
- 表达式查询(官方推荐)   --全面
- 字符串查询            --不全面

- 索引数组查询          --全面
- 关联数组查询          -- 不全面

```
$arrMerchant = db('merchant')->where('username','like', '中山市%')->find();                    ## 表达式查询 -- ok
$arrMerchant = db('merchant')->where("username like 中山市%")->find();                         ## 字符串查询 -- failed
$arrMerchant = db('merchant')->where([['username','like', '中山市%']])->find();                ## 索引数组   -- ok 
$arrMerchant = db('merchant')->where(['username'=>['like','中山市%']])->find();                ## 关联数组   -- failed ，tp5.1 理解为 in 了
```



/**
     * @return false|string
     * @comment 根据当前的节点，获取模块
     */
    public function getModule()
    {
        $nodeCur = $this->getNodeCurLittle();  ## eg : 'newadmin/merchant.merchant/getvipinfobyid'
        $halfStr = substr($nodeCur,strpos($nodeCur,'/'));
        $module = substr($halfStr,0,strpos($halfStr,'.'));
        return $module;
    }


### 操作数据库

#### 通过 model 获取多条数据，结果是对象

```
$admin = Admin::get(['username' => $username]);

```


#### 将结果转化为数组

```
$admin->toArray()

```


#### in 操作

- show the code

```

// 这一种只能查出一种数据出来
return $this->where(['user_id'=>['in','2000367,2000368,2000530']])
            ->column('accid');

// 这一种会报错
return $this->where(['user_id'=>['in',[2000367,2000368,2000530]]])
            ->column('accid');

// 这一种正常
return $this->where('user_id','in',[2000367,2000368,2000530])
            ->column('accid');

// 这一种正常
return $this->where('user_id','in','2000367,2000368,2000530')
                    ->column('accid');

```

```
// 这一种只能查出一种数据出来
return db('user_info')->where(['user_id'=>['in','2000367,2000368,2000530']])
            ->column('accid');

// 这一种会报错
return db('user_info')->where(['user_id'=>['in',[2000367,2000368,2000530]]])
    ->column('accid');

// 这一种正常
return db('user_info')->where('user_id','in',[2000367,2000368,2000530])
    ->column('accid');

// 这一种正常
return db('user_info')->where('user_id','in','2000367,2000368,2000530')
    ->column('accid');

```
- 和 tp5.1 文档描述的并不一致；
- 我当前的框架是 5.1.35
- 当前的数据库是 MariaDb8,version: mariadb  Ver 15.1 Distrib 10.4.13-MariaDB, for debian-linux-gnu (x86_64) using readline 5.2

### db() 的操作，取出来一般是数组

```
$res = db('user_info')->where(['user_id'=>$uid,'status'=>1])->find();

```


### tp5.1 更新数据库，字段错了，是没有报错，并且自动过滤的

```
$mess_data = [
            'check_status'=>-1,
            'reemark_content'=>$remark_content,                   ## 这个字段是错的，那么这个字段就不更新了，但是不报错。
            'mess_id'=>$mess_id
        ];

ClubnewMess::getInstance()->updateInfo($mess_data);


```
### validate

```
$check = ClubNewValidate::getInstance()->check([
            'club_name'      => $club_name
        ]);
        if (!$check) {
            return ['code' => -1, 'msg' => ClubNewValidate::getInstance()->getError()];
        }


```

### find 结果之后，既可以数组取值，也可以对象取值呀

```

$clubnew_info = ClubNewModel::getInstance()->getClubnewMessById($mess_info->club_id);
var_dump($clubnew_info['owner_accid']);
var_dump($clubnew_info->tid);
exit;

```


### session 

- 获取 session 对象
```
$session = Container::get('session');
```

- 判断是否包含某 key

```
$session->has($rule);

```
- 获取 session key

```
$session->get($rule);

```
- 设置 session key
```
$session->set($rule);

```
- 销毁 session key 
```

$session->delete($rule);
```



```

$session = Container::get('session');

if (!isset($data[$rule]) || !$session->has($rule)) {
    // 令牌数据无效
    return false;
}

// 令牌验证
if (isset($data[$rule]) && $session->get($rule) === $data[$rule]) {
    // 防止重复提交
    $session->delete($rule); // 验证完成销毁session
    return true;
}

// 开启TOKEN重置
$session->delete($rule);


```



## 连续点击新增，竟然可以创建两个俱乐部

- 引起这个问题的原因是 快照读

```



```


- 做法一 

```

        $club_count = ClubnewModel::getInstance()->getClubNumber($user_id);
        if ($club_count) {
            Db::rollback();
            return ['code' => -400889, 'msg' => '房间已存在'];
        }

        Db::startTrans();

        

        $NeteaseTeam = new NeteaseTeam();
        $im_group_info = $NeteaseTeam->createGroup($club_name, $owner_accid, $user_accids, $club_desc, $msg, 1, 1, '', [], $icon);
        if ($im_group_info['code'] != 200) {
            Db::rollback();
            return ['code' => -6, 'msg' => 'IM创建房间失败'];
        }

        $club_id = ClubnewModel::getInstance()->insertGetId([
            'tid'         => $im_group_info['tid'],
            'owner_id'    => $user_id,
            'owner_accid' => $owner_accid,
            'club_name'   => $club_name,
            'club_desc'   => $club_desc,
            'club_img'    => $user_info['himg'],
            'create_time' => time(),
            'update_time' => time(),
            'show_status' => 1,
        ]);
        if (!$club_id) {
            Db::rollback();
            return ['code' => -10, 'msg' => '创建房间失败'];
        }

        Db::commit();

        $ext = [
            'club_id'     => $club_id,
            'tid'         => $im_group_info['tid'],
            'user_id'     => $user_id,
            'owner_accid' => $owner_accid,
            'club_name'   => $club_name,
            'club_desc'   => $club_desc,
            'club_img'    => $icon,
            'himg'        => $icon,
            'in_private'  => 0,
        ];
        $NeteaseTeam->updateGroup($im_group_info['tid'], $owner_accid, $club_name, $club_desc, '', 1, $ext, $icon);
        return [
            'code' => 0, 'msg' => 'success', 'data' => ['tid' => $im_group_info['tid'], 'club_id' => $club_id],
        ];


```

- 做法二,将读放在事务之中，依然是快照读

```
        Db::startTrans();

        $club_count = ClubnewModel::getInstance()->getClubNumber($user_id);
        if ($club_count) {
            Db::rollback();
            return ['code' => -400889, 'msg' => '房间已存在'];
        }

        $NeteaseTeam = new NeteaseTeam();
        $im_group_info = $NeteaseTeam->createGroup($club_name, $owner_accid, $user_accids, $club_desc, $msg, 1, 1, '', [], $icon);
        if ($im_group_info['code'] != 200) {
            Db::rollback();
            return ['code' => -6, 'msg' => 'IM创建房间失败'];
        }

        $club_id = ClubnewModel::getInstance()->insertGetId([
            'tid'         => $im_group_info['tid'],
            'owner_id'    => $user_id,
            'owner_accid' => $owner_accid,
            'club_name'   => $club_name,
            'club_desc'   => $club_desc,
            'club_img'    => $user_info['himg'],
            'create_time' => time(),
            'update_time' => time(),
            'show_status' => 1,
        ]);
        if (!$club_id) {
            Db::rollback();
            return ['code' => -10, 'msg' => '创建房间失败'];
        }

        Db::commit();

        $ext = [
            'club_id'     => $club_id,
            'tid'         => $im_group_info['tid'],
            'user_id'     => $user_id,
            'owner_accid' => $owner_accid,
            'club_name'   => $club_name,
            'club_desc'   => $club_desc,
            'club_img'    => $icon,
            'himg'        => $icon,
            'in_private'  => 0,
        ];
        $NeteaseTeam->updateGroup($im_group_info['tid'], $owner_accid, $club_name, $club_desc, '', 1, $ext, $icon);
        return [
            'code' => 0, 'msg' => 'success', 'data' => ['tid' => $im_group_info['tid'], 'club_id' => $club_id],
        ];


```
- 做法三 在事务中， select for update,启动悲观琐
   - 在 MariaDb 中，InnoDb 的引擎中，隔离级别是 RR(Repeatable Read) 中，读写是可以并行的。
   - MySQL的autocommit（自动提交）默认是开启，其对mysql的性能有一定影响，举个例子来说，如果你插入了1000条数据，mysql会commit1000次的，如果我们把autocommit关闭掉，通过程序来控制，只要一次commit就可以了
   - 
```

        Db::execute('set autocommit=0');
        Db::startTrans();
        $club_info = ClubnewModel::getInstance()->getClubInfoForUpdate($user_id);
        if ($club_info) {
            Db::rollback();
            return ['code' => -400889, 'msg' => '房间已存在'];
        }
        $NeteaseTeam = new NeteaseTeam();
        $im_group_info = $NeteaseTeam->createGroup($club_name, $owner_accid, $user_accids, $club_desc, $msg, 1, 1, '', [], $icon);
        if ($im_group_info['code'] != 200) {
            Db::rollback();
            return ['code' => -6, 'msg' => 'IM创建房间失败'];
        }

        $club_id = ClubnewModel::getInstance()->insertGetId([
            'tid'         => $im_group_info['tid'],
            'owner_id'    => $user_id,
            'owner_accid' => $owner_accid,
            'club_name'   => $club_name,
            'club_desc'   => $club_desc,
            'club_img'    => $user_info['himg'],
            'create_time' => time(),
            'update_time' => time(),
            'show_status' => 1,
        ]);
        if (!$club_id) {
            Db::rollback();
            return ['code' => -10, 'msg' => '创建房间失败'];
        }

        Db::commit();

```
- 这里面，还缺少了一个测试，我需要将启动的悲观锁放在事务的外面，看是否有效。怎么少了这个关键的步骤呢？




## 源码分析

### 自动加载
- 目前所看，tp5 的自动加载，是在 composer 加载的基础上，包含了 composer 的自动加载

### 执行应用 001
- App::run()

#### $config = self::initCommon();
```
/**
     * 执行应用程序
     * @access public
     * @param  Request $request 请求对象
     * @return Response
     * @throws Exception
     */
    public static function run(Request $request = null)
    {
        $request = is_null($request) ? Request::instance() : $request;
        /*echo "<pre>";
        var_dump($request);
        echo "</pre>";*/

        try {
            $config = self::initCommon();                                         ## 001

            // 模块/控制器绑定
            if (defined('BIND_MODULE')) {
                BIND_MODULE && Route::bind(BIND_MODULE);
            } elseif ($config['auto_bind_module']) {
                // 入口自动绑定
                $name = pathinfo($request->baseFile(), PATHINFO_FILENAME);
                if ($name && 'index' != $name && is_dir(APP_PATH . $name)) {
                    Route::bind($name);
                }
            }

            $request->filter($config['default_filter']);

            // 默认语言
            Lang::range($config['default_lang']);
            // 开启多语言机制 检测当前语言
            $config['lang_switch_on'] && Lang::detect();
            $request->langset(Lang::range());

            // 加载系统语言包
            Lang::load([
                THINK_PATH . 'lang' . DS . $request->langset() . EXT,
                APP_PATH . 'lang' . DS . $request->langset() . EXT,
            ]);

            // 监听 app_dispatch
            Hook::listen('app_dispatch', self::$dispatch);
            // 获取应用调度信息
            $dispatch = self::$dispatch;

            // 未设置调度信息则进行 URL 路由检测
            if (empty($dispatch)) {
                $dispatch = self::routeCheck($request, $config);                          ## 002
            }

            // 记录当前调度信息
            $request->dispatch($dispatch);

            // 记录路由和请求信息
            if (self::$debug) {
                Log::record('[ ROUTE ] ' . var_export($dispatch, true), 'info');
                Log::record('[ HEADER ] ' . var_export($request->header(), true), 'info');
                Log::record('[ PARAM ] ' . var_export($request->param(), true), 'info');
            }

            // 监听 app_begin
            Hook::listen('app_begin', $dispatch);

            // 请求缓存检查
            $request->cache(
                $config['request_cache'],
                $config['request_cache_expire'],
                $config['request_cache_except']
            );

            $data = self::exec($dispatch, $config);
        } catch (HttpResponseException $exception) {
            $data = $exception->getResponse();
        }

        // 清空类的实例化
        Loader::clearInstance();

        // 输出数据到客户端
        if ($data instanceof Response) {
            $response = $data;
        } elseif (!is_null($data)) {
            // 默认自动识别响应输出类型
            $type = $request->isAjax() ?
            Config::get('default_ajax_return') :
            Config::get('default_return_type');

            $response = Response::create($data, $type);
        } else {
            $response = Response::create();
        }

        // 监听 app_end
        Hook::listen('app_end', $response);

        return $response;
    }




/**
     * URL路由检测（根据PATH_INFO)
     * @access public
     * @param  \think\Request $request 请求实例
     * @param  array          $config  配置信息
     * @return array
     * @throws \think\Exception
     */
    public static function routeCheck($request, array $config)
    {
        $path   = $request->path();
        $depr   = $config['pathinfo_depr'];
        $result = false;

//        var_dump($config['route_config_file']);
        // 路由检测
        $check = !is_null(self::$routeCheck) ? self::$routeCheck : $config['url_route_on'];
        if ($check) {
            // 开启路由
            if (is_file(RUNTIME_PATH . 'route.php')) {
                // 读取路由缓存
                $rules = include RUNTIME_PATH . 'route.php';
                is_array($rules) && Route::rules($rules);
            } else {
                $files = $config['route_config_file'];
                foreach ($files as $file) {
                    if (is_file(CONF_PATH . $file . CONF_EXT)) {
                        // 导入路由配置
                        $rules = include CONF_PATH . $file . CONF_EXT;
                        is_array($rules) && Route::import($rules);                          ## 003
                    }
                }
            }

            // 路由检测（根据路由定义返回不同的URL调度）
            $result = Route::check($request, $path, $depr, $config['url_domain_deploy']);
            $must   = !is_null(self::$routeMust) ? self::$routeMust : $config['url_route_must'];

            if ($must && false === $result) {
                // 路由无效
                throw new RouteNotFoundException();
            }
        }

        // 路由无效 解析模块/控制器/操作/参数... 支持控制器自动搜索
        if (false === $result) {
            $result = Route::parseUrl($path, $depr, $config['controller_auto_search']);
        }

        return $result;
    }



/**
     * 导入配置文件的路由规则
     * @access public
     * @param array  $rule 路由规则
     * @param string $type 请求类型
     * @return void
     */
    public static function import(array $rule, $type = '*')
    {

        // 检查域名部署
        if (isset($rule['__domain__'])) {
            self::domain($rule['__domain__']);
            unset($rule['__domain__']);
        }

        // 检查变量规则
        if (isset($rule['__pattern__'])) {
            self::pattern($rule['__pattern__']);
            unset($rule['__pattern__']);
        }

        // 检查路由别名
        if (isset($rule['__alias__'])) {
            self::alias($rule['__alias__']);
            unset($rule['__alias__']);
        }

        // 检查资源路由
        if (isset($rule['__rest__'])) {
            self::resource($rule['__rest__']);
            unset($rule['__rest__']);
        }
        self::registerRules($rule, strtolower($type));
    }



    // 批量注册路由
    protected static function registerRules($rules, $type = '*')
    {
        /*echo "<pre>";
        var_export($rules);
        echo "</pre>";*/

        foreach ($rules as $key => $val) {
            if (is_numeric($key)) {
                $key = array_shift($val);
            }
            if (empty($val)) {
                continue;
            }
            if (is_string($key) && 0 === strpos($key, '[')) {
                $key = substr($key, 1, -1);
                self::group($key, $val);                                          ## ing
            } elseif (is_array($val)) {
                self::setRule($key, $val[0], $type, $val[1], isset($val[2]) ? $val[2] : []);
            } else {
                self::setRule($key, $val, $type);
            }
        }
    }



    
```

















### 路由检测 返回一个Dispatch对象
        
- $dispatch = $this->route->check($path, $must);


```

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
        $dispatch = $this->route->check($path, $must);                       ## 001,  从这里开始吧。
                                                                             ## 当时的疑惑就是，  $this->route,发现 route class 中的 config 已经被设置
                                                                             ## 而 __construct 中没有看到调用和传递 config,于是得城下心去研究 $this->make


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




    public function __get($name)                                            ## 获取不存在的变量属性，回调用 __get() 方法
    {
        return $this->make($name);
    }


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

        if (isset($this->instances[$abstract]) && !$newInstance) {         ## make 方法的单例模式
            return $this->instances[$abstract];
        }

        if (isset($this->bind[$abstract])) {
            $concrete = $this->bind[$abstract];

            if ($concrete instanceof Closure) {
                $object = $this->invokeFunction($concrete, $vars);
            } else {
                $this->name[$abstract] = $concrete;
                return $this->make($concrete, $vars, $newInstance);
            }
        } else {
            $object = $this->invokeClass($abstract, $vars);                 ## make 方法，我探寻过很多次。这里的重点是 $this->invokeClass($abstract, $vars)
                                                                            ## 我将要重点探寻一下反射类
        }

        if (!$newInstance) {
            $this->instances[$abstract] = $object;
        }

        return $object;


### 获取对象的属性，采用数组的方式

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




### 

```

    /**
     * 检测URL路由
     * @access public
     * @param  string    $url URL地址
     * @param  bool      $must 是否强制路由
     * @return Dispatch
     * @throws RouteNotFoundException
     */
    public function check($url, $must = false)
    {
        // 自动检测域名路由
        $domain = $this->checkDomain();

        $url    = str_replace($this->config['pathinfo_depr'], '|', $url);
        /*var_dump($url);
        exit;*/

        $completeMatch = $this->config['route_complete_match'];

        $result = $domain->check($this->request, $url, $completeMatch);                ## 001
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

        return parent::check($request, $url, $completeMatch);                         ## 002

    }



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

            if ($reflect->hasMethod('__make')) {
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
        $rules  = $this->getMethodRules($method);
        /*var_dump($method);
        var_dump($rules);
        exit;*/

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
            $result = $item->check($request, $url, $completeMatch);

            if (false !== $result) {
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



```






