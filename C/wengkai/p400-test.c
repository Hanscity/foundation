#include <stdio.h>

int main(int argc, const char *argv[])
{
    int a;
    printf("请输入您的数字：");
    scanf("%d", &a);

    int yushu = a % 3;

    switch (yushu)    // 练习一下 switch
    {
        case 1:
            printf("余数是: 1\n");
            break;
        case 2:
            printf("余数是: 2\n");
            break;
        case 0:
            printf("余数是: 0\n");
            break;
    }

}