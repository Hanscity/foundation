#include <stdio.h>

void minmax(int a[], int length, int *min, int *max);

int main()
{
    
    int a[] = {1, 2, 3, 4, 5, 66, 7, 33, 9, 33, 55};
    int min, max;

    minmax(a, sizeof(a)/sizeof(a[0]), &min, &max);
    printf("min value: %d; max value: %d;\n", min, max);

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