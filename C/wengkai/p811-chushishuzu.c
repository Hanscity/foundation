#include <stdio.h>


int main()
{
    
    int i;
    int sum=0;
    int count=0;

    scanf("%d", &i);

    if (i==-1) {
        sum += i;
        count += 1;
    } else {
        while( i != -1) {
            sum += i;
            count += 1;
            scanf("%d", &i);
        }
    }
    
    printf("平均数是： %f \n", sum*1.0/count);
    
}

