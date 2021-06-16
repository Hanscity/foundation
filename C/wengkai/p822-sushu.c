#include <stdio.h>


int isPrime(int search, int primeArr[], int length);

int main()
{
    const int countArr = 100;
    int primeArr[100] = {2,};    // gcc (Ubuntu 7.5.0-3ubuntu1~18.04) 7.5.0；这个版本不能用变量。。

    int primeFind = 3;
    int i = 1;
    int length = 1;

    while(length < countArr) {
        if(isPrime(primeFind, primeArr, length) == 1) {
            primeArr[length] = primeFind;
            length++;
        };
        primeFind++;
    }
    
    for(int j=0; j<countArr; j++) {
        if (j%5 == 0) {
            printf("%d\n", primeArr[j]);
        } else {
            printf("%d\t", primeArr[j]);
        }
    }
}


int isPrime(int search, int primeArr[], int length)
{
    int ret = 1;
    for (int i=0; i<length; i++) {
        if (search % primeArr[i] == 0) {
            ret = 0;
            break;
        }
    }
    return ret;
    
};
