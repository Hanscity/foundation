#include <stdio.h>
#include <string.h>


int main(int argc, const char *argv[])
{
    char s1[] = "hello";
    char s2[20] = "world";

    strncat(s2, s1, 5);
    printf("string s2: %s\n", s2);

    return 0;
}