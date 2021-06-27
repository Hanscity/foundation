#include <stdio.h>

int main(int argc, const char* argv[])
{
    int number;
    scanf("%d", &number);
    unsigned mask = 1u<<31; // unsigned mask = unsigned int mask
                            // 1u 就是 unsigned 1   
    for (; mask; mask >>= 1) // mask >>=1 等于 mask = mask >> 1;如果不写等于号，将是一个无限的循环
    {
        printf("%d", number & mask ? 1 : 0);
    }
    printf("\n");
    return 0;

}