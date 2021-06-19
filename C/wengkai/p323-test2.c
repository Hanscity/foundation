#include <stdio.h>

int main(int argc, const char *argv[])
{
    int cnt = 0;
    for (int i = 0; i < 100; i++)
    {
        cnt++;
        if (i == 50)
        {
            printf("value: %d\n", i);
            break;    // 重新认识一下 break;
        }
    }
    printf("cnt: %d\n", cnt);
}