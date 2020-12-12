# Time

## 脚本执行的时间,哪一种方法更好 ？

两种方法的比较：

```
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();
$time_start_two = microtime(true);

var_dump($time_start);
var_dump($time_start_two);

// Sleep for a while
usleep(100);

$time_end = microtime_float();
$time_end_two = microtime(true);

var_dump($time_end);
var_dump($time_end_two);

$time = $time_end - $time_start;
$time_two = $time_end_two - $time_start_two;

echo "Did nothing in $time seconds\n";
echo "Did nothing in $time_two seconds\n";

```

结果如下：

```

float(1607766176.1233)
float(1607766176.1233)
float(1607766176.1235)
float(1607766176.1235)
Did nothing in 0.00018191337585449 seconds
Did nothing in 0.00017595291137695 seconds


```


可以看出，时间上相差无几  
至于结果上有差距，根本原因在于计算机对浮点数的保存和计算上，这点暂不深究  
差距已经在万分之秒上了，都可以用之  
故选择使用上更为简单的方法  ```microtime(true)```

