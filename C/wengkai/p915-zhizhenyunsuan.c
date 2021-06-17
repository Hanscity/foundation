#include <stdio.h>

int main()
{
    char jordan[] = {1, 2, 3, 4, 5, 6};
    char *p = jordan;    // char *p = &jordan[0];
                         // char *(p+i) = &jordan[i];


    printf("p value is: %p\n", p);
    printf("p+1 value is: %p\n", p+1);


    int kobe[] = {1, 2, 3, 4, 5};
    int *q = kobe;

    printf("q value is: %p\n", q);
    printf("q+1 value is: %p\n", q+1);

}