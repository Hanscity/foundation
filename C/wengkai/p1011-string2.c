#include <stdio.h>

int main()
{
    char *s;
    s = "hello";
    printf("%p:%s\n", &s[0], s);

}