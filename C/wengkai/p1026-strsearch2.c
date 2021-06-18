#include <stdio.h>
#include <string.h>
#include <stdlib.h>

int main(int argc, const char *argv[])
{
    char s[] = "hello";
    char *p = strchr(s, 'l');
    
    *p = '\0';
    char *t = (char*)malloc(strlen(s)+1);
    strcpy(t, s);
    printf("string: %s\n", t);    // he
    free(t);
    *p = 'l';    // 恢复字符串的值
    printf("string: %s\n", s);

    return 0;


}