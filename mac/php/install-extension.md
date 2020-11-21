# installing amqp on mac with brew

- 难点是安装 rabbitmq-c， 没人提醒的情况下，怎么都不对
> https://stackoverflow.com/questions/51818515/installing-amqp-on-mac-with-brew

```

brew install rabbitmq-c

```

### In Ubuntu
- 难点同样是 rabbitmq-c ,依赖安装失败，卡在 cmake 这里
> https://blog.51cto.com/laok8/2386307

- 以下代码经过测试，可以的

```

下载地址为：wget https://github.com/alanxz/rabbitmq-c/archive/v0.9.0.tar.gz

tar -zxvf   v0.9.0-master.tar.gz

cd    rabbitmq-c-0.9.0-master

mkdir build && cd build
cmake ..
cmake -DCMAKE_INSTALL_PREFIX=/usr/local/rabbitmq-c/0.9 ..  // 指定安装目录！important！

 cmake --build . --target install    // 这一步是真正的build rabbitmq-c库的，注意，不要漏掉点 '.'



```