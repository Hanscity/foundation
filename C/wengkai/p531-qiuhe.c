#include <stdio.h>


int main()
{
    int n;
    int i = 0;
    double sum = 0;

    scanf("%d", &n);

    for (i=1; i<=n; i++) {
        sum += 1.0/i;
    }
    printf("%f \n", sum);

}