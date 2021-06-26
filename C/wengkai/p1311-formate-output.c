#include <stdio.h>

int main(int argc, char const *argv[])
{
    printf("%9d\n", 123); // 包含九个字符，右对齐
    printf("%-9d", 123); // 包含九个字符，左对齐
    printf("%d\n", 123);
}