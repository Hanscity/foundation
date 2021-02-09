## composer depend


### 使用场景

- 当我用 composer version 2 来更新 laravel 6+ 的时候，出现了这个提示

```
Package jakub-onderka/php-console-color is abandoned, you should avoid using it. Use php-parallel-lint/php-console-color instead.
Package jakub-onderka/php-console-highlighter is abandoned, you should avoid using it. Use php-parallel-lint/php-console-highlighter instead.

```

- composer depends --tree ***

```

danche@danche-TM1701:~/www/mujia-laravel$ composer depends --tree jakub-onderka/php-console-color

jakub-onderka/php-console-color v0.2 
└──jakub-onderka/php-console-highlighter v0.4 (requires jakub-onderka/php-console-color ~0.2)
   ├──nunomaduro/collision v3.1.0 (requires jakub-onderka/php-console-highlighter 0.3.*|0.4.*)
   │  └──laravel/laravel dev-main (requires (for development) nunomaduro/collision ^3.0)
   └──psy/psysh v0.9.12 (requires jakub-onderka/php-console-highlighter 0.3.*|0.4.*)
      └──laravel/tinker v1.0.10 (requires psy/psysh 0.7.*|0.8.*|0.9.*)
         └──laravel/laravel dev-main (requires laravel/tinker ^1.0)


```


### 提高版本

- 首先去官网查看可用的版本
- 选择合适的版本


```
 "laravel/tinker": "2.4.*",

```

- 更新之

```
composer update --no-dev

```


### 问题依然存在

- 更新之后，这个错误减少了次数，但是依然存在

- 继续使用 composer depends --tree jakub-onderka/php-console-color 查找错误


```
jakub-onderka/php-console-color v0.2 
└──jakub-onderka/php-console-highlighter v0.4 (requires jakub-onderka/php-console-color ~0.2)
   └──nunomaduro/collision v3.1.0 (requires jakub-onderka/php-console-highlighter 0.3.*|0.4.*)
      └──laravel/laravel dev-main (requires (for development) nunomaduro/collision ^3.0)

```

- 很显然，laravel/tinker 包的问题已解决
- 问题出在 nunomaduro/collision 这个包上面

- 故伎重演，先查看合适的包，然后提升之，如下：

```
        "nunomaduro/collision": "4.0.*",


```

- 然后更新之

- 错误如下：

```
Loading composer repositories with package information
Updating dependencies
Your requirements could not be resolved to an installable set of packages.

  Problem 1
    - Root composer.json requires nunomaduro/collision 4.0.* -> satisfiable by nunomaduro/collision[v4.0.0, v4.0.1].
    - Conclusion: don't install symfony/console 4.4.x-dev (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.0-BETA1 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.0-BETA2 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.0-RC1 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.3.4 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.3.5 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.3.6 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.3.7 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.3.8 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.3.9 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.3.10 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.3.11 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.0 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.1 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.2 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.3 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.4 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.5 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.6 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.7 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.8 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.9 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.10 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.11 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.12 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.13 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.14 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.15 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.16 (conflict analysis result)
    - Conclusion: don't install symfony/console v4.4.17 (conflict analysis result)
    - laravel/framework[v6.20.0, ..., v6.20.7] require symfony/console ^4.3.4 -> satisfiable by symfony/console[v4.3.4, ..., 4.4.x-dev].
    - Conclusion: don't install symfony/console 4.3.x-dev (conflict analysis result)
    - Root composer.json requires laravel/framework 6.20.* -> satisfiable by laravel/framework[v6.20.0, ..., v6.20.7].

Use the option --with-all-dependencies (-W) to allow upgrades, downgrades and removals for packages currently locked to specific versions.


```

- 简而言之，包冲突了

- 这里就有一个非常冲突而严重的问题了，假如某用户一直在使用 laravel6 和 nunomaduro/collision ，而 nunomaduro/collision v3.1.0 又依赖了 
  jakub-onderka/php-console-highlighter 0.3.*|0.4. ，而 jakub-onderka/php-console-highlighter 包被持有者废弃了，你怎么办 ？

1. 经常更新查看
2. 将包的代码 fork 到自己的仓库，然后建立自己的包

