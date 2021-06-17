#include <stdio.h>

void f();

int main()
{
    f();
    return 0;
}


void f()
{
    char word[8];
    scanf("%8s", word);
    printf("%s##\n",word);
}