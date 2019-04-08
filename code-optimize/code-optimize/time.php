<?php

/**
 * Notes: 设置当前的月份的每天的固定时间段
 * User: ${USER}
 * Date: ${DATE}
 * Time: ${TIME}
 * @return array
 */
function packageCurMonthAllDay(){
    //获取当前时间，于是得到当前月份的所有天数
    $cur_date = date('Y-m',time());
    $year = substr($cur_date,0,4);
    $month = substr($cur_date,5,2);
    $start_date = "$year-$month-01";
    $month_next = $month + 1;
    $end_date = ($month_next<10) ? "$year-0$month_next-01" : "$year-$month_next-01";

    //设置每天的时间段
    $arr_time = [];
    $arr_hour_min = [['18:01','19:00'],['19:01','20:00'],['20:01','21:00'],['21:01','22:00']];

    //组装成三维数组
    $j = 1;
    for($i=strtotime($start_date);$i<strtotime($end_date);$i += 24*3600){
        $j_use = ($j<10) ? "0$j" : $j;
        for($k = 0;$k < 4; $k ++){
            $arr_time[$j][$k][] = "$year-$month-$j ".$arr_hour_min[$k][0];
            $arr_time[$j][$k][] = "$year-$month-$j ".$arr_hour_min[$k][1];
        }
        $j++;
    }
    return $arr_time;
}


?>