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


## 本地 pull 一个远程分支，并且独立使用
 
```
fatal: Cannot update paths and switch to branch 'dev2' at the same time.
Did you intend to checkout 'origin/dev2' which can not be resolved as commit?

git fetch

git checkout -b 本地分支名 origin/远程分支名 (可以简写为 git checkout 分支名)

```

## git clean 

- git clean -fnd (f: 强制删除；n: 展示将要删除的，但是并不删除；d: 删除文件夹)


