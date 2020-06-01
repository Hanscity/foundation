
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




