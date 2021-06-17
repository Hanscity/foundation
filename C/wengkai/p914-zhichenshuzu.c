#include <stdio.h>

void minmax(int a[], int length, int *min, int *max);

int main()
{
    
    int a[] = {22, 2, 3, 4, 5, 66, 7, 33, 9, 33, 55};
    int min, max;

    minmax(a, sizeof(a)/sizeof(a[0]), &min, &max);
    printf("min value: %d; max value: %d;\n", min, max);

    int *p = &min;
    // 指针可以当做数组来用
    printf("*p value is: %d\n", *p);
    printf("p[0] value is: %d\n", p[0]);

    // 数组可以当做指针来用，表示取用第一个元素
    printf("*a=%d\n", *a);
}


void minmax(int a[], int length, int *min, int *max)
{
    *min = *max = a[0];
    int i = 0;
    for (i; i<length; i++) {
        if (a[i] < *min) {
            *min = a[i];
        } 
        if (a[i] > *max) {
            *max = a[i];
        }
    }
}