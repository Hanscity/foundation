#include <stdio.h>

enum COLOR
{
    RED=1,
    YELLOW,
    GREEN=5,
    NumCOLORS
};

int main(int argc, const char *argv[])
{
    enum COLOR color = 0;

    printf("Green num: %d\n", GREEN);
    printf("color num: %d\n", color);
    
    return 0;
}
