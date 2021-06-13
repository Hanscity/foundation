#include <stdio.h>


int main()
{
    
    int i;
    int sum=0;
    int count=0;
    int num[100];
    double avg;

    scanf("%d", &i);

    if (i==-1) {
        sum += i;
        count += 1;
    } else {
        while( i != -1) {
            num[count] = i;
            sum += i;
            count += 1;
            scanf("%d", &i);
        }
    }

    avg = sum*1.0/count;
    printf("平均数是： %f \n", avg);
    for (int j=0; j<count; j++) {
        if (num[j] >= avg) {
            printf("不小于平均数，是： %d \n", num[j]);
        }
    }
    
    
    
}

