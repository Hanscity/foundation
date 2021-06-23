#include <stdio.h>

double getPI()
{
    double direct = 1000000;
    double sum = 0;
    int n = 0;
    int flag = 1;

    while (2*n + 1 < direct)
    {
        sum += 1.0 / (2*n + 1) * flag;
        ++n;
        flag = -flag;
    }
    sum = 4 * sum;
    return sum;
}

int main()
{
    printf("%f\n", getPI());
}
