# Yaf Basic Use



## PHPstorm支持YAF框架代码自动提示

You could find a documented prototype script here: https://github.com/elad-yosifon/php-yaf-doc

然后找到phpstorm     File->settings->Languages & Frameworks 选择PHP->include path 点  + 号将下载的文件路径添加进去即可。


## Yaf 的 Bootstrap

```
/* 定义这个常量是为了在application.ini中引用*/
define('APPLICATION_PATH', realpath(dirname(__FILE__).'/../'));

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

$application->run();

```

略去 Bootstrap 的加载，也是可以启动，一般情况下，肯定是需要加载 Bootstrap 的


### forward

```

    /** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/yaf_skeleton/index/index/index/name/danche 的时候, 你就会发现不同
     */
	public function indexAction($name = "Stranger") {

		//1. fetch query
		$get = $this->getRequest()->getQuery("get", "default value");

		// forward will set isDispatched = false
        $this->forward('index','index','show');

		//2. fetch model
		$model = new SampleModel();

		//3. assign
		$this->getView()->assign("content", $model->selectSample());
		$this->getView()->assign("name", $name);

		//4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
        return TRUE;
	}

	public function showAction() {
	    echo 'show';
	    return FALSE;
    }

```

根据流程图，他是会调用 showAction() 方法然后打印出 show 



## Yaf 的全局配置项

```
[yaf]

yaf.environ = "develop"
yaf.library = "/home/danche/www/Tool/"
yaf.cache_config = 0
yaf.name_suffix = 1
yaf.name_seperator = ""
yaf.forward_limit = 5
yaf.use_namespace = 1
yaf.use_spl_autoload = 0


```

### 着重解析一下几条：

#### 配置了 yaf.environ = "develop"，配置文件至少如此：


```
[common]
application.directory = APPLICATION_PATH  "/application"
application.dispatcher.catchException = TRUE


[product : common]

[develop : common]


```



#### 配置了 yaf.library = "/home/danche/www/Tool/"

/home/danche/www/Tool/Host.php 文件如下：


```

<?php


//namespace Tool; 不能开启命名空间，哪怕 yaf.use_spl_autoload = 1 都不行

class Host
{

    public static function getHost() {

            echo $_SERVER['HTTP_HOST'].' in '.__FILE__.'</br>';
    }

}

```


调用如下：

```

\Host::getHost();

```

如文档中所说，这个全局的目录是可以提供给服务器中所有的项目来使用的



#### 如果配置了 yaf.use_namespace = 1

关于 Yaf 的空间设置示例如下：

```


class SamplePlugin extends Yaf\Plugin_Abstract {

	public function routerStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function dispatchLoopStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function preDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function postDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}
}



```



## Yaf 的类库加载

### 全局库的加载
这里所谓的全局库是指放在与项目目录无关的目录下，供多个 Yaf 项目使用

1. php.ini 中配置全局目录

    ```
    yaf.library = "/home/danche/www/Tool/"

    ```

2. 新建文件（也就是类库）

   /home/danche/www/Tool/Host.php 文件如下：


    ```

    <?php


    //namespace Tool; 不能开启命名空间，哪怕 yaf.use_spl_autoload = 1 都不行

    class Host
    {

        public static function getHost() {

                echo $_SERVER['HTTP_HOST'].' in '.__FILE__.'</br>';
        }

    }

    ```



3. 调用

    ```

    // 全局库的加载
    echo \Host::getHost();
    // 全局库的加载不支持命名空间，子目录等
    //echo \Test\Test::getTest();

    ```



### 项目库的加载

1. 项目库的设置

    也就是设置在 application/conf/application.ini 中

    在 https://www.laruence.com/manual/yaf.config.optional.html 手册中有详细的描述，一般采用默认值 application.directory + "/library"	


2. 设置命名空间

    也就是设置在 application/conf/application.ini 中

    ```

    application.library.namespace = "Tool,Test"

    ```

    示例如上，我这里设置了多个，格式如上


3. 调用

    ```

    //项目库的加载
    echo Tool\Http::getHost();
    echo Test\Http::getHost();

    ```

4. 文件示例

- application/library/Tool/Http.php

    ```
    <?php

    namespace Tool;

    class Http
    {
        public static function getHost()
        {
            return $_SERVER['HTTP_HOST']."</br>";
        }
    }

    ```


- application/library/Test/Http.php
    
    ```
    <?php

    namespace Test;

    class Http
    {
        public static function getHost()
        {
            return $_SERVER['HTTP_HOST']."</br>";
        }
    }

    ```



### 全局文件的直接使用

- 填写绝对路径，直接使用之

    ```

    // get the file
    \yaf\Loader::import('/home/danche/www/Tool/Http.php');

    ```





## Yaf 模块

### 增加模块

1. 设置

    首先 conf/application.ini 中设置如下：

    ```
    application.modules = "Index,User"

    ```

2. 新增目录

   例如新增 User 模块

   ```
    mkdir -p application/modules/User/controllers
    mkdir -p application/modules/User/views


   ```

当你新增模块完成，用编辑器查看的时候，你会发现 yaf 的模块路径有些奇怪

比如说控制器，一般是 controllers 里面有 Index，User 等分组

而这里的 User 模块里面有 controller，view 等

所以在 Yaf 的模块里面，以前的模块只能称呼为分组

那为何 Yaf 的 controllers，models，views 里面不进行分组呢？





## 注意

### 控制器不支持驼峰


访问： http://yaf.test/user/userInfo/index

访问： http://yaf.test/user/userinfo/index

控制器如下：

```
<?php

class UserInfoController extends Yaf\Controller_Abstract
{
    public function indexAction()
    {
        echo 'userinfo';
        return false;
    }
}

```

报错如下：

```

Yaf Caught exception :
Exception Message: Failed opening controller script /home/danche/www/Yaf/sample/application/modules/User/controllers/Userinfo.php: No such file or directory

```


将文件名改为不使用驼峰，将类改为不使用驼峰，即可

示例如下：

```

<?php

class UserinfoController extends Yaf\Controller_Abstract
{
    public function indexAction()
    {
        echo 'userinfo';
        return false;
    }
}

```

### 方法名支持驼峰,支持下划线






## Yaf 的路由

默认路由 route_static 配置成功

简单路由 route_simple 配置成功 

正则路由，我没有配置成功，错误如下（以下几种配置版本都是如此）：


```

http://yaf.test/1001


Yaf Caught exception :
Exception Message: Failed opening controller script /home/danche/www/Yaf/sample/application/controllers/1001.php: No such file or directory


```


### Nginx 配置版本一

```
server {
    listen       80;
    server_name  yaf.test;
    root /home/danche/www/Yaf/sample/public;

    access_log  /var/log/nginx/yaf.test-access.log;
    error_log   /var/log/nginx/yaf.test-error.log;

    index  index.html index.htm index.php;

    if (!-e $request_filename) {
        rewrite ^/(.*)$  /index.php?$1 last;
    }

    location ~ \.php$ {
        fastcgi_pass   unix:/run/php/php7.4-fpm.sock;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}


```


### Nginx 配置版本二

```

if (!-e $request_filename) {
    rewrite ^/(.*)  /index.php/$1 last;
}


location ~ \.php(.*)$ {
    fastcgi_pass   unix:/run/php/php7.4-fpm.sock;
    fastcgi_index  index.php;
    fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
    fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
    fastcgi_param  PATH_INFO  $fastcgi_path_info;
    fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
    include        fastcgi_params;
}



```

### Nginx 配置版本三

这是我当前正在用的版本

```

server {
    listen       80;
    server_name  yaf.test;
    root /home/danche/www/Yaf/sample/public;

    access_log  /var/log/nginx/yaf.test-access.log;
    error_log   /var/log/nginx/yaf.test-error.log;

    index  index.html index.htm index.php;

    if (!-e $request_filename) {
        rewrite ^/(.*)  /index.php/$1 last;
    }

    location ~ \.php {
        fastcgi_pass   unix:/run/php/php7.4-fpm.sock;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}



```



## 错误码

以下是来自 Symfony 的组件 Http/Responce 的一些定义：

```

    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;            // RFC2518
    const HTTP_EARLY_HINTS = 103;           // RFC8297
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;          // RFC4918
    const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    const HTTP_IM_USED = 226;               // RFC3229
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const HTTP_LOCKED = 423;                                                      // RFC4918
    const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
    const HTTP_TOO_EARLY = 425;                                                   // RFC-ietf-httpbis-replay-04
    const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585

```


以下是来自 Yaf 定义的常量 (https://www.laruence.com/manual/yaf.constant.html)

```

    YAF_VERSION(Yaf\VERSION)	Yaf框架的三位版本信息
    YAF_ENVIRON(Yaf\ENVIRON	Yaf的环境常量, 指明了要读取的配置的节, 默认的是product
    YAF_ERR_STARTUP_FAILED(Yaf\ERR\STARTUP_FAILED)	Yaf的错误代码常量, 表示启动失败, 值为512
    YAF_ERR_ROUTE_FAILED(Yaf\ERR\ROUTE_FAILED)	Yaf的错误代码常量, 表示路由失败, 值为513
    YAF_ERR_DISPATCH_FAILED(Yaf\ERR\DISPATCH_FAILED)	Yaf的错误代码常量, 表示分发失败, 值为514
    YAF_ERR_NOTFOUND_MODULE(Yaf\ERR\NOTFOUD\MODULE)	Yaf的错误代码常量, 表示找不到指定的模块, 值为515
    YAF_ERR_NOTFOUND_CONTROLLER(Yaf\ERR\NOTFOUD\CONTROLLER)	Yaf的错误代码常量, 表示找不到指定的Controller, 值为516
    YAF_ERR_NOTFOUND_ACTION(Yaf\ERR\NOTFOUD\ACTION)	Yaf的错误代码常量, 表示找不到指定的Action, 值为517
    YAF_ERR_NOTFOUND_VIEW(Yaf\ERR\NOTFOUD\VIEW)	Yaf的错误代码常量, 表示找不到指定的视图文件, 值为518
    YAF_ERR_CALL_FAILED(Yaf\ERR\CALL_FAILED)	Yaf的错误代码常量, 表示调用失败, 值为519
    YAF_ERR_AUTOLOAD_FAILED(Yaf\ERR\AUTOLOAD_FAILED)	Yaf的错误代码常量, 表示自动加载类失败, 值为520
    YAF_ERR_TYPE_ERROR(Yaf\ERR\TYPE_ERROR)	Yaf的错误代码常量, 表示关键逻辑的参数错误, 值为521


```


以下是根据具体业务抽象出来的常量


```
    //定义业务 code 常量
    define('YAF_HTTP_OK', 200); ## http 请求成功
    define('YAF_LOGIC_EXISTS', 530); ## 已存在，例如该注册的号码已存在
    define('YAF_LOGIC_NOT_EXISTS', 531); ## 不存在，例如用户的手机号码不存在
    define('YAF_LOGIC_REQUIRE', 532); ## 缺少参数，例如用户的手机号码没有传递
    define('YAF_LOGIC_DATA_ERROR', 532); ## 数据不正确，例如用户的密码不正确
    define('YAF_LOGIC_DB_ERROR', 540); ## MySQL 异常错误


```




## Yaf 对 HTTP 数据的获取

### POST 请求

#### 当 header 是 "Content-Type:application/json" 的时候

```
curl -X POST -H "Content-Type: application/json" -d '{"account_idx":837,"gid":10021,"count":10}' http://yaf.test/index/user/test

```

php 代码如下：

```

var_export(file_get_contents("php://input"));
var_export($this->getRequest()->getPost());
var_export($_POST);

```


结果如下：


```
'{"account_idx":837,"gid":10021,"count":10}'

array ()

array ()

```

结论： 当 header 是 "Content-Type:application/json" 的时候，需要使用 php://input



### 当 header 是 "Content-Type:application/x-www-form-urlencoded" 的时候

```
curl -X POST -H 'Content-Type : application/x-www-form-urlencoded' -d 'name=ch&gid=10021&count=10' http://yaf.test/index/user/test

```

php 代码如下：

```

var_export(file_get_contents("php://input"));
var_export($_POST);
var_export($this->getRequest()->getPost());

```


结果如下：


```
'name=ch&gid=10021&count=10'

array (
  'name' => 'ch',
  'gid' => '10021',
  'count' => '10',
)

array (
  'name' => 'ch',
  'gid' => '10021',
  'count' => '10',
)

```

结论： 当 header 是 "Content-Type:application/json" 的时候，不要使用 php://input