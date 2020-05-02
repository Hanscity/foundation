
## 前缀索引

### 字符串的前缀索引

- 什么是前缀索引，为啥要前缀索引
- 对 Mysql 而言，对于字符串字段的索引而言，前缀索引很有必要。因为索引也是开销，字符串有可能很长，其索引也可能很长，限制大小，比较好。
- 应该大概能理解吧
- 再深入，为啥字符串很长，索引也可能长？ 索引长一点，不好吗？ balabala..
- Stop! 在下也不明白。

- 创建一个前缀索引

    ```
    Alter table articles add index pre_address (address_test(20));

    ```

- 语法类似于创建一个普通的索引，但是需要加一个前缀索引的最佳长度 N(int)。
- 你是不是有一个疑问，为啥最佳长度是 20？
- 是这么算出来的

    ```
    ## 数据表 articles 中 address_test 字段值大概这样--湖北省黄冈武穴市龙坪镇001
    select COUNT(DISTINCT LEFT(address_test,3))/COUNT(*) from articles;     ## 0.1429
    select COUNT(DISTINCT LEFT(address_test,10))/COUNT(*) from articles;    ## 0.1429
    select COUNT(DISTINCT LEFT(address_test,20))/COUNT(*) from articles;    ## 1.0000
    select COUNT(DISTINCT LEFT(address_test,30))/COUNT(*) from articles;    ## 1.0000

    ```

- 这条 sql 的大概意思是，截取多少个字符，可以得到尽量多的 address
- DISTINCT(取出不重复的值)，LEFT(截取)，这两个 Mysql 的语法，如果你们不熟悉，你们自己去查一查吧。
- 还是看不懂？
- 教你一个方法，从简单的开始。从这个 sql 开始，一点一点的加吧。
   ```
   select DISTINCT address_test from articles;
   
   ```

#### 多列索引的时候，也是可以增加字符串的前缀索引

```
Alter table articles add index title_category_brief (title(10),category_id,brief_intro);

```


#### 前缀索引的场景
1. 前缀索引是一种能使索引更小，更快的有效办法，但另一方面也有其缺点：mysql无法使用其前缀索引做ORDER BY和GROUP BY，也无法使用前缀索引做覆盖扫描
2. 要明确使用前缀索引的目的与优势：
   1. 大大节约索引空间，从而提高索引效率
   2. 对于 BOLB 、 TEXT 或者很长的 VARCHAR 类型的列，必须使用前缀索引,因为 MySQL 不允许索引这些列的完整长度
3. 前缀索引会降低索引的选择性
4. 真正的难点在于：要选择足够长的前缀以保证较高的选择性，同时又不能太长， 前缀的长度应该使前缀索引的选择性接近索引整个列，即前缀的基数应该接近于完整列的基数


#### 我的建议
- 可以先不考虑前缀索引

