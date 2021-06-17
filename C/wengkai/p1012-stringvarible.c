#include <stdio.h>

int main(void)
{
    char *s = "Hello World";    // 不可以修改,指针指向了代码段
    char word[] = "Hello";    // 可以修改


    printf("Here s[0]=%p\n", s);
    printf("Here word[0]=%p\n", word);

    word[0] = 'B';    // 如果是双引号，则会报错的
    printf("word[0]=%c\n", word[0]);

    return 0;

}