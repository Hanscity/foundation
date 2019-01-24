The PHP Interpreter
===================

This is the github mirror of the official PHP repository located at
https://git.php.net.

[![Build Status](https://secure.travis-ci.org/php/php-src.svg?branch=master)](http://travis-ci.org/php/php-src)
[![Build status](https://ci.appveyor.com/api/projects/status/meyur6fviaxgdwdy?svg=true)](https://ci.appveyor.com/project/php/php-src)

Pull Requests
=============
PHP accepts pull requests via github. Discussions are done on github, but
depending on the topic can also be relayed to the official PHP developer
mailing list internals@lists.php.net.

New features require an RFC and must be accepted by the developers.
See https://wiki.php.net/rfc and https://wiki.php.net/rfc/voting for more
information on the process.

Bug fixes **do not** require an RFC, but require a bugtracker ticket. Always
open a ticket at https://bugs.php.net and reference the bug id using #NNNNNN.

    Fix #55371: get_magic_quotes_gpc() throws deprecation warning

    After removing magic quotes, the get_magic_quotes_gpc function caused
    a deprecate warning. get_magic_quotes_gpc can be used to detected
    the magic_quotes behavior and therefore should not raise a warning at any
    time. The patch removes this warning

We do not merge pull requests directly on github. All PRs will be
pulled and pushed through https://git.php.net.



## Generate a preliminary configure.in
* man autoscan命令中产生的一句话
* [prɪˈlɪmɪnəri]
* 记忆技巧：pre 前 + limin 门槛，引申为“限制” + ary …的 → 入门前的 → 初步的 
* 生成一个初步的配置文件 configure.in


## error: incompatible types in assignment
* compatible,英 [kəmˈpætəbl]   美 [kəmˈpætəbəl]
* 记忆技巧：com 共同 + pat 轻拍 + ible 可…的，能…的 → 共同节奏的 → 相容的
* assign,分配，派遣
* 错误：赋予的类型不匹配

## traverse
* 英 [trəˈvɜ:s]   美 [trəˈvɜ:rs]  
* 横跨，来回移动，遍历[计算机]


