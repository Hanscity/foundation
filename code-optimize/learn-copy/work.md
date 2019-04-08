## LEARN

```

<?php

    /*----------------------------------------------------------------------------------------------------------------------
    *
    *   获取信息的方法
    * -----------------------------------------------------------------------------------------------------------------------------*/
    class GetMessage{

        public function getMessage(){
            //获取某挂件信息
            $OneDecrorationInfo = DecrorationDAO::getOneDecroration($decroration_id);

            //查开付款人是否开通vip 并且进行打折
            $vipInfo = UserVipDAO::getUserVipTypeInfo($uid);
            $discount = self::discount;
            if($vipInfo['vip_type'] >=1){
                $discount = $vipInfo['levelInfo']['decroration_discount'];
            }
            $discount = abs($discount);
            if($discount > 0){
                $price = intval($price*$discount/100);
            }




        }
    }

    /*----------------------------------------------------------------------------------------------------------------------
    *
    *   获取精确时间
    * -----------------------------------------------------------------------------------------------------------------------------*/
    class Timetamp{

        public function getTamp(){

            //获取当前时间戳，保留到小数点后6位--获取订单号，也是用的这个
            var_dump(intval(CommUtils::getmicrotime_no()));
            //获取当前时间戳，保留到小数点后4位
            var_dump(CommUtils::getmicrotime_float());

            /**
             * 获取毫秒 时间戳 16位
             * 这一层的封装是冗余的
             * @return string
             */
            public static function getmicrotime_no()
            {
                return self::getLogId();
            }

            /**
             * 获取日志id
             * @return string
             *
             *  警告
                在PHP 5中，list（）分配从最右边的参数开始的值。在PHP 7中，list（）以最左边的参数开头。
                如果使用纯变量，则不必担心这一点。但是如果你使用带索引的数组，你通常会期望数组中索引的顺序与list（） 中从左到右的顺序相同，这与PHP 5中的情况不同，因为它是以相反的顺序分配的。
                一般来说，建议避免依赖特定的操作顺序，因为这可能在将来再次发生变化。
             *  其实在 PHP5.6 后，就开始以左边的参数开头了--ch
             */
            public static function getLogId()
            {
                list($tmp1, $tmp2) = explode(' ', microtime());
                $tmp1 = str_pad(intval($tmp1 * 1000000), 6, '0', STR_PAD_LEFT);
                return $tmp2 . $tmp1;
            }

            /**
             * 获取毫秒 时间戳
             * @return type
             */
            public static function getmicrotime_float()
            {
                list($usec, $sec) = explode(" ", microtime());
                return $usec + $sec;
            }


        }
    }

    /*----------------------------------------------------------------------------------------------------------------------
    *
    *   检测用户的方法
    * -----------------------------------------------------------------------------------------------------------------------------*/
    class CheckUser{

        public function checkUser($ReqMessage){
            //检测用户的uid 和 auth 值
            $uid  = $ReqMessage->getHead()->getUid();
            $auth = $ReqMessage->getHead()->getAuth();
            $UserInfo = CommUtils::getUserInfoAndCheckAuth($uid, $auth);
            if(isset($UserInfo['code'])){
                $RetCodeMsg = $UserInfo;
                return RspMsg::rspMsg($ReqMessage->getHead(), $RetCodeMsg, \MSG::Rsp_BuyDecroration);
            }
            //检测用户的 uid
            if( !empty( $to_uid) ) {
                $toUserInfo = UserService::getUserDAOInstance()->getUserInfoByUid($to_uid);
                if( !$toUserInfo ){
                    $RetCodeMsg = RetCodeMsg::UserNotExist();
                    return RspMsg::rspMsg($ReqMessage->getHead(), $RetCodeMsg, \MSG::Rsp_BuyDecroration);
                }
            }

        }
    }





    /*----------------------------------------------------------------------------------------------------------------------
    *
    * 主逻辑的封装--$returnInfo 的用法
    * -----------------------------------------------------------------------------------------------------------------------------*/
    class BuyDecroration{

        /**
         * 购买挂件
         * @param $ReqMessage \Message
         * @return string
         */
        public function doBuyDecroration($ReqMessage){
            //
            $returnInfo = DecrorationDAO::doBugOneDecroration($id,$uid,$month,$to_uid,$myDecrorationUrl,$otherDecrorationUrl,$decrorationMostlyName);

            if ( isset($returnInfo['code']) && $returnInfo['code'] !== 0) {
                return RspMsg::rspMsg($ReqMessage->getHead(), $returnInfo, \MSG::Rsp_BuyDecroration);
            }
            $RspBuyDecroration = new \RspBuyDecroration();
            $DecrorationInfo = new \DecrorationInfo();
            $DecrorationInfo->setGoodsId($returnInfo['id']);
            $DecrorationInfo->setExpireTime($returnInfo['expire_time']);
            $DecrorationInfo->setLeftTime($returnInfo['left_time']);
            $RspBuyDecroration->setDecrorationInfo($DecrorationInfo);

            $UserInfo = UserService::getUserInfoByUid($uid);
            $userPropertyInfoObj = UserService::getUserDAOInstance()->getPbUserPropertyInfo($UserInfo);
            $RspBuyDecroration->setUserPropertyInfo($userPropertyInfoObj);
            $RetCodeMsg = RetCodeMsg::Success();
            $Rsp = new \Rsp();
            $Rsp->setRetCode( $RetCodeMsg['code'] );
            $Rsp->setRetMsg( $RetCodeMsg['msg'] );
            $Rsp->setRspBuyDecroration( $RspBuyDecroration );
            $Message = new \Message();
            $Message->setHead( $ReqMessage->getHead() );
            $Message->setRsp( $Rsp );
            $Message->setType( \MSG::Rsp_BuyDecroration );
            return $Message->serializeToString();

        }



        /**购买挂件或者特效
         * @param $id
         * @param $uid
         */
        public static function doBugOneDecroration($id,$uid,$month,$toUid = '',$myDecrorationUrl,$otherDecrorationUrl,$decrorationMostlyName,$coinType=1){

            // 定制挂件的判断--情侣挂件和家族定制挂件都不能赠送,所以 $toUid = 0 在这里；
            if($toUid == ''){
                $type = $OneDecrorationInfo['type'];
                if($type == 5){
                    LoggerUtils::info("1"."||LINE".__LINE__ ."||FILE". __FILE__,'app-ch.log');
                    $userCoupleInfo = BiaoBaiDAO::getUserCoupleInfoByUid($uid);
                    if(!((isset($userCoupleInfo['status']) && $userCoupleInfo['status'] == 1))){
                        return  RetCodeMsg::isNotCoupleRelation();
                    }
                }
                if($type == 6){
                    LoggerUtils::info("1"."||LINE".__LINE__ ."||FILE". __FILE__,'app-ch.log');
                    $teamInfo = FamilyMember::find()->where(['uid'=> $uid])->asArray()->one();
                    $realTeamInfo = TeamMember::find()->where(['uid'=>$uid])->asArray()->one();
                    if((empty($teamInfo) || $teamInfo['role'] != 1) && (empty($realTeamInfo) || $realTeamInfo['role'] != 1)){
                        return  RetCodeMsg::TeamMasterIsNotExists();
                    }
                }

            }

            //doing...
            return ['expire_time'=>$expire_time,'left_time'=>$left_time,'id'=>$id];
        }



    }


    /*----------------------------------------------------------------------------------------------------------------------
    *
    *   数据库和redis  的增删改查
    *
    * -----------------------------------------------------------------------------------------------------------------------------*/
    class basicAction{

        //展示
        public $arr_point_select = [
            0=>'不跳转',
            1=>'跳转到房间',
            2=>'成为 3天 CP，跳转 CP',
        ];
        public function actionChatterbox(){

            $query =  ChatterBoxQuestion::find()->where('is_del =:is_del',[':is_del' => 0]);
            $query->orderBy('create_time desc');
            $pagination = new Pagination([ 'totalCount' => $query->count() , 'pageSize' =>15 ]);
            $rows = $query -> offset($pagination->offset)->orderBy('id Desc')->limit($pagination->limit)->asArray()->all();


            return $this->render('chatterbox',[
                'rows' => $rows,
                'pagination' =>$pagination,
                'arr_point_select' =>$this->arr_point_select,

            ]);

        }

        public function actionAddchatterbox() {
            $this->view->title = '增加';
            if(Yii::$app->request->isPost){
                $mostly_url_final = "";
                if(!empty($_FILES['mostly_url']['tmp_name'])){
                    $qiniu = new QiniuUtils();
                    $mostly_url = time(). rand(10000, 99999);
                    $qiniu->uploadFile($_FILES['mostly_url']['tmp_name'], $mostly_url);
                    $mostly_url_final = $mostly_url;
                }
                $data = [];
                $data['pic_key'] = $mostly_url_final;
                $data['sum_point_two_msg'] = Yii::$app->request->post('sum_point_two_msg');
                $data['sum_point_three_msg'] = Yii::$app->request->post('sum_point_three_msg');
                $data['sum_point_four_msg'] = Yii::$app->request->post('sum_point_four_msg');
                $data['sum_point_five_msg'] = Yii::$app->request->post('sum_point_five_msg');
                $data['sum_point_six_msg'] = Yii::$app->request->post('sum_point_six_msg');
                $data['sum_point_seven_msg'] = Yii::$app->request->post('sum_point_seven_msg');
                $data['sum_point_eight_msg'] = Yii::$app->request->post('sum_point_eight_msg');
                $data['sum_point_nine_msg'] = Yii::$app->request->post('sum_point_nine_msg');
                $data['sum_point_ten_msg'] = Yii::$app->request->post('sum_point_ten_msg');
                $data['sum_point_eleven_msg'] = Yii::$app->request->post('sum_point_eleven_msg');
                $data['sum_point_twelve_msg'] = Yii::$app->request->post('sum_point_twelve_msg');
                $data['admin_name'] = \Yii::$app->admin->identity->username;
                $data['point_two_select'] = Yii::$app->request->post('point_two_select');
                $data['point_three_select'] = Yii::$app->request->post('point_three_select');
                $data['point_four_select'] = Yii::$app->request->post('point_four_select');
                $data['point_five_select'] = Yii::$app->request->post('point_five_select');
                $data['point_six_select'] = Yii::$app->request->post('point_six_select');
                $data['point_seven_select'] = Yii::$app->request->post('point_seven_select');
                $data['point_eight_select'] = Yii::$app->request->post('point_eight_select');
                $data['point_nine_select'] = Yii::$app->request->post('point_nine_select');
                $data['point_ten_select'] = Yii::$app->request->post('point_ten_select');
                $data['point_eleven_select'] = Yii::$app->request->post('point_eleven_select');
                $data['point_twelve_select'] = Yii::$app->request->post('point_twelve_select');
                $model = new ChatterBoxQuestion();
                $model->setAttributes($data);

                if($model->save()){
                    ChatterBoxDAO::getInstance()->addChatterBoxQuestionRedis($model->id);
                    $this->redirect(Url::toRoute('config/chatterbox'));
                }else{
                    return  parent::showErrorPage('添加失败，请重试！', 'config/chatterbox');
                }
            }

            return  $this->render('addchatterbox', [
                'arr_point_select' =>$this->arr_point_select,
            ]);
        }


        public function actionEditchatter() {
            $this->view->title = '编辑';
            if(Yii::$app->request->isPost){
                $mostly_url = "";
                if(!empty($_FILES['mostly_url']['tmp_name'])){
                    $qiniu = new QiniuUtils();
                    $mostly_url = time(). rand(10000, 99999);
                    $qiniu->uploadFile($_FILES['mostly_url']['tmp_name'], $mostly_url);
                    $qiniu->getLink($mostly_url);
                }
                $id = Yii::$app->request->post('id');
                $data = [];
                $pic_old = Yii::$app->request->post('pic_old');
                $data['pic_key'] = empty($mostly_url) ? $pic_old : $mostly_url;
                $data['sum_point_two_msg'] = Yii::$app->request->post('sum_point_two_msg');
                $data['sum_point_three_msg'] = Yii::$app->request->post('sum_point_three_msg');
                $data['sum_point_four_msg'] = Yii::$app->request->post('sum_point_four_msg');
                $data['sum_point_five_msg'] = Yii::$app->request->post('sum_point_five_msg');
                $data['sum_point_six_msg'] = Yii::$app->request->post('sum_point_six_msg');
                $data['sum_point_seven_msg'] = Yii::$app->request->post('sum_point_seven_msg');
                $data['sum_point_eight_msg'] = Yii::$app->request->post('sum_point_eight_msg');
                $data['sum_point_nine_msg'] = Yii::$app->request->post('sum_point_nine_msg');
                $data['sum_point_ten_msg'] = Yii::$app->request->post('sum_point_ten_msg');
                $data['sum_point_eleven_msg'] = Yii::$app->request->post('sum_point_eleven_msg');
                $data['sum_point_twelve_msg'] = Yii::$app->request->post('sum_point_twelve_msg');
                $data['admin_name'] = \Yii::$app->admin->identity->username;
                $data['update_time'] = date('Y-m-d H:i:s');
                $data['point_two_select'] = Yii::$app->request->post('point_two_select');
                $data['point_three_select'] = Yii::$app->request->post('point_three_select');
                $data['point_four_select'] = Yii::$app->request->post('point_four_select');
                $data['point_five_select'] = Yii::$app->request->post('point_five_select');
                $data['point_six_select'] = Yii::$app->request->post('point_six_select');
                $data['point_seven_select'] = Yii::$app->request->post('point_seven_select');
                $data['point_eight_select'] = Yii::$app->request->post('point_eight_select');
                $data['point_nine_select'] = Yii::$app->request->post('point_nine_select');
                $data['point_ten_select'] = Yii::$app->request->post('point_ten_select');
                $data['point_eleven_select'] = Yii::$app->request->post('point_eleven_select');
                $data['point_twelve_select'] = Yii::$app->request->post('point_twelve_select');

                $model = new ChatterBoxQuestion();
                $res = $model::updateAll($data, ['id'=>$id]);
                if($res == 1){
                    ChatterBoxDAO::getInstance()->reloadChatterBoxInfo($id);
                    $this->redirect(Url::toRoute('config/chatterbox'));
                }else{
                    return  parent::showErrorPage('编辑失败，请重试！', 'config/chatterbox');
                }
            }

            $id = Yii::$app->request->get('id');
            $row = ChatterBoxQuestion::find()->where(['id'=>$id])->asArray()->one();
            return  $this->render('editchatterbox', [
                'row'=>$row,
                'arr_point_select' =>$this->arr_point_select,
            ]);
        }



        public function actionDelchatterbox(){
            if($_POST){
                $num=ChatterBoxQuestion::find()->where(['is_del'=>0])->count();
                if($num!=1){
                    $id = Yii::$app->request->post("id", 0);
                    ChatterBoxDAO::getInstance()->delChatterBoxQuestion($id);
                    die(json_encode(['code'=>0, 'info'=>"操作成功"]));
                }else{
                    die(json_encode(['code'=>1000, 'info'=>'无法删除，至少保留一套话匣子题目']));
                }
            }
            die(json_encode(['code'=>1000, 'info'=>'非法操作']));
        }


        //增加题库
        public function addChatterBoxQuestionRedis($id){
            RedisService::sadd($this->getRedisSource(), self::CHATTERBOX_QUESTION_SET_KEY, $id);
        }
        //删除题库
        public function delChatterBoxQuestion($id){
            ChatterBoxQuestion::updateAll(['is_del'=>1],['id'=>$id]);
            RedisService::srem($this->getRedisSource(), self::CHATTERBOX_QUESTION_SET_KEY, $id);
        }

        //获取所有题库--方便检查
        public function getAllChatterBoxQuestionRedis(){
            $infos = RedisService::smembers($this->getRedisSource(), self::CHATTERBOX_QUESTION_SET_KEY);
            return $infos;
        }

        //初始化题库--如果谁删掉了数据库，使用这个方法重新加载所有
        public function initChatbox(){
            RedisService::del($this->getRedisSource(), self::CHATTERBOX_QUESTION_SET_KEY);
            $rows = ChatterBoxQuestion::find()->where(['is_del'=>0])->asArray()->all();
            foreach ($rows as $row){
                $id = $row['id'];
                RedisService::sadd($this->getRedisSource(), self::CHATTERBOX_QUESTION_SET_KEY, $id);
            }
        }


        public function getChatterBoxQuestionInfo($id){
            $key = $this->getChatterBoxQuestionInfoKey($id);
            $HashRows = RedisService::hgetall(self::getRedisSource(), $key);
            if (count($HashRows) > 0) {
                $row = CommUtils::getArrayByHash($HashRows);
            } else {
                $row = $this->reloadChatterBoxInfo($id);
            }
            return $row;
        }


        public function reloadChatterBoxInfo($id){

            RedisService::del($this->getRedisSource(),$this->getChatterBoxQuestionInfoKey($id));
            $ChatterBoxQuestion = ChatterBoxQuestion::find()->where(['id'=>$id])->asArray()->one();
            if($ChatterBoxQuestion){
                RedisService::hmset($this->getRedisSource(), $this->getChatterBoxQuestionInfoKey($id), $ChatterBoxQuestion, RD_DAY_EXPIRE);
            }
            return $ChatterBoxQuestion;
        }


        public function getChatterBoxQuestionInfoKey($id){
            return self::CHATTERBOX_QUESTION_INFO_KEY.$id;
        }



    }





    class Notice{


        /**
         * Notes: 这是典型的通知消息
         * User: ${USER}
         * Date: ${DATE}
         * Time: ${TIME}
         * @param $from_uid --主动方
         * @param $to_uid --被动方
         */
        public function sendMsgRelieveCp($from_uid,$to_uid){
            //发通知
            $from_info = UserDAO::getInstance()->getUserInfoByUid($from_uid);
            $to_info = UserDAO::getInstance()->getUserInfoByUid($to_uid);
            $from_nick = $from_info['nick'];
            $to_nick = $to_info['nick'];

            $msg = "你已经解除了与".$to_nick."的CP关系，3日恋爱计划已关闭，聊天置顶已取消，希望你们都可以找到更好的人。";
            $content = "你已经解除了与".$to_nick."的CP关系，3日恋爱计划已关闭，聊天置顶已取消，希望你们都可以找到更好的人。";
            $push_data = [
                'chat_username' => [CommUtils::getChatUserName($from_uid)],
                'msg' => $msg,
                'content' => $content,
            ];
            NoticeDAO::pushNoticMsgList($push_data);

            $msg = $from_nick."已经解除了与你的CP关系，3日恋爱计划已关闭，聊天置顶已取消，希望你们都可以找到更好的人。";
            $content = $from_nick."已经解除了与你的CP关系，3日恋爱计划已关闭，聊天置顶已取消，希望你们都可以找到更好的人。";
            $push_data = [
                'chat_username' => [CommUtils::getChatUserName($to_uid)],
                'msg' => $msg,
                'content' => $content,
            ];
            NoticeDAO::pushNoticMsgList($push_data);


        }
    }

    /**
     * 这是典型的私聊发送消息，由通知改造而来
     * Notes: 结成 CP在私聊页发送信息
     * User: ${USER}
     * Date: ${DATE}
     * Time: ${TIME}
     * @param $uid
     */
    public function sendMsgDoCpChat($uid){

        //发通知
        $cp_info = $this->getUserCpInfo($uid);
        $from_username = $cp_info['uid_two'];
        $from_user_info = UserDAO::getInstance()->getUserInfoByUid($cp_info['uid_two']);
        $from_user_nick = $from_user_info['nick'];
        $from_user_chat = CommUtils::getChatUserName($cp_info['uid_two']);
        $message_type = 43;

        $msg = "恭喜你们牵手成功，成功解锁3日cp。\n\n>>恋爱小tips：你可以跟另一半进入语音畅聊，情侣头像、互送礼物表达爱意、换昵称、给对方唱歌、哄对方睡觉，前往我的-3日恋爱计划完成3日恋爱计划，可以加速你们的情感升温哦~ \n\n点击表白大厅及亲密值都可以对ta表白，解锁更多恋爱新姿势，接受大家的祝福，恋爱升级~希望你们就是对方一直在等的那个人~";
        $content = "恭喜你们牵手成功，成功解锁3日cp。\n\n>>恋爱小tips：你可以跟另一半进入语音畅聊，情侣头像、互送礼物表达爱意、换昵称、给对方唱歌、哄对方睡觉，前往<ml>我的-3日恋爱计划</ml>完成3日恋爱计划，可以加速你们的情感升温哦~ \n\n点击表白大厅及亲密值都可以对ta表白，解锁更多恋爱新姿势，接受大家的祝福，恋爱升级~希望你们就是对方一直在等的那个人~";

        $links[] = CommUtils::getChatMsgLink("我的-3日恋爱计划", URL_APP_CP_THREE_TASK);
        $push_data = [
            'chat_username' => [CommUtils::getChatUserName($uid)],
            'msg' => $msg,
            'content' => $content,
            'links' => $links,
            'from_username' => $from_username,//传递发送方的 uid
            'from_user_nick' => $from_user_nick,//传递发送方的 nick
            'from_user_chat' => $from_user_chat,//传递发送方的 chat
            'message_type' => $message_type,//消息类型--这种情况下，默认位0
        ];

        NoticeDAO::pushNoticMsgList($push_data);

    }


    //普通消息队列
    public static function pushNoticMsgList($data,$source =NoticeQueueDAO::SYS_NOTICE_OTHER) {
        NoticeQueueDAO::pushNoticMsgListBySource($data,$source);
    //        NoticeQueueDAO::noticeQueueCount($source);
    //        $msglist = RedisCkey::getNoticMsgList();
    //        Yii::$app->redis->executeCommand('LPUSH', [$msglist, json_encode($data)]);
    }


    //加入通知队列
    public static function pushNoticMsgListBySource($data,$source) {
        $msglist = self::getNoticMsgListBySource($source);
        Yii::$app->redis->executeCommand('LPUSH', [$msglist, json_encode($data)]);
    }


    public static function getNoticMsgListBySource($source = self::SYS_NOTICE_OTHER){
        if (in_array($source,self::$queueItem[1])){
            return self::NOTICE_QUEUE_ONE_KEY;
        }elseif (in_array($source,self::$queueItem[2])){
            return self::NOTICE_QUEUE_TWO_KEY;
        }else{
            return RedisCkey::getNoticMsgList();
        }
    }


    /**
     * 消息通知队列
     */
    public static function getNoticMsgList()
    {
        return 'notic_msg_list';
    }


    //然后在 console 目录全局搜索--RedisCkey::getNoticMsgList()

    //发送通知队列
    public function actionSendnoticmsglist() {
        $next_num = 50;
        $NoticDAO = new NoticeDAO();
        while (true) {
            //获取当前队列的长度
            $length = intval( Yii::$app->redis->executeCommand('LLEN', [RedisCkey::getNoticMsgList()]) );
            if($length < 1){
                break ;
            }elseif($length < $next_num){
                $num = $length;
            }else{
                $num = $next_num;
            }
            //每次获取50条数据
            $rows = Yii::$app->redis->executeCommand('LRANGE', [RedisCkey::getNoticMsgList(), (-1 * $num), -1]);
            if(!is_array($rows) || count($rows)<1){
                break;
            }
            $rows = array_reverse($rows);
            foreach ($rows as $row_str) {
                $row = json_decode($row_str, true);
                if (is_array($row) && count($row) > 0) {
                    try {
                        LoggerUtils::info('chenhang=>'.json_encode($row).'<=chenhang'.'||'.__LINE__.'||'.__FILE__,"sendnoticmsg.log");
                        $chat_username = $row['chat_username']; //放入的时候就是一个数组
                        $msg = isset($row['msg']) ? $row['msg'] : '';
                        $content = isset($row['content']) ? $row['content'] : '';
                        $users = isset($row['users']) ? $row['users'] : [];
                        $links = isset($row['links']) ? $row['links'] : [];
                        $cmd = isset($row['cmd']) ? $row['cmd'] : [];
                        $up_grade_info = isset($row['up_grade_info']) ? $row['up_grade_info'] : [];
                        $from_username = isset($row['from_username']) ? $row['from_username'] : 'admin';
                        $dynamic_info = isset($row['dynamic_info']) ? $row['dynamic_info'] : [];
                        $message_type = isset($row['message_type']) ? $row['message_type'] : 0;
                        if($from_username == USER_XIAOMI_CID){
                            $NoticDAO->sendServerCenterNoticeXiaomi($chat_username, $msg, 0, $links, $users, [], $cmd, [], [], [], [], $content, $up_grade_info);
                        }elseif (  $from_username == USER_DYNAMIC_NOTICE_CID){
                            $NoticDAO->sendServerCenterNoticeDynamicNotice($chat_username, $msg, 0, $links, $users, [], $cmd, [], [], [], [], $content, $up_grade_info,$dynamic_info);
                        }elseif ($from_username == 'admin'){//通知中心
                            $NoticDAO->sendServerCenterNotice($chat_username, $msg, $message_type, $links, $users, [], $cmd, [], [], [], [], $content, $up_grade_info);
                        }else{
                            $NoticDAO->sendServerCenterNoticeUser($row['from_username'],$row['from_user_nick'],$row['from_user_chat'],$chat_username, $msg, $row['message_type'], $links, $users, [], $cmd, [], [], [], [], $content, $up_grade_info);
                        }
                    } catch (\Exception $e) {
                        LoggerUtils::error('发送消息通知队列异常:' . $e->getMessage(), 'sendnoticmsg.log');
                    }
                }
            }
            Yii::$app->redis->executeCommand('LTRIM', [RedisCkey::getNoticMsgList(), 0, (-1 * $num - 1)]);
        }
    }


    //然后在 crontab 中 搜索 sendnoticmsglist
    //然后在 console 中 全局搜索 sendnoticmsglist

    #!/bin/bash
    while [ true ]
    do
        n=`ps -ef | grep crontab/sendnoticmsglist | grep -v grep | wc -l`
        if [ $n -lt 1 ]
        then
            cd /data/www/releases/console
            nohup ./yii crontab/sendnoticmsglist > /data/www/releases/console/console/shell/logs/sendnoticmsglist.log 2>&1 &
    fi
        sleep 10
    done





    $query = PlatformRoomCash::find();
    $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
    var_dump($pagination);
    var_dump($pagination->offset);
    var_dump($pagination->limit);
    exit;
    $pagination->$pageSizeLimit = [1,55];
    var_dump($pagination->limit);

    $query->orderBy('total_room_cash DESC');
    $rows = $query->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
    $i = 1*$pagination->page*$pagination->pageSize+1;


    $query = TeamDiffWeek::find();
    $query->andOnCondition('total_gold >= :min_gold',[':min_gold' => TeamDAO::$min_gold_week]);//默认显示有奖励的用户。。
    $data = PageUtils::getInstance()->getPagedRows($query, ['order' => 'create_time Desc', 'pageSize' => 100, 'rows' => 'TeamDiffWeek', 'array' => true]);
    $TeamDiffWeek = $data['TeamDiffWeek'];
    echo "<pre>";
    var_dump($TeamDiffWeek);
    echo "</pre>";
    exit;





?>

```
