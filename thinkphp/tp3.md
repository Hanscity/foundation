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