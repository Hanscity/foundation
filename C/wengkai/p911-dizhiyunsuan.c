#include <stdio.h>

int main()
{
    int i;

    printf("请输入你的数字： ");
    scanf("%d", &i);

    // printf("16 进制的地址是： 0x%x\n", &i);
    printf("16 进制的地址是： %p\n", &i);

}