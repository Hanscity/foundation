#include <stdio.h>
#include <string.h>

long int mylen(char const *s)
{
    int idx = 0;
    while (s[idx] != '\0')
    {
        idx++;
    }
    return idx;
}

int main(int argc, char const *argv[])
{
    char len[] = "title";

    printf("str length: %ld\n", strlen(len));
    printf("str length: %ld\n", sizeof(len)/sizeof(len[0]));
    printf("str length: %ld\n", sizeof(len));
    printf("str length: %ld\n", mylen(len));


}