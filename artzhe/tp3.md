#
## 增删改查
### add

* 增加所有
   ```  
   $temp['status']=1;
   $temp['create_time']=date('Y-m-d');
   $temp['update_time']=date('Y-m-d H:i:s');
   $date_arr[]= $temp;
   $appreciate_image->addAll($date_arr);
   
   ```

### select
* sql语句执行查询
   ```   
   $sql = <<<SQL
           SELECT a.artwork_id as id
           FROM az_artwork_weight a LEFT JOIN (SELECT uid,artwork_id,weight FROM az_user_weight WHERE uid = {$uid}) b
           ON a.artwork_id = b.artwork_id
           ORDER BY {$this->config['order']['other']}
           LIMIT 5
           SQL;
   $arr = $ArtworkWeightModel->query($sql);
   
   ```

* 大于等于 M 且小于 N
   ```     
   $likeArr = M('ArtworkLike')
                ->where(['is_like'=>'Y'])
                ->where(['id'=>[['egt',$startNum],['lt',$endNum],'and']])
                ->select();

   ```

* 
## 有意思的一些问题
* 这是我非常不喜欢的一种写法，但是可以看看调用的顺序
   ```  
   $artwork = new ArtworkLogic();
   $artworkinfo=$artwork->where(['id' => $data['artwork_id'],'is_deleted'=>'N'])->find();
   
   ```

* checkLogin 需要看看，感觉没有进行什么校验
   ```  
   $this->checkLogin();
   $tokenInfo = Token::getTokenInfo($this->token);
   ```

* I 函数学习
   ``` 
   $mobileList = I('post.mobileList', '',false);
   ```

* mysql 的连接很慢，干其他工作一会，naicat 就要连接半天。 Ubuntu 上面更惨，直接需要重启软件。

   * 解决方法：

      1、show processlist发现在Command列是Connect, State是Login时等待了许久，说明是连接慢，不是访问数据慢

      2、百度发现了一个skip-name-resolve参数，禁止mysql做dns查询

      3、问题产生原因：由于本地机器没有配置网关，解析dns超时，导致连接慢

      4、问题解决：[mysqld]内加上skip-name-resolve



* 服务器可以 ssh 连接，但是 ping 不通
   1. 防火墙 的设置--iptables（wiki的解释很好）
      ```
      ## 查看防火墙的设置
      sudo iptables -nvL

      ```
   2. icmp 的设置
      ``` 
      # 查看此时 icmp 的设置
      cat /proc/sys/net/ipv4/icmp_echo_ignore_all

      #临时禁 ping
      echo 1 > /proc/sys/net/ipv4/icmp_echo_ignore_all
      #临时启用 ping
      echo 0 > /proc/sys/net/ipv4/icmp_echo_ignore_all

      #永久配置 ping
      vim /etc/sysctl.conf
      #设置关闭 ping
      net.ipv4.icmp_echo_ignore_all = 1
      #设置启用 ping
      net.ipv4.icmp_echo_ignore_all = 0

      #刷新配置
      sysctl -p
      ```
    


   3. 然后重启网络服务： service network restart
* PHP-fpm 进程明明在跑，为啥 top 命令的却显示 sleep
   * 我的 docker 环境里面，进程数非常少，容易观察。







# thinkphp 框架学习
* 简单的配置之后，我们来开始吧
* ./thinkphp/index.php, 我们都是从这里开始的，这个没有问题吧。
   1. 这有一句关键的代码
   ```
   // 引入ThinkPHP入口文件
   require './ThinkPHP/ThinkPHP.php';
   ```
* 开始进入 ./ThinkPHP/ThinkPHP.php 文件吧
   1. 大量的常量定义，建议把路径的定义过一遍，你会发现，缘起于两个重要的路径(THINK_PATH,APP_PATH)。
   ```
    // 系统常量定义
    defined('THINK_PATH')   or define('THINK_PATH',     __DIR__.'/'); ## ./thinkphp/ThinkPHP
    defined('APP_PATH')     or define('APP_PATH',       dirname($_SERVER['SCRIPT_FILENAME']).'/'); ## ./thinkphp/application/
    defined('APP_STATUS')   or define('APP_STATUS',     ''); // 应用状态 加载对应的配置文件
    defined('APP_DEBUG')    or define('APP_DEBUG',      false); // 是否调试模式

    if(function_exists('saeAutoLoader')){// 自动识别SAE环境
        defined('APP_MODE')     or define('APP_MODE',      'sae');
        defined('STORAGE_TYPE') or define('STORAGE_TYPE',  'Sae');
    }else{
        defined('APP_MODE')     or define('APP_MODE',       'common'); // 应用模式 默认为普通模式    
        defined('STORAGE_TYPE') or define('STORAGE_TYPE',   'File'); // 存储类型 默认为File    
    }

    defined('RUNTIME_PATH') or define('RUNTIME_PATH',   APP_PATH.'Runtime/');   // 系统运行时目录 ## ./thinkphp/application/Runtime
    defined('LIB_PATH')     or define('LIB_PATH',       realpath(THINK_PATH.'Library').'/'); // 系统核心类库目录 ## ./thinkphp/ThinkPHP/Library/
    defined('CORE_PATH')    or define('CORE_PATH',      LIB_PATH.'Think/'); // Think类库目录 ## ./thinkphp/ThinkPHP/Library/Think/
    defined('BEHAVIOR_PATH')or define('BEHAVIOR_PATH',  LIB_PATH.'Behavior/'); // 行为类库目录 ## ./thinkphp/ThinkPHP/Library/Behavior/
    defined('MODE_PATH')    or define('MODE_PATH',      THINK_PATH.'Mode/'); // 系统应用模式目录 ## ./thinkphp/ThinkPHP/Mode/
    defined('VENDOR_PATH')  or define('VENDOR_PATH',    LIB_PATH.'Vendor/'); // 第三方类库目录 ## ./thinkphp/ThinkPHP/Library/
    defined('COMMON_PATH')  or define('COMMON_PATH',    APP_PATH.'Common/'); // 应用公共目录 ## ./thinkphp/application/Common/
    defined('CONF_PATH')    or define('CONF_PATH',      COMMON_PATH.'Conf/'); // 应用配置目录 ## ./thinkphp/application/Conf/
    defined('LANG_PATH')    or define('LANG_PATH',      COMMON_PATH.'Lang/'); // 应用语言目录 ## ./thinkphp/application/Common/Lang/
    defined('HTML_PATH')    or define('HTML_PATH',      APP_PATH.'Html/'); // 应用静态目录 ## ./thinkphp/application/Html/
    defined('LOG_PATH')     or define('LOG_PATH',       RUNTIME_PATH.'Logs/'); // 应用日志目录 ## ./thinkphp/application/Runtime/Logs/
    defined('TEMP_PATH')    or define('TEMP_PATH',      RUNTIME_PATH.'Temp/'); // 应用缓存目录 ## ./thinkphp/application/Runtime/Temp/
    defined('DATA_PATH')    or define('DATA_PATH',      RUNTIME_PATH.'Data/'); // 应用数据目录 ## ./thinkphp/application/Runtime/Data/
    defined('CACHE_PATH')   or define('CACHE_PATH',     RUNTIME_PATH.'Cache/'); // 应用模板缓存目录 ## ./thinkphp/application/Runtime/Cache/
    defined('CONF_EXT')     or define('CONF_EXT',       '.php'); // 配置文件后缀
    defined('CONF_PARSE')   or define('CONF_PARSE',     '');    // 配置文件解析方法
   ```
   2. 只有两句核心的代码
   ```
    // 加载核心Think类
    require CORE_PATH.'Think'.EXT;
    // 应用初始化 
    Think\Think::start();
   ```
   3. 在这里，很有必要对这两句代码进行着重解释
   ```
   * 这缘起于，我对 use 用法的疑惑。
   * 必须先引入文件，才能开始使用命名空间的用法
   * 以上代码类似于以下三句代码

   // 加载核心Think类
   require CORE_PATH.'Think'.EXT;
   // 应用初始化
   use Think\Think;
   Think::start();

   * 继续疑惑，为什么在后来的业务代码中，只有 use 而没有引入文件的动作呢？

   ```
* 带着疑惑，继续前进，进入 start 函数，进入 ./thinkphp/ThinkPHP/Library/Think/Think.class.php

* 代码如下
   ```
   /**
     * 应用程序初始化
     * @access public
     * @return void
     */
    static public function start() {
      // 注册AUTOLOAD方法
      spl_autoload_register('Think\Think::autoload');         ## 这个方法，需要重点学习，你会发现，两个重要的知识点
      // 设定错误和异常处理
      register_shutdown_function('Think\Think::fatalError');
      set_error_handler('Think\Think::appError');
      set_exception_handler('Think\Think::appException');

      // 初始化文件存储方式
      Storage::connect(STORAGE_TYPE);

      $runtimefile  = RUNTIME_PATH.APP_MODE.'~runtime.php';
      if(!APP_DEBUG && Storage::has($runtimefile)){
          Storage::load($runtimefile);
      }else{
          if(Storage::has($runtimefile))
              Storage::unlink($runtimefile);
          $content =  '';
          // 读取应用模式
          $mode   =   include is_file(CONF_PATH.'core.php')?CONF_PATH.'core.php':MODE_PATH.APP_MODE.'.php';
          // 加载核心文件
          foreach ($mode['core'] as $file){
              if(is_file($file)) {
                include $file;
                if(!APP_DEBUG) $content   .= compile($file);
              }
          }

          // 加载应用模式配置文件
          foreach ($mode['config'] as $key=>$file){
              is_numeric($key)?C(load_config($file)):C($key,load_config($file));
          }

          // 读取当前应用模式对应的配置文件
          if('common' != APP_MODE && is_file(CONF_PATH.'config_'.APP_MODE.CONF_EXT))
              C(load_config(CONF_PATH.'config_'.APP_MODE.CONF_EXT));  

          // 加载模式别名定义
          if(isset($mode['alias'])){
              self::addMap(is_array($mode['alias'])?$mode['alias']:include $mode['alias']);
          }

          // 加载应用别名定义文件
          if(is_file(CONF_PATH.'alias.php'))
              self::addMap(include CONF_PATH.'alias.php');

          // 加载模式行为定义
          if(isset($mode['tags'])) {
              Hook::import(is_array($mode['tags'])?$mode['tags']:include $mode['tags']);
          }

          // 加载应用行为定义
          if(is_file(CONF_PATH.'tags.php'))
              // 允许应用增加开发模式配置定义
              Hook::import(include CONF_PATH.'tags.php');   

          // 加载框架底层语言包
          L(include THINK_PATH.'Lang/'.strtolower(C('DEFAULT_LANG')).'.php');

          if(!APP_DEBUG){
              $content  .=  "\nnamespace { Think\Think::addMap(".var_export(self::$_map,true).");";
              $content  .=  "\nL(".var_export(L(),true).");\nC(".var_export(C(),true).');Think\Hook::import('.var_export(Hook::get(),true).');}';
              Storage::put($runtimefile,strip_whitespace('<?php '.$content));
          }else{
            // 调试模式加载系统默认的配置文件
            C(include THINK_PATH.'Conf/debug.php');
            // 读取应用调试配置文件
            if(is_file(CONF_PATH.'debug'.CONF_EXT))
                C(include CONF_PATH.'debug'.CONF_EXT);           
          }
      }

      // 读取当前应用状态对应的配置文件
      if(APP_STATUS && is_file(CONF_PATH.APP_STATUS.CONF_EXT))
          C(include CONF_PATH.APP_STATUS.CONF_EXT);   

      // 设置系统时区
      date_default_timezone_set(C('DEFAULT_TIMEZONE'));

      // 检查应用目录结构 如果不存在则自动创建
      if(C('CHECK_APP_DIR')) {
          $module     =   defined('BIND_MODULE') ? BIND_MODULE : C('DEFAULT_MODULE');
          if(!is_dir(APP_PATH.$module) || !is_dir(LOG_PATH)){
              // 检测应用目录结构
              Build::checkDir($module);
          }
      }

      // 记录加载文件时间
      G('loadTime');
      // 运行应用
      App::run();
    }

   ```


## thinkphp C 函数的理解
```
//先理解这段程序，关于静态变量的理解
static $arr = [];
$arr['test001'] = 'test001';
$arr['test002'] = 'test002';
var_dump($arr); ## ['test001'=>'test001','test002'=>'test002']
static $arr = [];
var_dump($arr); ## ['test001'=>'test001','test002'=>'test002']
$arr = [];
var_dump($arr); ## []



function C($name=null, $value=null,$default=null) {
    static $_config = array();
    // 无参数时获取所有
    if (empty($name)) {
        return $_config;
    }
    // 优先执行设置获取或赋值
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtoupper($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : $default;
            $_config[$name] = $value;
            return;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtoupper($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : $default;
        $_config[$name[0]][$name[1]] = $value;
        return;
    }
    // 批量设置
    if (is_array($name)){
        $_config = array_merge($_config, array_change_key_case($name,CASE_UPPER));
        return;
    }
    return null; // 避免非法参数
}

var_dump(C('artzhe'));

```