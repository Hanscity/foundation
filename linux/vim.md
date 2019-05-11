# vim 

## 插入模式 iosa and IOSA
* i:before thie word
* o:next this line
* s:replace this word
* a:behind this word
* I:top of this line
* O:before this line
* S:replace this line
* A:behind this line


## ESC 模式下或者命令模式下的操作
* 输入 /word 后回车，即查找word，按 n 查找下一个匹配单词，按 N 查找上一个匹配单词。
* :set number（设置行数，enter即时生效）
* 当完成所有的编辑工作后，需要保存编辑器结果，退出编辑程序回到终端，可以发出ZZ命令，连续按两次大写的Z键。
* 将光标停留在某一个单词上，按*键就会跳到下一个
* 将光标停留在某一个单词上，按#键就会跳到上一个
* gg(来到文件的首行)
* G（来到文件的末行）
* numgg || numG(来到文件的第几行)
* 命令模式下，:num（来到文件的第几行）
* ctrl+g (查看当前行信息,显示类似信息："start_computer.sh" 13 行 --30%-- )
* 光标定位到要删除的那一行，然后  dd


## 查找字符串的三种情况
### 普通查找 
* 命令模式下，按’/’或’?’，然后输入要查找的字符，Enter。/和?的区别是，一个向前（下）找，一个向后（上）。

### 全词匹配
* 如果你输入 “/int”，你也可能找到 “print”。 要找到以 “int” 结尾的单词，可以用：/int\>  
“\>” 是一个特殊的记号，表示只匹配单词末尾。类似地，”\<” 只匹配单词的开头。
一次，要匹配一个完整的单词 “int”，只需：/\< int\>

### 是否区分大小写 
* :set ignorecase                    ##忽略大小写
* :set noignorecase                  ##大小写敏感


## 多行操作
* 1,10 d                             ## 删除 1到10行
* 1,10 co 12                         ## 将 1到10行复制到 12行
* 1,10 m 12                          ## 将 1到10行剪切到 12行


## 查找与替换

* %s/foo/bar/g 会在全局范围查找 foo 并替换为 bar，所有出现都会被替换
```
substitute : [ˈsʌbstɪtjuːt] 记忆技巧：sub 下 + stitute 建立；放 → 被放到下面 → 代替

{作用范围}s/{目标}/{替换}/{替换标志}

```

