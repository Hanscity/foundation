#include <stdio.h>

int main(int argc, const char *argv[])
{
    int i = 0;
    while (i < 10)
    {
        i++;
        printf("continue..\n");
        if (i == 6)
        {
            printf("break..\n");
            break;    // 重新认识一下 break;
        }
    }
}