#include <stdio.h>
#include <string.h>

char* mycpy(char *dst, const char *src)
{
    // 方法一： 数组
    // int idx = 0;
    // while (src[idx] != '\0')
    // {
    //     dst[idx] = src[idx];
    //     idx++;
    // }
    // dst[idx] = '\0';
    // return dst;

    // 方法二： 指针
    // char *ret = dst;
    // while (*src != '\0')
    // {
    //     *dst = *src;
    //     dst++;
    //     src++;
    // }
    // *dst = '\0';
    // return ret;

    // 方法二： 指针的简洁写法
    char *ret = dst;
    while (*dst++ = *src++);
    return ret;

}

int main(int argc, const char *argv[])
{
    char src[] = "title,wengkai's c";
    char dst[] = {};

    // strcpy(dst, src);
    mycpy(dst, src);
    printf("dst: %s\n", dst);

}