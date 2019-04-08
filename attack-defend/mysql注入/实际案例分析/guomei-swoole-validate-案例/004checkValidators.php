<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/21
 * Time: 9:41
 */

namespace library\base;

/**
 * checkValidators 检测变量是否在指定格式
 * @system 5262 <华人金融互联网金融系统>
 * @author xinting.zhang <xinting.zhang@5262.com>
 * @date        2016-03-21
 */
class checkValidators
{
    /**
     * 根据函数类型进行分类验证
     * @param $date =array(
     *  "values"=>val //提交变理值
     *  "range" =>array() 数组
     * )
     * @return bool true|false
     */
    public function checkValidators($vali)
    {
        $_infoArray = true;
        
        $vali['allowEmpty'] = isset($vali['allowEmpty'])?$vali['allowEmpty']:true;
        if($vali['allowEmpty']==='false'){
            return $_infoArray;
        }

        switch (strtolower($vali['type'])) {
            case 'required':
                $sval[$vali['id']] = $vali['_val'];

                if($vali['obj']->checkrequireds($sval)===false){
                    $_infoArray = $vali['msg'];
                }
                break;
            case 'int':
                if ( !is_numeric($vali['_val']) || $vali['_val'] < 0) {
                    $_infoArray = $vali['msg'];
                }
                break;
            case 'notnull':
                if($this->isEmpty($vali['_val']) ){
                    $_infoArray = $vali['msg'];
                }
                break;
            case 'length':
                if(!$this->checklength($vali)){
                    $_infoArray = $vali['msg'];
                }
                break;

            case 'email': //邮箱检测
                if(!$this->checkemail($vali['_val'])){
                    $_infoArray = $vali['msg'];
                }
                break;
            case 'phone': //电话检测
                if(!$this->checkphone($vali['_val'])){
                    $_infoArray = $vali['msg'];
                }
                break;

            case 'compare': //比较
                if(!$this->checkcompare($vali)){
                    $_infoArray = $vali['msg'];
                }
                break;
            case 'date'://日期
                if(!$this->checkdate($vali)){
                    $_infoArray = $vali['msg'];
                }
                break;

            case 'match': //正则
                if(!$this->checkmatch($vali)){
                    $_infoArray = $vali['msg'];
                }
                break;

            case 'in':
                if(!$this->checkRange($vali)){
                    $_infoArray = $vali['msg'];
                }
                break;

            default:
                $msgArr = E_PUBLIC_PARAMETER;
                throw new myException($msgArr[0], $msgArr[1]);
        }

        return $_infoArray;
    }

    /**
     * 检测是否为日期类型
     * @param $date =array(
     *  "values"=>val //提交变理值
     *  "format" =>"Y-m-d H:i:s" //格式
     * )
     * @return bool true|false
     */
    protected  function checkdate($vali)
    {
        $vali['format'] = empty($vali['format']) ? 'Y-m-d H:i:s' : $vali['format'];
        $d = DateTime::createFromFormat($vali['format'], $vali['_val']);
        return $d && $d->format($vali['format']) == $vali['_val'];
    }
    /**
     * 检测字符串长度是否在指定范围内
     * @param $date =array(
     *  "values"=>val //提交变理值
     *  "min" =>1 //最小长度
     *  "max" =>5  //最大长度
     * )
     * @return bool true|false
     */
    protected function checklength($vali){

        if(empty($vali['max']) && empty($vali['min'])){
            return false;
        }
        if(!empty($vali['min']) && mb_strlen($vali['_val'])<$vali['min']){
            return false;
        }
        if(!empty($vali['max']) && mb_strlen($vali['_val'])>$vali['max']){
            return false;
        }
        return true;
    }

    /**
     * 检测是否为邮箱
     * @param $email //email地址
     * @return bool true|false
     */
    protected function checkemail($email){
        $pattern = '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i';
        if ( preg_match( $pattern, $email ) ) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * 检测是否为手机号码
     * @param $phone // 手机号码
     * @return bool true|false
     */
    protected function checkphone($phone){
        $pattern = '/1[34578]{1}\d{9}$/';
        if(preg_match($pattern,$phone)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 字符串之间比较
     * @param $date =array(
     *  "values"=>val //比较字符串
     *  "compareval" =>compareval //目标比较字符串
     *  "operator" =>""  //类型有 ==,!=,>,>=,<,<=
     * )
     * @return bool true|false
     */
    protected function checkcompare($vali){
        if(empty($vali[$vali['compareAttribute']]) || empty($vali['_val'])){
            return false;
        }

        $vali['operator'] = empty($vali['operator'])?'==':$vali['operator'];
        $sFlag =true;
        switch($vali['operator'])
        {
            case '==':
                if($vali['_val'] !== $vali[$vali['compareAttribute']]){
                    $sFlag = false;
                }
                break;
            case '!=':
                if($vali['_val'] == $vali[$vali['compareAttribute']]){
                    $sFlag = false;
                }
                break;
            case '>':
                if($vali['_val'] <= $vali[$vali['compareAttribute']]){
                    $sFlag = false;
                }
                break;
            case '>=':
                if($vali['_val'] < $vali[$vali['compareAttribute']]){
                    $sFlag = false;
                }
                break;
            case '<':
                if($vali['_val'] >$vali[$vali['compareAttribute']]){
                    $sFlag = false;
                }
                break;
            case '<=':
                if($vali['_val'] >= $vali[$vali['compareAttribute']]){
                    $sFlag = false;
                }
                break;
            default:
                $sFlag = false;
        }
        return $sFlag;
    }

    /**
     * 正则检验
     * @param $date =array(
     *  'Field name' 字段名
     *  "allowEmpty"=>val //提交变理值
     *  "not" =>"true" 是否包括在内
     *  "pattern"=> 正则表达式
     * )
     * @return bool true|false
     */
    protected function checkmatch($vali){

        $vali['allowEmpty'] = empty($vali['allowEmpty'])?false:$vali['allowEmpty'];
        $vali['not'] = empty($vali['not'])?false:$vali['not'];

        if($vali['allowEmpty'] && $this->isEmpty($vali['_val']) ){
            return false;
        }

        if($this->isEmpty($vali['pattern']) ){
            return false;
        }

        if(is_array($vali['_val']) || (!$vali['not'] && !preg_match($vali['pattern'], $vali['_val'])) ||
            ($vali['not'] && preg_match($vali['pattern'], $vali['_val']))) {
            return false;
        }else{
            return true;
        }
    }

    /**
     * 检测当前值是否在数组内
     * @param $date =array(
     *  'Field name' 字段名
     *  "range" =>array() 数组
     * )
     * @return bool true|false
     */
    protected  function checkRange($vali)
    {
        if(empty($vali['_val']) && empty($vali['range'])){
            return false;
        }

        return in_array($vali['_val'],$vali['range'],true);
    }


    /**
     * 检测是否否为空
     * @param mixed $value the value to be checked
     * @param boolean $trim whether to perform trimming before checking if the string is empty. Defaults to false.
     * @return boolean whether the value is empty
     */
    protected function isEmpty($value,$trim=false)
    {
        return $value===null || $value===array() || $value==='' || $trim && is_scalar($value) && trim($value)==='';
    }

}