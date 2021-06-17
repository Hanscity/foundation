#include <stdio.h>

int main(int argc, char const *argv[])
{
    char *s[] = {    // 比较特殊的二维数组， s[] 是一个数组，数组中的每一个元素是字符数组中的地址
        "hello",
        "what",
        "jordan",
    };

    int length = sizeof(s) / sizeof(s[0]);
    for (int i = 0; i < length; i++)
    {
        printf("%p:%s\n", &s[i], s[i]);
    }

    char *s1 = "hello";
    printf("%p:%s\n", &s1[0], s1);
}