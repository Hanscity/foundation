#include <stdio.h>


int main()
{
    int a;
    int b;
    int t;
    printf("请输入两个正的数字：");

    scanf("%d %d", &a, &b);
    
    while (b != 0) {
        t = a % b;
        a = b;
        b = t;
    }
    
    printf("最大的公约数是： %d\n", a);

}