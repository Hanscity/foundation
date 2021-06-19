#include <stdio.h>

int main(int argc, const char *argv[])
{
    int n = 100;
    // 看看 vscode 格式化后的标准格式
    if (n < 10)
    {
        printf("small\n");
    }
    else if (n >= 10 && n < 1000)
    {
        printf("middle\n");
    }
    else
    {
        printf("big\n");
    }
}