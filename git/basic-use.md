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
