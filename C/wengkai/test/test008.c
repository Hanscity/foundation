#include <stdio.h>

int main(int argc, const char *argv[])
{

    int i, x, y;
    i = x = y = 0;
    do
    {
        ++i;
        if (i % 2)
            x += i, // 注意，这里是一个逗号
                i++;
        y += i++;
    } while (i <= 7);
    printf("%d %d %d\n", i, x, y); // 9, 1, 20
}