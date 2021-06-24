#include <stdio.h>

int main()
{
    char *s = "hello";    // 'hello' 单引号是不行的,因为单引号是表示字符，双引号才可以表示字符串
    printf("%p:%s\n", &s[0], s);

}