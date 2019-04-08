<?php
// if($_POST['id']){
//     $id = $_POST['id'];
// }else{
//     $id = 1;
// }
// if($_POST['name']){
//     $name = $_POST['name'];
// }else{
//     $name = 'admin';
// }

$mysqli = new mysqli('192.168.56.1', 'root', 'root', 'blogdemo2db');

/*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

/*
*
假如我们要插入很多1000个用户，你怎么做，for循环？
还是mysqli处理多条sql？ no！这些处理很慢的，php里面
有很多操作mysql数据库的函数，无非是把sql语句传递给
mysql数据库，真正处理sql语句的是mysql，mysql数据库是
要编译sql语句进行执行的，上面这两种操作会对相同的sql
语句进行多次编译，有这必要吗？程序员总是很聪明的，
于是有了mysqli预处理技术！mysqli还能防止sql注入攻击！
*/

/*
*
预处理语句的工作原理如下：
预处理：创建 SQL 语句模板并发送到数据库。预留的值使用参数 "?" 标记 。例如：INSERT INTO MyGuests (firstname, lastname, email) VALUES(?, ?, ?)
数据库解析，编译，对SQL语句模板执行查询优化，并存储结果不输出
执行：最后，将应用绑定的值传递给参数（"?" 标记），数据库执行语句。应用可以多次执行语句，如果参数的值不一样。

相比于直接执行SQL语句，预处理语句有两个主要优点：
预处理语句大大减少了分析时间，只做了一次查询（虽然语句多次执行）
绑定参数减少了服务器带宽，你只需要发送查询的参数，而不是整个语句
预处理语句针对SQL注入是非常有用的，因为 参数值发送后使用不同的协议，保证了数据的合法性。
*/


/*
*
mysqli prepare 语句的优点如下：
1：预编译，省掉了重复查询的开销；
2：仅传递参数，节省服务器带宽；
3：预编译后的操作，相当于对模板的操作，可以防止SQL注入；
备注：对于第三点，不是特别清楚，这涉及到MySQL的运行原理。
*/

$sql = 'select username,nickname,email from adminuser where username = ?';
// 创建预编译对象  
// 相当于一个模板 
if  ($stmt = $mysqli->prepare($sql)){

    echo "come in..";
    //下面*之间的内容可以重复执行类似功能，不需要再次编译了
    /**********************************************************************************/ 
    
    // 001--执行成功
    // $username = 'weixi';

    // 002--注入失败
    // $username = '\'weixi\';delete from adminuser where username = \'44\'';

    // 003--注入失败
    $username = 'weixi;delete from adminuser where username = 44';
    
    //参数有以下四种类型:  
    //i - integer（整型）  
    //d - double（双精度浮点型）  
    //s - string（字符串）  
    //b - BLOB（binary large object:二进制大对象） 
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $stmt->bind_result($username,$nickname,$email); //绑定结果
    // var_dump($stmt->affected_rows);

    echo "<table>";
    while($stmt->fetch()){
        echo "<tr>";
        echo "<td>".$username."</td>";
        echo "<td>".$nickname."</td>";
        echo "<td>".$email."</td>";
        echo "<td>".'im table'."</td>";
        echo "</tr>";
    }
    echo "</table>";
    /******************************************************************************/ 
    //关闭预编译
    $stmt->close();
    //关闭数据库连接  
    $mysqli->close(); 
}
     
?>