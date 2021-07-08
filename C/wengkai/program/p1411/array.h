#ifndef _ARRAY_H_
#define _ARRAY_H_

typedef struct
{
    int *array;
    int size;
} Array;

Array a;
Array array_create(int init_size);
void array_free(Array *a);
int array_size(const Array *a);


#endif