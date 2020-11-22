# Install Extention


## PECL && PEAL && Composer

- PECL：PHP Extension Community Library，他管理着最底层的PHP扩展。这些扩展是用 C 写的

- PEAR：PHP Extension and Application Repository，他管理着项目环境的扩展。这些扩展是用 PHP 写的

- composer：Php 写的，简称 Php 的包，已经取代了 PEAR，至少我都没有怎么用过 PEAR。Composer 不仅是扩展，还包含有自动加载机制



## PECL official site

> https://pecl.php.net/

- The step of install

```

phpize
./configure
make
make install

```




## amqp
> https://pecl.php.net/package/amqp

- Problem 

```
checking for amqp using pkg-config... configure: error: librabbitmq not found

```

### installing amqp on mac with brew

- 难点是安装 rabbitmq-c， 没人提醒的情况下，怎么都不对
> https://stackoverflow.com/questions/51818515/installing-amqp-on-mac-with-brew

```

brew install rabbitmq-c

```


### In Ubuntu
- 难点同样是 rabbitmq-c ,依赖安装失败，卡在 cmake 这里

```
sudo apt-get install librabbitmq-dev

```





## sodium in Ubuntu
- Sodium is a new, easy-to-use software library for encryption, decryption, signatures, password hashing and more.
> https://pecl.php.net/get/libsodium-2.0.19.tgz

- problem

```
checking for libsodium... configure: error: Please install libsodium - See https://github.com/jedisct1/libsodium

```

- fix

- 我现在都有经验了，直接加上 -dev

```
sudo apt-get install libsodium-dev

```

