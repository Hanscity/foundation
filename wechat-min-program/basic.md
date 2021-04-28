
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

```
wx.navigateTo({
  url: '/pages/index/register'
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

