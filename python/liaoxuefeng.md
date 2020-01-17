# Xuefeng Liao 

## Python Basic

### str and encode


- practice

```

# -*- coding: utf-8 -*-

s1 = 72
s2 = 85

r = (85-72)/72 * 100


print('%.1f%%' % r)

```

### list and tuple

```

#!/usr/bin/env python3
# -*- coding: utf-8 -*-

L = [
    ['Apple', 'Google', 'Microsoft'],
    ['Java', 'Python', 'Ruby', 'PHP'],
    ['Adam', 'Bart', 'Lisa']
]

# 打印Apple:
print(L[0][0])

# 打印Python:
print(L[1][1])

# 打印Lisa:
print(L[2][2])


```

### if else

```

# 低于18.5：过轻
# 18.5-25：正常
# 25-28：过重
# 28-32：肥胖
# 高于32：严重肥胖

height = 1.67
weight = 52.5

standard = weight/(height*height)
print(standard)

if standard < 18.5:
    print('thin')
elif (standard >= 18.5) and (standard < 25):
    print('common')
elif (standard >= 25) and (standard < 28):
    print('beyond weight')
elif (standard >= 28) and (standard < 32):
    print('fat')
else:
    print('terrible fat')


```

### for in

```
a = list(range(1,101))
sum = 0

for x in a:
    sum = sum + x
print(sum)

sumWhile = 0
j = 100
while j > 0:
    sumWhile = sumWhile + j
    j = j - 1

print(sumWhile)


```

## call function

```
# 请利用Python内置的hex()函数把一个整数转换成十六进制表示的字符串：
# -*- coding: utf-8 -*-

n1 = 255
n2 = 1000

print(str(hex(n1)))
print(str(hex(n2)))

```

## define function


```
# 请定义一个函数quadratic(a, b, c)，接收3个参数，返回一元二次方程 ax^2+bx+c=0 的两个解。

import math


def quadratic(a, b, c):
    sqrt_value = math.sqrt(b*b - 4*a*c)
    x1 = (0 - b + sqrt_value)/(2*a)
    x2 = (0 - b - sqrt_value)/(2*a)
    return x1,x2


# 测试:
print('quadratic(2, 3, 1) =', quadratic(2, 3, 1))
print('quadratic(1, 3, -4) =', quadratic(1, 3, -4))

if quadratic(2, 3, 1) != (-0.5, -1.0):
    print('测试失败')
elif quadratic(1, 3, -4) != (1.0, -4.0):
    print('测试失败')
else:
    print('测试成功')

```
