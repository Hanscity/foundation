#include <stdio.h>

#define cube(x) ((x) * (x) * (x)) 
// #define cube(x) (x * x * x) // 值，参数，都要带上括号，预编译的时候，你就会看到不带上括号可能会不按照你的设想执行
int main(int argc, const char *argv[])
{
    printf("%d\n", cube(3));
}