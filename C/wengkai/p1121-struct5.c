#include <stdio.h>

struct point { // 可以看出，结构与数组的一个很大区别：数组里的每一个元素必须是同一个类型，结构里的每一个元素不需要是同一种类型；
        int x;
        char *y;
};


int main(int argc, const char *argv[])
{
    struct point y = {0, "hello"};
    printf("y[0]=%d, y[1]=%s\n", y.x, y.y);
}