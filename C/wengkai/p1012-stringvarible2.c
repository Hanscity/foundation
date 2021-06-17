#include <stdio.h>

int main(void)
{

    int i = 0;
    char *s = "Hello, world"; 
    char *s2 = "Hello, world";
    char s3[] = "Hello, world";
    s3[1] = 'F';

    printf("i  address is: %p\n", &i);
    printf("s  address is: %p\n", s);
    printf("s2 address is: %p\n", s2);
    printf("s3 address is: %p\n", s3);


    return 0;

}