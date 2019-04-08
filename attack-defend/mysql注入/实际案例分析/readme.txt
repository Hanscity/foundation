## adminwww
* 在我的实际工作中，我有一部分主要工作是后台管理系统，
adminwww 是后台管理系统的一套代码，框架改编自Symfony。

99% 的工作都是调用Yaf中写好的API，API调用Swoole中写好的db服务。
我首先要谈的是这1%，这1%的adminwww业务不呼叫API，自己去调用数据库。
那么我的SQL注入的分析就分为两部分：adminwww调用数据库，
swoole调用数据库。



###. adminwww 调用数据库
* 从001menu.php的getlist中说起，一直追到003mysql.php中的query方法，

// Execute the query
	if (($result = mysqli_query($this->_connection, $sql)) === FALSE)
	{
		if (isset($benchmark))
		{
			// This benchmark is worthless
			Profiler::delete($benchmark);
		}

		throw new Database_Exception(':error [ :query ]',
			array(':error' => mysqli_error($this->_connection), ':query' => $sql),
			mysqli_errno($this->_connection));
	}

竟然用的是 mysqli_query,mysqli的面向过程连接，这直接暴露了注入漏洞。
详细原因查看mysqli-injection


###. swoole 调用数据库
* swoole 连接数据库用的是Medoo的MySQL-PHP框架，Medoo需要开启PDO部分，已做好了注入防范。
* 特别说明validate系列是无法防止注入漏洞的哦。（请查看guomei-swoole-validate）
