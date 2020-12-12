# for && foreach

哪一种速度更快呢？

```
// 生成同样的数组，提高条件一致性


$a = array();
for ($i = 0; $i < 10000; $i++) {
    $a[] = $i;
}

$b = array();
for ($i = 0; $i < 10000; $i++) {
    $b[] = $i;
}

$c = array();
for ($i = 0; $i < 10000; $i++) {
    $c[] = $i;
}

$d = array();
for ($i = 0; $i < 10000; $i++) {
    $d[] = $i;
}

$start = microtime(true);
$sum = count($a);
for ($i = 0; $i < $sum; $i ++) {
    $a[$i] = $a[$i] + 1;
}
echo "Completed in ", microtime(true) - $start, " Seconds\n";

$start = microtime(true);
for ($i = 0; $i < count($b); $i ++) {
    $b[$i] = $b[$i] + 1;
}
echo "Completed in ", microtime(true) - $start, " Seconds\n";

$start = microtime(true);
foreach ($c as $k => $v) {
    $c[$k] = $v + 1;
}
echo "Completed in ", microtime(true) - $start, " Seconds\n";


$start = microtime(true);
foreach ($d as $k => &$v) {
    $v = $v + 1;
}
echo "Completed in ", microtime(true) - $start, " Seconds\n";


```

执行环境如下：
```

PHP 7.4.13 (cli) (built: Nov 28 2020 06:24:43) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies
    with Zend OPcache v7.4.13, Copyright (c), by Zend Technologies


```

执行结果如下，进行了多组

```
Completed in 0.00020003318786621 Seconds
Completed in 0.00021815299987793 Seconds
Completed in 0.00031614303588867 Seconds
Completed in 0.00033402442932129 Seconds


```

```
Completed in 0.00022506713867188 Seconds
Completed in 0.0002748966217041 Seconds
Completed in 0.00036001205444336 Seconds
Completed in 0.00038790702819824 Seconds

```


```

Completed in 0.00032997131347656 Seconds
Completed in 0.00030803680419922 Seconds
Completed in 0.00040507316589355 Seconds
Completed in 0.00044679641723633 Seconds


```

```

Completed in 0.00024604797363281 Seconds
Completed in 0.00025582313537598 Seconds
Completed in 0.00038290023803711 Seconds
Completed in 0.00040698051452637 Seconds


```

结论如下：

- 结果受很多因素的影响，有少许波动
- for 循环比 foreach 快
- for 循环中 count 不提取出来，相对速度较慢
- foreach 中用地址赋值的方式，并没有比普通赋值更快
- 差别都在万分之几秒间，差别不大，随便使用之


