#include <stdio.h>

int main(int argc, const char *argv[])
{
    int i=10;
    long long t = sizeof(i++);
    printf("%d", i); // 10, 分析： C 语言中的 sizeof 运算符除变长数组作为操作数需要求值外，其他方式的操作数都不进行求值操作。
    
}