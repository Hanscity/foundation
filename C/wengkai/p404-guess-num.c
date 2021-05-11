#include <stdio.h>
#include <time.h>
#include <stdlib.h>

int main()
{
    srand(time(0));
    int a = rand()%100;    // 0 ~ 99
    int guessNum = 0;
    int count = 0;

    printf("請輸入您猜測的數字(範圍 0~99)： ");

    do {
        count ++;
        scanf("%d", &guessNum);
        if (guessNum > a) {
            printf("大了， 兄弟~\n");
        } else {
            printf("小了， 兄弟~\n");
        }
    } while (guessNum != a);

    printf("恭喜您，答對了~ 您一起猜了 %d 次", count);

}