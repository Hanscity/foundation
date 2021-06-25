#include <stdio.h>

// const double PI = 3.14159; // c99 的写法

#define PI 3.14159 // c90 的写法, 这不是 C 语言的写法，故不需要冒号来结束；
                      // # 是 C 的编译预处理指令,#define 就是 宏
                      // gcc --save-temps 加上这个参数后编译，.i 文件中可以看出预编译的情况，会将宏进行文本替换

int main(int argc, const char *argv[])
{

    printf("value: %f\n", PI);
}