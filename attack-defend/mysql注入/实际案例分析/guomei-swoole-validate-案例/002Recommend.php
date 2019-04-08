<?php
namespace modules\member;
use modules\member\Model\RecommendModel;
use modules\member\Model\UsersModel;
use library\base\baseCon;
use library\base\myException;
use modules\member\Model\outData;


class Recommend extends baseCon
{
    public $RecommendM;
    private $outData;
    public function __construct(){
        $this->RecommendM = new RecommendModel();
        $this->outData = new outData();
    }

    /*定义需要判断字段规则*/
    public function rules(){
        return [
            ['id'=>"userid", 'type'=>'int','msg'=>E_PUBLIC_USERID],
            ['id'=>"recommend_id", 'type'=>'int','msg'=>E_MEMBER_RECOMMEND_ID],
            ['id'=>"my_into_id", 'type'=>'int','msg'=>E_MEMBER_MY_INTO_ID],
            ['id'=>"is_status", 'type'=>'in','range'=>[0,1],'msg'=>E_MEMBER_IS_STATUS],
            ['id'=>"remark", 'type'=>'length','max'=>64,'msg'=>E_PUBLIC_REMARK],
            ['id'=>"sys_is_del", 'type'=>'in','range'=>[0,1],'msg'=>E_PUBLIC_IS_DEL],
            ['id'=>"update_time", 'type'=>'int','msg'=>E_UPDATE_TIME],
            ['id'=>"create_time", 'type'=>'int','msg'=>E_PUBLIC_TIME],
        ];
    }

    /**
     * 获取直接推荐人ID
     * @param array $data = ['userid'=>$userid]
     * @return array
     */
    public function getMyIntoId(array $data){
        try{
            $this->validators($data);
            $result = $this->RecommendM->select($data,'my_into_id');
            if($result && $result != 0){
                $results = ['result' => $result[0]];
                return $this->outData->setData($results)->getData();
            }else{
                return $this->outData->setCodeMsg(E_MEMBER_RECOMMEND_MYINTOID)->getData();
            }
        }catch (myException $e){
            return $e->showMsg();
        }
    }

    /**
     * 获取顶级推荐人ID（顶级推荐人必须是理财经理）
     * @param array $data
     * @return array
     */
    public function getMyTopIntoId(array $data){
        $res_first = $this->getMyIntoId($data);
        if($res_first['code'] != E_PUBLIC_SUCCESS[0]){
            return $this->outData->setCodeMsg(E_MEMBER_RECOMMEND_FIRSTMYINTOID)->getData();
        }
        $where = ['userid'=>$res_first['data']['result']];
        $res_second = $this->getMyIntoId($where);
        if($res_second['code'] != E_PUBLIC_SUCCESS[0]){
            return $this->outData->setCodeMsg(E_MEMBER_RECOMMEND_FIRSTMYINTOID)->getData();
        }
        $usersModel = new UsersModel;
        $where = ['userid'=>$res_second['data']['result']];
        try{
            $this->validators($where);
            $res_three  = $usersModel->select($where,'is_manages');
            if($res_three[0] == '1'){
                $results = ['result'  => $res_second['data']['result']];
                return $this->outData->setData($results)->getData();
            }else{
                return $this->outData->setCodeMsg(E_MEMBER_RECOMMEND_FIRSTMYINTOID)->getData();
            }
        }catch (myException $e){
            return $e->showMsg();
        }
    }

    /**
     * 修改推荐关系
     * @param array $data=['where'=>['userid'=>$userid],
                            'data'=>[]]
     * @return array
     */
    public function putUpdate(array $data){
        $where = $data['where'];
        $data = $data['data'];
        $data['update_time'] = time();
        try{
            $this->validators($data);
            // return $this->RecommendM;
            $result = $this->RecommendM->update($where,$data);
            if($result){
                $results = ['result' => $result];
                return $this->outData->setData($results)->getData(); 
            }else{
                return $this->outData->setCodeMsg(E_MEMBER_RECOMMEND_CHANGESTATUS)->getData();
            }
        }catch (myException $e){
            return $e->showMsg();
        }

    }

    
}