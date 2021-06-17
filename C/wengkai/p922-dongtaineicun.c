#include <stdio.h>
#include <stdlib.h>

int main()
{
    int number;
    int *a;
    int i;
    printf("请输入数量：");

    scanf("%d", &number);
    a = (int*)malloc(number*sizeof(int));
    for (i=0; i<number; i++) {
        scanf("%d", &a[i]);    // scanf 需要 &
    }
    i--;
    for (i; i>=0; i--) {
        printf("%d ",a[i]);
    }
    // a++;    // 不是首地址，free 是会报错的
               // 不是 malloc 动态分配过来的，也无法 free
               
    free(a);    // scanf 释放空间

    return 0;
}