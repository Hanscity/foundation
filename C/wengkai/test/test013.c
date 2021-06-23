#include <stdio.h>

int sumThree(int startNum, int endNum)
{
    int sum = 0;
    int i = startNum;
    while (i <= endNum)
    {
        if (i % 3 == 0)
        {
            sum += i;
        }
        ++i;
    }

    return sum;
}


int main()
{
    int sum = sumThree(3, 100);
    printf("%d\n", sum);
}
