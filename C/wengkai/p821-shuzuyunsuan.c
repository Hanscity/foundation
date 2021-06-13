#include <stdio.h>


int search(int search, int a[], int length);

int main()
{
    
    int arr[] = {2, 3, 4, 5, 6, 7, 8, 9, 10};
    int length;
    int a;
    int ret;

    printf("请输入需要查找的数字：");
    scanf("%d", &a);
    length = sizeof(arr)/sizeof(arr[0]);

    ret = search(a, arr, length);
    if(ret == -1){
        printf("没有找到此数字\n");
    }else{
        printf("此数字的位置在 %d 下标处\n", ret);
    }

}


int search(int search, int a[], int length)
{
    int i;
    int ret = -1;

    for(i=0; i<length; i++) {
        if(search == a[i]) {
            ret = i;
            break;
        }
    }

    return ret;
};
