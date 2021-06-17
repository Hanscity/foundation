#include <stdio.h>


int main()
{
    char buffer[100] = "";
    printf("%d\n", buffer[0]);    // 数值0，而不是字面量 0。所以用 "%s\n" 就会报错。

}