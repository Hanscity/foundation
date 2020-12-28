# php-di/php-di

> https://php-di.org/



## 调试查看

```

    $container = new DI\Container();    ## 1

    $userManager = $container->get('UserManager'); ## 2

```


```
    //vendor/php-di/php-di/src/Container.php:97

    public function __construct(    ## 101
        MutableDefinitionSource $definitionSource = null,
        ProxyFactory $proxyFactory = null,
        ContainerInterface $wrapperContainer = null
    ) {
        $this->delegateContainer = $wrapperContainer ?: $this;    ## 102 默认返回 vendor/php-di/php-di/src/Container

        $this->definitionSource = $definitionSource ?: $this->createDefaultDefinitionSource();    ## 103 
        $this->proxyFactory = $proxyFactory ?: new ProxyFactory(false);
        $this->definitionResolver = new ResolverDispatcher($this->delegateContainer, $this->proxyFactory);

        // Auto-register the container
        $this->resolvedEntries = [
            self::class => $this,
            ContainerInterface::class => $this->delegateContainer,
            FactoryInterface::class => $this,
            InvokerInterface::class => $this,
        ];
    }

```


```
    // \DI\Definition\Source\SourceChain

    private function createDefaultDefinitionSource() : SourceChain
    {
        $source = new SourceChain([new ReflectionBasedAutowiring]);    ## 104 define the attributes: source, rootSource
        $source->setMutableDefinitionSource(new DefinitionArray([], new ReflectionBasedAutowiring));    ## 105 

        return $source;
    }


```


......

追了几圈，大概是懂了，利用 ReflectionBasedAutowiring 来操作对象

暂不深究~

