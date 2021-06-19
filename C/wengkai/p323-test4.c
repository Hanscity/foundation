#include <stdio.h>

int main(int argc, const char *argv[])
{
    for (int i=10; i>1; i /= 2)
    {
        printf("%d\n", i++);    // 10 5 3 2 
    }
}