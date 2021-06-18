#include <stdio.h>
#include <string.h>

int main(int argc, const char *argv[])
{
    char *s = "hello";
    char *p = strchr(s, 'l');    // 寻找第一个 l
    printf("string: %s\n", p);    // llo
    char *q = strchr(p+1, 'l');    // 寻找第二个 l 
    printf("string: %s\n", q);
}