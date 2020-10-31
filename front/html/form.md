## Form 表单提交

- 问你一个问题，表单提交可以发送完好的 int 型数据吗？
- 话不多说，代码如下：

- test002.html

```

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> 
<title>菜鸟教程(runoob.com)</title>
</head>

<body>

<form action='http://localhost:8080/test002.php' method='get'>
    nickname: <input type="text" name="nickname" value=""><br />
    age: <input type="text" name="age" value=""><br />

    <input type="submit" value="Submit">
</form>

    
</body>
</html>


```



- test002.php

```

<?php


var_export($_REQUEST);


?>

```


- 结果如下：


```

// 如果输入的是 ch, 1111
array ( 'nickname' => 'ch', 'age' => '1111', )

// 如果输入的是 ch, '1111'
array ( 'nickname' => 'ch', 'age' => '\'1111\'', )

// 如果输入的是 ch, "1111"
array ( 'nickname' => 'ch', 'age' => '"1111"', )

```

- 总而言之，表单提交不了完好的 int 型数据
- 那作为 接收方的 PHP 端，如何检验呢？
- is_numeric()，这个函数可以胜任哈


