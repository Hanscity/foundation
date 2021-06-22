#include <stdio.h>


int main()
{
    int a[] = {0};
    int *p = a;

    printf("%d\n", p == &a[0]);
    printf("%d\n", *p == a[0]);
    printf("%d\n", p[0] == a[0]);
    
}
