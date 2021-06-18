#include <stdio.h>

int main()
{
    char ap[] = {1, 2, 3, 4, 5, 6, 7, 8, 9,};
    printf("ap   address: %p\n", ap);
    printf("ap   sizeof : %ld\n", sizeof(ap));
    printf("ap+1 address: %p\n", ap+1);

    int aq[] = {1, 2, 3, 4, 5, 6, 7, 8, 9,};
    printf("aq   address: %p\n", aq);
    printf("aq   sizeof : %ld\n", sizeof(aq));
    printf("aq+1 address: %p\n", aq+1);
}   