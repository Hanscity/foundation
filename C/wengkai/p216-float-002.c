#include <stdio.h>

int main()
{
    double foot;
    double inch;

    printf("请分别输入身高的英尺和英寸，如输入 \"5 7\" 表示 5 英尺 7 英寸： ");

    scanf("%lf %lf", &foot, &inch);

    printf("您的身高是 %f 米\n", (foot + inch/12) * 0.3048);

    return 0;

}