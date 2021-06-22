#include <stdio.h>

int main()
{
    int m[][3] = {1,4,7,2,5,8,3,6,9,10}; // 等同于 {{1,4,7},{2,5,8},{3,6,9},{10}}
    int i,j,k=2;
    for ( i=0; i<3; i++ ) {
        printf("%d", m[k][i]);
    }
    printf("\n");
}