#include <stdio.h>

int main()
{
    int i = 0;

    int *p = &i; // 这句话是一个定义：意思是，p变量保存的是一个指针，该指针指向变量 i 的地址，且该变量必须是 int 
                 // *p: 当拿来应用的时候，*p = i;
                 
    // int *q = 0;
    int *q = NULL;    // 很多的编译器，不喜欢用户看到 0 地址，用 NULL 来表示
    printf("*q address value is: %p \n", q);

}