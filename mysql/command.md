
- desc saas_author;                                                                          ## 查看数据表的字段及索引情况

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