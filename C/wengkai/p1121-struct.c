#include <stdio.h>

int main(int argc, const char *argv[])
{
    struct date {
        int year;
        int month;
        int day;
    };

    struct date today;

    today.year = 2019;
    today.month = 6;
    today.day = 22;

    printf("today is %i-%i-%i\n", today.year, today.month, today.day); // %i和%d 没有区别。%i 是老式写法。都是整型格式。
    
}