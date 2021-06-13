#include <stdio.h>

void cheer(int i);

int main()
{
    
    cheer(3.4);
    return -1;    // echo $? 可以打印出结果的
}

void  cheer(int i)
{
    printf("i=%d \n", i);
}