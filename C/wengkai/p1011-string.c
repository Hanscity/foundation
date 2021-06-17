#include <stdio.h>

int main()
{
    char *s = "hello";    // 'hello' 单引号是不行的
    printf("%p:%s\n", &s[0], s);

}