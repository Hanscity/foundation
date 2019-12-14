
## insert

```

db('table')->insert($data);
db('table')->insertGetId($data);
db('table')->insertAll($data);
```


## update

```

Db::name('user')->where('id', 1)
    ->update([
        'name'		=>	Db::raw('UPPER(name)'),
        'score'		=>	Db::raw('score-3'),
        'read_time'	=>	Db::raw('read_time+1')
    ]);

```


## select
- db('table') == DB::name() == DB::table($prefix.$table);       ## 会自动加上前缀，如果有前缀
- findOrEmpty();                   ## 一维数组或者空数组
- select();                        ## 二维数组或者空数组
- column('*','key');               ## 关联数组
- chunk                            ## 分段执行
- cursor                           ## PHP 生成器，节约内存
- json                             ## MySQL 支持 json 字段，tp5 支持 json 字段查询


         
### 查询方式
- 表达式查询(官方推荐)   --全面
- 字符串查询            --不全面

- 索引数组查询          --全面
- 关联数组查询          -- 不全面

```
$arrMerchant = db('merchant')->where('username','like', '中山市%')->find();                    ## 表达式查询 -- ok
$arrMerchant = db('merchant')->where("username like 中山市%")->find();                         ## 字符串查询 -- failed
$arrMerchant = db('merchant')->where([['username','like', '中山市%']])->find();                ## 索引数组   -- ok 
$arrMerchant = db('merchant')->where(['username'=>['like','中山市%']])->find();                ## 关联数组   -- failed ，tp5.1 理解为 in 了
```



/**
     * @return false|string
     * @comment 根据当前的节点，获取模块
     */
    public function getModule()
    {
        $nodeCur = $this->getNodeCurLittle();  ## eg : 'newadmin/merchant.merchant/getvipinfobyid'
        $halfStr = substr($nodeCur,strpos($nodeCur,'/'));
        $module = substr($halfStr,0,strpos($halfStr,'.'));
        return $module;
    }


    