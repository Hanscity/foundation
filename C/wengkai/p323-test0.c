#include <stdio.h>

int main(int argc, const char *argv[])
{
    int n = 100;

    if (1 <= n <= 10)
    {
        printf("value: %d\n", n); // 打印出了结果，可以看出从左往右执行
    }
}