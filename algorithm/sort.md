## 排序算法

```
<?php
    //
    // +---------------------------------------------------------------------------+
    // | 算法（algorithm），Php演示                                                |
    // +---------------------------------------------------------------------------+
    // | 这些基本算法的代码，满大街都是，但是我有我的理解。希望你们也有一点收获。  |
    // | 思想是借鉴的，代码是自己敲的，如有不好的地方，接受批评。                  |
    // +---------------------------------------------------------------------------+
    // | 以下排序都是从小到大。                                                    |
    // +---------------------------------------------------------------------------+
    // | Author: Chen Hang                                                         |
    // +---------------------------------------------------------------------------+
    // +---------------------------------------------------------------------------+
    // | Date: 2017/01/01                                                         |
    // +---------------------------------------------------------------------------+

    /*
    *    冒泡排序其实也分为两种，
    *   第一种是一个值和右边所有值的比较，我姑且称之为“一对多”;
    *   第二种是一个值只和右边相邻的值比较，我姑且称之为“邻值比对”。
    */

    //冒泡排序中的一对多排序
    function bubblesortMany($arr){
        for($i=0;$i<count($arr)-1;$i++){
            for($j=$i+1;$j<=count($arr)-1;$j++){
                //因为i的值不断变大，顺序不断后移，所以先确定左边的最小值。
                if($arr[$i] > $arr[$j]){
                    $temp = $arr[$i];
                    $arr[$i] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
        }
        return $arr;
    }

    //冒泡之邻值比对
    function bubblesortNeighbor($arr){

        for($i=0;$i<count($arr)-1;$i++){
            for($j=0;$j<count($arr)-1-$i;$j++){
                //冒泡的邻值比对满足条件必须换值，不断往右移动，此方式只能确定右边最大值。
                if($arr[$j]>$arr[$j+1]){
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j+1];
                    $arr[$j+1] = $temp;
                }
            }
        }
        return $arr;
    }

    /*
    *     选择排序简介：选出最小数与第一个位置的数交换，再找出最小的数与第二个位置的数交换，
    *   如此循环到倒数第二个数和最后一个数比较为止。
    *   找出最小的数，也有两种办法，我也姑且称之为“一对多”，“邻值比对”。
    *   冒泡排序的每次比较都有可能换值，选择排序的每次比较都不换值，而是记录下标。
    *   如果冒泡排序很顺溜了，选择排序也该自然的上手吧？
    */

    //选择排序中之一对多
    function selectsortMany($arr){
        for($i=0;$i<count($arr)-1;$i++){
            //将最小值的小标保存在$p中，换下标，而不去换值。
            //每次循环的开始，都假定下标是$i的值最小。
            $p = $i;
            for($j=$i+1;$j<=count($arr)-1;$j++){
                //此时同样先确定左边的最小值
                if($arr[$p]>$arr[$j]){
                    $p = $j;
                }
            }
            //循环结束，才开始换值
            if($p !== $i){
                $tmp = $arr[$i];
                $arr[$i] = $arr[$p];
                $arr[$p] = $tmp;
            }
        }
        return $arr;
    }

    //选择排序之邻值比对
    function selectsortNeighbor($arr){
        for($i=0;$i<count($arr)-1;$i++){
            $p = $i;
            //请注意，这里的邻值比对和冒泡的邻值比对逻辑不同，
            //这里挑出最小值
            for($j=$i;$j<count($arr)-1;$j++){
                if($arr[$p]>$arr[$j+1]){
                    $p = $j +1;
                }
            }
            if($p !== $i){
                $tmp = $arr[$i];
                $arr[$i] = $arr[$p];
                $arr[$p] = $tmp;
            }
        }
        return $arr;
    }

    /*
    *     插入排序简介：假定从第二个数开始，第二个数会与第一个数比较；然后
    *   后移，第三个数和第二个数比较，第二个数还是要与第一个数比较；依此类推。
    *   在这种情况下，只能不断的“邻值比对”来确定；如果此时用“一对多”来定最小值
    *   或是最大值，都不能确定之间值情况呀。
    *   我又将这个插入排序按照冒泡排序的两种思维来思考了，我也确实私下认为这是冒泡
    *   排序的另一种。不知道对不对？
    */
    function insertSortNeighbor($arr){
        for($i=1;$i<count($arr);$i++){
            for($j=$i-1;$j>=0;$j--){
                if($arr[$j+1]<$arr[$j]){
                    $tmp = $arr[$j+1];
                    $arr[$j+1] = $arr[$j];
                    $arr[$j] = $tmp;
                }
            }
        }
        return $arr;
    }
    
    /*
    *   插入排序的时间复杂度为 类 a*n*n,这一次的优化只是减少了 a 的值，
    *   复杂度的级别并没有改变
    */
    function insertSortNeighborWhile($arr){
            for($i=1;$i<count($arr);$i++){
                // 这里用 while 循环来做，更优一点
                $j = $i -1;
                while($j >= 0 && $arr[$j+1]<$arr[$j]){
                    $tmp = $arr[$j+1];
                    $arr[$j+1] = $arr[$j];
                    $arr[$j] = $tmp;
                    --$j;
                }
            }
            return $arr;
    }
    


    /*
    *    快排（快速排序）
    *   大方向上分为递归（recursion）实现和迭代（interation）实现。
    *   私下细分为以下四种：
    *   1. 快排递归实现用第一个元素；
    *   2. 快排递归实现用平均数（也叫折半排序）；
    *   3. 快排迭代实现用第一个元素；
    *   4. 快排迭代实现用平均数（不推荐）。
    */

    /*
    *   快排递归实现必须先理解递归，请看下面的递归简单入门程序
    *    递归简单入门程序
    *   在Php中，每调用一个函数，会开辟一个新栈。递归，可以简单的理解为在自己函数
    *   的执行过程中调用了自己，那么同样的会开辟一个新栈，那么递归就是在此栈的基
    *   础上不断往前开辟新栈，然后从后往前收回新栈，在新栈撤回即返回的过程中,才会
    *   执行递归后面的程序，然后一同返回结果。
    *   我在理解递归的时候，用栈图解画出了此程序，从此递归就变得简单了。
    */

    function recursion($str){
        $str = $str - 1;
        echo $str,"</br>";
        if($str > 2){
            recursion($str);
        }
        echo $str,"</br>";
    }//recursion(5);//4,3,2,2,3,4（用心地理解一下这个结果）


    //快排递归用第一个元素
    function quicksortRecursiveOne($arr) {
        //先判断是否需要继续进行
        $length = count($arr);
        if($length <= 1) {
            return $arr;
        }
        //将数组的第一个数来作为基准数
        $base_num = $arr[0];
        //小于此基准放入左边，大于或等于放入右边。
        $left_array = array();
        $right_array = array();
        for($i=1; $i<$length; $i++){
            if($arr[$i] < $base_num){
                $left_array[] = $arr[$i];
            } else {
                $right_array[] = $arr[$i];
            }
        }
        //再分别对左边和右边的数组进行相同的排序处理方式递归调用这个函数
        $left_array = quicksortRecursiveOne($left_array);
        $right_array = quicksortRecursiveOne($right_array);
        //合并，这个动作发生在撤掉栈返回的时候
        //这个案例的栈图解，私下画了出来，自我感觉十分透彻。
        //个人认为理解这个程序之前，一定要好好理解上面的递归简单入门程序的例子
        return array_merge($left_array,array($base_num),$right_array);
    }

    //快排递归用平均数（对半排序）
    function quicksortRecursiveAvg($arr){
        //先判断是否需要继续进行
        $length = count($arr);
        if($length <= 1) {
            return $arr;
        }
        //对半排序用平均数
        $arr_avg = array_sum($arr)/count($arr);
        //选择数组平均数作为基准，小于此基准放入左边，等于放入中间，大于放在右边。
        //这里要注意，必须要将等于单独拿出来，比如你将大于和等于合并一起放入右边，
        //如果有相等的元素，右边的数组会进入无限的循环，你想想是不是。
        $left_array = array();
        $right_array = array();
        for($i=0; $i<$length; $i++) {
            if($arr_avg > $arr[$i]) {
                $left_array[] = $arr[$i];
            }else if($arr_avg = $arr[$i]){
                $middle_array[] = $arr[$i];
            }else{
                $right_array[] = $arr[$i];
            }
        }
        $left_array = quicksortRecursiveAvg($left_array);
        $right_array = quicksortRecursiveAvg($right_array);
        return array_merge($left_array,$middle_array,$right_array);
    }

    //快排迭代用第一个元素
    //这里的迭代举例来说就是：array(1,2,3)迭代为array(array(3),array(2),array(1))
    //推荐看完代码后，自己设置一个简单的数组，画出图解。
    function quicksortInterationOne($arr){
        $stock = array($arr);
        $sort = array();
        while($stock){
            $arr = array_pop($stock);
            if(count($arr) == 1){//看下面就知道，倒序排列，所以最后一个是最小的。
                $sort[] = $arr[0];//不断地将最小的按顺序放入新的数组，新数组就是从小到大呀。
                continue;//continue会跳转到while()那里，然后继续往下执行
            }
            $base_num = $arr[0];
            $left_array = array();
            $right_array = array();
            for($i=1;$i<count($arr);$i++){
                if($arr[$i] < $base_num)
                    $left_array[] = $arr[$i];
                else
                    $right_array[] = $arr[$i];
            }
            !empty($right_array) && array_push($stock,$right_array);
            array_push($stock,array($base_num));//记得要将$base_num迭代为数组
            !empty($left_array) && array_push($stock,$left_array);
        }
        return $sort;
    }
    //快排迭代用平均数（不推荐）
    function quicksortInterationAvg($arr){
        $stock = array($arr);
        $sort = array();
        while($stock){
            $arr = array_pop($stock);
            if(count($arr) == 1){
                $sort[] = $arr[0];
                continue;
            }
            $base_num = array_sum($arr)/count($arr);
            $left_array = array();
            $middle_array = array();
            $right_array = array();
            for($i=0;$i<count($arr);$i++){
                if($arr[$i] < $base_num){
                    $left_array[] = $arr[$i];
                }else if($arr[$i] == $base_num){
                    //如果有重复的元素，比如$middle_array=array(2,2),
                    //这里不能转化为array(array(2),array(2))，会陷入无限循环。。
                    $middle_array[] = $arr[$i];
                }else{
                    $right_array[] = $arr[$i];
                }
            }
            !empty($right_array) && array_push($stock,$right_array);
            !empty($middle_array) && array_push($stock,$middle_array);
            !empty($left_array) && array_push($stock,$left_array);
        }
            return $sort;
        }

    // $arr = array(5,5,5,4,4,4,3,3,3);
    // var_dump(quicksortRecursiveAvg($arr));

    /*
    *   可以优化的地方（Php）：
    *   1. 加入flag来判断从小到大或是从大到小，可用性更强。
    *   2. 地址传参，可以节省内存。
    *   3. for($i=0,$num=count($arr);$i<$num;$i++){},for循环写成这个样子，
    *      减少了count()的运算，提高了效率。
    *   或许还有很多地方可以优化，我也乐意被告诉。
    *   这篇随笔的重点是这些排序整体思维的比较，这里就保持这简单的样子吧。
    *
    */

```