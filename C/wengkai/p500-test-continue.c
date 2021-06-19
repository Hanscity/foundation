#include <stdio.h>

int main(int argc, const char *argv[])
{
    int sum = 0;
    for (int i = 0; i < 10; i++)
    {
        if (i % 2)
            continue;
        sum += i;
    }
    printf("%d\n", sum);    // 20
}