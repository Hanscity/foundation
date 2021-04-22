# Chinese garbled(中文乱码)

garbled

英 [ˈɡɑːbld]   美 [ˈɡɑːrbld]  

adj.
混乱不清的，引起误解的(常因讲述者惊慌或匆忙所致)

v.
断章取义；窜改，歪曲;（非有意地）混淆;干扰；错乱；电文错乱；电文错漏

garble的过去分词和过去式



## Ubuntu git 默认情况下,乱码状况如下：

```
On branch master
Your branch is up to date with 'origin/master'.

Untracked files:
  (use "git add <file>..." to include in what will be committed)

        "front/js/lilichao/105_\345\210\240\351\231\244\346\267\273\345\212\240\350\256\260\345\275\225003.html"
        "front/js/lilichao/105_\345\210\240\351\231\244\346\267\273\345\212\240\350\256\260\345\275\225\344\274\230\345\214\226\347\211\210.html"
```

## 解决办法

> https://blog.csdn.net/lusyoe/article/details/53400641


###  方式一： 命令行修改

    ```
    git config --global core.quotepath false

    ```

###  方式二： 修改文件

    vim ~/.gitconfig

    ```
    [core]
        quotepath = false

    ```





