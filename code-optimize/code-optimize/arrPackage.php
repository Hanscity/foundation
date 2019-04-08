<?php
    
/*
-------------------------------------------------------------------method my

    /* swoole 将数据库的数据做成了数据服务，各服务之间，不能联表，于是需要组装数据
    *  我的思路如下：
    *  各 DB 服务返回的都是二维数组数据：
    */

    $arr001 = [['ppid'=>1111,'product_name'=>'ch001'],['ppid'=>1112,'product_name'=>'ch002']];
    $arr002 = [['ppid'=>1111,'add_name'=>'cl001'],['ppid'=>1113,'add_name'=>'cl003']];
    $pk = 'ppid';
    // 其实非常类似于最简单的冒泡排序
    function arrPackage($main,$add,$pk){
        foreach($main as $key001=>$value001){
            foreach($add as $key002=>$value002){
                if($value001[$pk] == $value002[$pk]){
                    foreach($value002 as $key003=>$value003){
                        $main[$key001][$key003] = $value003;
                    }
                }
            }
        }
        return $main;
    }

    $res  = arrPackage($arr001,$arr002,$pk);

    echo "<pre>";
    var_dump($res);
    echo "</pre>";

/*
-------------------------------------------------------------------method two
*/

/*
*   以下是一个很帅的小伙伴写的，
*   将一个简单的程序绕一圈，结果也是对的，说实话，我看了半天。。
*/
    
    $arr001 = [['ppid'=>1111,'product_name'=>'ch001'],['ppid'=>1112,'product_name'=>'ch002']];
    $arr002 = [['ppid'=>1111,'add_name'=>'cl001'],['ppid'=>1113,'add_name'=>'cl003']];
    $arr003 = ['ppid' => $arr002,'add_name' => $arr002];
    $pk = 'ppid';

    
    /**
     * 多DB服务数据重组方法，代替JOIN 连表查询方法
     * @auth: 。。。
     * @DateTime: 2017-06-15 10:47:46
     * @param array $key_list 主表数据列表
     * @param array $for_list 从表关联数据['freeze_money' => $list,'prov'=>$prov_list],   格式 主表字段 =>字段所在列表,可以传递多组对应关系
     *                          注：KEY值必须与从表的字段名相同
     * @param string $pk 关联字段名
     * @return array    重组后的数据 注：如果没有查找到相关数据将不会将添加对应KEY
     */
    function re_list($key_list = array(), $for_list, $pk)
    {
        foreach ($for_list as $colm_name => $listP) {
            if (!empty($listP)) {
                foreach ($key_list as $key_list_key => $key_list_value) {
                    foreach ($listP as $key => $value) {
                        if (isset($key_list_value[$pk]) && isset($value[$pk]) && $key_list_value[$pk] == $value[$pk]) {
                            $key_list[$key_list_key][$colm_name] = $listP[$key][$colm_name];
                        }
                    }
                }
            } else {
                $key_list[0][$colm_name] = '';
            }
        }
        return $key_list;
    }

    $res002  = re_list($arr001,$arr003,$pk);

    echo "<pre>";
    var_dump($res002);
    echo "</pre>";

    
?>