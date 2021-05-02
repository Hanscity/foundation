
## 开始

1. 微信小程序官网
  > https://mp.weixin.qq.com/


2. 扫码 -> 选择账号登录（可能注册有多个）
-> 进入主页面



## AppID(小程序ID) 和 AppSecret(小程序密钥)	

- 主页面 -> 开发 -> 开发管理 -> 开发设置


## weui
> https://weui.io/


## 小程序的跳转

### navigate 标签

```
<navigator url="/pages/index/register" open-type="navigate">
    注册
</navigator>

```

open-type 值选项说明：

- navigate 保留当前页面，跳转到应用内的某个页面
- redirect 关闭当前页面，跳转到应用内的某个页面
- reLaunch 关闭所有页面，打开到应用内的某个页面
- switchTab 跳转到 tabBar 页面，并关闭其他所有非 tabBar 页面


### 脚本方法的跳转

#### 同一个 tabbar 下的页面跳转

```
// 方式一
wx.navigateTo({
  url: '/pages/index/register'
})


// 方式二
wx.redirectTo({
  url: '/pages/index/register'
})

```
#### 不同的 tabbar 下的页面跳转

```
wx.switchTab({
  url: '/pages/market/market',
})

```

#### 跳转后，刷新当前页面

```
wx.switchTab({
  url: '/pages/market/market',
  success: function (res) {
    let page = getCurrentPages().pop();
    if (page == undefined || page == null) {
      return;
    }
    page.onLoad();
  }
})

```







## 弹出提示框信息

成功和失败时（含有条件判断和页面跳转）

```
if (!userinfo) {
  wx.showToast({
    title: '该用户名或者密码不存在',
    icon: 'fail',
    duration: 2000
  })
  return;
}

wx.showToast({
  title: '登录成功',
  icon: 'success',
  duration: 2000,
  success: function () {
    wx.navigateTo({
      url: '/pages/index/register'
    })
  }
})

```


## 设置页面上方的 title (NavigationBarTitle)

app.json 中设置默认的 NavigationBarTitle

```

"window": {
    "navigationBarBackgroundColor": "#000000",
    "navigationBarTextStyle": "white",
    "navigationBarTitleText": "沐家农贸信息"   
},

```

页面中动态设置

```
wx.setNavigationBarTitle({
    title: '登录页面',
})

```


## 本地存储（本地的注册登录）

```

/**
* 生命周期函数--监听页面加载
* 获取本地缓存数据并设置
*/
onLoad: function (options) {
  const itemArr = wx.getStorageSync('items') || []; 
  this.setData({ items: itemArr });
},


/*
  设置本地缓存并设置
*/
const newItem = {
  username: this.data.username,
  password: this.data.password,
  passwordConfirm: this.data.passwordConfirm,
  phone: this.data.phone,
  codeVerify: this.data.codeVerify,
};
const itemArr = [...this.data.items, newItem];
wx.setStorageSync('items', itemArr);
this.setData({ items: itemArr });


/*
  从本地缓存中获取数据并判断
*/
let users = wx.getStorageSync('items') || [];
let userinfo = users.find(item => {
  return item.username === this.data.usernameInput && 
  item.password === this.data.passwordInput
});

if (!userinfo) {
  wx.showToast({
    title: '该用户名或者密码不存在',
    icon: 'fail',
    duration: 2000
  })
  return;
}

wx.showToast({
  title: '登录成功',
  icon: 'success',
  duration: 2000,
  success: function () {
    wx.navigateTo({
      url: '/pages/index/registerIndi'
    })
  }
})


```

### getStorageSync 有多个方法，到底用哪一个，他们有啥区别 ？？？？





## 远程数据请求

### POST 请求

#### "content-type": "application/json"

传递的数据 newItem 是对象
```
const newItem = {
  username: this.data.username,
  password: this.data.password,
  passwordConfirm: this.data.passwordConfirm,
  phone: this.data.phone,
  codeVerify: this.data.codeVerify,
};

wx.request({
  url: app.globalData.serverHost + '/index/user/test',
  method: "POST",
  header: {
      "content-type": "application/json"
  },
  data: newItem,
  success(res) {
    console.log(res);
  }
});

```


#### "content-type": "application/x-www-form-urlencoded"

传递的数据 newItem 是对象

```
const newItem = {
  username: this.data.username,
  password: this.data.password,
  passwordConfirm: this.data.passwordConfirm,
  phone: this.data.phone,
  codeVerify: this.data.codeVerify,
};

wx.request({
  url: app.globalData.serverHost + '/index/user/test',
  method: "POST",
  header: {
      "content-type": "application/x-www-form-urlencoded"
  },
  data: newItem,
  success(res) {
    console.log(res);
  }
});

```


总结：传递对象数据即可



## 下拉框

> https://blog.csdn.net/qq_38215042/article/details/87609270

这篇文章写的挺好，拿来就可以用了,copy 如下：

JS 文件

```
Page({
  /**
   * 页面的初始数据
   */
  data: {
    shows: false, //控制下拉列表的显示隐藏，false隐藏、true显示
    selectDatas: {
      1: '稻谷',
      2: '大米',
      3: '稻米副产品',
      101: '小麦',
      102: '小麦副产品',
      201: '玉米',
      202: '玉米副产品',
      301: '大豆',
      302: '大豆副产品',
      401: '杂粮',
      402: '杂粮副产品'
  }, //下拉列表的数据
    indexs: 1, //选择的下拉列 表下标,
    selectDatasLength: 0,

  },

  // 点击下拉显示框
  selectTaps() {
    this.setData({
      shows: !this.data.shows,
    });
  },
  // 点击下拉列表
  optionTaps(e) {
    let Indexs = e.currentTarget.dataset.index; //获取点击的下拉列表的下标
    console.log(Indexs)
    this.setData({
      indexs: Indexs,
      shows: !this.data.shows
    });
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    let selectDatasLength = Object.getOwnPropertyNames(this.data.selectDatas).length;

    this.setData({
      selectDatasLength: selectDatasLength
    })
  },
  
})

```


wxml 文件

```
<!-- 
  https://blog.csdn.net/qq_38215042/article/details/87609270
-->

<view class='fenlei'>

  <view class="title">
    <text>农贸品类: </text>
  </view>

  <!-- 下拉框 -->
    <view class='select_box'>
      <view class='select' catchtap='selectTaps'>
        <text class='select_text'>{{selectDatas[indexs]}}</text>
        <!-- <image class='words_img' src='../../images/sanjiao.png'></image> -->
        <image class='select_img {{shows&&"select_img_rotate"}}' src='../../images/sanjiao.png'></image>
      </view>
      <view class='option_box' style='height:{{ shows ? ( selectDatasLength>5 ? 300 : selectDatasLength*60 ) : 0 }}rpx;'>
        <!-- 我个人觉得，wx:key='this' 并没有用到，暂且这样~ -->
        <text class='option' style='{{ indexs==selectDatasLength-1&&"border:0;"}}' wx:for='{{selectDatas}}' wx:key='this' data-index='{{index}}' catchtap='optionTaps'> {{item}} </text>
      </view>
    </view>
</view>


```

wxss 文件

```

/* fenlei */
.fenlei{
  margin: 0 25rpx;
  height: 90rpx;
  line-height: 90rpx;
  border-bottom: 1rpx solid #e6e6e6;
  display: flex;
  align-items: center;
}

.fenlei .title {
  width: 200rpx;
}

.fenlei text{
  font-size: 30rpx;
  color: #999999;
  margin-left: 15rpx;
}
/* 下拉框 */
.select_box {
  background: #fff;
  width: 100%;
  /* margin: 0 auto; */
  height: 90rpx;
  line-height: 90rpx;
  text-align: left;
  position: relative;
}

.select {
  box-sizing: border-box;
  width: 100%;
  height: 86rpx;
  /* border: 1px solid #efefef; */
  border-radius: 8rpx;
  display: flex;
  align-items: center;
  padding: 0 20rpx;
}

.select_text {
  font-size: 28rpx;
  flex: 1;
  color: rgb(102, 102, 102);
  line-height: 86rpx;
  height: 86rpx;
}

.select_img {
  width: 40rpx;
  height: 40rpx;
  display: block;
  transition: transform 0.3s;
}

.select_img_rotate {
  transform: rotate(180deg);
}

.option_box {
  position: absolute;
  top: 86rpx;
  width: 100%;
  /* border: 1px solid #efefef; */
  box-sizing: border-box;
  height: 0;
  overflow-y: auto;
  border-top: 0;
  background: #fff;
  transition: height 0.3s;
  z-index: 100;
}

.option {
  display: block;
  line-height: 40rpx;
  font-size: 28rpx;
  border-bottom: 1px solid #efefef;
  padding: 10rpx;
  color: rgb(102, 102, 102);
}

```



## 微信授权登录

新版本的代码如下：

JS 文件

```
//index.js
Page({
  // 页面的初始数据
  data: {
    isShowUserName: false,
    userInfo: null,
  },

  
  getUserProfile: function(e) {
    wx.getUserProfile({
      /**
       * parameter error: parameter.desc should be String instead of Undefined;
       * 简而言之，就是 desc 属性必不可少
       */
      desc: '用于完善会员资料',
      success: (res) => {
        console.log("获取用户信息成功", res);
        let user = res.userInfo;
        // wx.setStorageSync('user', user);
        this.setData({
          isShowUserName: true,
          userInfo: user,
        })
      },
      fail: res => {
        console.log("获取用户信息失败", res);
      }
    })
  },

  /**
   * 生命周期函数--监听页面显示
   */
  // onShow(options) {
  //   this.getUserProfile();
  //   let user = wx.getStorageSync('user');
  //   if (user && user.nickname) {
  //     this.setData({
  //       isShowUserName: true,
  //       userInfo: user,
  //     })
  //   }
  // },

  
})

```


wxml 文件

```
<!-- 用户授权了，就显示头像和昵称-->
<view class="header" wx:if="{{isShowUserName}}" bindtap="change" >
  <image class="userinfo-avatar" src="{{userInfo.avatarUrl}}"></image>
  <text class="userinfo-nickname">{{userInfo.nickName}}</text>
</view>

<!-- 如果用户没有授权，显示登录按钮 -->
<view wx:if="{{!isShowUserName}}" class="btn-login">
  <button type="primary" bindtap="getUserProfile">授权登录</button>
</view>


```

wxss 文件

```
page {
  background: gainsboro;
}

.header {
  width: 100%;
  display: flex;
  flex-direction: column;
  padding-bottom: 15px;
  align-items: center;
  background: white;
}

.btn-login {
  padding: 8%;
  background: white;
}

.userinfo-avatar {
  border-radius: 128rpx;
  width: 128rpx;
  height: 128rpx;
  /* margin-block-start: 10px; 此时等同于 margin-top: 10px; */
  margin-block-start: 10px;
}

.userinfo-nickname {
  margin-top: 20rpx;
  font-size: 38rpx;
}

```



