## 正则表达式中“?”的用法大概有以下几种
> https://blog.csdn.net/handsomexiaominge/article/details/87886857


1. 直接跟随在子表达式后面 
这种方式是最常用的用法，具体表示匹配前面的一次或者0次，类似于{0,1}，如：abc(d)?可匹配abc和abcd

2. 非贪婪匹配
关于贪婪和非贪婪，贪婪匹配的意思是，在同一个匹配项中，尽量匹配更多所搜索的字符，非贪婪则相反。正则匹配的默认模式是贪婪模式，当?号跟在如下限制符后面时，使用非贪婪模式（*,+,?，{n}，{n,}，{n,m}） 如正则表达式 \S+c 匹配字符串aaaacaaaaaaac的结果是aaaacaaaaaaac，而\S+?c则会优先匹配aaaac

3. 非获取匹配
当我们使用正则表达式的时候，捕获的字符串会被缓存起来以供后续使用，具体表现为每个（）中的表达式所匹配到的内容在进行正则匹配的过程中，都会被缓存下来，如以下代码


4. 断言