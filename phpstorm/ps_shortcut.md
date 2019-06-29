## 快捷键

* alt+1 :  展示文件夹--show the floder
* alt+home : 显示目录导航--navigation bar
* alt+f4 : 关闭当前的 phpstorm
* alt+enter : 迅速引入对象的类
* alt+up : 上一个方法
* alt+down : 下一个方法


* ctrl+e : 打开最近关闭的文件--recent files
* ctrl+f4 : 关闭当前 tab
* ctrl+d 复制当前行
* ctrl+y 删除当前行
* ctrl+/ : //注释
* ctrl+shift+/ :  /**/注释
* ctrl+z : 撤销
* ctrl+shift+z : 前进
* ctrl+w : 选中标签中的内容
* ctrl+g : 跳转哪一行
* ctrl+alt+left : 跳转到一个方法之后，再往回跳转
* ctrl+alt+right : 向前跳转
* shift+enter : 开启新行
* shift+f6 : 改变方法名并且应用到所有的地方--do refactor || cancel



## 搜索查找
* ctrl+n : 搜索类
* ctrl+b : 迅速查找变量定义的地方，这个变量也包括类
* ctrl+alt+b : 在类的申明的地方，查看有多少个子类继承
* ctrl+b :如果是类名，则显示此类在哪些地方被 new ;如果是方法名， 跳转到类的申明的地方-- go to function
* ctrl+单击 : 如果是类名，则显示此类在哪些地方被 new ;如果是方法名， 跳转到类的申明的地方-- go to function
* ctrl+f: 当前文件查找--find content in recent file
* alt+f7:在 ctrl+f 的情况下，展示所有的出现--
* ctrl+shift+f : 全局搜索字符串，包括方法，可以指定文件夹
* shift+shift : 查找文件，还有其它。。
* ctrl+shift+n : 查找文件--go to file
* ctrl+f12 : 显示当前文件有多少个的方法，然后直接输入查询。。
* ctrl+r : 当前页面的替换

## 
* alt+f12 : 打开命令行栏--open the command line 

## setting
* 是否需要提醒类型 : Editor > General > Appearance > Show (搜索 parameter name hints )
* 拼写检查 : File -> Settings -> Editor -> inspections -> spelling -> typo
* 自定义模板 : File -> Settings -> Editor -> Live Templates
* 忽略文件：File -> Settings -> Version Control -> Ignored Files
* 自动换行 : File -> Settings -> Editor -> General -> Use soft wraps in editor


## subversion

* 如何从版本库中忽略文件而不删除
   1. 从版本库中删除文件而不在本地删除
      ```   
      svn rm --keep-local file
      svn ci

      ```

   2. 利用 phpstorm 的设置来忽略文件



## 快捷键--Mac

* command + 7                                  ## 查看当前类的方法
* command + l                                  ## 跳转到哪一行
