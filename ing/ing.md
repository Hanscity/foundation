/V62/ArtCircle/userCirlelist

/V62/UserCenter/getMyGalleryDetail



$info['followerTotal'] = $followLogic->where(['user_id' => $this->loginUserId, 'is_follow' => 'Y'])->count();
            $info['followTotal'] = $followLogic->where(['follower' => $this->loginUserId, 'is_follow' => 'Y'])->count();




            $tag_arr_ids = array_unique(array_merge(explode(',',$category),explode(',',$subject),explode(',',$style)));
        $data_tag_mess = [
            'tag_arr_ids'=>$tag_arr_ids,
            'mess_id'=>$id,
            'type_sort'=>TagType::$arr_tag_mess_type['artwork'],
            'oprate_type'=>'edit',
        ];
        TagType::getSimple()->operateTagMess($data_tag_mess);


关注
推荐
热点
新锐
大师

赏析　　94
趣闻　90
美图　139
教程　140
展讯　92

拍卖　141　
素材　142
插画　62
活动　143
机构　144

美院　145
油画　98
水彩　61
彩铅　106
视频　95





array (

var_dump:

  'user_tag' => '{"1":"\\u5173\\u6ce8","2":"\\u63a8\\u8350","3":"\\u70ed\\u70b9","4":"\\u65b0\\u9510","5":"\\u5927\\u5e08","6":"\\u8d4f\\u6790","7":"\\u8da3\\u95fb","8":"\\u7f8e\\u56fe","9":"\\u6559\\u7a0b","10":"\\u5c55\\u8baf","11":"\\u62cd\\u5356","12":"\\u7d20\\u6750"}',


echo:
{"1":"\u5173\u6ce8","2":"\u63a8\u8350","3":"\u70ed\u70b9","4":"\u65b0\u9510","5":"\u5927\u5e08","6":"\u8d4f\u6790","7":"\u8da3\u95fb","8":"\u7f8e\u56fe","9":"\u6559\u7a0b","10":"\u5c55\u8baf","11":"\u62cd\u5356","12":"\u7d20\u6750"}
  
)


[{"id":1,"title":"\\u5173\\u6ce8"},{"id":2,"title":"\\u63a8\\u8350"},{"id":3,"title":"\\u70ed\\u70b9"},{"id":4,"title":"\\u65b0\\u9510"},{"id":5,"title":"\\u5927\\u5e08"},{"id":6,"title":"\\u8d4f\\u6790"},{"id":7,"title":"\\u8da3\\u95fb"},{"id":8,"title":"\\u7f8e\\u56fe"},{"id":9,"title":"\\u6559\\u7a0b"},{"id":10,"title":"\\u5c55\\u8baf"},{"id":11,"title":"\\u62cd\\u5356"},{"id":12,"title":"\\u7d20\\u6750"}]


[{"id":1,"title":"\u5173\u6ce8"},{"id":2,"title":"\u63a8\u8350"},{"id":3,"title":"\u70ed\u70b9"},{"id":4,"title":"\u65b0\u9510"},{"id":5,"title":"\u5927\u5e08"},{"id":6,"title":"\u8d4f\u6790"},{"id":7,"title":"\u8da3\u95fb"},{"id":8,"title":"\u7f8e\u56fe"},{"id":9,"title":"\u6559\u7a0b"},{"id":10,"title":"\u5c55\u8baf"},{"id":11,"title":"\u62cd\u5356"},{"id":12,"title":"\u7d20\u6750"}]





{
    "data": {
        "status": 1000,
        "face_url_arr": [
            "https://artzhe.oss-cn-shenzhen.aliyuncs.com/common/face_default/80x80_3X.png",
            "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/114/671/files/iosappSTS/2019/4/602235.jpg"
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}


"user_pic_like": [
                "https://artzhe.oss-cn-shenzhen.aliyuncs.com/common/face_default/80x80_3X.png",
                "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/114/671/files/iosappSTS/2019/4/602235.jpg"
            ],




"user_pic_like": [
                "https://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1492160518739919",
                "https://tva1.sinaimg.cn/crop.0.0.750.750.50/65a75f5fjw8fd2to52qpjj20ku0ku0ug.jpg",
                "https://tvax2.sinaimg.cn/crop.0.0.1080.1080.50/006ncv2uly8fhh9b2q9wbj30u00u1gqj.jpg",
                "https://tvax3.sinaimg.cn/crop.0.6.750.750.50/006k9vJTly8fdbs50h10zj30ku0l7gnh.jpg",
                "https://tva4.sinaimg.cn/crop.83.0.333.333.50/a5efe9dfjw8e72x2vkmz0j20dw099t90.jpg",
                "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/110/111/files/2017/11/s5m2i57drh.jpg",
                "https://tvax1.sinaimg.cn/crop.0.0.1002.1002.50/006jm6o7ly8ffah3kt36gj30ru0ruab5.jpg",
                "https://tvax4.sinaimg.cn/crop.4.0.741.741.50/af5d4537ly8fhokilbd1ij20ku0kl753.jpg",
                "https://tva2.sinaimg.cn/crop.0.1.1242.1242.50/006BqNRFjw8f8ztp4lg5nj30yi0ykq4a.jpg",
                "https://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1507510362025852.jpg"
            ],






[{"id":1,"title":"\u5173\u6ce8"},{"id":2,"title":"\u63a8\u8350"},{"id":3,"title":"\u70ed\u70b9"},{"id":4,"title":"\u65b0\u9510"},{"id":7,"title":"\u8da3\u95fb"},{"id":8,"title":"\u7f8e\u56fe"},{"id":9,"title":"\u6559\u7a0b"},{"id":10,"title":"\u5c55\u8baf"},{"id":11,"title":"\u62cd\u5356"},{"id":12,"title":"\u7d20\u6750"}]




[{"id":1,"isShow":false,"title":"关注"},{"id":2,"isShow":false,"title":"推荐"},{"id":3,"isShow":false,"title":"热点"},{"id":4,"isShow":false,"title":"新锐"},{"id":5,"isShow":false,"title":"大师"},{"id":6,"isShow":false,"title":"赏析"},{"id":7,"isShow":false,"title":"趣闻"},{"id":8,"isShow":false,"title":"美图"},{"id":9,"isShow":false,"title":"教程"},{"id":10,"isShow":false,"title":"展讯"},{"id":11,"isShow":false,"title":"拍卖"},{"id":12,"isShow":false,"title":"素材"},{"id":16,"isShow":true,"title":"美院"},{"id":15,"isShow":true,"title":"机构"},{"id":16,"isShow":true,"title":"美院"},{"id":17,"isShow":true,"title":"油画"},{"id":16,"isShow":true,"title":"美院"}]





112.97.50.240 - - [14/Jan/2020:10:44:29 +0800] "POST /V62/UserCenter/getMyFollowList HTTP/1.1" 200 1886 "-" "okhttp/3.11.0"
112.97.50.240 - - [14/Jan/2020:10:44:34 +0800] "POST /V62/UserCenter/getMyFollowList HTTP/1.1" 200 1886 "-" "okhttp/3.11.0"
112.97.50.240 - - [14/Jan/2020:10:44:42 +0800] "POST /V62/Extension/getApplyStatus HTTP/1.1" 200 121 "-" "okhttp/3.11.0"
112.97.50.240 - - [14/Jan/2020:10:44:42 +0800] "POST /V62/ArtCircle/getHeader HTTP/1.1" 200 544 "-" "okhttp/3.11.0"
112.97.50.240 - - [14/Jan/2020:10:44:42 +0800] "POST /V62/UserCenter/getMyGalleryDetail HTTP/1.1" 200 630 "-" "okhttp/3.11.0"
