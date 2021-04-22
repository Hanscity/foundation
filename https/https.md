# HTTPS

> http://www.ruanyifeng.com/blog/2014/09/ssl-latency.html

虽然下面的评论有些争议，但是还不错，特别是这个命令

```

curl -w "TCP handshake: %{time_connect}, SSL handshake: %{time_appconnect}\n" -so /dev/null https://www.alipay.com

```

我在 Ubuntu18.04 大概测试了以下： SSL 的时间大概是 HTTPS 时间的 2~4 倍
 

## 升级 HTTPS 证书

阮一峰博客的引导
> http://www.ruanyifeng.com/blog/2016/08/migrate-from-http-to-https.html

Let's Encrypt 网站的指示
> https://letsencrypt.org/zh-cn/getting-started/

Certbot 网站命令的具体安装 （我的环境是 Ubuntu18.04）
> https://certbot.eff.org/lets-encrypt/ubuntubionic-nginx


在第七步的时候，这个命令报错

sudo certbot certonly --nginx


```

IMPORTANT NOTES:

 - The following errors were reported by the server:

   Domain: api.mujia.online
   Type:   dns
   Detail: No valid IP addresses found for api.mujia.online


```


错误的原因，Let's Encrypt 网站有提及到，应该是这个原因：

```
在没有命令行访问权限的情况下，最好的办法是使用您托管服务提供商提供的内置功能。如果您的托管服务提供商提供 Let’s Encrypt 支持，他们可以帮助您申请免费证书，安装并配置自动续期。对于某些提供商，这是您需要在控制面板/联系客服打开的设置。其他一些提供商会自动为其所有客户请求和安装证书。

查看我们列举的托管服务提供商确认你的是否在上面。如果是的话，请按照他们的文档设置 Let’s Encrypt 证书。

如果您的托管服务提供商不支持 Let’s Encrypt，您可以与他们联系请求支持。我们尽力使添加 Let’s Encrypt 支持变得非常容易，提供商（注：非中国国内提供商）通常很乐意听取客户的建议！

如果您的托管服务提供商不想集成 Let’s Encrypt，但支持上传自定义证书，您可以在自己的计算机上安装 Certbot 并使用手动模式（Manual Mode）。在手动模式下，您需要将指定文件上传到您的网站以证明您的控制权。然后，Certbot 将获取您可以上传到提供商的证书。我们不建议使用此选项，因为它非常耗时，并且您需要在证书过期时重复此步骤。对于大多数人来说，最好从提供商处请求 Let’s Encrypt 支持。若您的提供商不打算兼容，建议您更换提供商。

```

