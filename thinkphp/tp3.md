#
## 增删改查
### add

* 增加所有
   ```  
   $temp['status']=1;
   $temp['create_time']=date('Y-m-d');
   $temp['update_time']=date('Y-m-d H:i:s');
   $date_arr[]= $temp;
   $appreciate_image->addAll($date_arr);
   
   ```
## save 方法探寻

* M('message')->where(['type'=>$type,'to_uid'=>$userId])->save($data);
1. 跳转可以找到两处，到底以哪一个为准呢？
2. saveAll 找不到


## save 
* M('message')->where(sql_pin_where(['to_user_id'=>$userId,'type[in]'=>$type]))->save($data);



### select
* sql语句执行查询
   ```   
   $sql = <<<SQL
           SELECT a.artwork_id as id
           FROM az_artwork_weight a LEFT JOIN (SELECT uid,artwork_id,weight FROM az_user_weight WHERE uid = {$uid}) b
           ON a.artwork_id = b.artwork_id
           ORDER BY {$this->config['order']['other']}
           LIMIT 5
           SQL;
   $arr = $ArtworkWeightModel->query($sql);
   
   ```

* sql 语句的执行 和 非标准的ORM模型 的对应
```
    $res = M()->table('saas_work as a')
            ->field('count(a.id),b.name')
            ->join('saas_work_cate as b on a.type_id = b.id','inner')
            ->where(['a.org_id'=>$org_id,'is_delete'=>0])
            ->group('a.type_id')
            ->select();

    $sql = "select count(saas_work.id),saas_work_cate.name from saas_work
       inner join saas_work_cate on saas_work.type_id = saas_work_cate.id where saas_work.org_id = {$org_id} group by
       saas_work.type_id";
    $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
    $res = $Model->query($sql);


```
* 大于等于 M 且小于 N
   ```     
   $likeArr = M('ArtworkLike')
                ->where(['is_like'=>'Y'])
                ->where(['id'=>[['egt',$startNum],['lt',$endNum],'and']])
                ->select();

   ```

* 连表查询

```
$data_artwork = $this->model
            ->table('az_artwork_like a')
            ->join('az_artwork_update b on a.artwork_id=b.id and a.type=2','left')
            ->field('(CASE when a.type=1 THEN a.artwork_id else  b.artwork_id end) as artwork_id,(CASE when a.type=1 THEN 0 else  a.artwork_id end) as artworkupdateid')
            ->where("a.`like_user_id` =".$userId." AND a.`is_like` = 'Y'")
            ->group('artwork_id')
            ->page($page, $perPageCount)
            ->order('a.like_time desc')
            ->select();


$arrSign = $modelSignature
            ->field('az_signature_image.url,az_signature_image.url_main,az_signature_image.date,
            az_signature_image.work_id,az_artwork.story')
            ->join('az_artwork on az_signature_image.work_id = az_artwork.id')
            ->where($where)->page($page,$pageSize)
            ->order("az_signature_image.date desc")
            ->select();


```

* 查询并分页

```

    /**
     * 获取我的收藏
     */
    public function getMyCollection()
    {
        $uid = intval($this->loginUserId);
        $page = I('page',1,'int');
        $pageSize = I('pageSize',20,'int');
        $total = M('UserCollection')
            ->where(['uid'=>$uid,'is_show'=>1])
            ->count();
        $maxPage = ($total % $pageSize == 0) ? intval($total / $pageSize)
            : intval($total / $pageSize) + 1;
        $arrColl = M('UserCollection')
            ->where(['uid'=>$uid,'is_show'=>1])
            ->order('create_time desc')
            ->page($page,$pageSize)
            ->select();
        $data = [
            'page'=>$page,
            'pageSize'=>$pageSize,
            'total'=>$total,
            'maxPage'=>$maxPage,
            'arrColl'=>$arrColl,
        ];
        Util::jsonReturnSuccess($data);
    }

```

* 查询并且按照字符的长度来排序

```
 $res = M('user')
            ->where(['nickname'=>['like',"%$nickname%"]])
            ->order('LENGTH(nickname) Asc')
            ->select();

```

* in 查询
```
public function getMessageListByPage($userId, $type, $page, $perPageCount)
    {
        $list = $this->where(
            sql_pin_where(['to_user_id' => $userId, 'is_deleted'=> 'N', 'type[in]' => $type])
        )->page($page, $perPageCount)->order('id DESC')->select();
        if (empty($list)) {
            return [];
        }
        return $list;
    }

```

* 大于且小于

```
$regi_num = M('user')
            ->where(['create_time'=>[['EGT',$start_time],['LT',$end_time]],'is_deleted'=>'N'])
            ->count(); ## 当天注册人数

```

* 
## 有意思的一些问题
* 这是我非常不喜欢的一种写法，但是可以看看调用的顺序
   ```  
   $artwork = new ArtworkLogic();
   $artworkinfo=$artwork->where(['id' => $data['artwork_id'],'is_deleted'=>'N'])->find();
   
   ```

* checkLogin 需要看看，感觉没有进行什么校验
   ```  
   $this->checkLogin();
   $tokenInfo = Token::getTokenInfo($this->token);
   ```

* I 函数学习
   ``` 
   $mobileList = I('post.mobileList', '',false);
   ```



## is_cli 模式
1. php index.php V60/Collection/exportData/token/93F7644C02360605A3815561D85F3D54(导入收藏的数据)
2. php index.php Api/Cron/reloadUserAttentionInfo & (导入所有的关注数据)


## 
* artzhe/ThinkPHP/Library/Behavior/CronRunBehavior.class.php--怎么理解这个函数呢？


## 
* $userAttriInfo = M('user_attributes_relation')->where(['userj_id'=>$uid])->find();
   * 像这样，'userj_id' 没有，那么不会报错，此时 where 条件没有用，会选择一条哦。。





## thinkphp C 函数的理解
```
//先理解这段程序，关于静态变量的理解
static $arr = [];
$arr['test001'] = 'test001';
$arr['test002'] = 'test002';
var_dump($arr); ## ['test001'=>'test001','test002'=>'test002']
static $arr = [];
var_dump($arr); ## ['test001'=>'test001','test002'=>'test002']
$arr = [];
var_dump($arr); ## []



function C($name=null, $value=null,$default=null) {
    static $_config = array();
    // 无参数时获取所有
    if (empty($name)) {
        return $_config;
    }
    // 优先执行设置获取或赋值
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtoupper($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : $default;
            $_config[$name] = $value;
            return;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtoupper($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : $default;
        $_config[$name[0]][$name[1]] = $value;
        return;
    }
    // 批量设置
    if (is_array($name)){
        $_config = array_merge($_config, array_change_key_case($name,CASE_UPPER));
        return;
    }
    return null; // 避免非法参数
}

var_dump(C('artzhe'));

```



## 操作缓存的三种用法

```
    //发送注册短信
    public function sendVerifyCode()
    {

        try {
            $type = (int)I('post.type');
            $mobile = Checker::mobile();
            $randomCode = Sms::generateRandomCode(4);

            $faile_key=Cache::VERIFY_CODE_PREFIX . $mobile.'_fail_count';

            $redis = new \Redis();                                             ## 1. 在这里，调用的是 PHP原生的扩展
            $redis->connect(C('REDIS_HOST'), C('REDIS_PORT'));
            $redis->auth(C('REDIS_PASSWD'));
            $redis->select(C('REDIS_DB_INDEX'));

            $cache_key = 'sendVerifyCode_limit_' . $mobile . '_' . $type . '_' . date('Ymd');
            //验证次数
            $cache_num = $redis->get($cache_key);
            if ($type == 1) {
                if ($cache_num >= 5) {
                    Util::jsonReturn(null, Code::SYS_ERR, '失败，注册验证码获取过多。');
                }
            } elseif ($type == 2) {
                if ($cache_num >= 3) {
                    Util::jsonReturn(null, Code::SYS_ERR, '失败，重置密码的验证码获取过多。');
                }
            } else {
                if ($cache_num >= 5) {
                    Util::jsonReturn(null, Code::SYS_ERR, '失败，验证码获取过多。');
                }
            }
            //验证次数 end

            $redis->incr($cache_key);
            $redis->expire($cache_key, 86400);

            $sendState = Sms::sendByRpc($mobile, $randomCode);

            if ($sendState['state'] === 200) {
                S($faile_key,0,3600);                                       ## 2. 在这里，调用的是 thinkPHP 封装的 S方法
                S(Cache::VERIFY_CODE_PREFIX . $mobile, $randomCode, ['expire' => Time::VERIFY_CODE_EXPIRE_30_MIN]);
                Util::jsonReturnSuccess();
            } else {
                throw  new Exception(var_export($sendState, true), -1);
            }
        } catch (Exception $e) {
            Util::jsonReturn(null, Code::SYS_ERR, 'Verify code send failed!', $e->getMessage());
        }
    }


    use Think\Cache\Driver\Redis;
    /**
     * @param $uid
     * @return array
     * @commend 重置缓存
     */
    public function reloadMyAttention($uid){

        $redisModel = Redis::getSimple();                                  ## 3. 在这里，调用的是封装之后的 Think\Cache\Driver\Redis;
        $key = self::KEY_USER_MY_ATTENTION.$uid;
        $redisModel->del($key);
        $res = [];

        $resMyAttention = M('user_follower')->where(['follower'=>$uid,'is_follow'=>'Y'])->select();
        if($resMyAttention){
            foreach($resMyAttention as $keyAtten=>$valueAtten){
                $redisModel->zadd($key,$valueAtten['follow_time'],$valueAtten['user_id']);
                $res[$valueAtten['user_id']] = $valueAtten['follow_time'];
            }
        }
        $redisModel->zadd($key,self::SIGN_CACHE_VALUE,self::SIGN_CACHE);
        $redisModel->expire($key,1*24*3600);

        $res[self::SIGN_CACHE] = self::SIGN_CACHE_VALUE;
        if(empty($res)){
            $this->reloadMyAttention($uid);
        }
        return $res;
    }

```



## Nginx 的路由配置
```


server {
    listen       80;
    server_name  ch-tp3.artzhe.com;
    root /var/www/tp3/;
    index  index.html index.htm index.php;
    error_page  404              /404.html;
    location = /404.html {
        return 404 'Sorry, File not Found!';
    }
    error_page  500 502 503 504  /50x.html;
    location = /50x.html {
        root   /usr/share/nginx/html; # windows[34m~T[34m~H[34m~[[34m~M[34m~Y个[34m~[[34m~U
    }
    location / {
        try_files $uri @rewrite;
    }
    location @rewrite {
        set $static 0;
        if  ($uri ~ \.(css|js|jpg|jpeg|png|gif|ico|woff|eot|svg|css\.map|min\.map)$) {
            set $static 1;
        }
        if ($static = 0) {
            rewrite ^/(.*)$ /index.php?s=/$1;
        }
    }
    location ~ /Uploads/.*\.php$ {
        deny all;
    }
    location ~ \.php/ {
       if ($request_uri ~ ^(.+\.php)(/.+?)($|\?)) { }
       fastcgi_pass 127.0.0.1:9000;
       include fastcgi_params;
       fastcgi_param SCRIPT_NAME     $1;
       fastcgi_param PATH_INFO       $2;
       fastcgi_param SCRIPT_FILENAME $document_root$1;
    }
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    location ~ /\.ht {
        deny  all;
    }
}



server {
    listen       80;
    server_name  ch-api.artzhe.com;
    root /var/www/artzhe/;
    index  index.html index.htm index.php;
    error_page  404              /404.html;
    location = /404.html {
        return 404 'Sorry, File not Found!';
    }
    error_page  500 502 503 504  /50x.html;
    location = /50x.html {
        root   /usr/share/nginx/html; # windows[34m~T[34m~H[34m~[[34m~M[34m~Y个[34m~[[34m~U
    }
    location / {
        try_files $uri @rewrite;
    }
    location @rewrite {
        set $static 0;
        if  ($uri ~ \.(css|js|jpg|jpeg|png|gif|ico|woff|eot|svg|css\.map|min\.map)$) {
            set $static 1;
        }
        if ($static = 0) {
            rewrite ^/(.*)$ /index.php?s=/$1;
        }
    }
    location ~ /Uploads/.*\.php$ {
        deny all;
    }
    location ~ \.php/ {
       if ($request_uri ~ ^(.+\.php)(/.+?)($|\?)) { }
       fastcgi_pass 127.0.0.1:9000;
       include fastcgi_params;
       fastcgi_param SCRIPT_NAME     $1;
       fastcgi_param PATH_INFO       $2;
       fastcgi_param SCRIPT_FILENAME $document_root$1;
    }
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    location ~ /\.ht {
        deny  all;
    }
}


//上面是两个同样的配置，可是在 ch-tp3.artzhe.com中，打印 $_REQUEST得到了
array(1) { ["s"]=> string(11) "/home/index" }
而，ch-api.artzhe.com中，却没有。。。



```




## 后台管理端，接口等各种地方，密码的加密是可逆的--2019-04-29

```

$password = 'ch@code';
$encInfo = '2M5CPhsl2WtlIoTXx6N9yGhsBddWQYELi5EwHwJ2o50=';
$salt = '543gOg4g'.'artzhe_for_gsy2020';
$encInfo = Xxtea::encrypt($password, $salt);
$encInfo = base64_decode($encInfo);
var_dump($encInfo);
$decInfo = Xxtea::decrypt($encInfo, $salt);
var_dump($decInfo);

```

* 密码加密的修改
```
password_hash

```


## thinkphp something..
* 调试模式的话，会在Runtime目录下面生成common~runtime.php文件（应用编译缓存文件）。

* 每个 module 下面的模块的配置文件是怎么加载的呢？

* define('APP_DEBUG',FALSE);//此时会有缓存，页面并不刷新

* 



{"13723308199":"\u5218\u7ece\u82b8","17722802861":"\u6885\u5b50\u3002","13629513095":"\u7237\u7237","13995315371":"\u516d\u59d1\u5976","13995119099":"\u5b5f\u8f89","15558097125":"\u300147","14707250883":"\u90d1\u5988","13709506085":"\u738b\u6d77\u6ce2","15009617812":"\u9646\u9732","18779183809":"\u4e07\u5f69\u4e3d","13160863327":"\u5927\u68cb\u68cb","15171671248":"\u90d1\u7238","18595064660":"\u9646\u9732","15170073539":"\u5468\u65ed\u4e1c","18195008655":"\u6797\u5b50","18310935896":"\u8c22\u96f7\u521a","17682340047":"\u300147","13502808440":"\u9646\u9732","13242984983":"\u6768\u831c","17727409839":"\u8f66\u68a6\u9896","18995112680":"Eiswein","13995089188":"\u7ea2\u7ea2\u59d1","13895378269":"Eiswein"}




## sprintf(),很适合与模板赋值
- 很不错的设计哦

```

sprintf($this->msg['repayComment'], $artName, $content)
public $msg = [
        'welcome' => '欢迎来到艺术者平台，在这里，开启你的艺术之旅，遇见你的品味吧。',
        'authSuccess' => '恭喜您，成为了艺术者平台的认证艺术家，一大波红利向您涌来。',
        'authFailed' => '很遗憾，艺术家认证失败了，艺术者客服将会与您取得联系。',
        'artworkUpdate' => '你喜欢的作品%s有更新了，快来欣赏吧。',
        'artistUpdate' => '我的新作品%s有更新了，快来欣赏吧。',
        'repayComment' => '回复了你对%s的鉴赏：“%s”',
        'repayMessage' => '回复了你对%s的评论：“%s”',
        'message' => '评论了你的作品%s：“%s”',
        'comment' => '鉴赏了你的作品%s：“%s”',
        'like' => '喜欢了你的作品%s'
    ];

```




public $msg = [

        'welcome' => '欢迎来到艺术者平台，在这里，开启你的艺术之旅，遇见你的品味吧。',
        'authSuccess' => '恭喜您，成为了艺术者平台的认证艺术家，一大波红利向您涌来。',
        'authFailed' => '很遗憾，艺术家认证失败了，艺术者客服将会与您取得联系。',
        'artworkUpdate' => '你喜欢的作品%s有更新了，快来欣赏吧。',                       ## 作品
        'artistUpdate' => '我的新作品%s有更新了，快来欣赏吧。',                          ## 文章
        'repayComment' => '回复了你对%s的鉴赏：“%s”',
        'repayMessage' => '回复了你对%s的评论：“%s”',
        'message' => '评论了你的作品%s：“%s”',
        'comment' => '鉴赏了你的作品%s：“%s”',
        'like' => '喜欢了你的作品%s',
        'topicLike' => '喜欢了你对话题#%s#的讨论',
        'topicComment' => '评论了你对话题#%s#的讨论',
        'topicReplyComment' => '回复了你对话题#%s#讨论的评论',
        'articleLike' => '喜欢了你的文章%s',                   ## 喜欢文章
        'articleComment' => '评论了你的文章%s',                ## 文章评论
        'articleRepay' => '回复了你的评论%s',                 ## 文章评论回复
    ];
    public $type = [

        'welcome' => '8',                        ## 系统消息--欢迎--ok
        'authSuccess' => '8',                    ## 系统消息 --认证成功--ok
        'authFailed' => '8',                     ## 系统消息 -- 认证失败--ok
        'like' => '9',                           ## 喜欢作品和花絮，增加的都是 作品的喜欢--ok
        'message' => '10',                       ## 评论花絮--ok
        'comment' => '10',                       ## 鉴赏作品--ok
        'artworkUpdate' => '12',                 ## 作品更新--ok
        'artistUpdate' => '12',                  ## 文章更新--ok
        'repayComment' => '13',                  ## 回复鉴赏作品--ok
        'repayMessage' => '13',                  ## 回复评论花絮--ok
        'artCircleComment' => '14',              ## 用户评论艺术圈动态 --ok
        'artCircleReplyComment' => '15',         ## 用户回复艺术圈动态的评论 --ok
        'artCircleLike' => '16',                 ## 用户点赞艺术圈动态--ok
        'userConsultation' => '17',              ## 用户咨询艺术家(画作)--ok
        'artistReplyConsultation' => '18',       ## 艺术家回复用户咨询--ok
        'topicLike' => '21',                     ## 用户点赞话题讨论--OK
        'topicComment' => '22',                  ## 用户评论话题讨论--ok
        'topicReplyComment' => '23',             ## 用户回复话题讨论的评论--ok
        'articleLike' => '40',                   ## 喜欢文章
        'articleComment' => '41',                ## 文章评论
        'articleRepay' => '42',                 ## 文章评论回复
    ];
    public static $showmsg = 1;                  ## 不用跳转的消息
    public static $linkmsg = 2;                  ## 需要跳转的消息
    public static $commentmsg = 3;


# 以下完全对应于 ThinkPHP3.2.3 完全开发手册

# CRUD 操作

## add

### 字段过滤
- 如果写入了数据表中不存在的字段数据，则会被直接过滤，例如：

```
$data['name'] = 'thinkphp';
$data['email'] = 'thinkphp@gmail.com';
$data['test'] = 'test';
$User = M('User');
$User->data($data)->add();
其中test字段是不存在的，所以写入数据的时候会自动过滤掉。

在3.2.2版本以上，如果开启调试模式的话，则会抛出异常，提示：非法数据对象：[test=>test]

```
- 问题是，我的 tp3.2.3,开启了调试模式，开启了报错模式，并没有抛出异常。。


### 字段内容过滤
- 通过filter方法可以对数据的值进行过滤处理，例如：

```
$data['name'] = '<b>thinkphp</b>';
$data['email'] = 'thinkphp@gmail.com';
$User = M('User');
$User->data($data)->filter('strip_tags')->add();
写入数据库的时候会把name字段的值转化为thinkphp。

filter方法的参数是一个回调类型，支持函数或者闭包定义。

```
- 有两个问题，一：我的 tp3.2.3 中的 think/model 没有写这个 filter 方法；二：就算写了，也不好。业务中，可能一开始就判断，名字是否重复。OK，不重复，写入的时候，去掉标签，可能会重复。所以需要在判断之前，去掉标签。这里应该写一个方法的。



### 返回 sql 语句

3.2.3版本开始，可以支持不执行SQL而只是返回SQL语句，例如：

$User = M("User"); // 实例化User对象
$data['name'] = 'ThinkPHP';
$data['email'] = 'ThinkPHP@gmail.com';
$sql = $User->fetchSql(true)->add($data);
echo $sql;
// 输出结果类似于
// INSERT INTO think_user (name,email) VALUES ('ThinkPHP','ThinkPHP@gmail.com')


### 批量写入
- 在某些情况下可以支持数据的批量写入，例如：

```
//批量添加数据
$dataList[] = array('name'=>'thinkphp','email'=>'thinkphp@gamil.com');
$dataList[] = array('name'=>'onethink','email'=>'onethink@gamil.com');
$User->addAll($dataList);

```
- 记得，批量写入的时候，数组的下标是从 0 到 N



### select 

- find();                   ## 查询单条数据
- select();                  ## 查询多条数据
- getField();                ## 有多种格式
   ```
    // 返回单个字符
    $data_space = M('art_space')
            ->where(['link_id'=>$org_id,'is_show'=>1])
            ->getField('space_name');

    Util::jsonReturnSuccess($data_space);

    {
    "data": {
        "status": 1000,
        "info": "冰封王座"
    },
    "code": 30000,
    "message": "success",
    "debug": false
    }

    //
    $data_space = M('art_space')
            ->where(['link_id'=>$org_id,'is_show'=>1])
            ->getField('space_name',true);


    {
    "data": {
        "status": 1000,
        "info": [
            "冰封王座",
            "黑暗军团",
            "巫妖王",
            "兽王",
            "影魔",
            "影魔&lt;html&gt;",
            "影魔&lt;php&gt;"
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
    }

    .....有很多中形式

    http://document.thinkphp.cn/manual_3_2.html#read_data
   ```


### 数据更新
- 记得添加 where 条件,如果没有 where 条件或者数据中没有 主键，那么不会执行操作

1. save()
2. setField()
3. setInc,setDec


### 删除
- 记得添加 where 条件，否则不执行

1. delete()



# ACTIVERECORD 
- 当前大部分都采用的 ORM 模型，典型的 AR模型，暂时不用

# 字段映射
- 暂时不用



### 生成 sql

- select

```
$sql = M('art_space')
            ->where(['link_id'=>$org_id,'is_show'=>1,'space_name'=>['like','%'.$space_name.'%']])
            ->page($page,$page_size)
            ->order('create_time Desc')
            ->select(false);

$sql = M('art_space')
    ->where(['link_id'=>$org_id,'is_show'=>1,'space_name'=>['like','%'.$space_name.'%']])
    ->page($page,$page_size)
    ->order('create_time Desc')
    ->buildSql();

SELECT * FROM `saas_art_space` WHERE `link_id` = 10 AND `is_show` = 1 AND `space_name` LIKE '%%' ORDER BY create_time Desc LIMIT 0,10


```

- add

```

$User = M("User"); // 实例化User对象
$data['name'] = 'ThinkPHP';
$data['email'] = 'ThinkPHP@gmail.com';
$sql = $User->fetchSql(true)->add($data);
echo $sql;
// 输出结果类似于
// INSERT INTO think_user (name,email) VALUES ('ThinkPHP','ThinkPHP@gmail.com')


```

- 

```

M('author')->getLastSql()


```



### tp 3.2 ,如果字字段写错，会更新了所有的记录
```

/**
     * 修改企业头像
     */
    public function fixMessHeadPic()
    {
        $org_id = $this->org_id;
        $head_pic = I('post.head_pic','');
        if(!$head_pic){
            Util::jsonReturnError('缺少参数');
        }
        try{
            M('org')->where(['org_id'=>$org_id,'status'=>1])
                ->setField(['head_pic'=>$head_pic]);
            Util::jsonReturnSuccess('修改成功');

        }catch(\Exception $e){

            Util::debugLog('test',$e->getMessage());
            Util::jsonReturnError('数据库开小差了');
        }

    }


```