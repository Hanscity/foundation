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

$mysqlPdo = new PDO('mysql:host=192.168.56.1;dbname=blogdemo2db', 'root', 'root');

//此种类型--001--OK
// $sql002 = "select * from adminuser where id = 1";
// $sth = $mysqlPdo->query($sql002);
// while($row = $sth->fetch()){
// 	// echo 'im come in..';
//     echo "<pre>";
//     var_dump($row);
//     echo "</pre>";
// }

//
// 此种类型--002--OK--注入成功
// $sql002 = "select * from adminuser where username = 'weixi';delete from adminuser 
// where username = '44'";
// $sth = $mysqlPdo->query($sql002);
// while($row = $sth->fetch()){
// 	// echo 'im come in..';
//     echo "<pre>";
//     var_dump($row);
//     echo "</pre>";
// }


// 执行成功--003
// $sql002 = "select * from adminuser where id = :id";
// $sth = $mysqlPdo->prepare($sql002); 
// $id = 4;
// $sth->bindParam(':id',$id); 
// $sth->execute();
// while($row = $sth->fetch(PDO::FETCH_ASSOC)){
// 	// echo 'im come in..';
//     echo "<pre>";
//     var_dump($row);
//     echo "</pre>";
// }

//--004--展示成功，注入失败（也有可能是注入的方式不对。。）
// $sql002 = "select * from adminuser where id = :id";
// $sth = $mysqlPdo->prepare($sql002); 
// $id = '3;delete from adminuser where id = 4';
// $sth->bindParam(':id',$id); 
// $sth->execute();
// while($row = $sth->fetch(PDO::FETCH_ASSOC)){
// 	// echo 'im come in..';
//     echo "<pre>";
//     var_dump($row);
//     echo "</pre>";
// }

$mysqlPdo = null;
/*
+----------------------------------------------------------+
|备注：由上可知，PDO也是可以被注入的。
|      bindParam 才是好的写法。
+----------------------------------------------------------
*/


?>