#include <stdio.h>

int main()
{

    int x;
    printf("请输入一个整数\n");
    scanf("%d", &x);

    if (x % 2 == 1)
    {
        printf("是奇数\r\n");
    }
    else 
    {
        printf("不是奇数\n");
    }

    return 0;
}
