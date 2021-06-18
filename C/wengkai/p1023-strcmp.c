#include <stdio.h>
#include <string.h>

int mycmp(char const *s1, char const *s2)
{
    // 方法一: 数组
    // int idx = 0;
    // while (s1[idx] == s2[idx] && s1[idx] != '\0')
    // {
    //     idx++;
    // }
    // return s1[idx] - s2[idx];

    // 方法二: 指针
    while (*s1 == *s2 && *s1 != '\0')
    {
        s1++;
        s2++;
    }
    return *s1 - *s2;
}

int main(int argc, const char *argv[])
{
    char s1[] = "Abc";
    char s2[] = "aBc ";

    printf("strcmp: %d\n", strcmp(s1, s2));
    printf("my cmp: %d\n", mycmp(s1, s2));


    // if (strcmp(s1, s2) == 0)
    // {
    //     printf("strcmp: %d\n", strcmp(s1, s2));
    //     printf("s1==s2: %d\n", s1==s2);
    // }

}