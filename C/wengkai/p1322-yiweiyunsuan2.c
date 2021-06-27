#include <stdio.h>

int main(int argc, const char* argv[])
{
    unsigned char c = 0xA5; // 16 进制 A 是 1001
    printf(" c   :%d\n", c); // 16 进制 aa
    printf("c<<2 :%d\n", c<<2); // 左移两位

}