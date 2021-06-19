#include <stdio.h>

int main(int argc, const char *argv[])
{
    int sum = 0;
    for (int i = 0; i < 10; i++)
    {
        if (i % 2)
        {
            printf("line-10: %d\n", i);
            break; // break 断掉的是整个 for 循环
        }
        printf("line-13: %d\n", i);
        sum += i;
    }
    printf("%d\n", sum); // 0
}