#include <stdio.h>
void f(void);

int main(int argc, const char *argv[])
{
    f();
    f();
    f();
    // printf("a value: %d\n", a); // 这里会报出错误，因为
                                   // 静态变量拥有全局的生存期，本地的作用域
                                   // 全局变量拥有全局的生存期，全局的作用域；
                                   // 本地变量拥有本地的生存期，本地的作用域；

    return 0;
}


void f(void)
{
    static int a = 1; // 如果是静态变量，初始化的动作只会进行一次
                      
    printf("a value: %d\n", a);
    ++a;
    printf("a value: %d\n", a);

}