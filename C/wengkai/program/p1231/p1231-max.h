#ifndef _MAX_H_
#define _MAX_H_
double max(double a, double b);
extern int gAll; // 普通变量是定义， 加上 extern 是申明，头文件中的申明不能初始化的赋值。


struct Node // 有个疑问，为啥结构体的申明不能加上 extern ?
{
    int a;
    char* b;
};

#endif

