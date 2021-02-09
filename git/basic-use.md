- git add -A :/                      ## add all
- git add file                       ## 将此文件提交到本地仓库
- git commit -m 'message'            ## 将本地仓库的内容提交到版本库，并记录内容等提示信息
- git commit -am ''                  ## 在无文件新增的情况下，等同于 add , -m 
- git status                         ## 查看当前版本库的状态 



- git branch                         ## find local branch
- git branch -a                      ## find all local branch
- git branch a                       ## add branch a
- git branch -D b                    ## delete branch b
- git checkout a                     ## go into branch a
- git checkout -b c                  ## create branch c, then checkout c

- git checkout -- file               ## revert the change when the file not add to local repository
- git reset --hard Version           ## revert the version while all files in 
- git merge branch_a                 ## merge local branch branch_a

- git pull origin branch_a           ## pull one branch from remote
- git fetch origin branch_a          ## fetch one branch from remote
- git push origin test               ## push branch to remote



## git 合并流程

### 普通流程

- 当前在 work_branch
- git checkout develop
- git pull origin develop

- git checkout work_branch
- git rebase develop

- git checkout develop
- git merge --no-ff work_branch


### 优化的办法

- 当前在 work_branch
- git fetch
- git rebase origin/develop

- git checkout develop
- git merge --no-ff work_branch



### --no-ff 参数的说明
- https://blog.csdn.net/zombres/article/details/82179122
- 将被合并分支的多个节点合并为一个阶段来合并，是图形更加好看


### git rebase

- rebase : 顾名思义，重新设置基准点

- rebase -i
> https://www.jianshu.com/p/4a8f4af4e803
> https://zhuanlan.zhihu.com/p/145037478

```
git rebase -i  [startpoint]  [endpoint]

pick：保留该commit（缩写:p）
reword：保留该commit，但我需要修改该commit的注释（缩写:r）
edit：保留该commit, 但我要停下来修改该提交(不仅仅修改注释)（缩写:e）
squash：将该commit和前一个commit合并（缩写:s）
fixup：将该commit和前一个commit合并，但我不要保留该提交的注释信息（缩写:f）
exec：执行shell命令（缩写:x）
drop：我要丢弃该commit（缩写:d）
```

- git rebase branch_name (将当前分支的基点往前提，是图形更加的好看)



## git config

### set
- git config --global user.name "aaa"
- git config --global user.email "bbb"

- git config --global push.default simple (设置之后，就可以直接使用 git push ,从而推送当前的分支)

### check
- git config --global user.name
- git config --global user.email



## git link remote

- git remote add origin git@github.com:Hanscity/Laravel-L01-weibo.git


## git change branch name

- git branch -M branch_name



## plaste all changes

- git clean -df

Sometimes you dont need to use git reset command, if you known this command

当你将文件放入了暂存区（也就是所使用了 git add），那么这个命令就不行了

