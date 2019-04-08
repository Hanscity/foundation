<?php

/*
 * data_account 控制层中间件，主要为方便以后扩展使用
 * @system 5262 <华人金融互联网金融系统>
 * @version V2.0
 * @author jack.zhang <xinting.zhang@5262.com>
 * @date   2015-02-01
 */

namespace library\base;

use library\base\checkValidators;

abstract class baseCon
{
    
    abstract protected function rules();


    /**
     * 提示信息导入
     * 根据模块，进行对应的msg进行加载
     */
    public function tagsinfo()
    {
       
    }

    /**
     * post 验证主函数
     * @param $seachArr post提交的参数
     * @return bool true|false
     */
    public  function  validators($seachArr=array())
    {
        $checkObj = new checkValidators();
        foreach($this->rules() as $key =>$val){

            if(array_key_exists($val['id'],$seachArr)){
                $val['_val'] = $seachArr[$val['id']];

                if(!empty($val['compareAttribute'])){
                    $val[$val['compareAttribute']] = $seachArr[$val['compareAttribute']];
                }

                $result  = $checkObj->checkvalidators($val);

                if($result!==true){
                    throw new myException($result[0],$result[1]);
                }
            }
        }
        return true;
    }




    /**
     * 返回json格式数据
     * 使用方法:
     * <code>
     * ajaxReturn($array); 获取$array数组
     * </code>
     * @return mixed  输出json格式数据
     */
    public function ajaxReturn($array)
    {

            $array['data'] = $array['data'];
            return  json_encode($array);
    }


}
