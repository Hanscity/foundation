# what about opcache

php opcache就是为了代码读取io用的，把代码转成字节码到内存中，这样子php-fpm就不用去硬盘读取代码了。php跟java那种编译的情况不一样。