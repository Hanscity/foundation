# gcc 编译多个文件

- gcc p1231-main.c p1231-max.c


## --save-temps

将编译，汇编，链接的中间文件给展示出来


## printf.h

/usr/include 文件夹中有 printf.h 文件，这只是一个头文件，真正的执行代码还不在这个文件当中。


## extern

- 申明，普通变量是定义， 加上 extern 是申明，头文件中的申明不能初始化的赋值。

- 申明不产生代码，定义产生代码


