- git add -A :/ 
- git commit -m 'message'


- git branch     (find local branch)
- git branch -a  (find all branch )

- git branch a   (add branch a )
- git branch -D b  (delete branch b)
- git checkout a  (go into branch a)
- git checkout -b c (create branch c, then checkout c)

- git checkout -- file
- git reset --hard Version


- git merge branch_a (merge ..)

- git pull origin branch_a ()
- git fetch origin branch_a     ()
- git merge 




- git push origin test

- 查看文件的改动

   - git log <filename>
   -  git show version_id <filename>




- 查看 git branch 合并图

```

git log --graph --decorate --oneline --simplify-by-decoration --all


说明：

--decorate 标记会让git log显示每个commit的引用(如:分支、tag等) 

--oneline 一行显示
--simplify-by-decoration 只显示被branch或tag引用的commit

--all 表示显示所有的branch，这里也可以选择，比如我指向显示分支ABC的关系，则将--all替换为branchA branchB branchC

```


