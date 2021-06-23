#include <stdio.h>

double forCircleDirect()
{
    double direct = 1.0/1000000;
    double sum = 0;
    int n = 0;

    while (1.0/(2*n + 1) > direct)
    {
        if (n%2 == 0)
        {
            sum += 1.0/(2*n + 1);
        }
        else
        {
            sum -= 1.0/(2*n + 1);
        }
        ++n;

    }
    sum = 4 * sum;
    return sum;
}
int main()
{
    printf("%f\n", forCircleDirect());
}
