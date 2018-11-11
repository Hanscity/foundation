# c

## Linux C 一站式编程

### 部分 I. C语言的语法
#### 第一章. 程序的基本概念
1. 程序和编程语言
   * 程序由五种指令构成，输入，输出，运算，测试和分支，循环或递归。
   * 程序由编程语言组成。低级的编程语言由指令组成，高级的编程语言由语句或者是表达式组成。只是一种说法上的传统习惯吧。
   * 低级的编程语言只有两种：机器语言，汇编语言。汇编语言是机器语言的形象表达。编译器将汇编语言编译成机器语言，汇编语言和机器语言是一一对应的关系。
   * 硬件架构的不同，机器语言有所不同，汇编语言很难平台移植。
   * C 语言可以调用硬件，可以平台移植。独孤九剑的强大在于其思想，C 的强大在于其编译器。
   
2. 自然语言和形式语言
   * 初一数学，表达式一章，已经有所讲解。编程语言和表达式一般，都是形式语言，场景不同而已。
   
3. 程序的调试
   * bug分为三种，编译错误，运行错误，逻辑错误和语义错误。
   * 编译错误就是语法错误，逻辑错误和语义错误就是业务错误，运行错误是最不容易检测出来的，特别是高级语言。因为出现死循环，需要用 gdb来查看内存调用。

4. 第一个程序
   * 建议加上 -Wall选项
   
   * printf("Hello,world!\n");需要双引号哦。
   
    
#### 第二章 常量,变量和表达式
1. 继续 Hello World
   * 双引号是界定符
   * \n 是转义序列中的一种，Windows习惯使用 \r\n
   
2. 常量
   * 字符常量，数字常量，枚举常量
   * 字符常量需要单引号，双引号是会出错的。` printf("character: %c\ninteger: %d\nfloat %f\n",'{',34,3.14);`
   1. 习题一
      * ` printf("%c\n",'%');`
      
3. 变量
   * 定义和声明是不同的。申明就是申明；定义是在申明的基础上分配存储空间。
   
4. 赋值
   * 代码说明：
   
      ```
      char login_name;//申明
      login_name = 'a';//赋值
      char reg_name = 'b';//初始化，初始化就是定义的同时也赋值
      
     ```
5. 表达式
   * 运算符：+ - * / = 这些就是运算符
   * 运算数：常量和变量就是运算数
   * 表达式：由运算符和运算数组成
   * 表达式语句：表达式加上分号即是
   1. 运算符的结合性： 同样优先级的运算符是从左往右，还是从右往左，这称为运算符的结合性。+ - * / 是从左往右，是左结合；= 是右结合，也就是说多个等号是从右往左开始运算的。
   2. 表达式的优先级：* / 最高，+ - 次之，= 最低。
   3. 调用一个方法，在传递参数的时候，参数可以是表达式，会被优先计算。也可以是赋值的表达式。
        ```
        int hour = 4;
        int minutes = 48;
        int total_minutes;
        printf("hour: %d\nminutes: %d\ntotal_minutes: %d\n",hour,minutes,total_minutes=hour*60+minutes);
       ```
   4. 表达式语句不宜过度复杂，会增加阅读和调试的难度。
   
   * 对比一下 C和 PHP的除法运算
      ```
      // C的代码
      printf("hour_one:%d\n",48/60);//0
      printf("hour_two:%f\n",48/60.0);//0.800000
      
      // Php的代码
      echo (48/60)."\n";//0.8
      echo intval(48/60)."\n";//0

     ```
   
6. 字符类型和字符编码
    * 计算机展示出来，也就是我们所看到的，都是字符类型。而计算机本身只能识别数字，这需要一套转换规则，这就是字符编码。
    * Ascii码的转义表示
       ```
       
       printf("%c\n",'\53');//输出 +，默认使用 8进制
       printf("%c\n",'\x2B');//输出 +，16进制尽量使用小 x

       ``` 
              
 #### 第三章 简单函数
 
 1. 数学函数
    * C语言的函数可以利用其副作用(SIDE EFFECT)，这是和数学函数的主要区别。
    * gcc编译含有数学库的引入的时候，需要加入 -lm的选项，-lc的选项是默认的，一般省略了。lm代表 lib库下面的 libm.so,lc代表 lib库下面的 libc.so.
       ```
        gcc -Wall -lm -lc test001.c -o test001
       ```
       
 2. 自定义函数
    * 函数原型(prototype)，有且只有函数名，参数，返回值。
    * 函数申明，函数定义。函数申明就是有且只有函数原型的语句，函数定义就是函数申明加上函数体。类似于变量的申明和定义，特别是在内存的申请上。
        ```
            //函数原型
            void test(void)
            //函数申明
            void test(void);
            //函数定义
            void test(void){
                //do something...
            };
       ```
    * 编译器在编译函数的时候，至少需要函数申明，才能生成相关指令。如果连函数申明也没有，会进行默认的隐式转换。
    * void值是虚构出来的，不能参与计算。任何的表达式都会有一个值，如果函数表达式没有返回值，就会返回 void值，从而兼顾了语法上的一致性。
    
 3. 形参(parameter)和实参(argument)
    * 函数申明中的参数就是形参，函数调用中的参数就是实参。C语言的函数调用是采取调用传值的方式(call by value)。形参和实参是不同的变量，只不过保存了同样的数值，在调用之后。
    1. 习题解答
       * 没有预期的效果。函数调用之后，call by value,形参的值发生改变，执行运算，改变形参的值，并没有改变实参的值。
       
 4. 局部变量(Local Variable)和全局变量(Global Variable)
    * 作用域(Scope)
       1.局部变量和全局变量使用相同的变量名，局部变量会覆盖全局变量的作用域。
    * 函数中定义的变量就是局部变量，比如形参，就是局部变量。
       1. 不同的函数，定义相同的变量名，还是代表不同的变量。
       2. 相同的函数，每一次调用，变量都代表不同的存储空间。
    * 全局变量在编译的时候分配存储空间，所以它的定义必须是常量。在程序退出的时候，释放存储空间。
    * 必要条件(Necessary Condition)和充分条件(Sufficient Condition),在编程逻辑判断的时候，很容易将必要条件当做充分条件来理解。
    
    
#### 第四章 分支语句(Selection Statement)
1. if语句
   * 所有语句的地方，都可以写成语句块。语句块不需要加冒号结尾，如果加了冒号，那么冒号就形成了一个新的语句，不过是空的。
   * 语句块有独立的作用域，比函数的作用域更小。
   * PHP的语句块同样是如此的。
   
   1. 习题
      * `if(x>0);//这样的意思是，如果变量大于0，那么一个空语句。`
   


2. if/else语句
    * if/else语句最好加上{},否则，else会与最近的 if组合（这称为 Dangling-else问题）。
    1. 习题二的答案
       ```
       void printfTen(int i){
               printf("整数的十进制位是：%d\n",i/10);
               printf("整数的个位是：%d\n",i%10);
       }
       ``` 
       
3. 布尔代数
   * 对真值的逻辑运算称为布尔代数(Boolean Algebra)。
   * 逻辑非就是平常所说的条件取反，符号是 !(Exclamation Mark),属于单目运算符(Unary Operator)。
   * 单目运算符的优先级很高。这些运算符的优先级顺序是：!高于*/%，高于+-，高于>、<、>=、<=，高于==、!=，高于&&，高于||。
   * 逻辑运算数，0 表示假，非0 表示真；运算结果是 1 表示真，0 表示假。C和 Php都是如此。
   
4. switch语句
   * 总是没有记住格式。。
       ```
       switch(控制表达式){
            case 常量表达式:语句序列
            case 常量表达式:语句序列
            default:语句序列
       }
    
       ```   
   
## 第五章 深入理解函数

1. return语句
   * call by value(按值传递)，值会传递过去，变量的存储空间会被释放。return语句也是 call by value。
   * `- +`这两个符号分别是取负数，取正数，是属于单目运算符。
   
2. 增量式开发(incremental)
   * 增量式开发，就是每写一段代码，就去验证它的正确性，然后写下一段。一口气写完程序，是一个不好的习惯。
   * 减量式调试，如果碰到不易调试的程序。
   * 程序的脚手架(scaff):C语言的 printf，Php的 echo，或者输出日志到文件。这是最直接明了的调试，当程序正常运行后，一般会去掉或者注释掉这部分内容，就像盖房子的时候需要用到的脚手架一样。
   * 分层思想：程序需要分模块，方法需要分层。写一个大的函数方法的时候，需要一个小功能点一个方法，然后复用(reuse)。这一层一层的调用，如何判断最终的正确性呢，这就需要 Leap Faith。
   
3. 递归(recursive)
   * 自己调用自己，就是递归。
   * 递归需要有 Base Case,否则会形成无穷递归(Infinite recursion)。
   * 递归函数在执行的过程中，随着函数一次次的调用，在一个特定的存储结构中的一端不断增加，每一次调用都只能访问自己的存储空间，这个存储空间称为帧栈(Stack Frame),这个特定的存储结构称为堆栈(Stack)。在函数的最末端，一次次 return的时候，Stack开始一层层的释放。
   * 所有的递归可以用循环来写，反之亦然。Lisp语言只有递归，没有循环。

   1. 习题1
      ```
      int recursive(int a,int b){
      
              int min;
              int max;
              if(a > b){
                      max = a;
                      min = b;
              }else{
                      max = b;
                      min = a;
              }
      
              if(max%min == 0){
                      return min;
              }else{
                      return recursive(min,max%min);
              }
      }

      ```
      
#### 第 6 章   循环语句
1. while语句
   1. 习题一
   ```
   //递归的写法--函数式编程(Functional Programming)--Declarative(申明式)
   int factorial(int i){
           if(i == 0){
                   return 1;
           }else{
                   int j = factorial(i-1);
                   return i*j;
           }
   }
    
    //while的写法--命令式编程(Imperative Programing)--Imperative(必要，祈求，命令式)
    int while_func(int i){
        int j = 1;
        while(i > 0){
            int j = j * i;
            i = i - 1;
        }
        return j;
    }
    
    //do while 的写法
    int do_while_func(int i){
        int j = 1;
        do{
            int j = j * i;
            i = i - 1;
        }while(i > 0);
        
        return j;
    }
    
    //for 的写法
    int for_func(int n){
            int res = 1;
            int i;
            for(i=1;i<=n;i++){
                    res = res * i;
            }
    
            return res;
    }


   ```
   2. 习题二
   
   ```   
   #include <stdio.h>
   
   int find_nine(int n){
           int res = 0;
   
           while(n<=100){
                   if((n/10 == 9) || (n%10 == 9)){
                           res = res + 1;
                   }
                   n = n + 1;
           }
           return res;
   }
   int main(void){
           int res = find_nine(1);
           printf("1~100 have 9 count is %d\n",res);
           return 0;
   }
   
   ```
   3. 循环语句需要小心，因为有些复杂的条件不容易一眼看出，还有一些待验证的公式。比如 3x + 1 问题，至今无人证明。。
   
2. do/while 语句

3. for 语句
   * 前缀自增运算符(Prefix Increment Operator `++i`)，前缀自减运算符(Prefix Decrement Operator `--i`)，后缀自增运算符(Postfix Increment Operator `i++`)，后缀自减运算符(Postfix Decrement Operator `i--`)。如果看做函数的调用，前缀返回改变后的值，后缀返回改变之前的值，这是前缀和后缀的区别。在 for循环的语句中，使用的都是它们的 Side Effect，所以没有差别此时。
   
   * C99的一个标准
       ```    
       
       int for_func(int n){
               int res = 1;
               for(int i=1;i<=n;i++){
                       res = res * i;
               }
       
               return res;
       }
       //test1110.c:27: error: ‘for’ loop initial declarations are only allowed in C99 mode
       //test1110.c:27: note: use option -std=c99 or -std=gnu99 to compile your code
       //C++ 一般采取了这种写法，而在 C语言中，为了有更好的兼容性，一般不采取这种写法。
    
       ```

4. break和 continue语句
   1. 习题一
       ```   
       #include <stdio.h>
       
       int is_prime(int n){
       
               int i;
               for(i=2;i<n;++i){
                       if(n%i == 0){
                               return 0;
                       }
               }
               return 1;
       }
       
       void print_prime(int n){
       
               int i;
               for(i=1;i<=n;++i){
                       if(is_prime(i)){
                               printf("The prime is %d\n",i);
                       }
               }
       }
       int main(void){
       
               print_prime(100);
               return 0;
       
       }
    
       ``` 
   
   2. 习题二
      * for循环的 continue会去执行表达式三，while和 do while的 continue会去执行条件表达式，故有所不同。
      
      * 补充一点，break是一样的，对于所有的循环而言。
          ```  
          void break_for(void){
          
                  int i;
                  for(i=0;i<10;++i){
                          printf("The point is %d\n",i);
                          if(i == 5){
                                  printf("I will break on this point %d\n",i);
                                  break;
                          }
                  }
          }
          
          void break_while(void){
          
                  int i=0;
                  while(i<10){
                          printf("The point is %d\n",i);
                          if(i == 5){
                                  printf("I will break on this point %d\n",i);
                                  break;
                          }
                          ++i;
                  }
          }
          
          int main(void){
          
                  break_for();
                  break_while();
                  return 0;
          }
    
          //结果是：
          The point is 0
          The point is 1
          The point is 2
          The point is 3
          The point is 4
          The point is 5
          I will break on this point 5
          The point is 0
          The point is 1
          The point is 2
          The point is 3
          The point is 4
          The point is 5
          I will break on this point 5

          ```
          
   3. 一个额外的思考：sqrt(n)就够了？
       ```   
        //这段代码对比习题一的代码，结果是一样的
        int is_prime(int n){
        
                int i;
                for(i=2;i<sqrt(n);++i){
                        if(n%i == 0){
                                return 0;
                        }
                }
                return 1;
        }
        
        void print_prime(int n){
        
                int i;
                for(i=1;i<=n;++i){
                        if(is_prime(i)){
                                printf("The prime is %d\n",i);
                        }
                }
        }
    
       
       ```