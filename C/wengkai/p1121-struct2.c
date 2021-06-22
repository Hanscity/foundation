#include <stdio.h>

int main(int argc, const char *argv[])
{
    struct date {
        int year;
        int month;
        int day;
    };

    struct date today;
    today = (struct date){2021, 06, 22};

    struct date today2 = today;
    struct date *p = &today; // today 并不是地址哦

    printf("today is %i-%i-%i\n", today.year, today.month, today.day);
    printf("today is %i-%i-%i\n", today2.year, today2.month, today2.day);
    printf("point address: %p\n", p);

    
}