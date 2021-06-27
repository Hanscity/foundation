#include <stdio.h>

int main(int argc, const char* argv[])
{
    int a = 0xC0000000;
    unsigned int b = 0x80000000;
    printf("a:    %d\n", a);
    printf("b:    %u\n", b);
    printf("a>>1: %d\n", a>>1);
    printf("b>>1: %u\n", b>>1); // C语言中的移动一位，是移动一位 bit
                                // 汇编当中的移动一位，也是指移动一位 bit

}