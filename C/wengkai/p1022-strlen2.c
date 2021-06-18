#include <stdio.h>
#include <string.h>

int main(int argc, char const *argv[])
{
    int len[] = "title";

    printf("str length: %ld\n", strlen(len));
    printf("str length: %ld\n", sizeof(len)/sizeof(len[0]));
    printf("str length: %ld\n", sizeof(len));


}