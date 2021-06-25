#include <stdio.h>

int main(int argc, const char *argv[])
{
    // C 预定义的宏
    printf("Line: %d\n", __LINE__);
    printf("File: %s\n", __FILE__);
    printf("Date: %s\n", __DATE__);
    printf("Time: %s\n", __TIME__);
    printf("Stdc: %d\n", __STDC__);

    return 0;

}