#include <stdio.h>

int gAll; // 如果没有做初始化，那么编译器会将其初始化为 0

void func(void);

int main(int argc, const char *argv[])
{
    printf("%s, %d\n", __func__, gAll);
    func();
    printf("%s, %d\n", __func__, gAll);
}

void func(void)
{
    gAll++;
    printf("%s, %d\n", __func__, gAll);
}