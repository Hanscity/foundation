* az_user_collection 需要增加

* az_user_follow 表格，去掉 follower_user_id_.. 的唯一索引

* 喜欢的文章，作品，需要导入收藏表
   ```   
   collection/exportData

   ```
* alter table az_user
  add city varchar(96) default '' not null comment '所属城市';



* alter table az_message
  add is_real_read varchar(8) default 'N' not null comment 'Y:已读；N：未读';


##
type = 14,15,16 朋友圈的消息
type = 12，我关注的人作品更新
type = 11，无
type = 10，我的作品所收到的评论和留言或者回复
type = 9, 我的作品所收到的 喜欢
type = 8，系统通知



## 

* 关注我的--有一种是不分页--ok

* 艺术圈--加上用户属性 --ok
/V51/ArtCircle/GetList?token=93F7644C02360605A3815561D85F3D54 HTTP/1.1" 200 1818 "-" "okhttp/3.11.0"
/V51/ArtCircle/userCirlelist?token=93F7644C02360605A3815561D85F3D54 HTTP/1.1" 200 880 "-" "okhttp/3.11.0"
/V51/ArtCircle/getHeader?token=93F7644C02360605A3815561D85F3D54 HTTP/1.1" 200 372 "-" "okhttp/3.11.0"
/V51/ArtCircle/getHeader?token=93F7644C02360605A3815561D85F3D54 

* 我的个人动态--有一种是不分页--ArtCircle/userCirlelist--ok
   * 备注： 和我的关注一样，获取所有，就是 pageSize 取大一点即可

* 个人主页--用户属性 + 数据统计--我的收藏(邀请暂时不做)--OK

* 收藏--增加一个字段--简介
* 我的作品--少了时间字段







killall php Server.php


启动socket 1
cd /var/www/im-socket-test.artzhe.com
nohup  php Server.php &

启动socket 2
cd /var/www/im-socket-test.artzhe.com2
nohup  php Server.php &

启动 消息服务
cd /var/www/im-socket-test.artzhe.com
nohup  php OnlineMessageServer.php  &
nohup  php SystemMessageServer.php  &
nohup  php NewUser7dayRecommendServer.php  &