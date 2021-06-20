#include <stdio.h>

int main(int argc, const char *argv[])
{
    // 知识点之逗号运算符： 逗号运算符是所有运算符里面优先级最低的，低于赋值运算符

    int i;
    int j;
    i = 1+2, 4+5;
    j = (1+2, 4+5);
    printf("num value: %d\n", i); // 3
    printf("num value: %d\n", j); // 9

}