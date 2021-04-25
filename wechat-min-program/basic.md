
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

