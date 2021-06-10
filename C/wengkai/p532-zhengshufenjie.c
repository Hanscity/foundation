#include <stdio.h>


int main()
{
    int x;
    scanf("%d", &x);
    int save_x = x;
    int yushu = 1;
    int mask = 1;
    int weishu;


    while (x > 9) {
        x /= 10;
        mask = mask * 10;
    }

    do {
        weishu = save_x / mask;
        save_x = save_x % mask;
        printf("%d", weishu);
        if (mask == 1) {
            printf("\n");
        };
        mask /= 10;
    }while (mask > 0);

    
    

}