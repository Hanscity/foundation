问题 一

```
PHP Warning:  PHP Startup: Unable to load dynamic library 'phalcon.so' (tried: /usr/lib/php/20190902/phalcon.so (/usr/lib/php/20190902/phalcon.so: undefined symbol: php_json_serializable_ce), /usr/lib/php/20190902/phalcon.so.so (/usr/lib/php/20190902/phalcon.so.so: cannot open shared object file: No such file or directory)) in Unknown on line 0

```

> https://blog.csdn.net/LuoLingying/article/details/81910086

建立一个这样的链接

```

lrwxrwxrwx 1 root root   39 1月  22 21:01 30-phalcon.ini -> /etc/php/7.4/mods-available/phalcon.ini


```


