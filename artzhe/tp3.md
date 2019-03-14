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

## cache
* cache
   ```   
   $cache      =   \Think\Cache::getInstance();
   $cache->rm('test001');
   $cache->set('test001','redis001');
   var_dump($cache->get('test001'));
   exit;
   
   S('test001');## get
   S('test001','redis001');## set
   S('test001','redis001',60);## set + expire
   S('test001',NULL);## rm
   
   //重写了 Redis的方法，较为好用吧
   $redis = new \Think\Cache\Driver\Redis();
   $redis->setString('test006','redis00006');
   Util::debugLog('test',$redis->getString('test006')); 
   ```

## print log
* print log
   ```   
   Util::debugLog($file,$data);
   
   ```