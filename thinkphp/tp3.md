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


## save 方法探寻

* M('message')->where(['type'=>$type,'to_uid'=>$userId])->save($data);

1. 跳转可以找到两处，到底以哪一个为准呢？
2. saveAll 找不到


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

