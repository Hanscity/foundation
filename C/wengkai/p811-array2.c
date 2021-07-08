#include <stdio.h>

int main()
{
    int a[5] = {0, 1, 2, 3, 4}; 
    a[0] = 1; // 数组的内容是可变的

    printf("a[0] value: %d\n", a[0]);
    
}