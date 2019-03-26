* az_user_collection 数据表需要增加

* az_user_follow 表格，去掉 follower_user_id_.. 的唯一索引

* 喜欢的文章，作品，需要导入收藏表
   ```   
   collection/exportData

   ```




##

CREATE TABLE `az_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '-1' COMMENT '-1未指定 1艺术家收到艺术品评论 2艺术家收到艺术品更新评论 3艺术家收到艺术品点赞 4欣赏者收到评论回复 5欣赏者收到评论喜欢 6欣赏者收到喜欢的艺术品更新 7欣赏者收到关注的艺术家的作品更新 这里的作品我没关注 8系统消息',
  `show_type` tinyint(3) NOT NULL,
  `topic_id` int(11) NOT NULL DEFAULT '-1' COMMENT '-1未指定 根据type字段变更',
  `content` varchar(1000) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '消息内容',
  `from_user_id` int(11) NOT NULL DEFAULT '-1' COMMENT '-1未指定',
  `to_user_id` int(11) NOT NULL DEFAULT '-1' COMMENT '-1未指定',
  `is_deleted` enum('N','Y') NOT NULL DEFAULT 'N',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  `is_read` enum('N','Y') NOT NULL DEFAULT 'N',
  `read_time` int(11) NOT NULL DEFAULT '0' COMMENT '查阅时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `comment_id` int(11) NOT NULL,
  `is_repay` enum('Y','N') NOT NULL DEFAULT 'N',
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=271587 DEFAULT CHARSET=utf8 COMMENT='消息';



type = 12，我关注的人作品更新

type = 11，无

type = 10，我的作品所收到的评论和留言或者回复

type = 9, 我的作品所收到的 喜欢
type = 8，系统通知
