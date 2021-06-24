#include <stdio.h>

struct sub
{
    int h;
    char *i;
};

typedef struct out
{
    struct sub a;
    struct sub b;
} outer;

int main(int argc, const char *argv[])
{

    struct out exam =
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