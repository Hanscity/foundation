
- mysql -uroot -p    ## 登陆

- show databases;    ## 展示所有的数据库

### 创建一个数据库

```

create schema fishadmin_2d default character set utf8mb4 collate utf8mb4_general_ci;

```



- use database;    ## 选择一个数据库


- desc saas_author;                                                                          ## 查看数据表的字段及索引情况


- show index from az_user_follower;                                                          ## 查看数据表的索引

- show create table saas_author;                                                             ## 查看建表语句

- ALTER TABLE saas_author CHARACTER SET = utf8mb4,COLLATE = utf8mb4_general_ci;              ## 修改表的默认字符集，排序集





- alter table saas_author add org_id int default 0 not null comment '机构 ID';               ## 增加字段

- alter table saas_author modify status tinyint null comment '签约状态0，未签约；1，已签约';     ## 修改注释

- alter table saas_author change status sign_status tinyint 
                               null comment '签约状态0，未签约；1，已签约';                      ## 修改字段名

                               
- alter table saas_author modify space_id int default 0 not null comment '空间ID';           ## 修改字段默认值


- ALTER TABLE `saas_author` CHANGE `original_name` `name` VARCHAR(32)
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '作家姓名';    ## 修改字段字符集


- alter table saas_author drop column space_id;                                              ## 删除字段

- drop table saas_record_art_edit;                                                           ## 删除一张表



## index (索引)

1. PRIMARY  KEY（主键索引） 
   ``` 
   ALTER  TABLE  `table_name`  ADD  PRIMARY  KEY (  `column`  ) 

   ```

2. UNIQUE(唯一索引)         
   
   ``` 
   ALTER  TABLE  `table_name`  ADD  UNIQUE ( `column` ) 

   ```


3. INDEX(普通索引) 

   ``` 
   ALTER  TABLE  `table_name`  ADD  INDEX index_name (  `column`  )

   ```

4. FULLTEXT(全文索引) 

   ``` 
   ALTER  TABLE  `table_name`  ADD  FULLTEXT ( `column` )

   ```
   
5. 多列索引

    ```
    ALTER  TABLE  `table_name`  ADD  INDEX index_name (  `column1`,  `column2`,  `column3`  )

    ```

6. 前缀索引

   ```
   Alter table articles add index pre_address (address_test(20));
   
   ```




### Mysql 的深入

- mysql的索引，为什么不用二叉树，会有什么样的问题，红黑树呢，为什么也不用，hashmap与B+树哪个用的多一点，B+是什么样的结构，B+能解决什么样的问题
- 索引引擎，myisam是什么样的，什么时候用，innodb呢，这里面有用到聚集索引吗，innodb是怎样实现它的行级锁的，谁能支持事务呢，事务了解多少简单说说，事务的七种传播行为说一下
- 有多少种锁







create schema fishadmin_2d default character set utf8mb4 collate utf8mb4_general_ci;




