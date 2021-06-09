#include <stdio.h>

int main()
{
    int a = 10000;

    int ret = 0;
    int res;

    while (a > 0) {
        res = a % 10;
        a /= 10;
        ret = ret * 10 + res;
    };

    printf("%d", ret);
    return 0;
    
}