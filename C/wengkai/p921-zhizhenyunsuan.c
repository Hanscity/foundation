#include <stdio.h>

int main()
{
    int i = 1;
    int *p = &i;
    void *q = (void*)p;

    printf("*p value is: %p\n", p);
    printf("*q value is: %p\n", q);

}