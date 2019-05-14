## 生成秘钥
```
ssh-keygen -t rsa -C "youremail@example.com"

```


## 从所有提交中删除一个文件
* 背景：这个经常发生。有些人不经思考使用git add .，意外地提交了一个巨大的二进制文件，你想将它从所有地方删除。也许你不小心提交了一个包含密码的文件，而你想让你的项目开源。filter-branch大概会是你用来清理整个历史的工具。要从整个历史中删除一个名叫password.txt的文件，你可以在filter-branch上使用--tree-filter选项：

* git filter-branch --tree-filter 'rm -f passwords.txt' HEAD


## 从 git 版本库中移出文件但不是在硬盘中删除

1. git rm -r data/runtime --cached
2. .gitignore 中增加过滤规则


## git 中文乱码问题
* git config –-global core.quotepath false

