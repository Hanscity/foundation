<?php
if($_POST['id']){
    $id = $_POST['id'];
}else{
    $id = 1;
}
if($_POST['name']){
    $name = $_POST['name'];
}else{
    $name = 'admin';
}

$mysqli = new mysqli('10.188.36.186', 'root', 'root', 'blogdemo2db');


/*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

//注入整型
// $id = '1;delete from adminuser where id = 4';
// $sql002 = "select * from adminuser where id = $id";

//注入字符型
$name = '44\';delete from adminuser where username = \'44';
$sql002 = "select * from adminuser where username = '" . $name . "'";

//注入注释型
// $name = '44\';delete from adminuser where username = \'44\'#';
// $sql002 = "select * from adminuser where username = '" . $name . "'" . " limit 0,10";

echo $sql002,"</br>";

/* Select queries return a resultset */
if ($result = $mysqli->multi_query($sql002)) {
    echo 'come in..';
    // while($row = $result->fetch_assoc()){
    //     echo "<pre>";
    //     var_dump($row);
    //     echo "</pre>";
    // }

}

echo 'after if..';

$mysqli->close();
?>