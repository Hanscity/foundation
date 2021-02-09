# day 3



## source code 


```

namespace Rebuild\Server;


use Rebuild\HttpServer\Router\DispatherFactory;
use Swoole\Coroutine\Server as SwooleCoServer;
use Swoole\Server as SwooleServer;
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
            if ($class === \Rebuild\HttpServer\Server::class) {
                $instance = new $class(new DispatherFactory());
            } else {
                $instance = new $class();
            }
            $this->server->on($swolleEvent, [$instance, $method]);
            if (method_exists($instance, 'initCoreMiddleware')) {
                $instance->initCoreMiddleware();
            }
        }
    }


}


```

这里面有一个小细节，就是 $this->server->on($swolleEvent, [$instance, $method]); 会将服务开启，
接受请求是 [$instance, $method] 的事情

然后就会执行 $instance->initCoreMiddleware(); 方法




### new DispatherFactory()

```

namespace Rebuild\HttpServer\Router;


use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Hyperf\HttpServer\Router\Router;
use Rebuild\HttpServer\MiddlewareManager;
use function FastRoute\simpleDispatcher;

class DispatherFactory
{

    /**
     * @var string[]
     */
    protected $routeFiles = [BASE_PATH . '/config/routes.php'];

    /**
     * @var Dispatcher[]
     */
    protected $dispatchers = [];

    /**
     * @var array
     */
    protected $routes = [];

    public function __construct()
    {
        $this->initConfigRoute();
    }

    public function getDispathcer(string $serverName): Dispatcher
    {
        if (! isset($this->dispatchers[$serverName])) {
            $this->dispatchers[$serverName] = simpleDispatcher(function (RouteCollector $r) {
                foreach ($this->routes as $route) {
                    [$httpMethod, $path, $handler] = $route;
                    if (isset($route[3])) {
                        $options = $route[3];
                    }
                    $r->addRoute($httpMethod, $path, $handler);
                    if (isset($options['middlewares']) && is_array($options['middlewares'])) {
                        MiddlewareManager::addMiddlewares($path, $httpMethod, $options['middlewares']);
                    }
                }
            });
        }
        return $this->dispatchers[$serverName];
    }

    public function initConfigRoute()
    {
        foreach ($this->routeFiles as $file) {
            if (file_exists($file)) {
                $routes = require_once $file;
                $this->routes = array_merge_recursive($this->routes, $routes);
            }
        }
    }

}



```


### $instance->initCoreMiddleware();

```

    public function initCoreMiddleware()
    {
        $config = (new ConfigFactory())();
        $this->globalMiddlewares = $config->get('middlewares');
        $this->coreMiddleware = new CoreMiddleware($this->dispatcherFactory);
    }


```

注册了两个变量，不难理解~


##  Rebuild\HttpServer\Server


```

<?php

namespace Rebuild\HttpServer;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Hyperf\Utils\Context;
use Hyperf\Utils\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rebuild\Config\ConfigFactory;
use Rebuild\Dispatcher\HttpRequestHandler;
use Rebuild\HttpServer\Router\Dispatched;
use Rebuild\HttpServer\Router\DispatherFactory;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Hyperf\HttpMessage\Server\Response as Psr7Response;
use Hyperf\HttpMessage\Server\Request as Psr7Request;
use function FastRoute\simpleDispatcher;


class Server
{

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @var \Rebuild\HttpServer\Contract\CoreMiddlewareInterface
     */
    protected $coreMiddleware;
    protected $globalMiddlewares;

    /**
     * @var DispatherFactory
     */
    protected $dispatcherFactory;

    public function __construct(DispatherFactory $dispatcherFactory)
    {
        $this->dispatcherFactory = $dispatcherFactory;
        $this->dispatcher = $this->dispatcherFactory->getDispathcer('http');
    }

    public function initCoreMiddleware()
    {
        $config = (new ConfigFactory())();
        $this->globalMiddlewares = $config->get('middlewares');
        $this->coreMiddleware = new CoreMiddleware($this->dispatcherFactory);
    }

    public function onRequest(SwooleRequest $request, SwooleResponse $response): void
    {
        /** @var \Psr\Http\Message\RequestInterface $psr7Request */
        /** @var \Psr\Http\Message\ResponseInterface $psr7Response */
        [$psr7Request, $psr7Response] = $this->initRequestAndResponse($request, $response);
        $psr7Request = $this->coreMiddleware->dispatch($psr7Request);

        $httpMethod = $psr7Request->getMethod();
        $path = $psr7Request->getUri()->getPath();

        $middlewares = $this->globalMiddlewares ?? [];

        $dispatched = $psr7Request->getAttribute(Dispatched::class);
        if ($dispatched instanceof Dispatched && $dispatched->isFound()) {
            $registeredMiddlewares = MiddlewareManager::get($path, $httpMethod) ?? [];
            $middlewares = array_merge($middlewares, $registeredMiddlewares);
        }
        $requestHandler = new HttpRequestHandler($middlewares, $this->coreMiddleware);
        $psr7Response = $requestHandler->handle($psr7Request);

        /*
         * Headers
         */
        foreach ($psr7Response->getHeaders() as $key => $value) {
            $response->header($key, implode(';', $value));
        }

        /*
         * Status code
         */
        $response->status($psr7Response->getStatusCode());
        $response->end($psr7Response->getBody()->getContents());
        var_dump('response end');
    }

    protected function initRequestAndResponse(SwooleRequest $request, SwooleResponse $response): array
    {
        // Initialize PSR-7 Request and Response objects.
        Context::set(ResponseInterface::class, $psr7Response = new Psr7Response());
        Context::set(ServerRequestInterface::class, $psr7Request = Psr7Request::loadFromSwooleRequest($request));
        return [$psr7Request, $psr7Response];
    }

}

```

重点分析 onRequest() 方法


### [$psr7Request, $psr7Response] = $this->initRequestAndResponse($request, $response);

```

protected function initRequestAndResponse(SwooleRequest $request, SwooleResponse $response): array
{
    // Initialize PSR-7 Request and Response objects.
    Context::set(ResponseInterface::class, $psr7Response = new Psr7Response());
    Context::set(ServerRequestInterface::class, $psr7Request = Psr7Request::loadFromSwooleRequest($request));
    return [$psr7Request, $psr7Response];
}

```

构造符合 psr7 接口规范的 request and response 对象，
[$psr7Request, $psr7Response] 这个功能等同于 list 函数

### $psr7Request = $this->coreMiddleware->dispatch($psr7Request);

```

public function dispatch(ServerRequestInterface $request): ServerRequestInterface
{
    $httpMethod = $request->getMethod();
    $uri = $request->getUri()->getPath();

    $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
    $dispatched = new Dispatched($routeInfo);

    $request = Context::set(ServerRequestInterface::class, $request->withAttribute(Dispatched::class, $dispatched));
    return $request;
}



public static function set(string $id, $value)
{
    if (Coroutine::inCoroutine()) {
        SwCoroutine::getContext()[$id] = $value;
    } else {
        static::$nonCoContext[$id] = $value;
    }
    return $value;
}

```

你看面向对象的思维，就是在不断的设置对象（本对象，或者其它对象）的属性等，然后返回对象

### $dispatched = $psr7Request->getAttribute(Dispatched::class);

这是上面 dispatch 方法中的在设置，如下：

```
$request = Context::set(ServerRequestInterface::class, $request->withAttribute(Dispatched::class, $dispatched));

```

随后取用之 


### middleware 的部分来了

```
// 获取中间件，合并中间件，从而得到总共需要使用的中间件
if ($dispatched instanceof Dispatched && $dispatched->isFound()) {
    $registeredMiddlewares = MiddlewareManager::get($path, $httpMethod) ?? [];
    $middlewares = array_merge($middlewares, $registeredMiddlewares);
}

// 
$requestHandler = new HttpRequestHandler($middlewares, $this->coreMiddleware);
$psr7Response = $requestHandler->handle($psr7Request);


```

```

namespace Rebuild\Dispatcher;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HttpRequestHandler extends AbstractRequestHandler
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->handleRequest($request);
    }
}


```



```

namespace Rebuild\Dispatcher;


use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractRequestHandler implements RequestHandlerInterface
{

    /**
     * @var \Psr\Http\Server\MiddlewareInterface
     */
    protected $coreHandler;

    protected $middlewares = [];

    protected $offset = 0;

    /**
     * @param array $middlewares
     */
    public function __construct(array $middlewares, MiddlewareInterface $coreHandler)
    {
        $this->middlewares = $middlewares;
        $this->coreHandler = $coreHandler;
    }

    protected function handleRequest($request)
    {
        if (! isset($this->middlewares[$this->offset]) && ! empty($this->coreHandler)) {
            $handler = $this->coreHandler;
        } else {
            $handler = $this->middlewares[$this->offset];
            // todo
            is_string($handler) && $handler = new $handler();// 这一段其实执行的是 App\Middleware\MiddlewareA
        }
        if (! method_exists($handler, 'process')) {
            throw new InvalidArgumentException(sprintf('Invalid middleware, it has to provide a process() method.'));
        }
        return $handler->process($request, $this->next());
    }

    /**
     * @return $this
     */
    protected function next()
    {
        ++$this->offset;
        return $this;
    }
}



```



MiddlewareA

```

namespace App\Middleware;


use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareA implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        defer(function () {
            var_dump('defer');
        });
        var_dump(__CLASS__);
        $path = $request->getUri()->getPath();
        if ($path === '/hello/hyperf') {
            return Context::get(ResponseInterface::class)->withStatus(401)->withBody(new SwooleStream('Not allow'));
        }
        // $handler->handle() 其实是 MiddlewareB
        $response = $handler->handle($request);
        return $response
            ->withBody(
                new SwooleStream($response->getBody()->getContents() . '++')
            );
    }
}




```


MiddlewareB

```

namespace App\Middleware;


use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareB implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        var_dump(__CLASS__);
        $response = $handler->handle($request);  // 因为 offset 在不断的 +1, 这一段其实转到了 $handler = $this->coreHandler;
        return $response
            ->withBody(
                new SwooleStream($response->getBody()->getContents() . '--')
            );
    }
}


```


CoreMiddleware

```

<?php

namespace Rebuild\HttpServer;


use FastRoute\Dispatcher;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Hyperf\Utils\Contracts\Arrayable;
use Hyperf\Utils\Contracts\Jsonable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Rebuild\HttpServer\Router\DispatherFactory;
use Hyperf\Utils\Context;
use Psr\Http\Message\ServerRequestInterface;
use Rebuild\HttpServer\Contract\CoreMiddlewareInterface;
use Rebuild\HttpServer\Router\Dispatched;

class CoreMiddleware implements CoreMiddlewareInterface
{

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    public function __construct(DispatherFactory $dispatcherFactory)
    {
        $this->dispatcher = $dispatcherFactory->getDispathcer('http');
    }

    public function dispatch(ServerRequestInterface $request): ServerRequestInterface
    {
        $httpMethod = $request->getMethod();
        $uri = $request->getUri()->getPath();

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        $dispatched = new Dispatched($routeInfo);

        $request = Context::set(ServerRequestInterface::class, $request->withAttribute(Dispatched::class, $dispatched));
        return $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $dispatched = $request->getAttribute(Dispatched::class);
        if (! $dispatched instanceof Dispatched) {
            throw new \InvalidArgumentException('Route not found');
        }
        switch ($dispatched->status) {
            case Dispatcher::NOT_FOUND:
                $response = $this->handleNotFound($request);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $response = $this->handleMethodNotAllow($request);
                break;
            case Dispatcher::FOUND:
                $response = $this->handleFound($request, $dispatched);
                break;
        }
        if (! $response instanceof ResponseInterface) {
            $response = $this->transferToResponse($response);
        }
        return $response;
    }

    protected function handleNotFound(ServerRequestInterface $request): ResponseInterface
    {
        /** @var ResponseInterface $response */
        return $response->withStatus(404)->withBody(new SwooleStream('Not found'));
    }

    protected function handleMethodNotAllow(ServerRequestInterface $request)
    {
        /** @var ResponseInterface $response */
        return $response->withStatus(405)->withBody(new SwooleStream('Method not allow'));
    }

    protected function handleFound(ServerRequestInterface $request, Dispatched $dispatched)
    {
        [$controller, $action] = $dispatched->handler;
        if (! class_exists($controller)) {
            throw new \InvalidArgumentException('Controller not exist');
        }
        if (! method_exists($controller, $action)) {
            throw new \InvalidArgumentException('Action of Controller not exist');
        }
        $parameters = [];
        $controllerInstance = new $controller();
        return $controllerInstance->{$action}(...$parameters);
    }

    protected function transferToResponse($response): ResponseInterface
    {
        if (is_string($response)) {
            return $this->response()
                ->withAddedHeader('Content-Type', 'text/plain')
                ->withBody(new SwooleStream((string) $response));
        } elseif (is_array($response) || $response instanceof Arrayable) {
            return $this->response()
                ->withAddedHeader('Content-Type', 'application/json')
                ->withBody(new SwooleStream(Json::encode($response)));
        } elseif ($response instanceof Jsonable) {
            return $this->response()
                ->withAddedHeader('Content-Type', 'application/json')
                ->withBody(new SwooleStream((string) $response));
        }
        return $response;
    }

    protected function response(): ResponseInterface
    {
        return Context::get(ResponseInterface::class);
    }
}

```

访问的时候，是 middlewareA -> middlewareB -> coremiddleware ,然后依次返回~

rebuild 项目符合 psr-15 的接口规范


