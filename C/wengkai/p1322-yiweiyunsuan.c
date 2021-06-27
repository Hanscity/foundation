#include <stdio.h>

int main(int argc, const char* argv[])
{
    unsigned char c = 0xAA; // 16 进制 A 是 1001
    printf(" c %hhx\n", c); // 16 进制 aa
    printf("~c %hhx\n", ~c); // 取反，h用于将整型的格式字符修正为short型
    printf("-c %hhx\n", -c); // 补码，取反加一

}