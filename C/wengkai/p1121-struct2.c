#include <stdio.h>

struct point {
        int x;
        int y;
};

void getStruct(struct point);
void output(struct point);


int main(int argc, const char *argv[])
{
    
    struct point y = {0, 0};
    getStruct(y); // 传入的是 y 的值，故改变不了 y 的值
    output(y);
}

void getStruct(struct point p)
{
    scanf("%d", &p.x);
    scanf("%d", &p.y);
    printf("%d %d\n", p.x, p.y);
}

void output(struct point p)
{
    printf("%d %d\n", p.x, p.y);
}