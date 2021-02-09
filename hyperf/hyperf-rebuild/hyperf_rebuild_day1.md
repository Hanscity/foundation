# day 1

入口文件  

这里面有一个包（symfony/finder），用来读取目录中的内容，


```
<?php

use Rebuild\Command\StartCommand;
use Rebuild\Config\ConfigFactory;
use Symfony\Component\Console\Application;

require 'vendor/autoload.php';

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));

$application = new Application();
$config = new ConfigFactory();
$config = $config();
$commands = $config->get('commands');
foreach ($commands as $command) {
    if ($command === StartCommand::class) {
        $application->add(new StartCommand($config));
    } else {
        $application->add(new $command);
    }
}
$application->run();

```



最终是想完成这个动作，开启 Swoole。执行的匿名函数，可以用其它转换之，就留下了很多的操作空间，详见下文


```

    $http = new Swoole\Http\Server('0.0.0.0', 9501);

    $http->on('request', function ($request, $response) {
        var_dump($request->server);
        $response->header("Content-Type", "text/html; charset=utf-8");
        $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
    });

    $http->start();


```

config 的配置如下：

```

array(4) {
  ["mode"]=>
  int(2)
  ["servers"]=>
  array(1) {
    [0]=>
    array(6) {
      ["name"]=>
      string(4) "http"
      ["type"]=>
      int(1)
      ["host"]=>
      string(7) "0.0.0.0"
      ["port"]=>
      int(9601)
      ["sock_type"]=>
      int(1)
      ["callbacks"]=>
      array(1) {
        ["request"]=>
        array(2) {
          [0]=>
          string(25) "Rebuild\HttpServer\Server"
          [1]=>
          string(9) "onRequest"
        }
      }
    }
  }
  
}


```



然后，读取到了 StartCommand 这个文件

这里面有一个包（symfony/console），用来设置命令行。执行 php bin/rebuild.php start ,这个 start 最终将执行 execute 方法



```
  
    class StartCommand extends Command
    {

        /**
        * @var \Rebuild\Config\Config
        */
        protected $config;

        /**
        * @param \Rebuild\Config\Config $config
        */
        public function __construct(\Rebuild\Config\Config $config)
        {
            parent::__construct();
            $this->config = $config;
        }

        protected function configure()
        {
            $this->setName('start')->setDescription('启动服务');
        }

        protected function execute(InputInterface $input, OutputInterface $output): int
        {
            $config = $this->config;
            $configs = $config->get('server');
            $serverFactory = new ServerFactory();
            $serverFactory->configure($configs);
            $serverFactory->getServer()->start();
            return 1;
        }


    }


```



```

    class ServerFactory
    {

        protected $serverConfig = [];

        /**
        * @var \Rebuild\Server\Server
        */
        protected $server;

        public function configure(array $configs)
        {
            $this->serverConfig = $configs;
            $this->getServer()->init($this->serverConfig);
        }

        public function getServer(): Server
        {
            if (! isset($this->server)) {
                $this->server = new Server();
            }
            return $this->server;
        }


    }



```


Rebuild\Server\Server

```

    use Swoole\Http\Server as SwooelHttpServer;

    class Server implements ServerInterface
    {

        /**
        * @var SwooleServer
        */
        protected $server;

        /**
        * @var array
        */
        protected $onRequestCallbacks = [];

        public function init(array $config): ServerInterface
        {
            foreach ($config['servers'] as $server) {
                $this->server = new SwooelHttpServer($server['host'], $server['port'], $server['type'], $server['sock_type']);
                $this->registerSwooleEvents($server['callbacks']);

                break;
            }
            return $this;
        }

        public function start()
        {
            $this->getServer()->start();
        }

        public function getServer()
        {
            return $this->server;
        }

        protected function registerSwooleEvents(array $callbacks)
        {
            foreach ($callbacks as $swolleEvent => $callback) {
                [$class, $method] = $callback;
                $instance = new $class();
                $this->server->on($swolleEvent, [$instance, $method]);
            }
        }
    }


```


```
namespace Rebuild\HttpServer;


class Server
{

    public function onRequest($request, $response)
    {
        // onRequest 方法里面我们吧刚才响应的代码补进来
        $response->header("Content-Type", "text/html; charset=utf-8");
        $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
        // 启动测试一次
        // 功能正常，也就是说现在写的各个功能都已经串联起来了
    }

}

```



