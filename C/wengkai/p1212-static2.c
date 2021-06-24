#include <stdio.h>

int gAll = 0;

void f(void);

int main(int argc, const char *argv[])
{
    f();
    return 0;
}


void f(void)
{
    static int a = 1;
    printf("point value: %p\n", &a);
    printf("point value: %p\n", &gAll); // 可以看出，静态变量的地址和全局变量相邻很近

}