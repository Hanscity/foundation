#include <stdio.h>


#define PI 3.14159 
#define PI2 3.14159*2
#define PRT printf("%f\t", PI); \
            printf("%f\n", PI2)

int main(int argc, const char *argv[])
{

    PRT;
    return 0;

}