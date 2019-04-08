* 只要全使用预编译语句,
你就用不着对传入的数据做任何过虑.
而如果使用普通的statement, 有可能要对drop,delete
等做费尽心机的判断和过虑.

* pdo
PHP数据对象，是PHP应用中的一个数据库抽象层规范。
PDO提供了一个统一的API接口可以使得你的PHP应用不去关心具体要
连接的数据库服务器系统类型。也就是说，如果你使用PDO的API，
可以在任何需要的时候无缝切换数据库服务器，比如从Firebird 到MySQL，
仅仅需要修改很少的PHP代码
其他数据库抽象层的例子包括Java应用中的JDBC以及Perl中的DBI。
当然，PDO也有它自己的先进性，比如一个干净的，
简单的，可移植的API.
它最主要的缺点是会限制让你不能使用
后期MySQL服务端提供所有的数据库高级特性。比如，PDO不允许使用MySQL支持的多语句执行。

from https://secure.php.net/manual/zh/mysqli.overview.php


* mysqli prepare 和PDO 的语句的优点如下：
1：预编译，省掉了重复查询的开销；
2：仅传递参数，节省服务器带宽；
3：预编译后的操作，相当于对模板的操作，不支持多语句执行(prepare是绝对的不支持，
PDO是bindParam方式才不支持)，可以防止SQL注入；
备注：对于第三点，不是特别清楚，这涉及到MySQL的运行原理。
      

