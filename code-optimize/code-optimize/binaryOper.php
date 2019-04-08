<?php


class Binary{


    public static $flag_shumei = 1; // 0001
    public static $flag_driver = 2; // 0010

    //判断这个标志位是否被设置
    public function isBitSetFlag($flag,$val)
    {
        return (($val & $flag) === $flag);
    }

    /**
     * Notes: 设置标志位
     * User: ${USER}
     * Date: ${DATE}
     * Time: ${TIME}
     * @param $flag
     * @param $val
     * @param $bool
     * @return mixed
     *
     */
    public function setBitflag($flag,$val,$bool){

        if($bool){
            $val |= $flag;
        }else{
            $flag ^= $flag;
            $val &= $flag;
        }

        return $val;
    }

    //初始化二进制的值
    public function initValueBinary(){
        return 0;
    }


}




class Activity{

    /**
     * Notes: 设置二进制位
     * User: ${USER}
     * Date: ${DATE}
     * Time: ${TIME}
     * @param $data
     * bool,如果设置为开启，则为true ；如果设置为关闭，则为 false;
     */
    public function userBinaryCharacter($data){

        $uid = $data['uid'];
        $type = $data['type'];
        $bool = $data['bool'];
        ## 更新和写入
        $model = new UserBinaryCharacter();
        $res = $model->find()->where(['uid'=>$uid])->asArray()->one();
        $cur_time = date('Y-m-d H:i:s');
        if($res){
            $binary_one = $res['binary_one'];
            //设置二进制位
            $binary_one = UserDAO::getInstance()->setBitflag($type,$binary_one,$bool);
            $data = [
                'binary_one' => $binary_one,
                'update_time' => $cur_time
            ];
            //数据库的更新操作
            if($model::updateAll($data, ['uid'=>$uid])){
                //更新redis
                UserDAO::getInstance()->updateRedisUserInfo($uid,$data);
            };

        }else{
            $binary_one = UserDAO::getInstance()->initValueBinary();
            $binary_one = UserDAO::getInstance()->setBitflag($type,$binary_one,$bool);
            //数据库的写入操作
            $model->uid = $uid;
            $model->binary_one = $binary_one;
            $model->create_time = $cur_time;
            $model->update_time = $cur_time;
            if($model->save()){
                //更新redis
                $data = [
                    'binary_one' => $binary_one,
                    'update_time' => $cur_time
                ];
                UserDAO::getInstance()->updateRedisUserInfo($uid,$data);
            };
        }

    }

    public function judgeUserBinaryCharacter($data){

        $uid = $data['uid'];
        $type = $data['type'];
        $user_info = UserDAO::getInstance()->getUserInfoByUid($uid);
        $bool = false;
        if(isset($user_info['binary_one']) && (UserDAO::getInstance()->isBitSetFlag($type,$user_info['binary_one']))){
            $bool = true;
        }
        return $bool;
    }
}





?>