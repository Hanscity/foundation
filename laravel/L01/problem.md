
## 问题 一

```

vagrant@homestead:~/Code/weibo$ SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass yarn
yarn install v1.19.0
info No lockfile found.
[1/4] Resolving packages...
warning laravel-mix > @types/browser-sync > chokidar@2.1.8: Chokidar 2 will break on node v14+. Upgrade to chokidar 3 with 15x less dependencies.
warning laravel-mix > @types/browser-sync > chokidar > fsevents@1.2.13: fsevents 1 will break on node v14+ and could be using insecure binaries. Upgrade to fsevents 2.
warning laravel-mix > @types/browser-sync > chokidar > braces > snapdragon > source-map-resolve > urix@0.1.0: Please see https://github.com/lydell/urix#deprecated
warning laravel-mix > @types/browser-sync > chokidar > braces > snapdragon > source-map-resolve > resolve-url@0.2.1: https://github.com/lydell/resolve-url#deprecated
warning popper.js@1.16.1: You can find the new Popper v2 at @popperjs/core, this package is dedicated to the legacy v1
[2/4] Fetching packages...
error laravel-mix@6.0.10: The engine "node" is incompatible with this module. Expected version ">=12.14.0". Got "12.10.0"
error Found incompatible module.
info Visit https://yarnpkg.com/en/docs/cli/install for documentation about this command.



```

解决方案：

> https://learnku.com/laravel/t/53419

- yarn config set ignore-engines true




## 问题 二

```

Session store not set on request.

```

查了半天的错误，都没有解决

从 Windows homestead 换成独立的 Ubuntu 系统环境，成功

于是删除目录，从新下载 weibo 项目，重新 Composer，问题解决。

回想起来，就是 Phpstorm 删除文件的时候，编辑器不小心改动了 Vendor 里面的内容

另外一个项目 homestead.test 也报了同样的错误，然后我删除 vendor，执行 composer，成功

让我一度怀疑是环境哪里出问题了




