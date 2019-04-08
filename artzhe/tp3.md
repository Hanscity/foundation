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

* mysql 的连接很慢，干其他工作一会，naicat 就要连接半天。 Ubuntu 上面更惨，直接需要重启软件。

   * 解决方法：

      1、show processlist发现在Command列是Connect, State是Login时等待了许久，说明是连接慢，不是访问数据慢

      2、百度发现了一个skip-name-resolve参数，禁止mysql做dns查询

      3、问题产生原因：由于本地机器没有配置网关，解析dns超时，导致连接慢

      4、问题解决：[mysqld]内加上skip-name-resolve



* 服务器可以 ssh 连接，但是 ping 不通
   1. 防火墙 的设置--iptables（wiki的解释很好）
      ```
      ## 查看防火墙的设置
      sudo iptables -nvL

      ```
   2. icmp 的设置
      ``` 
      # 查看此时 icmp 的设置
      cat /proc/sys/net/ipv4/icmp_echo_ignore_all

      #临时禁 ping
      echo 1 > /proc/sys/net/ipv4/icmp_echo_ignore_all
      #临时启用 ping
      echo 0 > /proc/sys/net/ipv4/icmp_echo_ignore_all

      #永久配置 ping
      vim /etc/sysctl.conf
      #设置关闭 ping
      net.ipv4.icmp_echo_ignore_all = 1
      #设置启用 ping
      net.ipv4.icmp_echo_ignore_all = 0

      #刷新配置
      sysctl -p
      ```
    


   3. 然后重启网络服务： service network restart
* PHP-fpm 进程明明在跑，为啥 top 命令的却显示 sleep
   * 我的 docker 环境里面，进程数非常少，容易观察。



## is_cli 模式
1. php index.php V60/Collection/exportData/token/93F7644C02360605A3815561D85F3D54(导入收藏的数据)
2. php index.php Api/Cron/reloadUserAttentionInfo & (导入所有的关注数据)


## 
* artzhe/ThinkPHP/Library/Behavior/CronRunBehavior.class.php--怎么理解这个函数呢？


## 
* $userAttriInfo = M('user_attributes_relation')->where(['userj_id'=>$uid])->find();
   * 像这样，'userj_id' 没有，那么不会报错，此时 where 条件没有用，会选择一条哦。。






## save 方法探寻

M('message')->where(['type'=>$type,'to_uid'=>$userId])->save($data);

1. 跳转可以找到两处，到底以哪一个为准呢？
2. saveAll 找不到



