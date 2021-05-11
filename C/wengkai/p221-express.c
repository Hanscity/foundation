#include <stdio.h>

int main()
{
    int startHour = 0, startMin = 0;
    int endHour = 0, endMin = 0;
    const int HOURMINTURN = 60;

    // 计算时间差
    printf("请输入开始时间的小时和分钟： ");
    scanf("%d %d", &startHour, &startMin);

    printf("请输入结束时间的小时和分钟： ");
    scanf("%d %d", &endHour, &endMin);

    int totalEnd = endHour * HOURMINTURN + endMin;
    int totalStart = startHour * HOURMINTURN  + startMin;
    int diffNum = totalEnd - totalStart;

    printf("间隔时间是 %d 小时 %d 分钟 \n", diffNum / HOURMINTURN, diffNum % HOURMINTURN);


}