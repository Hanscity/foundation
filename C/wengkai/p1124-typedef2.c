#include <stdio.h>

struct sub
{
    int h;
    char *i;
};

typedef struct
{
    struct sub a;
    struct sub b;
} outer;

int main(int argc, const char *argv[])
{

    outer exam =
    {
        {
            0, "hello"
        },
        {
            1, "world"
        }
    };

    printf("exam's sub a: %d-%s\n", exam.a.h, exam.a.i);
}